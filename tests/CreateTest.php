<?php


namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class CreateTest
 * @package App\Tests
 */
class CreateTest extends WebTestCase
{
    use AuthTrait, UploadTrait;

    public function test_access_denied()
    {
        $client = static::createClient();
        $crawler = $client->request(Request::METHOD_GET, '/create');

        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);

        $client->followRedirect();

        $this->assertRouteSame('security_login');
    }

    public function testSuccessfully()
    {
        $client = static::createAuthenticatedClient();
        $crawler = $client->request(Request::METHOD_GET, '/create');

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $form = $crawler->filter('form[name=post]')->form([
            "post[title]" => "title test",
            "post[content]" => "Content test",
            "post[image]" => static::createImage()
        ]);

        $client->submit($form);

        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);
        $client->followRedirect();

        $this->assertRouteSame('blog_read');
    }

    /**
     * @param $title
     * @param $content
     * @param $image
     * @param $message
     * @dataProvider provideFailedData
     */
    public function testFailed($title, $content, $image, $message)
    {

        $client = static::createAuthenticatedClient();
        $crawler = $client->request(Request::METHOD_GET, '/create');

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $form = $crawler->filter('form[name=post]')->form([
            "post[title]" => $title,
            "post[content]" => $content,
            "post[image]" => $image
        ]);

        $client->submit($form);

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->assertSelectorTextContains('html', $message);
    }

    /**
     * @return \Generator
     */
    public function provideFailedData(): \Generator
    {
        yield [
            '',
            'content post',
            static::createImage(),
            'This value should not be blank.'
        ];

        yield [
            'title post',
            '',
            static::createImage(),
            'This value should not be blank.'
        ];

        yield [
            'title post',
            'content post',
            '',
            'This value should not be null.'
        ];

        yield [
            't',
            'content post',
            static::createImage(),
            'This value is too short. It should have 5 characters or more.'
        ];

        yield [
            'title post',
            'post',
            static::createImage(),
            'This value is too short. It should have 10 characters or more.'
        ];
    }
}

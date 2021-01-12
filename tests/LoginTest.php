<?php


namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class LoginTest
 * @package App\Tests
 */
class LoginTest extends WebTestCase
{

    public function testSuccessfully()
    {
        $client = static::createClient();

        $crawler = $client->request(Request::METHOD_GET, '/login');

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);

        $form = $crawler->filter("form[name=login]")->form([
            "login[username]" => "email+1@email.com",
            "login[password]" => "password"
        ]);
        $client->submit($form);

        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);

        $client->followRedirect();

        $this->assertRouteSame('blog_index');
    }

    /**
     * @param string|null $email
     * @param string|null $password
     * @param string|null $message
     * @dataProvider provideFailedData
     */
    public function testFailed(?string $email, ?string $password, ?string $message)
    {
        $client = static::createClient();

        $crawler = $client->request(Request::METHOD_GET, '/login');

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);

        $form = $crawler->filter("form[name=login]")->form([
            "login[username]" => $email,
            "login[password]" => $password
        ]);
        $client->submit($form);

        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);

        $client->followRedirect();

        $this->assertSelectorTextContains('html', $message);
    }


    public function provideFailedData(): \Generator
    {
        yield [
            'email+1@email.com',
            'fail',
            'Password Failed'
        ];

        yield [
            'email+1@em',
            'fail',
            'User "email+1@em" not found'
        ];

        yield [
            '',
            '',
            'Email and Password not Valid'
        ];
    }
}

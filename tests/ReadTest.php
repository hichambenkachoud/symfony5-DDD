<?php


namespace App\Tests;

use App\Application\Entity\Post;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * Class ReadTest
 * @package App\Tests
 */
class ReadTest extends WebTestCase
{
    use AuthTrait;
    /**
     *
     */
    public function testSuccessfullyWithoutAuth()
    {
        $client = static::createClient();

        /** @var UrlGeneratorInterface $generator */
        $generator = $client->getContainer()->get('router');

        /** @var EntityManagerInterface $entityManager */
        $entityManager = $client->getContainer()->get('doctrine.orm.entity_manager');
        /** @var Post $post */
        $post = $entityManager->getRepository(Post::class)->findOneBy([]);
        $count = $post->getComments()->count();

        $crawler = $client->request(
            Request::METHOD_GET, $generator->generate('blog_read', ['id' => $post->getId()])
        );

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->assertContains($post->getTitle(), $crawler->filter('html')->text());
        $this->assertSelectorTextContains('h1', $post->getTitle());

        $form = $crawler->filter('form[name=comment]')->form([
            'comment[author]' => 'Author',
            'comment[content]' => 'content of test'
        ]);

        $client->submit($form);

        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);

        $client->followRedirect();

        $this->assertSelectorTextContains('html', 'content of test');

        $this->assertEquals($count, $post->getComments()->count());
        $this->assertCount($count, $crawler->filter('main ul li'));
    }

    public function testSuccessfullyWithAuth()
    {
        $client = static::createAuthenticatedClient();

        /** @var UrlGeneratorInterface $generator */
        $generator = $client->getContainer()->get('router');

        /** @var EntityManagerInterface $entityManager */
        $entityManager = $client->getContainer()->get('doctrine.orm.entity_manager');
        /** @var Post $post */
        $post = $entityManager->getRepository(Post::class)->findOneBy([]);
        $count = $post->getComments()->count();

        $crawler = $client->request(
            Request::METHOD_GET, $generator->generate('blog_read', ['id' => $post->getId()])
        );

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->assertContains($post->getTitle(), $crawler->filter('html')->text());
        $this->assertSelectorTextContains('h1', $post->getTitle());

        $form = $crawler->filter('form[name=comment]')->form([
            'comment[content]' => 'content of test auth'
        ]);

        $client->submit($form);

        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);

        $client->followRedirect();

        $this->assertSelectorTextContains('html', 'content of test auth');

        $this->assertEquals($count, $post->getComments()->count());
        $this->assertCount($count, $crawler->filter('main ul li'));
    }

    /**
     * @param string|null $author
     * @param string|null $content
     * @param string|null $message
     * @dataProvider provideFailedData
     */
    public function testFailed(?string $author, ?string $content, ?string $message)
    {
        $client = static::createClient();

        /** @var UrlGeneratorInterface $generator */
        $generator = $client->getContainer()->get('router');

        /** @var EntityManagerInterface $entityManager */
        $entityManager = $client->getContainer()->get('doctrine.orm.entity_manager');
        /** @var Post $post */
        $post = $entityManager->getRepository(Post::class)->findOneBy([]);
        $count = $post->getComments()->count();

        $crawler = $client->request(
            Request::METHOD_GET, $generator->generate('blog_read', ['id' => $post->getId()])
        );

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->assertContains($post->getTitle(), $crawler->filter('html')->text());
        $this->assertSelectorTextContains('h1', $post->getTitle());

        $form = $crawler->filter('form[name=comment]')->form([
            'comment[author]' => $author,
            'comment[content]' => $content
        ]);

        $client->submit($form);

        $this->assertSelectorTextContains('html', $message);
    }

    /**
     * @return \Generator
     */
    public function provideFailedData(): \Generator
    {
        yield [
            '',
            'content of text',
            'This value should not be blank.'
        ];
        yield [
            'a',
            'content of test',
            'This value is too short. It should have 5 characters or more.'
        ];
        yield [
            'authir',
            'co',
            'This value is too short. It should have 10 characters or more.'
        ];
    }
}

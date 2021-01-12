<?php


namespace App\Tests;

use App\Application\Entity\Post;
use App\Application\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * Class ReadTest
 * @package App\Tests
 */
class UpdateTest extends WebTestCase
{
    use AuthTrait, UploadTrait;
    public function testSuccessfullyWithAuth()
    {
        $client = static::createAuthenticatedClient();

        /** @var UrlGeneratorInterface $generator */
        $generator = $client->getContainer()->get('router');

        /** @var EntityManagerInterface $entityManager */
        $entityManager = $client->getContainer()->get('doctrine.orm.entity_manager');
        /** @var User $user */
        $user = $entityManager->getRepository(User::class)->findOneByEmail("email+1@email.com");
        /** @var Post $post */
        $post = $entityManager->getRepository(Post::class)->findOneBy(["user" => $user]);

        $crawler = $client->request(
            Request::METHOD_GET, $generator->generate('blog_update', ['id' => $post->getId()])
        );

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->assertSelectorTextContains('html', 'Update Post!');

        $form = $crawler->filter('form[name=post]')->form([
            "post[title]" => "title test",
            "post[content]" => "Content test",
            "post[image]" => static::createImage()
        ]);

        $client->submit($form);

        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);

        $client->followRedirect();

        $this->assertRouteSame("blog_read");
    }


    public function testAccessDenied()
    {
        $client = static::createAuthenticatedClient();

        /** @var UrlGeneratorInterface $urlGenerator */
        $urlGenerator = $client->getContainer()->get("router");

        /** @var EntityManagerInterface $entityManager */
        $entityManager = $client->getContainer()->get("doctrine.orm.entity_manager");

        /** @var User $user */
        $user = $entityManager->getRepository(User::class)->findOneByEmail("email+1@email.com");

        /** @var Post $post */
        $post = $entityManager->createQueryBuilder()
            ->select("p")
            ->from(Post::class, "p")
            ->where("p.user != :user")
            ->setParameter("user", $user)
            ->setMaxResults(1)
            ->getQuery()
            ->getSingleResult()
        ;

        $client->request(
            Request::METHOD_GET,
            $urlGenerator->generate("blog_update", ["id" => $post->getId()])
        );

        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);
    }

    public function testWithoutAuthentication()
    {
        $client = static::createClient();

        /** @var UrlGeneratorInterface $urlGenerator */
        $urlGenerator = $client->getContainer()->get("router");

        /** @var EntityManagerInterface $entityManager */
        $entityManager = $client->getContainer()->get("doctrine.orm.entity_manager");

        /** @var Post $post */
        $post = $entityManager->getRepository(Post::class)->findOneBy([]);

        $crawler = $client->request(
            Request::METHOD_GET,
            $urlGenerator->generate("blog_update", ["id" => $post->getId()])
        );

        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);

        $client->followRedirect();

        $this->assertRouteSame('security_login');
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

        /** @var UrlGeneratorInterface $generator */
        $generator = $client->getContainer()->get('router');

        /** @var EntityManagerInterface $entityManager */
        $entityManager = $client->getContainer()->get('doctrine.orm.entity_manager');
        /** @var User $user */
        $user = $entityManager->getRepository(User::class)->findOneByEmail("email+1@email.com");
        /** @var Post $post */
        $post = $entityManager->getRepository(Post::class)->findOneBy(["user" => $user]);
        $crawler = $client->request(
            Request::METHOD_GET, $generator->generate('blog_update', ['id' => $post->getId()])
        );
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

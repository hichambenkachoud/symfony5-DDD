<?php


namespace App\Tests;

use App\Application\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

/**
 * Class AuthTrait
 * @package App\Tests
 */
trait AuthTrait
{
    /**
     * @return KernelBrowser
     */
    public static function createAuthenticatedClient(): KernelBrowser
    {
        /** @var KernelBrowser $client */
        $client = static::createClient();
        $client->getCookieJar()->clear();

        $firewallContext = "main";
        /** @var SessionInterface $session */
        $session = $client->getContainer()->get('session');
        /** @var EntityManagerInterface $entityManager */
        $entityManager = $client->getContainer()->get('doctrine.orm.entity_manager');

        $user = $entityManager->getRepository(User::class)->findOneByEmail("email+1@email.com");

        $token = new UsernamePasswordToken(
            $user,
            $user->getPassword(),
            $firewallContext,
            $user->getRoles()
        );

        $session->set('_security_'.$firewallContext, serialize($token));
        $session->save();

        $cookie = new Cookie($session->getName(), $session->getId());
        $client->getCookieJar()->set($cookie);

        return $client;
    }
}

<?php


namespace App\Application\DataFixtures;

use App\Application\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Class UserFixtures
 * @package App\Application\DataFixtures
 */
class UserFixtures extends Fixture
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private UserPasswordEncoderInterface $encoder;

    /**
     * UserFixtures constructor.
     * @param UserPasswordEncoderInterface $encoder
     */
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }


    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        for ($i = 1; $i <= 10; $i++)
        {
            $user = new User();
            $user->setEmail(sprintf("email+%d@email.com", $i));
            $user->setPseudo(sprintf("pseudo+%d", $i));
            $user->setPassword($this->encoder->encodePassword($user, "password"));

            $manager->persist($user);

            $this->setReference(sprintf("user-%d", $i), $user);
        }

        $manager->flush();
    }
}

<?php


namespace App\Handler;


use App\DataTransferObject\User;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegistrationHandler extends AbstractHandler
{
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $entityManager;

    /**
     * RegistrationHandler constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @return string
     */
    protected function getFormType(): string
    {
        return UserType::class;
    }

    /**
     * @return object
     */
    protected function getDataTransferObject(): object
    {
        return new User();
    }

    protected function process($data): void
    {
        $this->entityManager->persist($data);
        $this->entityManager->flush();
    }
}

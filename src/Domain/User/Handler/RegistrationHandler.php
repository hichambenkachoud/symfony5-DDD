<?php


namespace App\Domain\User\Handler;


use App\Domain\User\Dto\User;
use App\Domain\User\Form\UserType;
use App\Infrastructure\Handler\AbstractHandler;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class RegistrationHandler
 * @package App\Handler
 */
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

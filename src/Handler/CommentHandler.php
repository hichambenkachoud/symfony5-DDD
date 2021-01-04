<?php


namespace App\Handler;

use App\DataTransferObject\Comment;
use App\Form\CommentType;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class CommentHandler
 * @package App\Handler
 */
class CommentHandler extends AbstractHandler
{
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $entityManager;

    /**
     * CommentHandler constructor.
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
        return CommentType::class;
    }

    /**
     * @param $data
     * @return void
     */
    protected function process($data): void
    {
        $this->entityManager->persist($data);
        $this->entityManager->flush();
    }

    /**
     * @return object
     */
    protected function getDataTransferObject(): object
    {
        return new Comment();
    }
}

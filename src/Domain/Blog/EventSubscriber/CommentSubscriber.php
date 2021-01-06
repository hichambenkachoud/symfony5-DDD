<?php


namespace App\Domain\Blog\EventSubscriber;

use App\Application\Entity\Comment;
use App\Infrastructure\Events\ReverseEvent;
use App\Infrastructure\Events\TransferEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\Security;

/**
 * Class CommentSubscriber
 * @package App\EventSubscriber
 */
class CommentSubscriber implements EventSubscriberInterface
{
    /**
     * @var Security
     */
    private Security $security;

    /**
     * CommentTransfer constructor.
     * @param Security $security
     */
    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    /**
     * @return string[]
     */
    public static function getSubscribedEvents()
    {
        return [
          TransferEvent::NAME => 'onTransfer',
          ReverseEvent::NAME => 'onReverse'
        ];
    }

    /**
     * @param TransferEvent $event
     */
    public function onTransfer(TransferEvent $event): void
    {

        if (!$event->getOriginalData() instanceof Comment) return;

        $event->getData()->setAuthor($event->getOriginalData()->getAuthor());
        $event->getData()->setContent($event->getOriginalData()->getContent());
    }

    /**
     * @param ReverseEvent $event
     */
    public function onReverse(ReverseEvent $event): void
    {
        if (!$event->getOriginalData() instanceof Comment) return;

        if ($this->security->isGranted('ROLE_USER')) {
            $event->getOriginalData()->setUser($this->security->getToken()->getUser());
        }

        $event->getOriginalData()->setAuthor($event->getData()->getAuthor());
        $event->getOriginalData()->setContent($event->getData()->getContent());
    }
}

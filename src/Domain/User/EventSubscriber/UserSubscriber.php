<?php


namespace App\Domain\User\EventSubscriber;

use App\Application\Entity\User;
use App\Infrastructure\Events\ReverseEvent;
use App\Infrastructure\Events\TransferEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Class CommentSubscriber
 * @package App\EventSubscriber
 */
class UserSubscriber implements EventSubscriberInterface
{

    /**
     * @var UserPasswordEncoderInterface
     */
    private UserPasswordEncoderInterface $encoder;

    /**
     * UserSubscriber constructor.
     * @param UserPasswordEncoderInterface $encoder
     */
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
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
        return;
    }

    /**
     * @param ReverseEvent $event
     */
    public function onReverse(ReverseEvent $event): void
    {
        if (!$event->getOriginalData() instanceof User) return;

        $event->getOriginalData()->setPseudo($event->getData()->getPseudo());
        $event->getOriginalData()->setEmail($event->getData()->getEmail());
        $event->getOriginalData()->setPassword(
            $this->encoder->encodePassword($event->getOriginalData() ,$event->getData()->getPassword())
        );
    }
}

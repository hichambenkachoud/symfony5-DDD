<?php


namespace App\Application\Security\Voter;

use App\Application\Entity\Post;
use App\Application\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

/**
 * Class PostVoter
 * @package App\Application\Security\Voter
 */
class PostVoter extends Voter
{
    public const UPDATE = 'UPDATE';

    /**
     * @param string $attribute
     * @param mixed $subject
     * @return false
     */
    protected function supports(string $attribute, $subject)
    {
        if (!$subject instanceof Post) {
            return false;
        }

        if (!in_array($attribute, [self::UPDATE])) {
            return false;
        }

        return true;
    }

    /**
     * @param string $attribute
     * @param Post $subject
     * @param TokenInterface $token
     * @return bool|void
     */
    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        /** @var User $user */
        $user = $token->getUser();

        switch ($attribute) {
            case self::UPDATE:
                return $user === $subject->getUser();
                break;

            default:
        }
    }
}

<?php


namespace App\Controller;

use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * Trait AuthorizationTrait
 * @package App\Controller
 */
trait AuthorizationTrait
{
    /**
     * @var AuthorizationCheckerInterface
     */
    private AuthorizationCheckerInterface $authorizationChecker;

    /**
     * @param AuthorizationCheckerInterface $authorizationChecker
     * @required
     */
    public function setAuthorizationChecker(AuthorizationCheckerInterface $authorizationChecker): void
    {
        $this->authorizationChecker = $authorizationChecker;
    }

    /**
     * @param string $attribute
     * @param object|null $subject
     */
    protected function denyAccessUnlessGranted(string $attribute, ?object $subject = null): void
    {
        if (!$this->authorizationChecker->isGranted($attribute, $subject)) {
            throw new AccessDeniedException();
        }
    }

    /**
     * @param string $attribute
     * @param object|null $subject
     * @return bool
     */
    protected function isGranted(string $attribute, ?object $subject = null): bool
    {
        return $this->authorizationChecker->isGranted($attribute, $subject);
    }

}

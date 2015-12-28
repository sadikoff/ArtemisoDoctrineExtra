<?php

namespace Artemiso\DoctrineExtraBundle\Listener;

use Gedmo\Loggable\LoggableListener;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;

class DoctrineExtensionLoggableListener
{
    /**
     * @var TokenStorage
     */
    private $securityTokenStorage;
    /**
     * @var AuthorizationChecker
     */
    private $securityAuthorizationChecker;

    /**
     * @var LoggableListener
     */
    private $loggable;

    /**
     * DoctrineExtensionLoggableListener constructor.
     *
     * @param TokenStorage $securityTokenStorage
     * @param AuthorizationChecker $securityAuthorizationChecker
     * @param LoggableListener $loggable
     */
    public function __construct(
        TokenStorage $securityTokenStorage,
        AuthorizationChecker $securityAuthorizationChecker,
        LoggableListener $loggable
    ) {
        $this->securityTokenStorage = $securityTokenStorage;
        $this->securityAuthorizationChecker = $securityAuthorizationChecker;
        $this->loggable = $loggable;
    }

    public function onKernelRequest()
    {
        if (null !== $this->securityTokenStorage && null !== $this->securityTokenStorage->getToken(
            ) && $this->securityAuthorizationChecker->isGranted('IS_AUTHENTICATED_REMEMBERED')
        ) {
            $this->loggable->setUsername($this->securityTokenStorage->getToken()->getUsername());
        }
    }
}

<?php

namespace Artemiso\DoctrineExtraBundle\Listener;

use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class DoctrineExtensionListener implements ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function onLateKernelRequest(GetResponseEvent $event)
    {

        $translatable = $this->container->get('artemiso_doctrine_extra.listener.translatable');
        $translatable->setTranslatableLocale($event->getRequest()->getLocale());
    }

    public function onKernelRequest()
    {
        /** @var \Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage $tokenStorage */
        $tokenStorage = $this->container->get(
            'security.token_storage',
            ContainerInterface::NULL_ON_INVALID_REFERENCE
        );

        /** @var \Symfony\Component\Security\Core\Authorization\AuthorizationChecker $authorizationChecker */
        $authorizationChecker = $this->container->get(
            'security.authorization_checker',
            ContainerInterface::NULL_ON_INVALID_REFERENCE
        );

        if (null !== $tokenStorage && null !== $tokenStorage->getToken() && $authorizationChecker->isGranted(
                'IS_AUTHENTICATED_REMEMBERED'
            )
        ) {
            $loggable = $this->container->get('artemiso_doctrine_extra.listener.loggable');
            $loggable->setUsername($tokenStorage->getToken()->getUsername());
        }
    }
}
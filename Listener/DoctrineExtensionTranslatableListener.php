<?php

namespace Artemiso\DoctrineExtraBundle\Listener;

use Gedmo\Translatable\TranslatableListener;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;

class DoctrineExtensionTranslatableListener
{
    /**
     * @var TranslatableListener
     */
    private $translatable;

    public function __construct(TranslatableListener $translatable)
    {
        $this->translatable = $translatable;
    }

    public function onLateKernelRequest(GetResponseEvent $event)
    {
        $this->translatable->setTranslatableLocale($event->getRequest()->getLocale());
    }
}

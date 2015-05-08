<?php

namespace Artemiso\DoctrineExtraBundle\Traits;

/**
 * Translatable trait.
 *
 * Should be used inside entity, that needs to be translated.
 *
 * @author Sadicov Vladimir <sadikoff@gmail.com>
 *
 * @property \Doctrine\Common\Collections\ArrayCollection $translations
 */
trait PersonalTranslation
{
    /**
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getTranslations()
    {
        return $this->translations;
    }

    /**
     * @param \Gedmo\Translatable\Entity\MappedSuperclass\AbstractPersonalTranslation $translation
     */
    public function addTranslation(\Gedmo\Translatable\Entity\MappedSuperclass\AbstractPersonalTranslation $translation)
    {
        if (!$this->translations->contains($translation)) {
            $this->translations[] = $translation;
            $translation->setObject($this);
        }
    }

}
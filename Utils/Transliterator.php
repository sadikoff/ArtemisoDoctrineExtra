<?php

namespace Artemiso\DoctrineExtraBundle\Utils;

use Transliterator\Settings;
use Transliterator\Transliterator as xTransliterator;

class Transliterator
{
    private $transliterator;

    public function __construct()
    {
        $this->transliterator = new xTransliterator(Settings::LANG_RU);
    }

    public function transliterate($text)
    {
        return $this->transliterator->cyr2Lat($text);
    }
}
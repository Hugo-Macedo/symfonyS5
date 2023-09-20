<?php
namespace App\Services;
use Symfony\Component\String\Slugger\AsciiSlugger;

class Slugify
{
    public function generateSlug ($texte): string {
        $slugger = new AsciiSlugger();
        return $slugger->slug($texte);
    }
}
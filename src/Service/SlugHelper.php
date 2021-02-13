<?php 

namespace App\Service;

class SlugHelper
{
    public function slugify($text)
    {
        // replace non letter or digits by -
        $text = preg_replace('~[^\pL\d]+~u', '_', $text);
    
        // transliterate
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
    
        // remove unwanted characters
        $text = preg_replace('~[^_\w]+~', '', $text);
    
        // trim
        $text = trim($text, '_');
    
        // remove duplicate -
        $text = preg_replace('~_+~', '_', $text);
    
        // lowercase
        $text = strtolower($text);
    
        if (empty($text)) {
        return 'n-a';
        }
    
        return $text;
    }
}
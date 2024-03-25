<?php

namespace App\Helpers;

class HighlightUsername
{
    // mètode per remarcar el color quan algú escriu "@username" als comentaris
    public static function highlightUsernames($text)
    {
        return preg_replace('/@(\w+)/', '<strong style="color: white;">@$1</strong>', htmlspecialchars($text));
    }
}
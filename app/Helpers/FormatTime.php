<?php

namespace App\Helpers;

use Carbon\Carbon;

class FormatTime
{
    public static function longTimeFilter($date)
    {
        // convertim la data a un objecte Carbon per a una fàcil manipulació
        $carbonDate = Carbon::parse($date);

        // calculem la diferència de temps en un format llegible
        $timeDiff = $carbonDate->diffForHumans();

        return $timeDiff;
    }
}
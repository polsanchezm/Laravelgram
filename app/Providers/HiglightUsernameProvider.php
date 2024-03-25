<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class HiglightUsernameProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        require_once app_path() . "/Helpers/HighlightUsername.php";

    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}

<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use App\View\Components\PermissionManager;
use App\View\Components\PermissionCheck;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */

    public function boot()
    {
        Blade::component('permission-manager', PermissionManager::class);
        Blade::component('permission-check', PermissionCheck::class);

        // Register Carbon for use in Blade templates
        Blade::directive('formatDate', function ($expression) {
            return "<?php echo \Carbon\Carbon::parse($expression)->format('d/m/Y'); ?>";
        });
    }
}

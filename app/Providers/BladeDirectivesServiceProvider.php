<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use function dd;
use function is_int;

class BladeDirectivesServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Blade::directive('dateTime', function ($expression) {
            return "<?php echo Carbon\Carbon::parse($expression)->format('Y-m-d H:i'); ?>";
        });
    }
}

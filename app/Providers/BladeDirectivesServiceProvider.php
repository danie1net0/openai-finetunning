<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class BladeDirectivesServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Blade::directive('dateTime', fn ($expression) => "<?php echo Carbon\Carbon::parse({$expression})->format('Y-m-d H:i'); ?>");

        Blade::directive('fileSize', function ($bytes) {
            return <<<PHP
                <?php

                if ({$bytes} == 0) {
                    echo "0B";
                    return;
                }

                \$sizes = array('B', 'KB', 'MB', 'GB', 'TB', 'PB');
                \$exponent = floor(log({$bytes}, 1024));


                echo round({$bytes} / pow(1024, \$exponent), 2) . \$sizes[\$exponent];
                ?>
            PHP;
        });
    }
}

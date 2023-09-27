<?php

declare(strict_types=1);

namespace Orchid\Platform\Providers;

use Illuminate\Support\ServiceProvider;

class CKEditorServiceProvider extends ServiceProvider
{
    protected function offerPublishing()
    {
        if(! $this->app->runningInConsole()) {
            return;
        }
        $this->publishes([
            __DIR__.'/../../../config/ckeditor.php' => config_path('ckeditor.php'),
        ], 'ckeditor-config');
    }
}

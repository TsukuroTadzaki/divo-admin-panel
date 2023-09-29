<?php 

namespace Orchid\Platform\Providers;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;

class ElfinderServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$configPath = base_path('/vendor/barryvdh/laravel-elfinder/config/elfinder.php');
		$this->mergeConfigFrom($configPath, 'elfinder');
		$this->publishes([$configPath => config_path('elfinder.php')], 'config');

		$this->app->singleton('command.elfinder.publish', function($app)
		{
		    $publicPath = $app['path.public'];
            return new \Barryvdh\Elfinder\Console\PublishCommand($app['files'], $publicPath);
		});
		$this->commands('command.elfinder.publish');
	}

	/**
	 * Define your route model bindings, pattern filters, etc.
	 *
	 * @param  \Illuminate\Routing\Router  $router
	 * @return void
	 */
	public function boot(Router $router)
	{
        $viewPath = __DIR__.'/../resources/views';
        $this->loadViewsFrom($viewPath, 'elfinder');
        $this->publishes([
            $viewPath => base_path('resources/views/vendor/elfinder'),
        ], 'views');

        if (!defined('ELFINDER_IMG_PARENT_URL')) {
			define('ELFINDER_IMG_PARENT_URL', $this->app['url']->asset('packages/barryvdh/elfinder'));
		}

        $config = $this->app['config']->get('elfinder.route', []);
        $config['namespace'] = 'Barryvdh\Elfinder';

        $router->group($config, function($router)
        {
            $router->any('connector', ['as' => 'elfinder.connector', 'uses' => 'ElfinderController@showConnector']);
            $router->get('ckeditor', ['as' => 'elfinder.ckeditor', 'uses' => 'ElfinderController@showCKeditor4']);
            // $router->get('/',  ['as' => 'elfinder.index', 'uses' =>'ElfinderController@showIndex']);
            // $router->get('popup/{input_id}', ['as' => 'elfinder.popup', 'uses' => 'ElfinderController@showPopup']);
            // $router->get('filepicker/{input_id}', ['as' => 'elfinder.filepicker', 'uses' => 'ElfinderController@showFilePicker']);
            // $router->get('tinymce', ['as' => 'elfinder.tinymce', 'uses' => 'ElfinderController@showTinyMCE']);
            // $router->get('tinymce4', ['as' => 'elfinder.tinymce4', 'uses' => 'ElfinderController@showTinyMCE4']);
            // $router->get('tinymce5', ['as' => 'elfinder.tinymce5', 'uses' => 'ElfinderController@showTinyMCE5']);
        });
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array('command.elfinder.publish');
	}

}

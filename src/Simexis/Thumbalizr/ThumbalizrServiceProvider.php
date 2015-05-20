<?php namespace Simexis\Thumbalizr;

use Illuminate\Support\ServiceProvider;

class ThumbalizrServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->publishes([
            __DIR__.'/../config/thumbalizr.php' => config_path('thumbalizr.php'),
        ], 'config');
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app['thumbalizr'] = $this->app->share(function($app)
        {
            return new Thumbalizr($app['config']);
        });

        $this->app->booting(function()
		{
		  $loader = \Illuminate\Foundation\AliasLoader::getInstance();
		  $loader->alias('Thumbalizr', 'Simexis\Thumbalizr\Facades\Thumbalizr');
		});
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array();
	}

}

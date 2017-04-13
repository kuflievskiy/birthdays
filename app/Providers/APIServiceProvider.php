<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Helpers\APIConnection;


class APIServiceProvider extends ServiceProvider
{
	
	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = true;
	
	/**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
	
//	    $this->app->bind('\App\Helpers\APIConnection', function ($app) {
//		    return new APIConnection();
//	    });
	    
	    $this->app->singleton(APIConnection::class, function ($app) {
		    return new APIConnection();
	    });
    }
	
	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return [APIConnection::class];
	}
}

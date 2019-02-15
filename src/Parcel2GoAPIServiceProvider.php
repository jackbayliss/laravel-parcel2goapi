<?php


namespace jackbayliss\Parcel2GoApi;
use Illuminate\Support\ServiceProvider;
class Parcel2GoAPIServiceProvider extends ServiceProvider
{
    /**
     * Run boot operations.
     */
    public function boot()
    {
        
        $this->app->bind('Parcel2GoAPI', Parcel2GoAPI::class);
    }
    /**
     * Register the service provider.
     */
    public function register()
    {
        $config = __DIR__.'/Config/config.php';

        $this->publishes([
            $config => config_path('config.php'),
        ], 'parcel2goapi');

        $this->mergeConfigFrom($config, 'parcel2goapi');
    

        $this->app->singleton(Parcel2GoAPI::class, function ($app) {
            return new Parcel2GoAPI();
        });
    }
    
    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [Parcel2GoAPI::class];
    }
}
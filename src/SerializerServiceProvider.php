<?php namespace NuWave\Serializers;

use Illuminate\Support\ServiceProvider;
use League\Fractal\Manager;
use NuWave\Serializers\Ember\EmberSerializer;

class SerializerServiceProvider extends ServiceProvider {

    /**
     * Bootstrap the application service
     *
     * @return void
     */
    public function boot()
    {
        $configPath = __DIR__ . '../../config/ember.php';

        $this->publishes([
            $configPath => config_path('ember.php')
        ]);
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bindShared('NuWave\Serializers\SerializerManager', function($app)
        {
            $manager = new Manager();

            $manager->setSerializer(new EmberSerializer());

            return new SerializerManager($manager, new SerializerTranslator());
        });
    }
}
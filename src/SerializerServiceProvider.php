<?php namespace NuWave\Serializers;

use Illuminate\Support\ServiceProvider;
use League\Fractal\Manager;

class SerializerServiceProvider extends ServiceProvider {

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('NuWave\Serializers\SerializerManager', function($app)
        {
            $manager = new Manager();

            $manager->setSerializer(new EmberSerializer());

            return new SerializerManager($manager, new SerializerTranslator());
        });
    }
}
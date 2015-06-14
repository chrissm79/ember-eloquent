<?php namespace NuWave\Serializers\Ember;

trait EmberTrait {

    /**
     * Create an Ember Data formatted response
     *
     * @param $model
     * @param $name
     * @return array
     */
    protected function emberResponse($model, $name, $includes = [])
    {
        return app('NuWave\\Serializers\\SerializerManager')->make($model, $name, $includes);
    }

}
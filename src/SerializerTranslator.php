<?php namespace NuWave\Serializers;

use NuWave\Serializers\Exceptions\SerializerTranslatorException;

class SerializerTranslator {

    public function toTranslatorHandler($model)
    {
        $transformer = config('ember.namespace') . '\\' . $model . config('ember.suffix');

        if( ! class_exists($transformer))
        {
            $message = "Resource Transformer [$transformer] does not exist.";

            throw new SerializerTranslatorException($message);
        }

        return $transformer;
    }

}
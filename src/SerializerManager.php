<?php namespace NuWave\Serializers;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use League\Fractal\Manager;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;

class SerializerManager {

    /**
     * @var SerializerTranslator
     */
    private $translator;

    /**
     * @var Manager
     */
    private $manager;

    /**
     * SerializerManager constructor.
     * @param Manager $manager
     * @param SerializerTranslator $translator
     */
    public function __construct(Manager $manager, SerializerTranslator $translator)
    {
        $this->translator = $translator;
        $this->manager = $manager;
    }

    /**
     * Create Ember Data friendly response
     *
     * @param $data
     * @param $model
     * @param array $includes
     * @return array
     * @throws Exceptions\SerializerTranslatorException
     */
    public function make($data, $model, $includes = [])
    {
        if( ! $data || empty($data)) return [];

        $transformer = app($this->translator->toTranslatorHandler($model));
        $resource    = $this->createResource($data, $transformer, $model);

        if( ! empty($includes))
        {
            $this->manager->parseIncludes($includes);
        }

        return $this->manager->createData($resource)->toArray();
    }

    /**
     * Create Fractal Resource
     *
     * @param $data
     * @param $transformer
     * @param $model
     * @return \League\Fractal\Resource\Collection|\League\Fractal\Resource\Item
     */
    private function createResource($data, $transformer, $model)
    {
        if($data instanceof LengthAwarePaginator)
        {
            $resource = new \League\Fractal\Resource\Collection($data->getCollection(), $transformer, snake_case(str_plural($model)));
            $resource->setPaginator(new IlluminatePaginatorAdapter($data));
            return $resource;
        }
        else if ($data instanceof Collection)
        {
            return new \League\Fractal\Resource\Collection($data, $transformer, snake_case(str_plural($model)));
        }

        return new \League\Fractal\Resource\Item($data, $transformer, snake_case($model));
    }
}
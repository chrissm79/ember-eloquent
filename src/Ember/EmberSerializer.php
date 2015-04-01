<?php namespace NuWave\Serializers\Ember;

use League\Fractal\Resource\ResourceInterface;
use League\Fractal\Serializer\JsonApiSerializer;

class EmberSerializer extends JsonApiSerializer {

    /**
     * Serialize the included data.
     *
     * @param ResourceInterface $resource
     * @param array             $data
     *
     * @return array
     */
    public function includedData(ResourceInterface $resource, array $data)
    {
        $serializedData = array();
        $linkedIds      = array();

        foreach ($data as $value) {
            foreach ($value as $includeKey => $includeValue) {
                foreach ($includeValue[$includeKey] as $itemValue) {
                    if (!array_key_exists('id', $itemValue)) {
                        $serializedData[$includeKey][] = $itemValue;
                        continue;
                    }
                    $itemId = $itemValue['id'];
                    if (!empty($linkedIds[$includeKey]) && in_array($itemId, $linkedIds[$includeKey], true)) {
                        continue;
                    }
                    $serializedData[$includeKey][] = $itemValue;
                    $linkedIds[$includeKey][] = $itemId;
                }
            }
        }

        return empty($serializedData) ? array() : $serializedData;
    }

}
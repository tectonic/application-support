<?php

namespace Tectonic\Application\Support;

use Illuminate\Database\Eloquent\ModelNotFoundException;

abstract class BaseRepository
{
    /**
     * Stores the model object for querying.
     *
     * @var Eloquent
     */
    protected $model;

    /**
     * Get a specific resource.
     *
     * @param integer $id
     *
     * @return Resource
     * @throws ModelNotFoundException
     */
    public function getById($id)
    {
        return $this->model->find($id);
    }

    /**
     * Searches for a resource with the id provided. If no resource is found that matches
     * the $id value, then it will throw a ModelNotFoundException.
     *
     * @param $id
     *
     * @return Resource
     */
    public function requireById($id)
    {
        $model = $this->getById($id);

        if (!$model) {
            throw with(new ModelNotFoundException)->setModel(get_class($this->model));
        }

        return $model;
    }

    /**
     * Returns the model that is being used by the repository.
     *
     * @return Eloquent
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * Sets the model to be used by the repository.
     *
     * @param $model
     */
    public function setModel($model)
    {
        $this->model = $model;
    }

    /**
     * Create a resource based on the data provided.
     *
     * @param array $data
     *
     * @return Resource
     */
    public function getNew($data = [])
    {
        return $this->model->newInstance($data);
    }

    /**
     * Delete a specific resource. Returns the resource that was deleted.
     *
     * @param object  $resource
     * @param boolean $permanent
     *
     * @return Resource
     */
    public function delete($resource, $permanent = false)
    {
        if ($permanent) {
            $resource->forceDelete();
        }
        else {
            $resource->delete();
        }

        return $resource;
    }

    /**
     * Update a resource based on the id and data provided.
     *
     * @param object $resource
     * @param array  $data
     *
     * @return Resource
     */
    public function update($resource, $data = [])
    {
        if (is_array($data) && count($data) > 0) {
            $resource->fill($data);
        }

        $this->save($resource);

        return $resource;
    }

    /**
     * Saves the resource provided to the database.
     *
     * @param $resource
     *
     * @return Resource
     */
    public function save($resource)
    {
        $attributes = $resource->getDirty();

        if (!empty($attributes)) {
            $resource->save();
        }
        else {
            $resource->touch();
        }
    }
}

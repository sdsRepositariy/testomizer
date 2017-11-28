<?php

namespace App\Repositories;

abstract class AbstractRepository
{
    /**
     * Make a new instance of the entity to query on
     *
     * @param array $with
    */
    protected function make(array $with = array())
    {
        return $this->model->with($with);
    }

    /**
    * Return models collection
    *
    * @return Illuminate\Database\Eloquent\Collection
   */
    public function all()
    {
        return $this->model->all();
    }

    /**
     * Retrive model by id
     *
     * @param int $id
     *
     * @return lluminate\Database\Eloquent\Model
    */
    public function getById($id)
    {
        return $this->model->findOrFail($id);
    }

    /**
     * Retrive model by name
     *
     * @param string $attribute
     * @param string $name
     *
     * @return lluminate\Database\Eloquent\Model
    */
    public function getByName($attribute, $name)
    {
        return $this->model->where($attribute, $name)->firstOrFail();
    }

    /**
     * Find an entity by id
     *
     * @param int $id
     * @param array $with
     *
     * @return Illuminate\Database\Eloquent\Model
    */
    public function findByIdWith($id, array $with = array())
    {
        $query = $this->make($with);
 
        return $query->findOrFail($id);
    }

    /**
     * Get all entities
     *
     * @param array $with
     *
     * @return Illuminate\Database\Eloquent\Model
    */
    public function getAllWith(array $with = array())
    {
        $query = $this->make($with);
 
        return $query->get();
    }
}

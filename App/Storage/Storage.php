<?php

namespace App\Storage;

interface Storage
{
    /**
     * Browse all records.
     * @return array
     */
    public function all();

    /**
     * Create a new record.
     * @param array $newData
     * @return mixed
     */
    public function add($newData);

    /**
     * Read a record by ID.
     * @param mixed $id
     * @return array|null
     */
    public function get($id);

    /**
     * Update a record by ID.
     * @param mixed $id
     * @param array $newData
     * @return void
     */
    public function update($id, $newData);

    /**
     * Delete a record by ID.
     * @param mixed $id
     * @return void
     */
    public function delete($id);
}

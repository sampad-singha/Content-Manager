<?php

namespace App\Repositories\Interfaces;

interface EmailRepositoryInterface
{
    public function all();

    public function find($id);

    public function findByReceiver($receiver);

    public function create(array $data);

    public function update($id, array $data);

    public function delete($id);
}

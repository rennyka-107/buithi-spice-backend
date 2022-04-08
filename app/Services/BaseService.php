<?php

namespace App\Services;
use App\Services\BaseServiceInterface;

class BaseService implements BaseServiceInterface
{
    public function get($id){}
    public function getAll($option){}
    public function create($data){}
    public function update($data){}
    public function delete($id){}
}

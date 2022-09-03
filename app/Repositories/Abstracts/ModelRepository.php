<?php

namespace App\Repositories\Abstracts;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\ValidationException;

abstract class ModelRepository
{
    /**
     * @return Model
     */
    public abstract function get(): Model;

    /**
     * @throws ValidationException
     * @param array $data
     * @return Model
     */
    public abstract function update(array $data): Model;
    public abstract function save(): bool;
    public abstract function delete(): bool;
    public abstract function saved(): bool;
    public abstract function refresh(): self;
}

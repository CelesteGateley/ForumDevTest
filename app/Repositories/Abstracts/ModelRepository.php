<?php

namespace App\Repositories\Abstracts;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

abstract class ModelRepository
{
    public abstract static function create(array $data): Model;
    public abstract static function all(): Collection|array;
    public abstract function get(): Model;
    public abstract function update(array $data): Model;
    public abstract function save(): bool;
    public abstract function delete(): bool;
    public abstract function saved(): bool;
    public abstract function refresh(): self;
}

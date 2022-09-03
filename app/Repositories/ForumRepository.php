<?php

namespace App\Repositories;

use App\Models\Forum;
use App\Repositories\Abstracts\ModelRepository;
use Illuminate\Support\Facades\Validator;

class ForumRepository extends ModelRepository#
{
    private Forum $forum;

    public function __construct(Forum $forum)
    {
        $this->forum = $forum;
    }

    public static function create(string $name, string $description): Forum
    {
        return Forum::create(['name' => $name, 'description' => $description]);
    }

    public function get(): Forum
    {
        return $this->forum;
    }

    public function update(array $data): Forum
    {
        $this->forum->update($data);
        $this->save();
        return $this->get();
    }

    public function save(): bool
    {
        return $this->forum->save();
    }

    public function delete(): bool
    {
        return $this->forum->delete();
    }

    public function saved(): bool
    {
        return isset($this->forum->id);
    }

    public function refresh(): ForumRepository
    {
        $this->forum->refresh();
        return $this;
    }
}

<?php

namespace App\Repositories;

use App\Models\Forum;
use App\Repositories\Abstracts\ModelRepository;
use Illuminate\Support\Collection;

class ForumRepository extends ModelRepository
{
    private Forum $forum;

    public function __construct(Forum $forum)
    {
        $this->forum = $forum;
    }

    /**
     * @return Collection|Forum[]
     */
    public static function all(): Collection|array
    {
        return Forum::all();
    }

    public static function create(array $data): Forum
    {
        return Forum::create($data);
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

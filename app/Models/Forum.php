<?php

namespace App\Models;

use App\Repositories\ForumRepository;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Forum extends Model
{
    use HasFactory;

    protected $guarded = ['id','created_at','updated_at'];
    private ForumRepository $repository;

    public function repository(): ForumRepository
    {
        isset($this->repository) || $this->repository = new ForumRepository($this);
        return $this->repository;
    }
}

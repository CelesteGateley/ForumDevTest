<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\ForumRepository;

class ForumController extends Controller
{
    public function index()
    {
        $data = [];
        foreach (ForumRepository::all() as $forum) {
            $data[] = ['id' => $forum->id, 'name' => $forum->name, 'description' => $forum->description,];
        }
        return response()->json($data);
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ForumRequest;
use App\Models\Forum;
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

    public function create(ForumRequest $request)
    {
        $forum = ForumRepository::create($request->getData());
        return response()->json(['success' => true, 'id' => $forum->id, 'name' => $forum->name, 'description' => $forum->description,]);
    }

    public function update(ForumRequest $request, Forum $forum)
    {
        $forum->repository()->update($request->getData());
        return response()->json(['success' => true, 'id' => $forum->id, 'name' => $forum->name, 'description' => $forum->description,]);
    }
}

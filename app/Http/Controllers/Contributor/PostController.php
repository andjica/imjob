<?php

namespace App\Http\Controllers\Contributor;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Interfaces\PostInterface;
use App\Models\Post;

class PostController extends Controller
{
    protected $postServices;

    public function __construct(PostInterface $postServices)
    {
        $this->postServices = $postServices;
    }

    public function store(PostRequest $request)
    {
        $post = $this->postServices->store($request);

        return $post;
    }

    public function editPost($id)
    {
        $post = Post::findOrFail($id);
        return view('contributor.pages.post.edit', compact('post'));
    }
    public function update($postId, PostRequest $request)
    {
        $this->postServices->updatePost($postId,$request);
        return redirect()->back()->with('success', 'You upddated post successfully');
    }
    public function delete($postId)
    {
        $this->postServices->deletePost($postId);

        return redirect()->back()->with('success', 'You deleted post successfully');

    }
}

<?php

namespace App\Http\Controllers\Contributor;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Interfaces\PostInterface;

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
}

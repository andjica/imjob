<?php

namespace App\Interfaces;

use App\Http\Requests\PostRequest;

interface PostInterface
{
    public function getPostsByContributor(int $contributorId);
    public function store(PostRequest $request);
}

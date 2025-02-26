<?php 

namespace App\Services;

use App\Http\Requests\PostRequest;
use App\Models\Post;
use App\Interfaces\PostInterface;
use Exception;

class PostServices implements PostInterface
{
    public function getPostsByContributor(int $contributorId)
    {

        $posts = Post::where('contributor_id', $contributorId)->orderBy('created_at', 'desc')->get();

        return $posts;
    }

    public function store(PostRequest $request)
    {
        
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('uploads/contributor/posts/image', 'public');
        }

        $contributorId = auth()->user()->contributor->id ?? abort(404);
        $post = new Post();
        $post->description = $request->validated()['description'];
        $post->image = $imagePath;
        $post->contributor_id = $contributorId;

        try{
            $post->save();
            return redirect('/contributor/posts')->with('success', 'You created a post successfully');
        }
        catch(Exception $e)
        {
            return abort(500);
        }
       

        
    }
}
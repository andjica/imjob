<?php 

namespace App\Services;

use Exception;
use App\Models\Post;
use App\Interfaces\PostInterface;
use App\Http\Requests\PostRequest;
use Illuminate\Support\Facades\Storage;

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
        $descriptionHtml = $request->input('description'); // preuzmi sirov HTML
        $post->description = $descriptionHtml;
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

    public function updatePost(int $postId, PostRequest $request)
    {
        $post = Post::findOrFail($postId);
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('uploads/contributor/posts/image', 'public');

        }

        $contributorId = auth()->user()->contributor->id ?? abort(404);
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

    public function deletePost(int $postId)
    {
        $post = Post::findOrFail($postId);

        if($post->image != null)
        {
            if (!empty($post->image) && Storage::exists('public/' . $post->image)) {
                Storage::delete('public/' . $post->image);
            }
        }

        try{
            $post->delete();
        }
        catch(Exception $e)
        {
            return abort(500);
        }
    }
}
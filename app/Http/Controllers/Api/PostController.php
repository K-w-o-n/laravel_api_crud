<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
        return response()->json(Post::all(),200);

        //route=>http://127.0.0.1:8000/api/posts
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {   
        $messages = [
            'required' => 'The :attribute field is required'
        ];

        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'description' => 'required',
        ]);

        if($validator->fails()) {
            return response()->json(['msg' => 'fails'],500);
        } else {
            
        $post = Post::create([
            'title' => $request->title,
            'description' => $request->description
        ]);

            return response()->json([$post, 'msg' => 'Data created successfully'],200);
        }
 

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $post = Post::find($id);

        return response()->json($post,200);

        //route => http://127.0.0.1:8000/api/posts/id
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $post = Post::findOrFail($id);

        $post->update([
            'title' => $request->title,
            'description' => $request->description
        ]);

        return response()->json(['msg' => 'Update success'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $post = Post::findOrFail($id);

        $post->delete();

        return response()->json(['msg' => 'Delete success'], 200);
    }
}

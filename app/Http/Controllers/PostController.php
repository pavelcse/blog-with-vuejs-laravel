<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;

class PostController extends Controller
{
    public function index()
    {
        $post =  Post::with('user', 'category')->orderBy('id', 'desc')->get();
        return response()->json([
            'posts' => $post
        ], 200);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'description' => 'required',
            'category_id' => 'required',
            //'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:1024',
        ]);

        $post = new Post();
        $post->title = $request->title;
        $post->description = $request->description;
        $post->category_id = $request->category_id;

        if($request->photo) {
            $strpos = strpos($request->photo, ';');
            $sub = substr($request->photo, 0, $strpos);
            $ext = explode('/', $sub)[1];
            $imageName = time().'.'.$ext;
            $img = Image::make($request->photo)->resize(200, 200);
            $path = public_path('upload_images/');
            $img->save($path . $imageName);

            $post->photo = 'upload_images/' . $imageName;
        }

        try {
            $post->save();

        } catch (\Throwable $exception) {
            return response()->json([
                'message' => 'Something Wrong. Please Try Again!!!',
                'type' => 'error'
            ]);
        }

        return response()->json([
            'message' => 'Post Added Successfully',
            'type' => 'success'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }


    public function destroy($id)
    {
        try {
            $post = Post::findOrFail($id);
            $post->delete();

        } catch (\Throwable $exception) {
            return response()->json([
                'message' => 'Something Wrong. Please Try Again!!!',
                'type' => 'error'
            ]);
        }

        return response()->json([
            'message' => 'Post Deleted Successfully',
            'type' => 'success'
        ]);
    }
}

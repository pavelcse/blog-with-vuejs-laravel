<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
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


    public function edit($id)
    {
        $category = Post::findOrFail($id);
        return response()->json([
            'post' => $category
        ], 200);
    }


    public function update(Request $request, $id)
    {
        $post = Post::findOrFail($id);
        $this->validate($request, [
            'title' => 'required|min:2|max:50',
            'description' => 'required|min:2|max:500',
            'category_id' => 'required|min:1',
        ]);

        try {
            $post->title = request()->title;
            $post->description = request()->description;
            $post->category_id = request()->category_id;

            if($request->photo && preg_match('/\bdata:image\b/', $request->photo)) {
                $strpos = strpos($request->photo, ';');
                $sub = substr($request->photo, 0, $strpos);
                $ext = explode('/', $sub)[1];
                $imageName = time().'.'.$ext;
                $img = Image::make($request->photo)->resize(200, 200);
                $path = public_path('upload_images/');
                $img->save($path . $imageName);

                $imgPath = public_path().'/'.$post->photo;
                if(file_exists($imgPath)) {
                    @unlink($imgPath);
                }

                $post->photo = 'upload_images/' . $imageName;
            }

            $post->save();

        } catch (\Throwable $exception) {
            Log::debug($exception);
            return response()->json([
                'message' => 'Something Wrong. Please Try Again!!!',
                'type' => 'error'
            ]);
        }

        return response()->json([
            'message' => 'Post Updated Successfully',
            'type' => 'success'
        ]);
    }


    public function destroy($id)
    {
        try {
            $post = Post::findOrFail($id);
            $imgPath = public_path().'/'.$post->photo;
            if(file_exists($imgPath)) {
                @unlink($imgPath);
            }
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

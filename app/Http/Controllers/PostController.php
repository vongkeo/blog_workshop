<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public $help;
    public $model;

    public function __construct()
    {
        $this->help = new HelpController();
        $this->model = new Post();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = $this->model->all();
        return $this->help->response('Posts retrieved successfully', $posts, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            // title,content,image,user_id
            // 1.validate the request
            $rules = [
                'title' => 'required|string|max:100',
                'content' => 'required|string',
                'image' => 'nullable|image',
                'user_id' => 'required|integer'
            ];
            $this->help->validated($request, $rules);
            // 2.store the data in the database
            // generate the object array
            $arr = [
                'title' => $request->title,
                'content' => $request->content,
                'user_id' => $request->user_id
            ];
            $object = $this->model->create($arr);
            // 3.return the response
            return $this->help->response('Post created successfully', $object, 201);
        } catch (\Throwable $th) {
            return $this->help->response($th->getMessage(), null, 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show($postId)
    {

        $model = new Post();
        $post = $model->find($postId);
        if (!$post) {
            return $this->help->response('Post not found', null, 404);
        }
        return $this->help->response('Post retrieved successfully', $post, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $post)
    {

        try {
            $rules = [
                'title' => 'required|string|max:100',
                'content' => 'required|string',
                'image' => 'nullable|image',
                'user_id' => 'required|integer'
            ];
            $this->help->validated($request, $rules);
            $model = new Post();
            $post = $model->find($post);
            if (!$post) {
                return $this->help->response('Post not found', null, 404);
            }
            $arr = [
                'title' => $request->title,
                'content' => $request->content,
                'user_id' => $request->user_id
            ];
            $post->update($arr);
            return $this->help->response('Post updated successfully', $post, 200);
        } catch (\Throwable $th) {
            //throw $th;
            return $this->help->response($th->getMessage(), null, 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy($post)
    {
        $post = $this->model->find($post);
        if (!$post) {
            return $this->help->response('Post not found', null, 404);
        }
        $post->delete();
        return $this->help->response('Post deleted successfully', null, 200);
    }
}

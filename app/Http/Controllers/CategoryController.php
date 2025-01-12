<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    public $help;
    public $model;

    public function __construct()
    {
        $this->help = new HelpController();
        $this->model = new Category();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $search = request('search');
        $data = $this->model->with('user:id,name')
            ->where('name', 'like', '%' . $search . '%');
        $data = $this->help->paginate($data);
        return $this->help->response('data retrieved successfully', $data, 200);
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
                'name' => 'required|string|max:100',
                'user_id' => 'required|integer',
            ];
            $this->help->validated($request, $rules);
            // 2.store the data in the database
            // generate the object array
            $arr = [
                'name' => $request->name,
                'user_id' => $request->user_id,

            ];
            $object = $this->model->create($arr);
            // 3.return the response
            return $this->help->response('Data created successfully', $object, 201);
        } catch (\Throwable $th) {
            return $this->help->response($th->getMessage(), null, 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show($catId)
    {

        $model = new Category();
        $data = $model->where('id', $catId)->with('user:id,name');
        if (!$data->exists()) {
            return $this->help->response('data not found', null, 404);
        }
        $data = $data->first();
        return $this->help->response('data retrieved successfully', $data, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $catId)
    {
        try {
            $rules = [

                'name' => 'required|string|max:100',
                'user_id' => 'required|integer',
            ];
            $this->help->validated($request, $rules);
            $model = new Category();
            $data = $model->where('id', $catId);
            if (!$data->exists()) {
                return $this->help->response('data not found', null, 404);
            }
            $arr = [
                'name' => $request->name,
                'user_id' => $request->user_id,
            ];
            $data->update($arr);
            return $this->help->response('data updated successfully', $data->first(), 200);
        } catch (\Throwable $th) {
            //throw $th;
            return $this->help->response($th->getMessage(), null, 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy($catId)
    {
        $post = $this->model->where('id', $catId);
        if (!$post->exists()) {
            return $this->help->response('Post not found', null, 404);
        }
        // delete the post
        $post->delete();
        return $this->help->response('data deleted successfully', null, 200);
    }
}

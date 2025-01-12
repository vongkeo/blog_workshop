<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class HelpController extends Controller
{
    // validate the request
    public function validated(Request $request, $rules)
    {
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            throw new \Exception($validator->errors()->first(), 400);
        }
    }

    public function response($message, $data, $status)
    {
        return response()->json(['message' => $message, 'data' => $data], $status);
    }

    // file upload in public folder
    public function fileUpload($file, $path)
    {
        $pre_fix = 'uploads/' . $path;
        $file_name = $file->hashName();
        $full_path = $pre_fix . '/' . $file_name;
        Storage::disk('public')->put($pre_fix, $file);
        return $full_path;
    }
    // delete file
    public function fileDelete($path)
    {
        // if $path is not null 
        if ($path != null && $path != '') {
            // check file exist
            if (Storage::disk('public')->exists($path)) {
                Storage::disk('public')->delete($path);
            }
        }
    }

    // paginate
    public function paginate($model)
    {
        $page = request()->page ? request()->page : 1;
        $limit = request()->limit ? request()->limit : 30;
        return $model->paginate($limit, ['*'], 'page', $page);
    }
}

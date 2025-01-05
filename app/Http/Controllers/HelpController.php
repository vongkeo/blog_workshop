<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
    // file upload
    // delete file
    // paginate
    // search
    // join table : category_id, user_id    
    // group by
}

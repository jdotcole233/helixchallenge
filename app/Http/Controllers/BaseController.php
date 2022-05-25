<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as Controller;
use Illuminate\Validation\Validator;

define('RESPONSE_SUCCESS', 200);

class BaseController extends Controller
{
    public function successResponseJSON (string $message, $content)
    {  
        return response()->json(['success' => true,'data' => $content,'message' => $message], RESPONSE_SUCCESS);
    }

    public function errorResponseJSON (string $error, $errMessage = [], int $http_code = 404)
    {
        $errorResponse = ['success' => false, 'message' => $error];

        if (!empty($errMessage))
        {
            $errorResponse['data'] = $errMessage;
        }

        return response()->json($errorResponse, $http_code);
    }
}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SubmitController extends Controller
{
    public function submit(Request $request)
    {
        // Define validation rules
        $rules = [
            'name' => 'required|string',
            'email' => 'required|email',
            'message' => 'required|string',
        ];

        // Validate the request
        $validator = Validator::make($request->all(), $rules);

        // Check if the validation fails
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()
            ], 400);
        }

        // Extract the validated data
        $validatedData = $validator->validated();
        $name = $validatedData['name'];
        $email = $validatedData['email'];
        $message = $validatedData['message'];

        // Process the data (for example, log it)
        \Log::info("Received submission: Name={$name}, Email={$email}, Message={$message}");

        // Return a success response
        return response()->json([
            'status' => 'success',
            'message' => 'Data received successfully'
        ], 200);
    }
}

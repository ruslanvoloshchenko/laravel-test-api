<?php

namespace App\Http\Controllers;

use App\Models\Submission;
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

        // Save to the database
        $submission = Submission::create($validatedData);

        // Return a success response
        return response()->json([
            'status' => 'success',
            'message' => 'Data received successfully',
            'data' => $submission
        ], 200);
    }
}

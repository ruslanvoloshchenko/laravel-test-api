<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessSubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

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

        try {
            // Dispatch the job to process the submission
            ProcessSubmission::dispatch($validatedData);

            // Return a success response
            return response()->json([
                'status' => 'success',
                'message' => 'Data received and is being processed'
            ], 200);
        } catch (\Exception $e) {
            // Log the error
            Log::error('Error dispatching ProcessSubmission job: ' . $e->getMessage(), [
                'data' => $validatedData,
                'exception' => $e,
            ]);

            // Return an error response
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred while processing your request. Please try again later.'
            ], 500);
        }
    }
}

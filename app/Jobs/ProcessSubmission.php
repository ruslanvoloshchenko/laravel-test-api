<?php

namespace App\Jobs;

use App\Events\SubmissionSaved;
use App\Models\Submission;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ProcessSubmission implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $data;

    /**
     * Create a new job instance.
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(): void
    {
        try {
            // Save the data to the database
            $submission = Submission::create($this->data);

            // Trigger the SubmissionSaved event
            event(new SubmissionSaved($submission));
        } catch (\Exception $e) {
            // Log the error
            Log::error('Error processing submission: ' . $e->getMessage(), [
                'data' => $this->data,
                'exception' => $e,
            ]);

            // Re-throw the exception to be handled by the queue worker
            throw $e;
        }
    }
}

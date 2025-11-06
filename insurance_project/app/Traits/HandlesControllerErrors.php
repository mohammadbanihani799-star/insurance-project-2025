<?php

namespace App\Traits;

use App\Models\SupportTicket;
use Illuminate\Support\Facades\Log;

trait HandlesControllerErrors
{
    /**
     * Handle controller errors and create support tickets
     *
     * @param \Throwable $th
     * @param string $functionName
     * @return \Illuminate\View\View
     */
    protected function handleControllerError(\Throwable $th, string $functionName)
    {
        // Log error details for debugging
        Log::error("Error in {$functionName}", [
            'file' => $th->getFile(),
            'line' => $th->getLine(),
            'message' => $th->getMessage(),
            'trace' => $th->getTraceAsString(),
        ]);

        // Create or retrieve existing support ticket
        $ticket = SupportTicket::firstOrCreate(
            [
                'error_location' => $th->getFile(),
                'error_description' => $th->getMessage(),
                'function_name' => $functionName,
                'error_line' => $th->getLine(),
            ]
        );

        // Return error view with ticket details
        return view('errors.support_tickets', [
            'th' => $th,
            'function_name' => $functionName,
            'end_error_ticket' => $ticket
        ]);
    }
}

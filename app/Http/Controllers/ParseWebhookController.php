<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\DataUpdated;  // Your custom event
use App\Events\ParseLiveQueryEvent;
use Illuminate\Support\Facades\Log as FacadesLog;
use Log;

class ParseWebhookController extends Controller
{
    public function handleWebhook(Request $request)
    {
        // Log the webhook data to inspect the structure
        FacadesLog::info('Parse webhook received:', $request->all());

        // Example of broadcasting the event to the frontend
        $data = $request->all();  // You can filter this based on your requirements

        // You can perform some action here before broadcasting (e.g., store data, update models)

        // Dispatch the event for real-time updates
        event(new ParseLiveQueryEvent($data));

        return response()->json(['status' => 'ok']);
    }
}

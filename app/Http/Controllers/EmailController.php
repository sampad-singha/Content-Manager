<?php

namespace App\Http\Controllers;

use App\Services\EmailService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class EmailController extends Controller
{
    protected $emailService;

    public function __construct(EmailService $emailService)
    {
        return $this->emailService = $emailService;
    }

    public function getAll()
    {
        try{
            $emails = $this->emailService->getAll();
            return view('emails.index', ['emails' => $emails]);
        } catch (\Exception $exception) {
            Log::error('Error fetching all emails: ' . $exception->getMessage());
            return response()->json(['message' => $exception->getMessage()], 500);
        }
    }

    public function getEmailByReceiver(Request $request)
    {
        try {
            $receiver = $request->input('receiver');
            $emails =  $this->emailService->getEmailByReceiver($receiver);
            return view('emails.filterByReceiver', ['emails' => $emails]);
        }catch (\Exception $exception){
            Log::error('Error fetching email by receiver: ' . $exception->getMessage());
            return response()->json(['message' => $exception->getMessage()], 500);
        }
    }

    /**
     * @throws \Exception
     */
    public function create(Request $request)
    {
        $response = $this->emailService->create($request->all());
        dd($response);
    }
}

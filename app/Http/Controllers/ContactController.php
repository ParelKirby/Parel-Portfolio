<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Services\PortfolioData;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ContactController extends Controller
{
    public function __construct(private readonly PortfolioData $portfolioData)
    {
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['nullable', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'message' => ['required', 'string', 'max:5000'],
        ], [
            'email.required' => 'Please provide your email address.',
            'email.email' => 'Please provide a valid email address.',
            'message.required' => 'Please write a message.',
        ]);

        $message = Message::query()->create([
            'name' => $validated['name'] ?? null,
            'email' => $validated['email'],
            'message' => $validated['message'],
            'status' => 'pending',
        ]);

        $sent = $this->forwardToMailService($message);

        $message->update([
            'status' => $sent ? 'sent' : 'failed',
            'sent_at' => $sent ? now() : null,
        ]);

        if ($sent) {
            return back()->with('contact_sent', true);
        }

        return back()->with('contact_error', 'Message was saved but could not be emailed. We will still receive it.');
    }

    private function forwardToMailService(Message $message): bool
    {
        $endpoint = rtrim(config('portfolio.mail_service_url'), '/').'/send';
        $recipient = config('portfolio.contact_email');

        if (empty($recipient)) {
            return false;
        }

        try {
            $response = Http::timeout(15)->asJson()->post($endpoint, [
                'to' => $recipient,
                'subject' => sprintf('Website contact from %s', $message->name ?: $message->email),
                'body' => $message->message."\n\n---\nFrom: ".($message->name ?: 'Anonymous').' <'.$message->email.'>',
                'html' => false,
                'from_name' => $message->name,
                'from_email' => $message->email,
            ]);

            return $response->successful();
        } catch (\Throwable $e) {
            Log::warning('Failed to forward contact message to mail service.', [
                'error' => $e->getMessage(),
            ]);

            return false;
        }
    }
}

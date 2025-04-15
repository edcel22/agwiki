<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\User;
use Illuminate\Support\Facades\Http;

class CleanupInvalidEmails extends Command
{
    protected $signature = 'emails:cleanup-invalid';
    protected $description = 'Soft delete users with invalid email addresses using Abstract API';

    public function handle()
    {
        $apiKey = '8b1f1364eac54d159aaf14e236a4387c';

        $users = User::whereNull('deleted_at')->get();

        foreach ($users as $user) {
            $response = Http::get("https://emailvalidation.abstractapi.com/v1/", [
                'api_key' => $apiKey,
                'email' => $user->email
            ]);

            if ($response->successful()) {
                $data = $response->json();
                if ($data['deliverability'] !== 'DELIVERABLE') {
                    $this->info("Soft deleting: {$user->email} ({$data['deliverability']})");
                    $user->delete();
                } else {
                    $this->line("Valid: {$user->email}");
                }
            } else {
                $this->error("Failed to check {$user->email}: {$response->status()}");
            }

            sleep(1); // Avoid hitting API rate limits
        }

        $this->info('Email validation and cleanup done!');
    }
}

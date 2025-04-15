<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\User;
use GuzzleHttp\Client;

class CleanupInvalidEmails extends Command
{
    protected $signature = 'emails:cleanup-invalid';
    protected $description = 'Soft delete users with invalid email addresses using Abstract API';

    public function handle()
    {
        $apiKey = '8b1f1364eac54d159aaf14e236a4387c';
        $client = new Client();

        $users = User::whereNull('deleted_at')->get();

        foreach ($users as $user) {
            try {
                $response = $client->request('GET', 'https://emailvalidation.abstractapi.com/v1/', [
                    'query' => [
                        'api_key' => $apiKey,
                        'email' => $user->email,
                    ],
                    'timeout' => 10,
                ]);

                $data = json_decode($response->getBody(), true);

                if (isset($data['deliverability']) && $data['deliverability'] !== 'DELIVERABLE') {
                    $this->info("Soft deleting: {$user->email} ({$data['deliverability']})");
                    $user->delete(); // Soft delete
                } else {
                    $this->line("Valid: {$user->email}");
                }

            } catch (\Exception $e) {
                $this->error("Error checking {$user->email}: " . $e->getMessage());
            }

            sleep(1); // Prevent API rate limiting
        }

        $this->info('Email validation and cleanup done!');
    }
}

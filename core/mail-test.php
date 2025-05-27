<?php
require __DIR__ . '/vendor/autoload.php';

// Get the Laravel app
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

// Try direct Postmark API
try {
    echo "Attempting to send via direct Postmark API...\n";
    $client = new \Postmark\PostmarkClient('362472fb-178c-4cbd-94b2-c59bb5f112b3');
    $response = $client->sendEmail(
        'rpkrotz@agwiki.com',
        'edcel.estadola.dev@gmail.com',
        'Test from direct Postmark API',
        "This is a test email sent via direct Postmark API.",
        "<html><body><h1>Test Email</h1><p>This is a test email sent via direct Postmark API.</p></body></html>"
    );
    echo "Success! Message ID: " . $response['MessageID'] . "\n";
} catch (\Exception $e) {
    echo "Direct API Error: " . $e->getMessage() . "\n";
}

// Try Laravel Mail
try {
    echo "Attempting to send via Laravel Mail...\n";
    
    \Illuminate\Support\Facades\Mail::raw('Test from Laravel Mail', function($message) {
        $message->to('edcel.estadola.dev@gmail.com')
               ->from('rpkrotz@agwiki.com', 'AGWIKI')
               ->subject('Test from Laravel Mail');
    });
    
    echo "Laravel Mail sent successfully!\n";
} catch (\Exception $e) {
    echo "Laravel Mail Error: " . $e->getMessage() . "\n";
}

echo "Done!\n";

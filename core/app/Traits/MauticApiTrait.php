<?php
// app/Traits/MauticApiTrait.php
namespace App\Traits;

trait MauticApiTrait
{
    protected function makeApiRequest($url, $method = 'GET', $data = null)
    {
        $ch = curl_init();
        
        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_HTTPHEADER => [
                "Content-type: application/json",
                "Authorization: Basic " . base64_encode("sitecontrol:flattir3"),
                "User-Agent: Mozilla/5.0",
                "Accept: application/json"
            ]
        ]);

        if ($data && $method === 'POST') {
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        }

        $response = curl_exec($ch);
        
        if (curl_errno($ch)) {
            \Log::error("Mautic API error: " . curl_error($ch));
            curl_close($ch);
            return null;
        }
        
        curl_close($ch);
        return json_decode($response, true);
    }

    protected function handleMauticContact($email, $segments = [])
    {
        try {
            // Get or create contact
            $contact_id = $this->getOrCreateMauticContact($email);
            
            if (!$contact_id) {
                return false;
            }

            // Add contact to specified segments
            foreach ($segments as $segment) {
                $this->addContactToSegment($contact_id, $segment);
            }

            return true;
        } catch (\Exception $e) {
            \Log::error("Mautic contact handling error: " . $e->getMessage());
            return false;
        }
    }

    protected function getOrCreateMauticContact($email)
    {
        // First try to get existing contact
        $url = 'https://mautic.agwiki.com/api/contacts?search=' . urlencode($email);
        $contact = $this->makeApiRequest($url);

        if (isset($contact['contacts']) && !empty($contact['contacts'])) {
            return array_keys($contact['contacts'])[0];
        }

        // Create new contact if not found
        $url = 'https://mautic.agwiki.com/api/contacts/new';
        $data = ['email' => $email, 'overwriteWithBlank' => true];
        $result = $this->makeApiRequest($url, 'POST', $data);

        return $result['contact']['id'] ?? null;
    }

    protected function addContactToSegment($contact_id, $segment_id)
    {
        $url = "https://mautic.agwiki.com/api/segments/{$segment_id}/contact/{$contact_id}/add";
        return $this->makeApiRequest($url, 'POST');
    }
}
<?php

namespace App\Mail;

use Illuminate\Mail\Transport\Transport;
use Postmark\PostmarkClient;
use Swift_Mime_SimpleMessage;

class PostmarkTransport extends Transport
{
    /**
     * The Postmark API client.
     *
     * @var \Postmark\PostmarkClient
     */
    protected $client;

    /**
     * The Postmark API key.
     *
     * @var string
     */
    protected $key;

    /**
     * Create a new Postmark transport instance.
     *
     * @param  \Postmark\PostmarkClient  $client
     * @param  string  $key
     * @return void
     */
    public function __construct(PostmarkClient $client, $key)
    {
        $this->key = $key;
        $this->client = $client;
    }

    /**
     * {@inheritdoc}
     */
    public function send(Swift_Mime_SimpleMessage $message, &$failedRecipients = null)
    {
        $this->beforeSendPerformed($message);

        $to = $this->getTo($message);
        $cc = $this->getCc($message);
        $bcc = $this->getBcc($message);
        $from = $this->getFrom($message);

        $response = $this->client->sendEmail(
            $from,
            $to,
            $message->getSubject(),
            $message->getBody(),
            $this->getPlainTextBody($message),
            null, // tag
            true, // track opens
            $message->getHeaders()->get('Reply-To') ? $message->getHeaders()->get('Reply-To')->getFieldBody() : null,
            $cc,
            $bcc
        );

        $this->sendPerformed($message);

        return $this->numberOfRecipients($message);
    }

    /**
     * Get the plain text part from the message.
     *
     * @param  \Swift_Mime_SimpleMessage  $message
     * @return string|null
     */
    protected function getPlainTextBody(Swift_Mime_SimpleMessage $message)
    {
        $contentType = $message->getContentType();

        if ($contentType == 'text/plain') {
            return $message->getBody();
        }

        foreach ($message->getChildren() as $child) {
            if ($child->getContentType() == 'text/plain') {
                return $child->getBody();
            }
        }

        return null;
    }

    /**
     * Get the "to" recipients from the message.
     *
     * @param  \Swift_Mime_SimpleMessage  $message
     * @return string
     */
    protected function getTo(Swift_Mime_SimpleMessage $message)
    {
        return $this->formatAddress($message->getTo());
    }

    /**
     * Get the "cc" recipients from the message.
     *
     * @param  \Swift_Mime_SimpleMessage  $message
     * @return string
     */
    protected function getCc(Swift_Mime_SimpleMessage $message)
    {
        return $this->formatAddress($message->getCc());
    }

    /**
     * Get the "bcc" recipients from the message.
     *
     * @param  \Swift_Mime_SimpleMessage  $message
     * @return string
     */
    protected function getBcc(Swift_Mime_SimpleMessage $message)
    {
        return $this->formatAddress($message->getBcc());
    }

    /**
     * Get the "from" field from the message.
     *
     * @param  \Swift_Mime_SimpleMessage  $message
     * @return string
     */
    protected function getFrom(Swift_Mime_SimpleMessage $message)
    {
        return $this->formatAddress($message->getFrom());
    }

    /**
     * Format the addresses.
     *
     * @param  array  $addresses
     * @return string
     */
    protected function formatAddress($addresses)
    {
        if (is_null($addresses)) {
            return null;
        }

        return array_keys($addresses)[0];
    }
}

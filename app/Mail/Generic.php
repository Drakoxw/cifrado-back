<?php

namespace App\Mail;

use App\Classes\Mails\Base as DataBaseEmails;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class Generic extends Mailable
{
    use Queueable, SerializesModels;

    private DataBaseEmails $data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(DataBaseEmails $data)
    {
        $this->data = $data->get();
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: $this->data->subject,
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        return new Content(
            htmlString: $this->data->template
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }
}

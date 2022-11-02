<?php

namespace App\Mail;

use App\Models\Zone;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The order instance.
     *
     */
    public $zone;
    public $type;
    public $temperature;
    public $humidity;
    public $my_message;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Zone $zone,$type,$temperature,$humidity,$my_message = Null)
    {
        $this->zone = $zone;
        $this->type = $type;
        $this->humidity = $humidity;
        $this->temperature = $temperature;
        $this->my_message = $my_message;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: 'Notification Mail',
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
            view: 'emails.notification',
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

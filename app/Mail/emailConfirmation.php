<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class emailConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public $id_transaksi;
    public $nama_tamu;
    // public $id_transaksi;

    /**
     * Create a new message instance.
     *
     * @return void
     */

  

    public function __construct($id_transaksi, $nama_tamu)
    {
        $this -> id_transaksi = $id_transaksi;
        $this -> nama_tamu = $nama_tamu;
    }

    public function build()
    {
        return $this -> view('email_confirmation') -> subject('Confirmation email');
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: 'Email Confirmation',
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
            view: 'email_confirmation',
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

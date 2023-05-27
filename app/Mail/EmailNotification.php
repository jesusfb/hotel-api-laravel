<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EmailNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $id_transaksi;
    public $nama_tamu;
    public $tanggal_checkin;
    public $tanggal_checkout;
    // public $isi;
    public $jumlah_kamar;
    public $harga;
    // public $total;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($nama_tamu, $id_transaksi, $tanggal_checkin, $tanggal_checkout, $jumlah_kamar, $harga)
    {
        $this -> nama_tamu = $nama_tamu;
        $this -> tanggal_checkin = $tanggal_checkin;
        $this -> tanggal_checkout = $tanggal_checkout;
        // $this -> isi = $isi;    
        $this -> jumlah_kamar = $jumlah_kamar;
        $this -> harga = $harga;
        // $this -> total = $total;
        $this -> id_transaksi = $id_transaksi;
    }

    public function build(){
        return $this -> view('email') -> subject('Ngetes email');
    }
 
    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: 'Email Notification',
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
            view: 'email',
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

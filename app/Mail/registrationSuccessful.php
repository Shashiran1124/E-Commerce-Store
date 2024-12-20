<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class registrationSuccessful extends Mailable
{
    use Queueable, SerializesModels;

    public $customer;
    
    public function __construct($customer)
    {
        $this->customer = $customer;
    }

    public function build()
    {
        return $this->subject('Welcome to Pick & Pay!')
                    ->view('emails.registration_success')
                    ->with('customer', $this->customer);
    }
   
}

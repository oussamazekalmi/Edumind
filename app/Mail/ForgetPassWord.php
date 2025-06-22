<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ForgetPassWord extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct($username,$email,$password,$forgetPassword)
    {
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
        $this->forgetPassword = $forgetPassword;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Récupération de mot de passe',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        if ($this->forgetPassword) {
            return new Content(
                view: 'emails.forgetPassword',
                with:[
                    'username'=>$this->username,
                    'forgetPassword'=>$this->forgetPassword
                ]
            );
        } else {
            return new Content(
                view: 'emails.modificationPassword',
                with:[
                    'username'=>$this->username,
                    'email'=>$this->email,
                    'password'=>$this->password
                ]
            );
        }
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
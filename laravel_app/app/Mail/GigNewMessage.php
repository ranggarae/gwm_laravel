<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class GigNewMessage extends Mailable
{
    use Queueable, SerializesModels;
    public $data;
    public $subject;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data,$subject)
    {
        $this->data = $data;
        $this->subject = $subject;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $default_lang = get_default_language();
        $mail =  $this->from(get_static_option('site_global_email'),get_static_option('site_'.$default_lang.'_title'))
            ->subject($this->subject )
            ->view('mail.gig-message');

        return $mail;
    }
}

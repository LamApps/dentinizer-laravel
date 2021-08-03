<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SupplyRequest extends Mailable
{
    use Queueable, SerializesModels;

    public $request;
    public $sprequestItems;
    public $total;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($request,$sprequestItems,$total)
    {
        $this->request = $request;
        $this->sprequestItems = $sprequestItems;
        $this->total = $total;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $app_title=config('global.app_title');
        $app_email_from=config('global.app_email_from');
        return $this->from($app_email_from, $app_title)->subject($this->request->subject)->view('request.emails.request');
    }
}

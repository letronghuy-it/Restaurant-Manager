<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class QuenMatKhau extends Mailable
{
    use Queueable, SerializesModels;
    protected $link;
    public function __construct($link)
    {
        $this->$link =$link;
    }

    public function build(){
        return $this->subject('Khôi Phục Tài Khoản Của Bạn')
                    ->view('admin.page.mail.index',[
                        'link' =>$this->link
                    ]);
    }

}

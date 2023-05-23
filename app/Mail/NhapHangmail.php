<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NhapHangmail extends Mailable
{
    use Queueable, SerializesModels;

    protected $data;
    public function __construct($data)
    {
        $this->data = $data;
    }
    public function build()
    {
        return $this->subject('Xác Nhận Nhập hàng')
            ->view('admin.page.mail.mail_xac_nhan_nhap_hang', [
                'data' => $this->data
            ]);
    }
}

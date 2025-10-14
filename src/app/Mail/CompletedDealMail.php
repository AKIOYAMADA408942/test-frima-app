<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CompletedDealMail extends Mailable
{
    use Queueable, SerializesModels;

    private $seller_name;
    private $buyer_name;
    private $item_name;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($mail)
    {
        $this->seller_name = $mail['seller_name'];
        $this->buyer_name = $mail['buyer_name'];
        $this->item_name = $mail['item_name'];
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('取引完了しました')->view('emails.complete-deal')->with([
            'seller_name' => $this->seller_name,
            'buyer_name' => $this->buyer_name,
            'item_name' => $this->item_name,
        ]);
    }
}

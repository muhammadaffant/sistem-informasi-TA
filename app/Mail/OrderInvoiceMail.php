<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Barryvdh\DomPDF\Facade\Pdf; // <-- Import PDF Facade

class OrderInvoiceMail extends Mailable
{
    use Queueable, SerializesModels;

    public $order;
    public $orderItem;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($order, $orderItem)
    {
        $this->order = $order;
        $this->orderItem = $orderItem;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // Data yang akan dikirim ke view PDF
        $data = [
            'order' => $this->order,
            'orderItem' => $this->orderItem,
        ];

        // Buat PDF dari view invoice Anda
        // $pdf = Pdf::loadView('frontend.user.invoice.pdf', $data);

        // Kirim email dengan lampiran PDF
        return $this->subject('Invoice untuk Pesanan #' . $this->order->invoice_no)
                    ->view('emails.order.invoice_email_body') // Body email (bisa dibuat sederhana)
                    ->with($data);
                    // ->attachData($pdf->output(), 'invoice-'.$this->order->invoice_no.'.pdf', [
                    //     'mime' => 'application/pdf',
                    // ]);
    }
}
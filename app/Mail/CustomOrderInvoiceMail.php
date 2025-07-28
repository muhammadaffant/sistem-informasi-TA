<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Barryvdh\DomPDF\Facade\Pdf;

class CustomOrderInvoiceMail extends Mailable
{
    use Queueable, SerializesModels;

    public $customOrder;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($customOrder)
    {
        $this->customOrder = $customOrder;
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
            'customOrder' => $this->customOrder,
        ];

        // Buat PDF dari view invoice CUSTOM ORDER Anda
        // Pastikan path-nya benar
        $pdf = Pdf::loadView('admin.customorder.download', $data);

        // Siapkan nama file untuk lampiran
        $fileName = 'invoice-custom-' . $this->customOrder->id . '-' . time() . '.pdf';

        // Kirim email dengan lampiran PDF
        return $this->subject('Invoice untuk Pesanan Custom Anda')
                    ->view('emails.custom_order.invoice_email_body', ['order' => $this->customOrder]) // Kita bisa gunakan body email yang sama
                    ->attachData($pdf->output(), $fileName, [
                        'mime' => 'application/pdf',
                    ]);
    }
}
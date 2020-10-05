<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Booking;
use App\Itinerary;

class TicketSent extends Mailable
{
    use Queueable, SerializesModels;

    protected $booking;
    protected $itinerary;
    protected $seats;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Booking $booking, Itinerary $itinerary, $seats)
    {
        //
        $this->booking = $booking;
        $this->itinerary = $itinerary;
        $this->seats = $seats;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.ticket_invoice')
                    ->with([
                        'booking' => $this->booking,
                        'itinerary' => $this->itinerary,
                        'seats' => $this->seats
                    ]);
    }
}

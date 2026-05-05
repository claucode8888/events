<?php

namespace App\Service;

use App\Entity\Booking;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;

class EmailService
{
  public function __construct(private MailerInterface $mailer){}


  public function sendBookingConfirmation(Booking $booking, int $totalTickets, array $ticketsByCategory): void
  {
    $eventName = $booking->getTickets()[0]->getCategory()->getEvent()->getName();
    $subject = 'Booking Confirmation '.$eventName;

    $email = new TemplatedEmail()
      ->from(new Address('no-replay@eventhub.com', 'EventHub'))
      ->to('claucode88@gmail.com')
      ->subject($subject)
      ->htmlTemplate('email/booking_confirmation.html.twig')
      ->context([
        'booking' => $booking,
        'total_tickets_booking' => $totalTickets,
        'tickets_by_category' => $ticketsByCategory,
      ]);
    $this->mailer->send($email);
  }
}
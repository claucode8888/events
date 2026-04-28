<?php

namespace App\Service;

use App\Entity\Booking;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;

class EmailService
{
  public function __construct(private MailerInterface $mailer){}


  public function welcome(Booking $booking): void
  {
    $email = new TemplatedEmail()
      ->from(new Address('no-replay@eventhub.com', 'EventHub'))
      ->to('claucode88@gmail.com')
      ->subject('Welcome!')
      ->htmlTemplate('email/welcome.html.twig')
      ->context([
        'booking' => $booking,
        'event' => $booking->getTickets()[0]->getCategory()->getEvent(),
        'tickets_by_category' => '1000',
        'total_tickets_booking' => '8000'
      ]);
    $this->mailer->send($email);
  }
}
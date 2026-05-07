<?php

namespace App\Service;

use App\Entity\Booking;
use Psr\Log\LoggerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;

class EmailService
{
  public function __construct(
    private LoggerInterface $logger,
    private MailerInterface $mailer,
    #[Autowire('%app_sender_email%')] private string $senderEmail,
    #[Autowire('%app_name%')] private string $appName,
  ){}

    public function sendBookingConfirmation(Booking $booking, int $totalTickets, array $ticketsByCategory) : bool
  {
    $eventName = $booking->getTickets()[0]->getCategory()->getEvent()->getName();
    $subject = 'Booking Confirmation '.$eventName;

    $email = new TemplatedEmail()
      ->from(new Address($this->senderEmail, $this->appName))
      ->to($this->senderEmail)
      ->subject($subject)
      ->htmlTemplate('email/booking_confirmation.html.twig')
      ->context([
        'booking' => $booking,
        'total_tickets_booking' => $totalTickets,
        'tickets_by_category' => $ticketsByCategory,
      ]);

    try {
      $this->mailer->send($email);
      return true;
    }catch (TransportExceptionInterface $e) {
      $this->logger->error('Booking confirmation email failed', [
        'booking_id' => $booking->getId(),
        'error' => $e->getMessage(),
      ]);
      return false;
    }

  }
}
<?php

namespace App\Service;

use App\Entity\Booking;
use Psr\Log\LoggerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;

class EmailService
{
  public function __construct(
    private LoggerInterface $logger,
    private MailerInterface $mailer,
    private string $senderEmail,
    private string $appName,
  ){}

    public function sendBookingConfirmation(Booking $booking, string $html, array $attachments = []) : bool
  {
    $eventName = $booking->getTickets()[0]->getCategory()->getEvent()->getName();
    $subject = 'Booking Confirmation '.$eventName;

    $email = new TemplatedEmail()
      ->from(new Address($this->senderEmail, $this->appName))
      ->to($booking->getUser()->getEmail())
      ->subject($subject)
      ->html($html);

    if($attachments)
    {
      foreach ($attachments as $attachment) {
        $email->attach(
          $attachment['content'],
          $attachment['name'],
          $attachment['type']
        );
      }
    }
    
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
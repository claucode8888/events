<?php

namespace App\Service;

use App\Entity\Booking;
use Stripe\Checkout\Session;
use Stripe\Stripe;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class StripePaymentService
{
  public function __construct(
    private string $stripeSecretKey,
    private UrlGeneratorInterface $urlGenerator,
  ) {
    Stripe::setApiKey($this->stripeSecretKey);
  }

  public function createPaymentSession(Booking $booking): Session
  {
    $firstTicket = $booking->getTickets()->first();
    $productName = $firstTicket?->getCategory()->getEvent()->getName() ?? 'Event';
    
    $session = Session::create([
      'payment_method_types' => ['card'],
      'line_items' => [[
        'price_data' => [
          'currency' => 'eur',
          'product_data' => [
            'name' => $productName
          ],
          'unit_amount' => $this->calculateStripeUnitAmount($booking->getTotal())
        ],
        'quantity' => 1,
      ]],
      'mode' => 'payment',
      'success_url' => $this->urlGenerator->generate('app_payment_success', [
        'booking_id' => $booking->getId(),
      ], UrlGeneratorInterface::ABSOLUTE_URL),
      'cancel_url' => $this->urlGenerator->generate('app_payment_cancel', [
        'booking_id' => $booking->getId(),
      ], UrlGeneratorInterface::ABSOLUTE_URL),
      'metadata' => [
        'booking_id' => $booking->getId(),
      ],
    ]);

    return $session;
  }

  private function calculateStripeUnitAmount(int|float $total) : int
  {
    return (int) round($total * 100);
  }
}
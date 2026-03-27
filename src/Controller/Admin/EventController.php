<?php

namespace App\Controller\Admin;

use App\Entity\Event;
use App\Form\EventType;
use App\Entity\TicketCategory;
use App\Service\ImageUploader;
use App\Repository\EventRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_ADMIN')]
#[Route('admin/event')]
final class EventController extends AbstractController
{
  #[Route(name: 'app_admin_events_index', methods: ['GET'])]
  public function index(EventRepository $eventRepository): Response
  {
    return $this->render('admin/event/index.html.twig', [
      'events' => $eventRepository->findBy([], ['createdAt' => 'DESC']),
    ]);
  }

  #[Route('/new', name: 'app_admin_event_new', methods: ['GET', 'POST'])]
  public function new(Request $request, EntityManagerInterface $entityManager, ImageUploader $imageUploader): Response
  {
    $event = new Event();
    $event->addTicketCategory(new TicketCategory());
    $form = $this->createForm(EventType::class, $event);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      if ($form->get('imageFile')->getData()) {
        /** Upload image in events directory */
        $filename = $imageUploader->upload($form->get('imageFile')->getData());
        /** End Upload image in events directory */
        $event->setImgPath($filename);
      }

      $entityManager->persist($event);
      $entityManager->flush();
      $this->addFlash('success', 'Event "' . $event->getName() . '" created successfully.');
      return $this->redirectToRoute('app_admin_events_index', [], Response::HTTP_SEE_OTHER);
    }

    return $this->render('admin/event/new.html.twig', [
      'event' => $event,
      'form' => $form,
    ]);
  }

  #[Route('/{id}', name: 'app_admin_event_show', methods: ['GET'])]
  public function show(Event $event): Response
  {
    return $this->render('event/show.html.twig', [
      'event' => $event,
    ]);
  }

  #[Route('/{id}/edit', name: 'app_admin_event_edit', methods: ['GET', 'POST'])]
  public function edit(Request $request, Event $event, EntityManagerInterface $entityManager, ImageUploader $imageUploader): Response
  {
    $form = $this->createForm(EventType::class, $event, ['is_edit' => true]);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      if ($form->get('imageFile')->getData()) {
       /** Replace image in events directory */
        $oldFilename = $event->getImgPath();
        $filename = $imageUploader->replace($form->get('imageFile')->getData(), $oldFilename);
       /** End Replace image in events directory */
        $event->setImgPath($filename);
      }
      $entityManager->persist($event);
      $entityManager->flush();

      $this->addFlash('success', 'Event "' . $event->getName() . '" was updated.');
      return $this->redirectToRoute('app_admin_events_index', [], Response::HTTP_SEE_OTHER);
    }

    return $this->render('admin/event/edit.html.twig', [
      'event' => $event,
      'form' => $form,
    ]);
  }

  #[Route('/{id}', name: 'app_admin_event_delete', methods: ['DELETE'])]
  public function delete(Request $request, Event $event, EntityManagerInterface $entityManager, ImageUploader $imageUploader): Response
  {
    if($this->isCsrfTokenValid('delete' . $event->getId(), $request->getPayload()->getString('_token')))
    {
      /** Delete image */
      $imageUploader->delete($event->getImgPath());
      /** End Delete image */

      $entityManager->remove($event);
      $entityManager->flush();
      $this->addFlash('success', 'Event "' . $event->getName() . '" deleted successfully.');
    }
    else{
      $this->addFlash('error', 'Event not found.');
    }

    return $this->redirectToRoute('app_admin_events_index', [], Response::HTTP_SEE_OTHER);
  }
}
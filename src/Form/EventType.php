<?php
namespace App\Form;

use App\Entity\Event;
use App\Entity\EventStatus;
use App\Entity\Organizer;
use App\Entity\TicketCategory;
use App\Form\OrganizerType;
use App\Form\TicketCategoryType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EventType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options): void
  {
    $builder
      ->add('name', TextType::class, ['attr' => ['placeholder' => 'Event name']])
      ->add('description', TextareaType::class, ['attr' => ['placeholder' => 'Describe your event...']])
      ->add('startAt', DateTimeType::class, ['widget' => 'single_text'])
      ->add('endAt', DateTimeType::class, ['widget' => 'single_text'])
      ->add('status', EntityType::class, [
          'class' => EventStatus::class,
          'choice_label' => fn(EventStatus $status) => ucfirst($status->getName()),
          'placeholder' => 'Select a status',
          'required' => true,
      ])
      ->add('imageFile', FileType::class, [
        'mapped' => false,
        'required' => false,
      ])
      ->add('ticketCategories', CollectionType::class, [
        'entry_type' => TicketCategoryType::class,
        'entry_options' => ['label' => false],
        'allow_add' => true,
        'allow_delete' => true,
        'by_reference' => false,
        'prototype' => true,
        'prototype_data' => new TicketCategory(),
      ]);

    // ONLY CREATION CASE
    if(!$options['is_edit']){
      // Create mode - radio and creation block
      $builder
        ->add('organizerMode', ChoiceType::class, [
          'mapped' => false,
          'choices' => [
            'Create new organizer' => 'create',
            'Select existing organizer' => 'select',
          ],
          'expanded' => true,
          'multiple' => false,
          'label' => false,
          'data' => 'create',
        ])

        ->add('organizer', OrganizerType::class, [
          'label' => 'Create a new organizer',
        ]);
    }

    $builder->add('organizerChoices', EntityType::class, [
      'class' => Organizer::class,
      'choice_label' => fn(Organizer $o) => $o->getName() . ' (' . $o->getEmail() . ')',
      'placeholder' => 'Select organizer',
      'mapped' => false,
    ]);

    // In case an organizer already exists, it will be shown as pre-selected
    $builder->addEventListener(FormEvents::POST_SET_DATA, function (FormEvent $event){
      $form = $event->getForm();
      $eventEntity = $event->getData();
      $organizer = $eventEntity->getOrganizer();

      if($organizer){
        $form->get('organizerChoices')->setData($organizer);
      }
    });

    // Add Organizer field regarding to mode - mapped or unmapped
    $builder->addEventListener(FormEvents::PRE_SUBMIT, function (FormEvent $event){
      $form = $event->getForm();
      $data = $event->getData();
      $mode = $data['organizerMode'] ?? 'create';
      
      if($mode === 'select'){
        $form->remove('organizer');
        $form->add('organizer', OrganizerType::class, [
          'label' => 'Create a new organizer',
          'mapped' => false,
          'required' => false,
        ]);
      }
    });

    // Decide which organizer to save
    $builder->addEventListener(FormEvents::POST_SUBMIT, function (FormEvent $event) use ($options) {
      $form = $event->getForm();
      $eventEntity = $event->getData();
      $selected = $form->get('organizerChoices')->getData();

      // CASE CREATION
      if(!$options['is_edit']){
        $mode = $form->get('organizerMode')->getData();
        $new = $form->get('organizer')->getData();

        if($mode === 'select'){
          if(!$selected){
            $form->get('organizerChoices')->addError(new FormError('Please select an organizer.'));
          }
          $eventEntity->setOrganizer($selected);
        }elseif($mode === 'create' && $new){
          $eventEntity->setOrganizer($new);
        }
      }
      // CASE EDITION
      else{
        if(!$selected){
          $form->get('organizerChoices')->addError(new FormError('Please select an organizer.'));
        }
        $eventEntity->setOrganizer($selected);
      }
    });
  }

  public function configureOptions(OptionsResolver $resolver): void
  {
    $resolver->setDefaults([
      'data_class' => Event::class,
      'is_edit' => false,
    ]);
  }
}
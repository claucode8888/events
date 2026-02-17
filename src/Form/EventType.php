<?php
namespace App\Form;

use App\Entity\Event;
use App\Entity\TicketCategory;
use App\Form\TicketCategoryType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class EventType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options): void
  {
    $builder
      ->add('name', TextType::class, ['attr' => ['placeholder' => 'Event name']])
      ->add('description', TextareaType::class, ['attr' => ['placeholder' => 'Describe your event...']])
      ->add('startAt', DateTimeType::class, ['widget' => 'single_text'])
      ->add('endAt', DateTimeType::class, ['widget' => 'single_text'])
      ->add('status', ChoiceType::class, [
        'choices' => [
          'Draft' => 'draft',
          'Published' => 'published',
          'Cancelled' => 'cancelled',
          'Completed' => 'completed'
        ],
        'placeholder' => 'Select status',
        'required' => false
      ])
      ->add('imageFile', FileType::class, [
        'mapped' => false,
        'required' => false
      ])
      // Ticket Categories 
      ->add('ticketCategories', CollectionType::class, [
        'entry_type'   => TicketCategoryType::class,
        'entry_options'=> ['label' => false],
        'allow_add'    => true,
        'allow_delete' => true,
        'by_reference' => false,
        'prototype' => true,
        'prototype_data' => new TicketCategory(),
      ]);
  }

  public function configureOptions(OptionsResolver $resolver): void
  {
    $resolver->setDefaults([
      'data_class' => Event::class
    ]);
  }
}
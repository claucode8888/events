<?php
namespace App\Form;

use App\Entity\Event;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class EventType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options): void
  {
    $builder
      ->add('name', TextType::class, ['attr' => ['placeholder' => 'Event name']])
      ->add('description', TextareaType::class, ['attr' => ['placeholder' => 'Describe your event...']])
      ->add('capacity', IntegerType::class, ['attr' => ['placeholder' => '100', 'min' => 1]])
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
      ]);
  }

  public function configureOptions(OptionsResolver $resolver): void
  {
    $resolver->setDefaults([
      'data_class' => Event::class
    ]);
  }
}
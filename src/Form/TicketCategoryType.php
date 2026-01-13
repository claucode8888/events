<?php

namespace App\Form;

use App\Entity\TicketCategory;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class TicketCategoryType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options): void
  {
    $builder
      ->add('name', TextType::class)
      ->add('price', MoneyType::class, ['currency' => false])
      ->add('quantity', IntegerType::class)
      ->add('_delete', HiddenType::class, [
        'mapped' => false,
        'required' => false,
      ]);
      
    $builder->get('name')->addEventListener(FormEvents::PRE_SUBMIT, function (FormEvent $event) {
      $data = $event->getData();
      if ($data !== null) {
        $event->setData(strtolower(trim($data)));
      }
    });
  }

  public function configureOptions(OptionsResolver $resolver): void
  {
    $resolver->setDefaults([
      'data_class' => TicketCategory::class,
    ]);
  }
}
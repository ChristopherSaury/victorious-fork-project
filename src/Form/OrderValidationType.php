<?php

namespace App\Form;

use App\Entity\Order;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrderValidationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            //->add('price')
            //->add('delivery_hour')
            ->add('location', TextType::class, [
                'label' => 'Adresse de livraison (optionnelle si sur place) :'
            ])
            //->add('user')
            ->add('delivery_hour', DateTimeType::class, [
                        'label' => 'heure de livraison',
                        'placeholder' => [
                            'year' => 'Year', 'month' => 'Month', 'day' => 'Day',
                            'hour' => 'Hour', 'minute' => 'Minute',
                        ],
                    ])
            // ->add('submit', SubmitType::class,[
            //     'label' => "Payer"
            // ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Order::class,
        ]);
    }
}

<?php

namespace App\Form;

use App\Entity\Ad;
use App\Entity\User;
use App\Entity\Booking;
use App\Form\ApplicationType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use App\Form\DataTransformer\FrenchToDateTimeTransformer;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class AdminBookingType extends ApplicationType
{

    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'startDate',
                DateType::class,
                $this->getConfiguration(
                    "Date d'arrivée", 
                    "La date à laquelle vous comptez arriver ...",
                    ['widget' => 'single_text']
                )  
            )
            ->add(
                'endDate',
                DateType::class,
                $this->getConfiguration(
                    "Date de départ", 
                    "La date à laquelle vous quittez les lieux ...",
                    ['widget' => 'single_text']
                ) 
            )
            ->add(
                'comment',
                TextareaType::class,
                $this->getConfiguration(
                    false, 
                    "Faites nous part d'un commentaire ...",
                    ["required" => false]
                ) 
            )
            ->add(
                'booker',
                EntityType::class,
                [
                    'class' => User::class,
                    'choice_label' => 'fullName'
                ]
            )
            ->add(
                'ad',
                EntityType::class,
                [
                    'class' => Ad::class,
                    'choice_label' => 'title'
                ]
            );


    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Booking::class,
        ]);
    }
}

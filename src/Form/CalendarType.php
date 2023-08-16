<?php

namespace App\Form;

use App\Entity\Calendar;
use Doctrine\DBAL\Types\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\Constraints\GreaterThan;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

class CalendarType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title',null, [
                'attr' => ['class' => 'form-control','placeholder'=>'Enter your Name'],
                ])
            ->add('guests',ChoiceType::class, [
                'attr' => ['class' => 'form-control'],
                'choices'  => [
                    '1' => 1,
                    '2' => 2,
                    '3' => 3,
                ],
            ])
            ->add('children',ChoiceType::class, [
                'attr' => ['class' => 'form-control'],
                'choices'  => [
                    '0' => 0,
                    '1' => 1,
                    '2' => 2,
                    '3' => 3,
                ],
            ])
            ->add('start', DateTimeType::class, [
                'widget' => 'single_text',
                'constraints' => [
                    new GreaterThan([
                        'value' => new \DateTime('today')]), // Minimum date constraint
                ],
            ])
            ->add('endReversed',DateTimeType::class, [
                'widget' => 'single_text',
                'constraints' => [
                    new Callback([$this, 'validateEndDate']),
                ],
            ])
            ->add('statut',ChoiceType::class, [
                'attr' => ['class' => 'form-control'],
                'choices'  => [
                    'occuper' => 'occuper',
                    'libre' => 'libre',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Calendar::class,
        ]);
    }
    public function validateEndDate($endDate, ExecutionContextInterface $context)
    {
        /** @var FormInterface $form */
        $form = $context->getRoot();
        $startDate = $form->get('start')->getData();

        if ($startDate >= $endDate) {
            $context->buildViolation('The end date must be after the start date.')
                ->atPath('endReversed')
                ->addViolation();
        }
    }
}

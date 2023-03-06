<?php

namespace App\Form;

use App\Entity\Product;
use App\Form\Data\CalcFormData;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class CalcType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Products', EntityType::class, [
                'class' => Product::class,
                'choice_label' => function (Product $product) {
                    return $product->getCaption() . ' - ' . $product->getCost() . ' EUR.';
                },
                'attr' => ['class' => 'btn btn-primary'],
                'constraints' => [
                        new Assert\NotBlank(),
                    ]
            ])
            ->add('taxNumber', TextType::class, [
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Regex([
                        'pattern' => '/^\w{2}\d{9}$/',
                        'message' => 'Incorrect TAX number.'
                    ])
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Calculate',
                'attr' => ['class' => 'btn btn-primary'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => CalcFormData::class,
        ]);
    }

}
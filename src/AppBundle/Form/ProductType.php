<?php

namespace AppBundle\Form;

use AppBundle\Entity\Category;
use AppBundle\Entity\Promotion;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('picture', UrlType::class, array('label' => 'Picture URL: '))
                ->add('name', TextType::class, array('label' => 'Name: '))
                ->add('description', TextareaType::class, array('label' => 'Description: '))
                ->add('quantity', NumberType::class, array('label' => 'Quantity: '))
                ->add('price', MoneyType::class, array('label' => 'Price: ', 'currency' => 'BGN'))
                ->add('category', EntityType::class, [
                    'class' => Category::class,
                    'label' => 'Category: ',
                    'choice_label' => 'name',
                    'placeholder' => 'Choose Category'])
                ->add("promotions", EntityType::class, [
                'class' => Promotion::class,
                    'required' => false,
                'multiple' => true,
                'expanded' => true ]);
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Product'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_product';
    }


}

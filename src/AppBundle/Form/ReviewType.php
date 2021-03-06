<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReviewType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('rating', ChoiceType::class, [
            "placeholder" => "Add Stars",
            "choices" => [
                '★ ☆ ☆ ☆ ☆' => '★ ☆ ☆ ☆ ☆',
                '★ ★ ☆ ☆ ☆' => '★ ★ ☆ ☆ ☆',
                '★ ★ ★ ☆ ☆' => '★ ★ ★ ☆ ☆',
                '★ ★ ★ ★ ☆' => '★ ★ ★ ★ ☆',
                '★ ★ ★ ★ ★' => '★ ★ ★ ★ ★'
            ]])
            ->add('body');
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Review'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_review';
    }


}

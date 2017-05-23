<?php
namespace WCS\TvShowManagerBundle\Form;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use WCS\TvShowManagerBundle\Controller\TvShowController;
use WCS\TvShowManagerBundle\Entity\TvShow;

class TvShowType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array
    $options)
    {
        $builder
            ->add('name', TextType::class)
            ->add('type', TextType::class)
            ->add('url', TextType::class)
            ->add('year', TextType::class)
            ->add('Enregistrer', SubmitType::class);
    }
        public function configureOptions(OptionsResolver $resolver){
        $resolver->setDefaults(array(
            'data_class' => TvShow::class
));
    }
}
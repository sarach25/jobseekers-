<?php

namespace MyApp\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EntreprisesForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
$builder
    ->add('nomentreprise')
    ->add('domaine')
    ->add('adresse')
    ->add('imgentreprise',FileType::class, array('label' => 'Imgentreprise (Image file)'))
    ->setMethod('GET')
    ->add('ajouter',SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'class' => 'MyAppUserBundle:Entreprise',
        ));
    }

    public function getName()
    {
        return 'my_app_user_bundle_entreprises_form';
    }
}

<?php
/**
 * Created by PhpStorm.
 * User: ODevS-Inc
 * Date: 9/22/2017
 * Time: 2:58 PM
 */

namespace AuthBundle\Form;
use AuthBundle\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null, [
                'label'    => 'Nom',
                'required' => true,
            ])
            ->add('firstname', null, [
                'label'    => 'Prénom',
                'required' => true,
            ])
            /*->add('enabled', CheckboxType::class, [
                'label'    => 'Activer/Désactiver',
                'required' => false,
            ])*/
            ->add('ficheClient', FicheClientType::class)
        ;
    }

    public function getParent()
    {
        return 'FOS\UserBundle\Form\Type\RegistrationFormType';
    }

    public function getBlockPrefix()
    {
        return 'app_user_registration';
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => User::class,
            'csrf_token_id' => 'registration',
        ));
    }

}
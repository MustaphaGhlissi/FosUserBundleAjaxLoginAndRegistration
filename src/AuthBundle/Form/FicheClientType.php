<?php
/**
 * Created by PhpStorm.
 * User: ODevS-Inc
 * Date: 9/22/2017
 * Time: 3:40 PM
 */

namespace  AuthBundle\Form;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use AuthBundle\Entity\FicheClient;

class FicheClientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('phone', null, [
                'label'    => 'Téléphone',
                'required' => true,
            ])
            ->add('address', null, [
                'label'    => 'Adresse',
                'required' => true,
            ])
            ->add('address2', null, [
                'label'    => 'Complément d\'adresse',
                'required' => false,
            ])
            ->add('zip', null, [
                'label'    => 'Code postal',
                'required' => true,
            ])
            ->add('city', null, [
                'label'    => 'Ville',
                'required' => true,
            ])
            ->add('country', CountryType::class, [
                'label'    => 'Pays',
                'required' => true,
                'data'     => 'FR',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => FicheClient::class,
        ]);
    }

    public function getName()
    {
        return 'fiche_client_type';
    }
}

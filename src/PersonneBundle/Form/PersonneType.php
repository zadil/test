<?php

namespace PersonneBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class PersonneType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nom' , TextType::class)
                ->add('prenom' , TextType::class)
                ->add('email' , TextType::class)
                ->add('password', PasswordType::class )
                ->add('sexe' , TextType::class)
                ->add('numero', TextType::class)
                ->add('rue', TextType::class)
                ->add('codePostal' , TextType::class)
                ->add('ville' , TextType::class)
                ->add('photo', TextType::class)
                ->add('enregistrer',SubmitType::class);
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'PersonneBundle\Entity\Personne'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'personnebundle_personne';
    }


}

<?php
namespace App\Form;

use App\Entity\Medecin;
use App\Entity\Hopital;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\OptionsResolver\OptionsResolver; // Assurez-vous d'importer la bonne classe

class MedecinType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class)
            ->add('Datenaissance', DateType::class, [
                'widget' => 'single_text',
            ])
            ->add('hopital', EntityType::class, [
                'class' => Hopital::class,
                'choice_label' => 'id',
                'placeholder' => 'Sélectionner un hôpital',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver) // Assurez-vous que le paramètre est du bon type
    {
        $resolver->setDefaults([
            'data_class' => Medecin::class, // Assurez-vous que la classe est bien définie
        ]);
    }
}

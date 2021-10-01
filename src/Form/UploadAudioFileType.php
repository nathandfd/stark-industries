<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class UploadAudioFileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('audioFile', FileType::class, [
                'mapped'=>false,
                'label'=>'Fichier audio',
                'constraints' => [
                    new File([
                        'mimeTypes' => [
                            'audio/mp3',
                            'audio/m4a',
                            'audio/x-m4a',
                            'audio/mpeg'
                        ],
                        'mimeTypesMessage' => 'Veuillez ajouter uniquement un fichier MP3 ou M4A',
                    ])
                ],
            ])
            ->add('audioContractId', HiddenType::class, [
                'mapped'=>false,
                'attr'=>[
                    'class'=>'audioContractId'
                ]
            ])
            ->add('submit', SubmitType::class,[
                'label'=>'Sauvegarder'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}

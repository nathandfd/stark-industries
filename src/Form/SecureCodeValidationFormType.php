<?php

namespace App\Form;

use App\Entity\Contract;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\SubmitButton;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SecureCodeValidationFormType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{

		$builder

			//ADHÉRENT

			->add('secure_code', TextType::class,[
				'label'=>'Numéro de vérification',
				'mapped'=>false,
                'required'=>true,
                'attr' => [
                    'class' => 'secure_code_input phone w-full py-2 px-3 placeholder-gray-500 rounded-md border border-solid border-gray-300 focus:border-yellow-500 outline-none my-3 mb-6',
                    'placeholder'=>'Ex. 123456'
                ],
			])
			->add('save', SubmitType::class,[
				'label'=>'Valider',
                'attr' => [
                    'class' => 'focus:outline-none text-white text-sm m-auto py-2.5 px-8 w-full rounded-md bg-yellow-500 hover:bg-yellow-600 hover:shadow-lg',
                ],
			]);
		}

}

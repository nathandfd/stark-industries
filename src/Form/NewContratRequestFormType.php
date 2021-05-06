<?php

namespace App\Form;

use App\Entity\Contract;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
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

class NewContratRequestFormType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{

		$builder

			//ADHÉRENT

			->add('gender', ChoiceType::class,[
				'label'=>'Genre',
				'mapped'=>false,
				'expanded'=>false,
				'multiple'=>false,
				'choices'=>[
					'M.'=>'m',
					'Mme'=>'f'
				]
			])
			->add('lastname', TextType::class,[
				'label'=>'Nom',
				'mapped'=>false,
			])
			->add('firstname', TextType::class,[
				'label'=>'Prénom',
				'mapped'=>false,
			])
			->add('birthday', BirthdayType::class,[
				'label'=>'Date de naissance',
				'mapped'=>false,
				'placeholder' => [
					'year' => 'Année', 'month' => 'Mois', 'day' => 'Jour',
				]
			])
			->add('address', TextType::class,[
				'label'=>'Adresse',
				'mapped'=>false,
			])
			->add('zipcode', TextType::class,[
				'label'=>'Code postal',
				'mapped'=>false,
			])
			->add('city', TextType::class,[
				'label'=>'Ville',
				'mapped'=>false,
			])
			->add('country', TextType::class,[
				'label'=>'Pays',
				'mapped'=>false,
			])

			->add('phone', TelType::class,[
				'label'=>'Téléphone fixe',
				'mapped'=>false,
			])
			->add('mobile', TelType::class,[
				'label'=>'Téléphone mobile',
				'mapped'=>false,
			])
			->add('mail', TextType::class,[
				'label'=>'Adresse mail',
				'mapped'=>false,
			])

			//MANDAT DE PRÉLÉVEMENT

			->add('iban', TextType::class,[
				'label'=>'IBAN',
				'mapped'=>false,

			])
			->add('bic', TextType::class,[
				'label'=>'BIC',
				'mapped'=>false,

			])
			->add('save', SubmitType::class,[
				'label'=>'Valider le contrat'
			]);
		}

}

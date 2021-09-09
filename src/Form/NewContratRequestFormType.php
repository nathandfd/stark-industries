<?php

namespace App\Form;

use App\Entity\Contract;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
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
use function date;

class NewContratRequestFormType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{

		$builder

			//ADHÉRENT

			->add('gender', ChoiceType::class,[
			    'attr'=>[
			        'autocomplete'=>'off'
                ],
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
                'attr'=>[
                    'autocomplete'=>'off'
                ],
				'label'=>'Nom',
				'mapped'=>false,
			])
			->add('firstname', TextType::class,[
                'attr'=>[
                    'autocomplete'=>'off'
                ],
				'label'=>'Prénom',
				'mapped'=>false,
			])
			->add('birthday', BirthdayType::class,[
                'attr'=>[
                    'autocomplete'=>'off'
                ],
				'label'=>'Date de naissance',
				'mapped'=>false,
                'days' => range(1,31),
                'years' =>  range(date("Y") - 18, date("Y") - 75),
				'placeholder' => [
					'year' => 'Année', 'month' => 'Mois', 'day' => 'Jour',
				]
			])
			->add('address', TextType::class,[
                'attr'=>[
                    'autocomplete'=>'off'
                ],
				'label'=>'Adresse',
				'mapped'=>false,
			])
			->add('zipcode', IntegerType::class,[
                'attr'=>[
                    'autocomplete'=>'off'
                ],
				'label'=>'Code postal',
				'mapped'=>false,
			])
			->add('city', TextType::class,[
                'attr'=>[
                    'autocomplete'=>'off'
                ],
				'label'=>'Ville',
				'mapped'=>false,
			])
			->add('country', ChoiceType::class,[
                'attr'=>[
                    'autocomplete'=>'off'
                ],
				'label'=>'Pays',
				'mapped'=>false,
                'choices' => array(
                    "FR" => "France",
                    "AF" => "Afghanistan",
                    "AL" => "Albania",
                    "DZ" => "Algeria",
                    "AS" => "American Samoa",
                    "AD" => "Andorra",
                    "AO" => "Angola",
                    "AI" => "Anguilla",
                    "AQ" => "Antarctica",
                    "AG" => "Antigua and Barbuda",
                    "AR" => "Argentina",
                    "AM" => "Armenia",
                    "AW" => "Aruba",
                    "AU" => "Australia",
                    "AT" => "Austria",
                    "AZ" => "Azerbaijan",
                    "BS" => "Bahamas",
                    "BH" => "Bahrain",
                    "BD" => "Bangladesh",
                    "BB" => "Barbados",
                    "BY" => "Belarus",
                    "BE" => "Belgium",
                    "BZ" => "Belize",
                    "BJ" => "Benin",
                    "BM" => "Bermuda",
                    "BT" => "Bhutan",
                    "BO" => "Bolivia",
                    "BA" => "Bosnia and Herzegovina",
                    "BW" => "Botswana",
                    "BV" => "Bouvet Island",
                    "BR" => "Brazil",
                    "BQ" => "British Antarctic Territory",
                    "IO" => "British Indian Ocean Territory",
                    "VG" => "British Virgin Islands",
                    "BN" => "Brunei",
                    "BG" => "Bulgaria",
                    "BF" => "Burkina Faso",
                    "BI" => "Burundi",
                    "KH" => "Cambodia",
                    "CM" => "Cameroon",
                    "CA" => "Canada",
                    "CT" => "Canton and Enderbury Islands",
                    "CV" => "Cape Verde",
                    "KY" => "Cayman Islands",
                    "CF" => "Central African Republic",
                    "TD" => "Chad",
                    "CL" => "Chile",
                    "CN" => "China",
                    "CX" => "Christmas Island",
                    "CC" => "Cocos [Keeling] Islands",
                    "CO" => "Colombia",
                    "KM" => "Comoros",
                    "CG" => "Congo - Brazzaville",
                    "CD" => "Congo - Kinshasa",
                    "CK" => "Cook Islands",
                    "CR" => "Costa Rica",
                    "HR" => "Croatia",
                    "CU" => "Cuba",
                    "CY" => "Cyprus",
                    "CZ" => "Czech Republic",
                    "CI" => "Côte d’Ivoire",
                    "DK" => "Denmark",
                    "DJ" => "Djibouti",
                    "DM" => "Dominica",
                    "DO" => "Dominican Republic",
                    "NQ" => "Dronning Maud Land",
                    "DD" => "East Germany",
                    "EC" => "Ecuador",
                    "EG" => "Egypt",
                    "SV" => "El Salvador",
                    "GQ" => "Equatorial Guinea",
                    "ER" => "Eritrea",
                    "EE" => "Estonia",
                    "ET" => "Ethiopia",
                    "FK" => "Falkland Islands",
                    "FO" => "Faroe Islands",
                    "FJ" => "Fiji",
                    "FI" => "Finland",
                    "GF" => "French Guiana",
                    "PF" => "French Polynesia",
                    "TF" => "French Southern Territories",
                    "FQ" => "French Southern and Antarctic Territories",
                    "GA" => "Gabon",
                    "GM" => "Gambia",
                    "GE" => "Georgia",
                    "DE" => "Germany",
                    "GH" => "Ghana",
                    "GI" => "Gibraltar",
                    "GR" => "Greece",
                    "GL" => "Greenland",
                    "GD" => "Grenada",
                    "GP" => "Guadeloupe",
                    "GU" => "Guam",
                    "GT" => "Guatemala",
                    "GG" => "Guernsey",
                    "GN" => "Guinea",
                    "GW" => "Guinea-Bissau",
                    "GY" => "Guyana",
                    "HT" => "Haiti",
                    "HM" => "Heard Island and McDonald Islands",
                    "HN" => "Honduras",
                    "HK" => "Hong Kong SAR China",
                    "HU" => "Hungary",
                    "IS" => "Iceland",
                    "IN" => "India",
                    "ID" => "Indonesia",
                    "IR" => "Iran",
                    "IQ" => "Iraq",
                    "IE" => "Ireland",
                    "IM" => "Isle of Man",
                    "IL" => "Israel",
                    "IT" => "Italy",
                    "JM" => "Jamaica",
                    "JP" => "Japan",
                    "JE" => "Jersey",
                    "JT" => "Johnston Island",
                    "JO" => "Jordan",
                    "KZ" => "Kazakhstan",
                    "KE" => "Kenya",
                    "KI" => "Kiribati",
                    "KW" => "Kuwait",
                    "KG" => "Kyrgyzstan",
                    "LA" => "Laos",
                    "LV" => "Latvia",
                    "LB" => "Lebanon",
                    "LS" => "Lesotho",
                    "LR" => "Liberia",
                    "LY" => "Libya",
                    "LI" => "Liechtenstein",
                    "LT" => "Lithuania",
                    "LU" => "Luxembourg",
                    "MO" => "Macau SAR China",
                    "MK" => "Macedonia",
                    "MG" => "Madagascar",
                    "MW" => "Malawi",
                    "MY" => "Malaysia",
                    "MV" => "Maldives",
                    "ML" => "Mali",
                    "MT" => "Malta",
                    "MH" => "Marshall Islands",
                    "MQ" => "Martinique",
                    "MR" => "Mauritania",
                    "MU" => "Mauritius",
                    "YT" => "Mayotte",
                    "FX" => "Metropolitan France",
                    "MX" => "Mexico",
                    "FM" => "Micronesia",
                    "MI" => "Midway Islands",
                    "MD" => "Moldova",
                    "MC" => "Monaco",
                    "MN" => "Mongolia",
                    "ME" => "Montenegro",
                    "MS" => "Montserrat",
                    "MA" => "Morocco",
                    "MZ" => "Mozambique",
                    "MM" => "Myanmar [Burma]",
                    "NA" => "Namibia",
                    "NR" => "Nauru",
                    "NP" => "Nepal",
                    "NL" => "Netherlands",
                    "AN" => "Netherlands Antilles",
                    "NT" => "Neutral Zone",
                    "NC" => "New Caledonia",
                    "NZ" => "New Zealand",
                    "NI" => "Nicaragua",
                    "NE" => "Niger",
                    "NG" => "Nigeria",
                    "NU" => "Niue",
                    "NF" => "Norfolk Island",
                    "KP" => "North Korea",
                    "VD" => "North Vietnam",
                    "MP" => "Northern Mariana Islands",
                    "NO" => "Norway",
                    "OM" => "Oman",
                    "PC" => "Pacific Islands Trust Territory",
                    "PK" => "Pakistan",
                    "PW" => "Palau",
                    "PS" => "Palestinian Territories",
                    "PA" => "Panama",
                    "PZ" => "Panama Canal Zone",
                    "PG" => "Papua New Guinea",
                    "PY" => "Paraguay",
                    "YD" => "People's Democratic Republic of Yemen",
                    "PE" => "Peru",
                    "PH" => "Philippines",
                    "PN" => "Pitcairn Islands",
                    "PL" => "Poland",
                    "PT" => "Portugal",
                    "PR" => "Puerto Rico",
                    "QA" => "Qatar",
                    "RO" => "Romania",
                    "RU" => "Russia",
                    "RW" => "Rwanda",
                    "RE" => "Réunion",
                    "BL" => "Saint Barthélemy",
                    "SH" => "Saint Helena",
                    "KN" => "Saint Kitts and Nevis",
                    "LC" => "Saint Lucia",
                    "MF" => "Saint Martin",
                    "PM" => "Saint Pierre and Miquelon",
                    "VC" => "Saint Vincent and the Grenadines",
                    "WS" => "Samoa",
                    "SM" => "San Marino",
                    "SA" => "Saudi Arabia",
                    "SN" => "Senegal",
                    "RS" => "Serbia",
                    "CS" => "Serbia and Montenegro",
                    "SC" => "Seychelles",
                    "SL" => "Sierra Leone",
                    "SG" => "Singapore",
                    "SK" => "Slovakia",
                    "SI" => "Slovenia",
                    "SB" => "Solomon Islands",
                    "SO" => "Somalia",
                    "ZA" => "South Africa",
                    "GS" => "South Georgia and the South Sandwich Islands",
                    "KR" => "South Korea",
                    "ES" => "Spain",
                    "LK" => "Sri Lanka",
                    "SD" => "Sudan",
                    "SR" => "Suriname",
                    "SJ" => "Svalbard and Jan Mayen",
                    "SZ" => "Swaziland",
                    "SE" => "Sweden",
                    "CH" => "Switzerland",
                    "SY" => "Syria",
                    "ST" => "São Tomé and Príncipe",
                    "TW" => "Taiwan",
                    "TJ" => "Tajikistan",
                    "TZ" => "Tanzania",
                    "TH" => "Thailand",
                    "TL" => "Timor-Leste",
                    "TG" => "Togo",
                    "TK" => "Tokelau",
                    "TO" => "Tonga",
                    "TT" => "Trinidad and Tobago",
                    "TN" => "Tunisia",
                    "TR" => "Turkey",
                    "TM" => "Turkmenistan",
                    "TC" => "Turks and Caicos Islands",
                    "TV" => "Tuvalu",
                    "UM" => "U.S. Minor Outlying Islands",
                    "PU" => "U.S. Miscellaneous Pacific Islands",
                    "VI" => "U.S. Virgin Islands",
                    "UG" => "Uganda",
                    "UA" => "Ukraine",
                    "SU" => "Union of Soviet Socialist Republics",
                    "AE" => "United Arab Emirates",
                    "GB" => "United Kingdom",
                    "US" => "United States",
                    "ZZ" => "Unknown or Invalid Region",
                    "UY" => "Uruguay",
                    "UZ" => "Uzbekistan",
                    "VU" => "Vanuatu",
                    "VA" => "Vatican City",
                    "VE" => "Venezuela",
                    "VN" => "Vietnam",
                    "WK" => "Wake Island",
                    "WF" => "Wallis and Futuna",
                    "EH" => "Western Sahara",
                    "YE" => "Yemen",
                    "ZM" => "Zambia",
                    "ZW" => "Zimbabwe",
                    "AX" => "Åland Islands",
                ),
			])


			->add('phone', TelType::class,[
                'attr'=>[
                    'autocomplete'=>'off'
                ],
				'label'=>'Téléphone fixe',
				'mapped'=>false,
                'required'=>false,
			])
			->add('mobile', TelType::class,[
                'attr'=>[
                    'autocomplete'=>'off'
                ],
				'label'=>'Téléphone mobile',
				'mapped'=>false,
			])
			->add('mail', EmailType::class,[
                'attr'=>[
                    'autocomplete'=>'off'
                ],
				'label'=>'Adresse mail',
				'mapped'=>false,
			])

			//MANDAT DE PRÉLÉVEMENT

			->add('iban', TextType::class,[
                'attr'=>[
                    'autocomplete'=>'off'
                ],
				'label'=>'IBAN',
				'mapped'=>false,

			])
			->add('bic', TextType::class,[
                'attr'=>[
                    'autocomplete'=>'off'
                ],
				'label'=>'BIC',
				'mapped'=>false,

			])
            ->add('contractType', ChoiceType::class,[
                'attr'=>[
                    'autocomplete'=>'off'
                ],
                'data'=>'0',
                'label'=>'Type de contrat',
                'choices'=>[
                    '9,99€'=>'0',
                    '12,99€'=>'1'
                ],
                'expanded'=>true
            ])
			->add('save', SubmitType::class,[
                'attr'=>[
                    'autocomplete'=>'off'
                ],
				'label'=>'Valider le contrat'
			]);
		}

}

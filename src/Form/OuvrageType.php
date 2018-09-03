<?php
// src/Form/OuvrageType.php
namespace App\Form;

use App\Entity\Ouvrage;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;


class OuvrageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, array('label' => false,
                'attr' => array('class' => 'form-control')))
            ->add('sub_title', TextType::class, array('label' => false,
                'attr' => array('class' => 'form-control')))
            ->add('dewey', CollectionType::class, array(
                'label' => false,
                'entry_type' => ChoiceType::class,
                'entry_options' => array(
                    'label' => false,
                    'attr' => array('class' => 'form-control'),
                    'choices' => array(
                        '010-Bibliographie catalogue générale' => '010',
                        '020-Bibliothéques Sciences de l information' => '020',
                        '030-Dictionnaires Encyclopedies' => '030', //'040' inexsitant
                        '050-Annuaires' => '050',
                        '060-Musées Académies' => '060',
                        '070-Médias Presse Journalisme Edition' => '070',
                        '080-Recueils généraux' => '080',
                        '090-Manuscrits Livres rares' => '090',

                        '110-Métaphysique Philosophie de la vie' => '110',
                        '120-Epistemologie Théorie de la connaissance' => '120',
                        '130-Parapsychologie Esoterisme' => '130',
                        '140-Systèmes philosophiques' => '140',
                        '150-Psychologie' => '150',
                        '160-Logique' => '160',
                        '170-Morale éthique' => '170',
                        '180-Philosophie de l antiquité, du moyen age, de l orient' => '180',
                        '190-Philosophie occidentale moderne' => '190',

                        '210-Philosophie de la religions - dieu athéisme' => '210',
                        '220-Bible' => '220',
                        '230-Christianisme thélogie dogme' => '230',
                        '240-Pratiques religieuses chrétiennes' => '240',
                        '250-Paroisse, clergé, ordres religieux' => '250',
                        '260-Eglise chrétienne et société culte' => '260',
                        '270-Histoire de l eglise chrétienne' => '270',
                        '280-Eglise catholique, protestante, sectes' => '280',
                        '290-Mythologie, boudhisme , Judaïsme, Islam' => '290',

                        '310-Statistiques générales' => '310',
                        '320-Politique, Etat, Gouvernement' => '320',
                        '330-Economie, travail, finances, production' => '330',
                        '340-Droit Justice' => '340',
                        '350-Administration politique, Armée' => '350',
                        '360-Problèmes et services sociaux, Associations' => '360',
                        '370-Education, Enseignement, Orientation' => '370',
                        '380-Commerce, Communications, Transports' => '380',
                        '390-Coutumes, savoir-vivre, traditions populaires' => '390',

                        '410-Linguistique, Alphabets, Ecritures' => '410',
                        '420-Anglais' => '420',
                        '430-Allemand' => '430',
                        '440-Français' => '440',
                        '450-Italien' => '450',
                        '460-Espagnol, Portugais' => '460',
                        '470-Latin' => '470',
                        '480-Grec' => '480',
                        '490-Autres Langues' => '490',

                        '510-Mathématiques' => '510',
                        '520-Astronomie' => '520',
                        '530-Physique' => '530',
                        '540-Chimie, Minéralogie' => '540',
                        '550-Sciences de la terre, Géologie, Météorologie' => '550',
                        '560-Fossiles, Paléontologie, Homme préhistorique' => '560',
                        '570-Sciences de la vie, Biologie, Ecologie' => '570',
                        '580-Botanique' => '580',
                        '590-Zoologie' => '590',

                        '610-Médecine, Santé hygiène, corps humain' => '610',
                        '620-Ingénierie, Technologie, Energie' => '620',
                        '630-Agriculture, elevage, pêche' => '630',
                        '640-Economie domestique, cuisine, soins esthétiques' => '640',
                        '650-Entreprise, gestion, venten publicité' => '650',
                        '660-Industries chimiques, alimentaires, Métallurgie' => '660',
                        '670-Productique , technologie des matériaux' => '670',
                        '680-Produits manufacturés, artisanaux, imprimerie' =>'680',
                        '690-Construction des bâtiments' => '690',

                        '710-Urbanisme, Art du paysage' => '710',
                        '720-Architecture, Monuments' => '720',
                        '730-Arts plastiques, Sculpture' => '730',
                        '740-Dessin, Arts décoratifs, activités manuelles, BD' => '740',
                        '750-Peinture' => '750',
                        '760-Arts graphiques, gravure' => '760',
                        '770-Photographie' => '770',
                        '780-Musique' => '780',
                        '790-Arts du spectacle, cinéma, théatre, jeux, sports' => '790',

                        '810-Littérature américaine de langue anglaise' => '810',
                        '820-Littérature anglaise' => '820',
                        '830-Littérature allemande' => '830',
                        '840-Littérature française' => '840',
                        '850-Littérature italienne' => '850',
                        '860-Littérature espagnole et portugaise' => '860',
                        '870-Littérature Latine' => '870',
                        '880-Littérature grecque' => '880',
                        '890-Littérature des autres langues' => '890',

                        '910-Géographie, voyages, atlas, cartes' => '910',
                        '920-Biographies, généalogie' => '920',
                        '930-Histoire ancienne, archéologie' => '930',
                        '940-Histoire de l Europe' => '940',
                        '950-Histoire de l Asie' => '950',
                        '960-Histoire de l Afrique' => '960',
                        '970-Histoire de l Amérique du Nord' => '970',
                        '980-Histoire de l Amérique du Sud' => '980',
                        '990-Histoire de l Océanie et des pôles' => '990'
                    ),
                )
            ))
            ->add('resume', TextareaType::class,  array('label' => false,
                'attr' => array('class' => 'form-control')))
            ->add('author', TextType::class, array('label' => false,
                'attr' => array('class' => 'form-control')))
            ->add('editor', TextType::class, array('label' => false,
                'attr' => array('class' => 'form-control')))
            ->add('isbnumber', TextType::class, array('label' => false,
                'attr' => array('class' => 'form-control')))
            ->add('picture', FileType::class, array( 'required' => false,
                'data_class' => null, 'label' => false,
                'attr' => array('class' => 'form-control-file')/*, 'empty_data' => '67ed4725ccd826c68edc65f1313f7994.jpeg'*/))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Ouvrage::class,
        ));
    }


}
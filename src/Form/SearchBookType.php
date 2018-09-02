<?php
// src/Form/EmpruntType.php
namespace App\Form;

use App\Entity\SearchBook;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class SearchBookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('ouvrage', CollectionType::class, array(
                'label' => false,
                'entry_type' => ChoiceType::class,
                'entry_options' => array(
                    'label' => false,
                    'attr' => array('class' => 'form-control'),
                    'choices' => array(
                        'Bibliographie catalogue générale' => '010',
                        'Bibliothéques Sciences de l information' => '020',
                        'Dictionnaires Encyclopedies' => '030', //'040' inexsitant
                        'Annuaires' => '050',
                        'Musées Académies' => '060',
                        'Médias Presse Journalisme Edition' => '070',
                        'Recueils généraux' => '080',
                        'Manuscrits Livres rares' => '090',
//                        ),
//                        'Philosophie -psychologie' => array(
                        'Métaphysique Philosophie de la vie' => '110',
                        'Epistemologie Théorie de la connaissance' => '120',
                        'Parapsychologie Esoterisme' => '130',
                        'Systèmes philosophiques' => '140',
                        'Psychologie' => '150',
                        'Logique' => '160',
                        'Morale éthique' => '170',
                        'Philosophie de l antiquité, du moyen age, de l orient' => '180',
                        'Philosophie occidentale moderne' => '190',
//                        ),
//                        'Religions' => array(
                        'Philosophie de la religions - dieu athéisme' => '210',
                        'Bible' => '220',
                        'Christianisme thélogie dogme' => '230',
                        'Pratiques religieuses chrétiennes' => '240',
                        'Paroisse, clergé, ordres religieux' => '250',
                        'Eglise chrétienne et société culte' => '260',
                        'Histoire de l eglise chrétienne' => '270',
                        'Eglise catholique, protestante, sectes' => '280',
                        'Mythologie, boudhisme , Judaïsme, Islam' => '290',

//                        ),
//                        'Société' => array(
                        'Statistiques générales' => '310',
                        'Politique, Etat, Gouvernement' => '320',
                        'Economie, travail, finances, production' => '330',
                        'Droit Justice' => '340',
                        'Administration politique, Armée' => '350',
                        'Problèmes et services sociaux, Associations' => '360',
                        'Education, Enseignement, Orientation' => '370',
                        'Commerce, Communications, Transports' => '380',
                        'Coutumes, savoir-vivre, traditions populaires' => '390',
//                        ),
//                        'Langues' => array(
                        'Linguistique, Alphabets, Ecritures' => '410',
                        'Anglais' => '420',
                        'Allemand' => '430',
                        'Français' => '440',
                        'Italien' => '450',
                        'Espagnol, Portugais' => '460',
                        'Latin' => '470',
                        'Grec' => '480',
                        'Autres Langues' => '490',
//                        ),
//                        'Sciences' => array(
                        'Mathématiques' => '510',
                        'Astronomie' => '520',
                        'Physique' => '530',
                        'Chimie, Minéralogie' => '540',
                        'Sciences de la terre, Géologie, Météorologie' => '550',
                        'Fossiles, Paléontologie, Homme préhistorique' => '560',
                        'Sciences de la vie, Biologie, Ecologie' => '570',
                        'Botanique' => '580',
                        'Zoologie' => '590',
//                        ),
//                        'Techniques' => array(
                        'Médecine, Santé hygiène, corps humain' => '610',
                        'Ingénierie, Technologie, Energie' => '620',
                        'Agriculture, elevage, pêche' => '630',
                        'Economie domestique, cuisine, soins esthétiques' => '640',
                        'Entreprise, gestion, venten publicité' => '650',
                        'Industries chimiques, alimentaires, Métallurgie' => '660',
                        'Productique , technologie des matériaux' => '670',
                        'Produits manufacturés, artisanaux, imprimerie' =>'680',
                        'Construction des bâtiments' => '690',
//                        ),
//                        'Arts Sports Loisirs' => array(
                        'Urbanisme, Art du paysage' => '710',
                        'Architecture, Monuments' => '720',
                        'Arts plastiques, Sculpture' => '730',
                        'Dessin, Arts décoratifs, activités manuelles, BD' => '740',
                        'Peinture' => '750',
                        'Arts graphiques, gravure' => '760',
                        'Photographie' => '770',
                        'Musique' => '780',
                        'Arts du spectacle, cinéma, théatre, jeux, sports' => '790',
//                        ),
//                        'Litterature' => array(
                        'Littérature américaine de langue anglaise' => '810',
                        'Littérature anglaise' => '820',
                        'Littérature allemande' => '830',
                        'Littérature française' => '840',
                        'Littérature italienne' => '850',
                        'Littérature espagnole et portugaise' => '860',
                        'Littérature Latine' => '870',
                        'Littérature grecque' => '880',
                        'Littérature des autres langues' => '890',
//                        ),
//                        'Histoire Geographie' => array(
                        'Géographie, voyages, atlas, cartes' => '910',
                        'Biographies, généalogie' => '920',
                        'Histoire ancienne, archéologie' => '930',
                        'Histoire de l Europe' => '940',
                        'Histoire de l Asie' => '950',
                        'Histoire de l Afrique' => '960',
                        'Histoire de l Amérique du Nord' => '970',
                        'Histoire de l Amérique du Sud' => '980',
                        'Histoire de l OCéanie et des pôles' => '990'
//                        )
                    ),
                )
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => SearchBook::class
        ));
    }

}


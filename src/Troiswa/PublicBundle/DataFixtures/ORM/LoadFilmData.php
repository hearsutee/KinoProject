<?Php

namespace Troiswa\PublicBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Troiswa\PublicBundle\Entity\Film;

class LoadFilmData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {

        $contenus = array( "L'amitié d'un jeune banquier condamné à la prison à vie pour le meurtre de sa femme et d'un vétéran de la prison de Shawshank, le pénitencier le plus sévère de l'Etat du Maine.",
            "L'odyssée sanglante et burlesque de petits malfrats dans la jungle de Hollywood à travers trois histoires qui s'entremêlent.",
            "En 1945, à New York, les Corleone sont une des cinq familles de la mafia. Don Vito Corleone marie sa fille à un bookmaker. Sollozzo, 'parrain' de la famille Tattaglia, propose à Don Vito une association dans le trafic de drogue...",
            "Tandis que les ténèbres se répandent sur la Terre du Milieu, Aragorn se révèle être l'héritier caché des rois antiques. Quant à Frodon, toujours tenté par l'Anneau, il voyage à travers les contrées ennemies, se reposant sur Sam et Gollum...",
            "Au début des années 70, Sixto Rodriguez enregistre deux albums sur un label de Motown. C'est un échec, à tel point qu’on raconte qu’il se serait suicidé sur scène. Des années plus tard, deux fans du Cap partent à la recherche de “Sugar Man”. Ce qu’ils découvrent est une histoire faite de surprises, d’émotions et d’inspiration.",
            "John Doe a decidé de nettoyer la societé des maux qui la rongent en commettant sept meurtres bases sur les sept pechés capitaux.",
            "Derek veut venger la mort de son père, abattu par un dealer noir, et épouse les thèses racistes d'un groupuscule de militants d'extrême droite. Ces théories le mèneront à commettre un double meurtre...",
            "Lors d'un procès, un juré émet l'hypothèse que l'homme qu'il doit juger n'est peut-être pas coupable. Il va tenter de convaincre les onze autres jurés." );

        $titres = array( "Le Seigneur des anneaux : le retour du roi",
            "Les Evadés",
            "Pulp Fiction",
            "Le Parrain",
            "Django Unchained",
            "Forrest Gump",
            "Gran Torino",
            "The Dark Knight, Le Chevalier Noir",
            "La Liste de Schindler",
            "Fight Club",
            " Les Enfants Loups, Ame & Yuki",
            "Le Roi Lion",
            "Paperman",
            "12 hommes en colère",
            "Alabama Monroe",
            "Sugar Man" );

        $dates = array( '2000-06-05 ', '2004-06-05 ', '1998-06-05 14:59:23.0', '2001-07-05 14:59:23.0', '2012-06-05 14:59:23.0', '2013-05-05 14:59:23.0', '2002-06-05 14:59:23.0', '1987-06-05 14:59:23.0', );

        $actives = array( 1, 0 );

        for ($i = 0; $i < 20; $i++) {
            $film = new Film();
            $t = array_rand($titres);
            $tt = $titres[$t];

            $c = array_rand($contenus);
            $cc = $contenus[$c];

            $d = array_rand($dates);
            $dd = $dates[$d];

            $a = array_rand($actives);
            $aa = $actives[$a];

            $film->setTitre($tt)
                ->setContenu($cc)
                ->setDateCreation(new \DateTime( $dd ))
                ->setActive($aa);

            $manager->persist($film);
            $manager->flush();
        }

    }
}

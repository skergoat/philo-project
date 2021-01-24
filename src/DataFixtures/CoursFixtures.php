<?php

namespace App\DataFixtures;

use App\Entity\Cours;
use App\Entity\CoursCardsImage;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;


class CoursFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // CoursFactory::new()->createMany(10);
        for($i=0;$i<11;$i++) {
            // create image 
            $image = new CoursCardsImage();
            $image->setSrc('https://picsum.photos/300');
            $image->setAlt('lorempicsum');
            // create course
            $cours = new Cours();
            $cours->setTitre('La conscience');
            $cours->setDescription('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut facilisis pulvinar convallis. Fusce lacinia eros est, quis volutpat nisi bibendum sit amet. Aenean ut ante risus. Aliquam at egestas ex. Nunc non felis a lacus scelerisque viverra. Nulla a interdum ipsum. Donec nec ligula auctor, imperdiet nisl ac, semper mauris. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin aliquam id velit ac pellentesque. Integer sagittis suscipit ultricies. Nulla neque augue, ultrices vitae nunc eget, aliquam dignissim urna. Vivamus scelerisque porta mauris convallis sollicitudin. Praesent ullamcorper neque non lacus ullamcorper, eget finibus tortor posuere.');
            $cours->setLevel('facile');
            $cours->setDuration('6h');
            $cours->setMainImage($image);
            // presist 
            $manager->persist($image);
            $manager->persist($cours);
            $manager->flush();
            
        }
    }
}

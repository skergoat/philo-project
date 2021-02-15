<?php

namespace App\DataFixtures;

use App\Entity\Cours;
use App\Service\SlugHelper;
use App\Entity\CoursCardsImage;
use App\Service\UploaderHelper;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\File;

class CoursFixtures extends Fixture
{
    private $slughelper; 
    private $uploaderHelper;

    public function __construct(SlugHelper $slugHelper, UploaderHelper $uploaderHelper) {
        $this->slughelper = $slugHelper;
        $this->uploaderHelper = $uploaderHelper;
    }   

    // private function fakeUploadImage(): string
    // {
    //     $randomImage = 'https://picsum.photos/300';
    //     $fs = new Filesystem();
    //     $targetPath = sys_get_temp_dir().'/'.$randomImage;
    //     $fs->copy(__DIR__.$randomImage, $targetPath, true);
    //     return $this->uploaderHelper
    //         ->uploadArticleImage(new File($targetPath));
    // }

    public function load(ObjectManager $manager)
    {
        // CoursFactory::new()->createMany(10);
        for($i=0;$i<21;$i++) {
            // create image 
            $image = new CoursCardsImage();
            // $imageFilename = $this->fakeUploadImage();
            // $image->setSrc('https://picsum.photos/300');
            $image->setAlt('cours');
            // create course
            $cours = new Cours();
            $cours->setTitre('La conscience');
            // slug 
            $titre = $cours->getTitre();
            
            $cours->setSlug($this->slughelper->slugify($titre).'_'.rand());
            $cours->setDescription('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut facilisis pulvinar convallis. Fusce lacinia eros est, quis volutpat nisi bibendum sit amet. Aenean ut ante risus. Aliquam at egestas ex. Nunc non felis a lacus scelerisque viverra. Nulla a interdum ipsum. Donec nec ligula auctor, imperdiet nisl ac, semper mauris. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin aliquam id velit ac pellentesque. Integer sagittis suscipit ultricies. Nulla neque augue, ultrices vitae nunc eget, aliquam dignissim urna. Vivamus scelerisque porta mauris convallis sollicitudin. Praesent ullamcorper neque non lacus ullamcorper, eget finibus tortor posuere.');
            $cours->setResume('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed consectetur sit amet quam eu malesuada. Mauris at mauris nec leo dignissim vulputate vel vitae augue.');
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

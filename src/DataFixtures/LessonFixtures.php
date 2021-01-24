<?php

namespace App\DataFixtures;

// use App\Factory\LessonFactory;
use App\Entity\Cours;
use App\Entity\Lesson;
use App\Repository\CoursRepository;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class LessonFixtures extends Fixture
{
    private $cours;

    public function __construct(CoursRepository $repo) {
        // get repository 
        $this->cours = $repo;
    }

    public function load(ObjectManager $manager)
    {  
        // get cours  
        $cours = $this->cours->findAll();
        // loop on each cours 
        foreach($cours as $teach) {
            // create 10 lessons for each cours 
            for($i=0;$i<11;$i++) {

                $lesson = new Lesson();

                $lesson->setCours($teach);
                $lesson->setVideo('<iframe width="560" height="315" src="https://www.youtube.com/embed/3Iiyzo9vdYA" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>');
                $lesson->setContent('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut facilisis pulvinar convallis. Fusce lacinia eros est, quis volutpat nisi bibendum sit amet. Aenean ut ante risus. Aliquam at egestas ex. Nunc non felis a lacus scelerisque viverra. Nulla a interdum ipsum. Donec nec ligula auctor, imperdiet nisl ac, semper mauris. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin aliquam id velit ac pellentesque. Integer sagittis suscipit ultricies. Nulla neque augue, ultrices vitae nunc eget, aliquam dignissim urna. Vivamus scelerisque porta mauris convallis sollicitudin. Praesent ullamcorper neque non lacus ullamcorper, eget finibus tortor posuere.');
                
                $manager->persist($lesson);
                $manager->flush();
            }
        }
    }
}

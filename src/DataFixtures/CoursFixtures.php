<?php

namespace App\DataFixtures;

use App\Entity\Cours;
use App\Entity\Lesson;
// use App\Factory\CoursFactory;
// use App\Repository\CoursRepository;
use App\Factory\CoursFactory;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;


class CoursFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        CoursFactory::new()->createMany(10);
        $manager->flush();
    }
}

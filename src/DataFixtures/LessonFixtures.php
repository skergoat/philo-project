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
    private $array = [
        '',
        'La Conscience : Introduction',
        'De L\'immediateté à la conscience de soi',
        'L\'âme ou la "Chose Pensante"',
        'Moi, c\'est-à-dire mon vécu (HUME)',
        'La Conscience chez Kant',
        'La Conscience et sa continuité',
        'L\'Intentionnalité',
        'Le Dasein (HEIDEGGER)',
        'L\'Homme : un animal politique ?',
        'Conclusion', 
    ];

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
            for($i=1;$i<11;$i++) {

                $lesson = new Lesson();
                $lesson->setOrderId($i);
                $lesson->setTitle($this->array[$i]);
                $lesson->setCours($teach);
                $lesson->setVideo('https://www.youtube.com/embed/3Iiyzo9vdYA');
                $lesson->setContent('<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut facilisis pulvinar convallis. Fusce lacinia eros est, quis volutpat nisi bibendum sit amet. Aenean ut ante risus. Aliquam at egestas ex. Nunc non felis a lacus scelerisque viverra. Nulla a interdum ipsum. Donec nec ligula auctor, imperdiet nisl ac, semper mauris. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin aliquam id velit ac pellentesque. Integer sagittis suscipit ultricies. Nulla neque augue, ultrices vitae nunc eget, aliquam dignissim urna. Vivamus scelerisque porta mauris convallis sollicitudin. Praesent ullamcorper neque non lacus ullamcorper, eget finibus tortor posuere.</p><br><p>Praesent eget bibendum nibh. Sed leo orci, luctus sit amet pellentesque vitae, finibus non neque. Fusce non diam nulla. In imperdiet quis urna a sodales. Morbi venenatis non lacus sed laoreet. Vivamus sem nunc, semper non egestas sed, auctor id lacus. Etiam sed metus nisl. Sed sagittis interdum eros, nec feugiat odio egestas vel. Proin quis commodo erat.

</p><br><p>Morbi vulputate iaculis lectus eu egestas. In id elementum ante. Praesent at odio magna. Nunc tellus mi, rutrum nec lacus dignissim, dignissim ornare lectus. Quisque ac sagittis ligula. Suspendisse eu sollicitudin nisi. Nulla lacinia semper arcu, commodo dignissim sem aliquam nec.</p><br><p>Cras sed lorem diam. Proin eu tellus vestibulum, lobortis dui non, euismod quam. Mauris eu efficitur purus, nec sagittis est. Cras nisl magna, auctor et nibh sed, facilisis egestas lorem. Vestibulum turpis risus, euismod vel porttitor vel, dignissim vel nulla. Curabitur pulvinar ante egestas, pharetra lacus quis, dapibus sapien. Morbi sollicitudin pellentesque felis.

</p><br><p>Ut varius quam mauris, quis hendrerit sem maximus mattis. Integer faucibus commodo quam et volutpat. Nulla quis tellus dui. Fusce ex orci, tristique porttitor leo eu, eleifend consequat nisi. Vivamus euismod neque leo, ac mollis lorem suscipit lobortis. Sed pretium elit elit, id pretium nisl mollis luctus. Sed pharetra libero et libero malesuada egestas. Suspendisse eget pulvinar lorem.</p>');
                $lesson->setCompleted(false);

                $manager->persist($lesson);
                $manager->flush();
            }
        }
    }
}

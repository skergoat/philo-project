<?php

namespace App\Controller;

use App\Entity\Cours;
use App\Entity\Lesson;
use App\Repository\CoursRepository;
use App\Repository\LessonRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

/**
 * @Route("/lesson")
 */
class LessonManageController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager) 
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/{id}", name="show_lesson")
     */
    public function show(LessonRepository $repository, $id, CoursRepository $coursRepository): Response
    {   
        // get current lesson 
        $lesson = $repository->findOneBy(['order_id' => $id]); 
        // get current lesson cours_id
        $coursId = $lesson->getCours()->getId();
        // get lessons before and after 
        $idBefore =  $id - 1; 
        $idAfter =  $id + 1; 
        $before = $repository->findOneBy(['order_id' => $idBefore]);
        $after = $repository->findOneBy(['order_id' => $idAfter]);
        // get parent cours 
        $cours = $coursRepository->findOneBy(['id' => $coursId]);
        // get child lessons 
        $lessons = $cours->getLessons();

        return $this->render('home/lesson.html.twig', [
            'lesson' => $lesson,
            'lessons' => $lessons,
            'before' => $before,
            'after' => $after
            ]
        );
    }

    /**
     * @Route("/completed/{id}/{value}", name="completed", methods={"POST"})
     */
    public function completed(Request $request, LessonRepository $repository, $id, $value) : Response 
    {
        // get current lesson
        $lesson = $repository->findOneBy(['id' => $id]);
        // set completed value 
        $lesson->setCompleted($value); 
        // save 
        $this->entityManager->flush($lesson);        
        // redirect
        if($value == 1) {
            $redirect = $lesson->getOrderId() + 1;
            $this->addFlash('notice', 'Bravo, encore un cours de fini !');
        } 
        else {
            $redirect = $lesson->getOrderId();
        }
        return $this->redirectToRoute('show_lesson', ['id' =>  $redirect ]);
    }
}

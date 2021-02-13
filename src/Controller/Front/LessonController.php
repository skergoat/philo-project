<?php

namespace App\Controller\Front;

use App\Entity\Cours;
use App\Entity\Lesson;
use App\Repository\CoursRepository;
use App\Repository\LessonRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/lesson")
 */
class LessonController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager) 
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/{id}/{order}", name="lesson_show", methods={"GET"})
     */
    public function show(LessonRepository $repository, $id, $order, CoursRepository $coursRepository): Response
    {   
        // get current lesson 
        $lesson = $repository->findOneBy(['order_id' => $order]); 
        // get current lesson cours_id
        $coursId = $lesson->getCours()->getId();
        dd($coursId);
        // get lessons before and after 
        $idBefore =  $order - 1; 
        $idAfter =  $order + 1; 
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
            $message = 'Bravo, encore un cours de fini !';
        } 
        else {
            $redirect = $lesson->getOrderId();
            $message = 'Vous pouvez vous remettre à ce cours !';
        }
        $this->addFlash('notice', $message);

        return $this->redirectToRoute('show_lesson', ['id' =>  $redirect ]);
    }
}

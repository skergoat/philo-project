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
        // get parent cours 
        $cours = $coursRepository->findOneBy(['id' => $coursId]);
        // get child lessons 
        $lessons = $cours->getLessons();

        return $this->render('home/lesson.html.twig', [
            'lesson' => $lesson,
            'lessons' => $lessons 
            ]
        );
    }

    /**
     * @Route("/completed/{id}", name="completed", methods={"POST"})
     */
    public function completed(Request $request, $id, LessonRepository $repository) : Response 
    {
        // get current lesson
        $lesson = $repository->findOneBy(['id' => $id]);
        // set completed value 
        $lesson->setCompleted(true);
        // save 
        $this->entityManager->flush($lesson);
        // send flash message 
        $this->addFlash('notice', 'Bravo, encore un cours de fini !');
        // redirect
        return $this->redirectToRoute('show_lesson', ['id' => $lesson->getOrderId() + 1 ]);
    }
}

<?php

namespace App\Controller;

use App\Repository\CoursRepository;
use App\Repository\LessonRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(): Response
    {
        return $this->render('home/index.html.twig');
    }

    /**
     * @Route("/gallery", name="gallery")
     */
    public function gallery(): Response
    {
        return $this->render('home/gallery.html.twig');
    }

    /**
     * @Route("/events", name="events")
     */
    public function events(): Response
    {
        return $this->render('home/events.html.twig');
    }

    /**
     * @Route("/courses", name="courses")
     */
    public function courses(Request $request, CoursRepository $repository, PaginatorInterface $paginator): Response
    {   
        $queryBuilder = $repository->findAll();     

        $pagination = $paginator->paginate(
            $queryBuilder, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            10/*limit per page*/
        );

        return $this->render('home/courses.html.twig', ['cours' => $pagination]);
    }

     /**
     * @Route("/lesson/{id}", name="lesson")
     */
    public function lesson(LessonRepository $repository, $id, CoursRepository $coursRepository): Response
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
}

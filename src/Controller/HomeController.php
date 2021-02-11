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
     * @Route("/", name="home", methods={"GET"})
     */
    public function index(): Response
    {
        return $this->render('home/index.html.twig');
    }

    /**
     * @Route("/gallery", name="gallery", methods={"GET"})
     */
    public function gallery(): Response
    {
        return $this->render('home/gallery.html.twig');
    }

    /**
     * @Route("/events", name="events", methods={"GET"})
     */
    public function events(): Response
    {
        return $this->render('home/events.html.twig');
    }

    /**
     * @Route("/courses", name="courses", methods={"GET"})
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
}

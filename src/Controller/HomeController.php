<?php

namespace App\Controller;

use App\Repository\CoursRepository;
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
    public function courses(CoursRepository $repository): Response
    {        
        return $this->render('home/courses.html.twig', ['cours' => $repository->findAll()]);
    }
}

<?php

namespace App\Controller\Admin;

use App\Entity\Cours;
use App\Entity\Lesson;
use App\Form\Lessons\LessonType;
use App\Repository\LessonRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/lesson")
 */
class LessonController extends AbstractController
{

    /**
     * @Route("/new", name="lesson_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $lesson = new Lesson();
        $form = $this->createForm(LessonType::class, $lesson);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($lesson);
            $entityManager->flush();

            return $this->redirectToRoute('lesson_index');
        }

        return $this->render('admin/lesson/new.html.twig', [
            'lesson' => $lesson,
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/{id}/edit", name="lesson_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Lesson $lesson): Response
    {
        $form = $this->createForm(LessonType::class, $lesson);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', 'Leçon Modifiée !');
            return $this->redirectToRoute('lesson_edit', ['id' => $form->getData()->getId()]);
        }

        return $this->render('admin/lesson/edit.html.twig', [
            'lesson' => $lesson,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/up/{id}", name="lesson_up", methods={"POST"})
     */
    public function lessonUp(Request $request, Lesson $lesson, LessonRepository $lessonRepository)
    {
        // cours id 
        $coursId = $lesson->getCours()->getId();

        if ($this->isCsrfTokenValid('edit'.$lesson->getId(), $request->request->get('_token'))) 
        {
            // get request 
            $order = $request->get('orderId');

            if($order > 0) {
                // change order item before 
                $before = $lessonRepository->findOneBy(['order_id' => $order]);
                $before->setOrderId($order + 1);
                // edit current lesson and flush
                $lesson->setOrderId($order);
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->flush();
            }
            else { // error message Ajax
                
            }
        }
        return new JsonResponse([
            [$lesson->getId(), $lesson->getOrderId(),  $lesson->getTitle()], 
            [$before->getId(), $before->getOrderId(), $before->getTitle()],
            $lesson->getCours()->getId()
        ]); // json reponse to ajax
    }

     /**
     * @Route("/down/{id}", name="lesson_down", methods={"POST"})
     */
    public function lessonDown(Request $request, Lesson $lesson, LessonRepository $lessonRepository)
    {
        // cours id 
        $coursId = $lesson->getCours()->getId();

        if ($this->isCsrfTokenValid('edit'.$lesson->getId(), $request->request->get('_token'))) 
        {
            // get request 
            $order = $request->get('orderId');

            if($order < $lessonRepository->getLessonByCoursLength($coursId)) {
                // change order item before 
                $before = $lessonRepository->findOneBy(['order_id' => $order]);
                $before->setOrderId($order - 1);
                // edit current lesson and flush
                $lesson->setOrderId($order);
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->flush();
            }
            else { // error message Ajax
    
            }
        }
        return new JsonResponse([[
            $lesson->getId(), $lesson->getOrderId(),  $lesson->getTitle()], 
            [$before->getId(), $before->getOrderId(), $before->getTitle()],
            $lesson->getCours()->getId()
        ]); // json reponse to ajax
    }

    /**
     * @Route("/{id}/load", name="lesson_load", methods={"GET"})
     */
    public function load(Request $request, Cours $cours, LessonRepository $lessonRepository, PaginatorInterface $paginator)
    {
        // get lessons order by order_id 
        $queryBuilder = $lessonRepository->findBy(['Cours' => $cours->getId()], ['order_id' => 'ASC']);
    
        $pagination = $paginator->paginate(
            $queryBuilder, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            10/*limit per page*/
        );
    
        return $this->render('admin/cours/load.html.twig', [
            'lessons' => $pagination // lessons 
        ]);
    }

    /**
     * @Route("/{id}", name="lesson_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Lesson $lesson): Response
    {
        if ($this->isCsrfTokenValid('delete'.$lesson->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($lesson);
            $entityManager->flush();
        }

        return $this->redirectToRoute('lesson_index');
    }
}

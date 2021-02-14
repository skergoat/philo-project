<?php

namespace App\Controller\Admin;

use App\Entity\Cours;
use App\Form\Cours\Cours1Type;
use App\Entity\CoursCardsImage;
use Gedmo\Sluggable\Util\Urlizer;
use App\Repository\CoursRepository;
use App\Repository\LessonRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/admin/cours")
 * @IsGranted("ROLE_ADMIN")
 */
class CoursController extends AbstractController
{
    /**
     * @Route("/", name="cours_index", methods={"GET"})
     */
    public function index(Request $request, CoursRepository $coursRepository, PaginatorInterface $paginator): Response
    {
        $queryBuilder = $coursRepository->findAll();     

        $pagination = $paginator->paginate(
            $queryBuilder, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            10/*limit per page*/
        );

        return $this->render('admin/cours/index.html.twig', [
            'cours' => $pagination,
        ]);
    }

    /**
     * @Route("/new", name="cours_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $cour = new Cours();
        $form = $this->createForm(Cours1Type::class, $cour);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($cour);
            $entityManager->flush();

            return $this->redirectToRoute('cours_index');
        }

        return $this->render('admin/cours/new.html.twig', [
            'cour' => $cour,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/upload/test", name="upload_test")
     */
    // public function temporaryUploadAction(Request $request)
    // {
    //     $uploadedFile = $request->files->get('image');
    //     $destination = $this->getParameter('kernel.project_dir').'/public/uploads';
    //     $originalFilename = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
    //     $newFilename = Urlizer::urlize($originalFilename).'-'.uniqid().'.'.$uploadedFile->guessExtension();
    //     dd($uploadedFile->move(
    //         $destination,
    //         $newFilename
    //     ));
    // }
    
    /**
     * @Route("/{id}/edit", name="cours_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Cours $cour, PaginatorInterface $paginator, LessonRepository $lessonRepository): Response
    {
        // edit cours
        $form = $this->createForm(Cours1Type::class, $cour);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // current cours 
            $cours = $form->getData();
            // upload 
            $uploadedFile = $form['mainImage']->getData();
            $destination = $this->getParameter('kernel.project_dir').'/public/uploads';
            // image 
            if ($uploadedFile) {
                // security 
                $originalFilename = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
                $newFilename = Urlizer::urlize($originalFilename).'-'.uniqid().'.'.$uploadedFile->guessExtension();
                $uploadedFile->move(
                    $destination,
                    $newFilename
                );
                // dd($destination."/".$newFilename);
                // save 
                $image = new CoursCardsImage();
                $image->setSrc($newFilename);
                $image->setAlt($newFilename);
                $cours->setMainImage($image);
            }
            // flush 
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($cours);
            $manager->persist($image);
            $manager->flush();

            $this->addFlash('success', 'Cours Modifié !');
            return $this->redirectToRoute('cours_edit', ['id' => $form->getData()->getId()]);
        }
        // get lessons order by order_id 
        $queryBuilder = $lessonRepository->findBy(['Cours' => $form->getData()->getId()], ['order_id' => 'ASC']);
    
        $pagination = $paginator->paginate(
            $queryBuilder, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            10/*limit per page*/
        );
    
        return $this->render('admin/cours/edit.html.twig', [
            'cour' => $cour,
            'form' => $form->createView(),
            'lessons' => $pagination // lessons 
        ]);
    }

    /**
     * @Route("/{id}", name="cours_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Cours $cour): Response
    {
        if ($this->isCsrfTokenValid('delete'.$cour->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($cour);
            $entityManager->flush();
        }

        return $this->redirectToRoute('cours_index');
    }
}

<?php

namespace WCS\TvShowManagerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use WCS\TvShowManagerBundle\Entity\TvShow;

class TvShowController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $tvShow = $em->getRepository('WCSTvShowManagerBundle:TvShow')->findAll();
        return $this->render('WCSTvShowManagerBundle:TvShow:index.html.twig', array(
            'tvShow' => $tvShow,
        ));
    }

    public function addAction(Request $request)
    {
        $tvShow = new TvShow();
        $form = $this->createFormBuilder($tvShow)
            ->add('name', TextType::class)
            ->add('type', TextType::class)
            ->add('url', TextType::class)
            ->add('year', TextType::class)
            ->add('Enregistrer', SubmitType::class)
            ->getForm()
        ;
// Hydrate notre objet avec la donnée du formulaire
        $form->handleRequest($request);
        // Si method POST et si le form est valid
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($tvShow);
            $em->flush();
            return $this->redirectToRoute('wcs_tv_show_manager_index');
        }
// createView() permet à la vue d’afficher le formulaire
        return $this->render('WCSTvShowManagerBundle:TvShow:add.html.twig', array(
            'tvShow' => $tvShow,
            'my_form' => $form->createView(),
            ));
    }

    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $tvShow = $em->getRepository('WCSTvShowManagerBundle:TvShow')->find($id);

        return $this->render('WCSTvShowManagerBundle:TvShow:show.html.twig', array(
            'tvShow' => $tvShow,

        ));
    }

    public function modifyAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $tvShow = $em->getRepository('WCSTvShowManagerBundle:TvShow')->find($id);
        $form = $this->createFormBuilder($tvShow)
            ->add('name', TextType::class)
            ->add('type', TextType::class)
            ->add('url', TextType::class)
            ->add('year', TextType::class)
            ->add('Enregistrer', SubmitType::class)
            ->getForm()
            ;

        $form->handleRequest($request);
        // Si method POST et si le form est valid
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            $request->getSession()->getFlashBag()->add('notice', 'Annonce bien modifiée.');
            return $this->redirectToRoute('wcs_tv_show_manager_index');
        }
        // createView() permet à la vue d’afficher le formulaire
        return $this->render('WCSTvShowManagerBundle:TvShow:modify.html.twig', array(
            'tvShow' => $tvShow,
            'my_form' => $form->createView(),
        ));

    }

    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $tvShow = $em->getRepository('WCSTvShowManagerBundle:TvShow')->find($id);
        $em->remove($tvShow);
        $em->flush();

        $this->addFlash(
            'success',
            'La série a bien été supprimée'
        );

        return $this->redirectToRoute('wcs_tv_show_manager_index');
    }

}

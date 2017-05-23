<?php

namespace WCS\TvShowManagerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use WCS\TvShowManagerBundle\Entity\Episode;

class EpisodeController extends Controller
{
    public function addAction(Request $request, $tvShow_id)
    {
        $episode = new Episode();
        $em = $this->getDoctrine()->getManager();
        $tvShow = $em->getRepository('WCSTvShowManagerBundle:TvShow')->find($tvShow_id);

        $form = $this->createFormBuilder($episode)
            ->add('name', TextType::class)
            ->add('season', IntegerType::class)
            ->add('number', IntegerType::class)
            ->add('note', IntegerType::class)
            ->add('Enregistrer', SubmitType::class)
            ->getForm()
        ;

// Hydrate notre objet avec la donnée du formulaire
        $form->handleRequest($request);
        // Si method POST et si le form est valid
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $episode->setTvShow($tvShow);
            $em->persist($episode);
            $em->flush();
            return $this->redirectToRoute('show', array('id' => $episode->getTvShow()->getId()));
        }
// createView() permet à la vue d’afficher le formulaire
        return $this->render('WCSTvShowManagerBundle:Episode:addEpisode.html.twig', array(
            'episode' => $episode,
            'my_formulaire' => $form->createView(),
        ));
    }

    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $episode = $em->getRepository('WCSTvShowManagerBundle:Episode')->find($id);
        $em->remove($episode);
        $em->flush();

        $this->addFlash(
            'success',
            'La série a bien été supprimée'
        );


        return $this->redirectToRoute('show', array('id' => $episode->getTvShow()->getId()));
    }

    public function modifyAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $episode = $em->getRepository('WCSTvShowManagerBundle:Episode')->find($id);
        $form = $this->createFormBuilder($episode)
            ->add('name', TextType::class)
            ->add('season', IntegerType::class)
            ->add('number', IntegerType::class)
            ->add('note', IntegerType::class)
            ->add('Enregistrer', SubmitType::class)
            ->getForm()
        ;

        $form->handleRequest($request);
        // Si method POST et si le form est valid
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            $request->getSession()->getFlashBag()->add('notice', 'Episode bien modifié.');
            return $this->redirectToRoute('show', array('id' => $episode->getTvShow()->getId()));
        }

        return $this->render('WCSTvShowManagerBundle:Episode:modifyEpisode.html.twig', array(
            'episode' => $episode,
            'my_formulaire' => $form->createView(),
        ));
    }

}

<?php

namespace WCS\TvShowManagerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use WCS\TvShowManagerBundle\Entity\TvShow;
use WCS\TvShowManagerBundle\Form\TvShowType;


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
        $form = $this->createForm(TvShowType::class, $tvShow);
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
        $form = $this->createForm(TvShowType::class, $tvShow)
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

    public function triAction(){
        $tvShow = new TvShow();
        $em = $this->getDoctrine()->getManager();
        $tvShows = $em->getRepository('WCSTvShowManagerBundle:TvShow')->findAll(); // recupere tous les tvShow
        $notes=[];
        $moyNotes=[];
        foreach ($tvShows as $tvShow) { // parcourt un tvShow un par un
            $episodes = $tvShow->getEpisodes(); // recupere les episodes d'un tvshow
            foreach ($episodes as $episode) { //parcourt les episodes un par un
                $note = $episode->getNote(); // recupere la note d'un episode
                array_push($notes, $note); // stocke la note dans un tableau de notes
            }
            $moyNote = array_sum($notes) / count($notes); // on fait la moyenne des notes pour une série
            $moyNotes[$tvShow->getName()]= $moyNote; // stocke la moyenne des notes dans un tableau de moyenne qui a pour clé le nom de la série
        }

        return $this->render('WCSTvShowManagerBundle:TvShow:tri.html.twig', array(
            'tvShow' => $tvShow,
            'moyNotes' =>$moyNotes,
        ));
    }

}

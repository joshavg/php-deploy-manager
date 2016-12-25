<?php

namespace AppBundle\Controller;

use AppBundle\Entity\ApplicationConfig;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Applicationconfig controller.
 *
 * @Route("applicationconfig")
 */
class ApplicationConfigController extends Controller
{
    /**
     * Lists all applicationConfig entities.
     *
     * @Route("/", name="applicationconfig_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $applicationConfigs = $em->getRepository('AppBundle:ApplicationConfig')->findAll();

        return $this->render('applicationconfig/index.html.twig', array(
            'applicationConfigs' => $applicationConfigs,
        ));
    }

    /**
     * Creates a new applicationConfig entity.
     *
     * @Route("/new", name="applicationconfig_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $applicationConfig = new Applicationconfig();
        $form = $this->createForm('AppBundle\Form\ApplicationConfigType', $applicationConfig);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($applicationConfig);
            $em->flush($applicationConfig);

            return $this->redirectToRoute('applicationconfig_show', array('id' => $applicationConfig->getId()));
        }

        return $this->render('applicationconfig/new.html.twig', array(
            'applicationConfig' => $applicationConfig,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a applicationConfig entity.
     *
     * @Route("/{id}", name="applicationconfig_show")
     * @Method("GET")
     */
    public function showAction(ApplicationConfig $applicationConfig)
    {
        $deleteForm = $this->createDeleteForm($applicationConfig);

        return $this->render('applicationconfig/show.html.twig', array(
            'applicationConfig' => $applicationConfig,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing applicationConfig entity.
     *
     * @Route("/{id}/edit", name="applicationconfig_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, ApplicationConfig $applicationConfig)
    {
        $deleteForm = $this->createDeleteForm($applicationConfig);
        $editForm = $this->createForm('AppBundle\Form\ApplicationConfigType', $applicationConfig);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('applicationconfig_edit', array('id' => $applicationConfig->getId()));
        }

        return $this->render('applicationconfig/edit.html.twig', array(
            'applicationConfig' => $applicationConfig,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a applicationConfig entity.
     *
     * @Route("/{id}", name="applicationconfig_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, ApplicationConfig $applicationConfig)
    {
        $form = $this->createDeleteForm($applicationConfig);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($applicationConfig);
            $em->flush($applicationConfig);
        }

        return $this->redirectToRoute('applicationconfig_index');
    }

    /**
     * Creates a form to delete a applicationConfig entity.
     *
     * @param ApplicationConfig $applicationConfig The applicationConfig entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(ApplicationConfig $applicationConfig)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('applicationconfig_delete', array('id' => $applicationConfig->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

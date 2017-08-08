<?php

namespace WorkBundle\Controller;

use WorkBundle\Entity\Emp;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Emp controller.
 *
 */
class EmpController extends Controller
{
    /**
     * Lists all emp entities.
     *
     */
    public function indexAction(Request $request)
    {
        /*
        $em = $this->getDoctrine()->getManager();

        $emps = $em->getRepository('WorkBundle:Emp')->findAll();

        return $this->render('emp/index.html.twig', array(
            'emps' => $emps,
        ));
        */

        $em    = $this->get('doctrine.orm.entity_manager');
        $dql   = "SELECT e FROM WorkBundle:Emp e";
        $query = $em->createQuery($dql);

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            10/*limit per page*/
        );

        // parameters to template
        return $this->render('emp/index.html.twig', array('pagination' => $pagination));
    }


    /**
     * Creates a new emp entity.
     *
     */
    public function newAction(Request $request)
    {
        $emp = new Emp();
        $form = $this->createForm('WorkBundle\Form\EmpType', $emp);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($emp);
            $em->flush();

            return $this->redirectToRoute('emp_show', array('id' => $emp->getId()));
        }

        return $this->render('emp/new.html.twig', array(
            'emp' => $emp,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a emp entity.
     *
     */
    public function showAction(Emp $emp)
    {
        $deleteForm = $this->createDeleteForm($emp);

        return $this->render('emp/show.html.twig', array(
            'emp' => $emp,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing emp entity.
     *
     */
    public function editAction(Request $request, Emp $emp)
    {
        $deleteForm = $this->createDeleteForm($emp);
        $editForm = $this->createForm('WorkBundle\Form\EmpType', $emp);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('emp_edit', array('id' => $emp->getId()));
        }

        return $this->render('emp/edit.html.twig', array(
            'emp' => $emp,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a emp entity.
     *
     */
    public function deleteAction(Request $request, Emp $emp)
    {
        $form = $this->createDeleteForm($emp);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($emp);
            $em->flush();
        }

        return $this->redirectToRoute('emp_index');
    }

    /**
     * Creates a form to delete a emp entity.
     *
     * @param Emp $emp The emp entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Emp $emp)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('emp_delete', array('id' => $emp->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

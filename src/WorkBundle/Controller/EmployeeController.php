<?php

namespace WorkBundle\Controller;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use WorkBundle\Entity\Position;
use WorkBundle\Entity\Employee;
use WorkBundle\Entity\Search;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Employee controller.
 *
 */
class EmployeeController extends Controller
{
    /**
     * Lists all employee entities.
     *
     */
    public function indexAction(Request $request)
    {
        /***************** Searching form *********************/
        $search = new Search();

        $form = $this->createFormBuilder($search)
            ->add('field', TextType::class, ['attr' => ['class' => 'form-control', 'style' => 'width:50%']])
            ->add('save', SubmitType::class, ['label' => 'Search', 'attr' => ['class' => 'btn btn-primary', 'style' => 'width:170px']])
            ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $search = $form->get('field')->getData();

            $find = $em = $this->getDoctrine()
                ->getRepository(Employee::class)
                ->findAllByLike($search);

            return $this->render('employee/results.html.twig', [
                'find' => $find,
            ]);
        }
        /***            Select all entity's                 ***/
        $em    = $this->get('doctrine.orm.entity_manager');
        $dql = "SELECT e.id, e.fio, e.salary, e.positionId, e.date, p.name FROM WorkBundle:Employee e 
                JOIN WorkBundle:Position p 
                WHERE e.positionId = p.id 
                ORDER BY e.id ASC";

        $query = $em->createQuery($dql);

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            10
        );

        // parameters to template
        return $this->render('employee/index.html.twig', [
            'pagination' => $pagination,
            'form' => $form->createView(),
        ]);
    }

    /**
     * Creates a new employee entity.
     *
     */
    public function newAction(Request $request)
    {
        $employee = new Employee();
        $form = $this->createForm('WorkBundle\Form\EmployeeType', $employee);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($employee);
            $em->flush();

            return $this->redirectToRoute('employee_show', array('id' => $employee->getId()));
        }

        return $this->render('employee/new.html.twig', array(
            'employee' => $employee,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a employee entity.
     *
     */
    public function showAction(Employee $employee)
    {
        $deleteForm = $this->createDeleteForm($employee);

        return $this->render('employee/show.html.twig', array(
            'employee' => $employee,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing employee entity.
     *
     */
    public function editAction(Request $request, Employee $employee)
    {
        $deleteForm = $this->createDeleteForm($employee);
        $editForm = $this->createForm('WorkBundle\Form\EmployeeType', $employee);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('employee_edit', array('id' => $employee->getId()));
        }

        return $this->render('employee/edit.html.twig', array(
            'employee' => $employee,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a employee entity.
     *
     */
    public function deleteAction(Request $request, Employee $employee)
    {
        $form = $this->createDeleteForm($employee);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($employee);
            $em->flush();
        }

        return $this->redirectToRoute('employee_index');
    }

    /**
     * Creates a form to delete a employee entity.
     *
     * @param Employee $employee The employee entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Employee $employee)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('employee_delete', array('id' => $employee->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    public function searchAction(Request $request)
    {
        $search = new Search();

        $form = $this->createFormBuilder($search)
            ->add('field', TextType::class, ['attr' => ['class' => 'form-control']])
            ->add('save', SubmitType::class, ['label' => 'Search', 'attr' => ['class' => 'btn btn-primary']])
            ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $search = $form->get('field')->getData();

            $find = $em = $this->getDoctrine()
                ->getRepository(Employee::class)
                ->findAllByLike($search);

            return $this->render('employee/results.html.twig', [
                'find' => $find,
            ]);
        }

        return $this->render('employee/search.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}

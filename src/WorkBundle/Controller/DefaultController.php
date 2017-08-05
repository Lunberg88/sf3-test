<?php

namespace WorkBundle\Controller;

use WorkBundle\Entity\News;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('WorkBundle:Default:index.html.twig');
    }

    public function listAction()
    {
        $news = $this->getDoctrine()
            ->getRepository(News::class)
            ->findAll();

        return $this->render('WorkBundle:Default:list.html.twig', [
            'news' => $news,
        ]);
    }
	
	public function viewAction($id)
	{
	    $views = $this->getDoctrine()->getRepository(News::class)->find($id);

		return $this->render('WorkBundle:Default:view.html.twig', [
			'views' => $views,
		]);
	}

	public function setAction(Request $request)
    {
        $session = new Session();

        if($request->isMethod('POST')) {
            $session->set('MySess', 'LUCK FOR YOU');
        }

        return $this->render('WorkBundle:Default:set.html.twig', [
            'session' => $session,
        ]);
    }

    public function aboutAction()
    {
        return $this->render('WorkBundle:Default:about.html.twig');
    }
}

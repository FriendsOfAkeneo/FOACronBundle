<?php

namespace FOA\CronBundle\Controller;

use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\Response;
use FOA\CronBundle\Form\Type\CronType;
use FOA\CronBundle\Manager\Cron;
use FOA\CronBundle\Manager\CronManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Display dashboard and manage CRUD operations
 */
class DashboardController extends Controller
{
    /**
     * Displays the current crons and a form to add a new one.
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        $cronManager = new CronManager();
        $this->addFlash('message', $cronManager->getOutput());
        $this->addFlash('error', $cronManager->getError());

        $form = $this->createForm(new CronType(), new Cron());

        return $this->render('FOACronBundle:Dashboard:index.html.twig', array(
            'crons' => $cronManager->get(),
            'raw'   => $cronManager->getRaw(),
            'form'  => $form->createView(),
        ));
    }

    /**
     * Add a cron to the cron table
     *
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function addAction(Request $request)
    {
        $cronManager = new CronManager();
        $cron = new Cron();
        $this->addFlash('message', $cronManager->getOutput());
        $this->addFlash('error', $cronManager->getError());
        $form = $this->createForm(new CronType(), $cron);

        $form->handleRequest($request);
        if ($form->isValid()) {
            $cronManager->add($cron);
            $this->addFlash('message', $cronManager->getOutput());
            $this->addFlash('error', $cronManager->getError());

            return $this->redirect($this->generateUrl('BCCCronManagerBundle_index'));
        }

        return $this->render('FOACronBundle:Dashboard:index.html.twig', array(
            'crons' => $cronManager->get(),
            'raw'   => $cronManager->getRaw(),
            'form'  => $form->createView(),
        ));
    }

    /**
     * Edit a cron
     *
     * @param $id - the line of the cron in the cron table
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editAction($id)
    {
        $cronManager = new CronManager();
        $cronList = $cronManager->get();
        $this->addFlash('message', $cronManager->getOutput());
        $this->addFlash('error', $cronManager->getError());
        $form = $this->createForm(new CronType(), $cronList[$id]);

        $request = $this->get('request');
        $form->handleRequest($request);
        if ($form->isValid()) {
            $cronManager->write();

            $this->addFlash('message', $cronManager->getOutput());
            $this->addFlash('error', $cronManager->getError());

            return $this->redirect($this->generateUrl('BCCCronManagerBundle_index'));
        }

        return $this->render('FOACronBundle:Dashboard:edit.html.twig', array(
            'form'  => $form->createView(),
        ));
    }

    /**
     * Wake up a cron from the cron table
     *
     * @param $id - the line of the cron in the cron table
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function wakeupAction($id)
    {
        $cronManager = new CronManager();
        $cronList = $cronManager->get();
        $this->addFlash('message', $cronManager->getOutput());
        $this->addFlash('error', $cronManager->getError());

        /**
         * @var \FOA\CronBundle\Manager\Cron $cron
         */
        $cron = $cronList[$id];
        $cron->setSuspended(false);

        $cronManager->write();
        $this->addFlash('message', $cronManager->getOutput());
        $this->addFlash('error', $cronManager->getError());

        return $this->redirect($this->generateUrl('BCCCronManagerBundle_index'));
    }

    /**
     * Suspend a cron from the cron table
     *
     * @param $id - the line of the cron in the cron table
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function suspendAction($id)
    {
        $cronManager = new CronManager();
        $cronList = $cronManager->get();
        $this->addFlash('message', $cronManager->getOutput());
        $this->addFlash('error', $cronManager->getError());

        /**
         * @var \FOA\CronBundle\Manager\Cron $cron
         */
        $cron = $cronList[$id];
        $cron->setSuspended(true);

        $cronManager->write();
        $this->addFlash('message', $cronManager->getOutput());
        $this->addFlash('error', $cronManager->getError());

        return $this->redirect($this->generateUrl('BCCCronManagerBundle_index'));
    }

    /**
     * Remove a cron from the cron table
     *
     * @param $id - the line of the cron in the cron table
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function removeAction($id)
    {
        $cronManager = new CronManager();
        $this->addFlash('message', $cronManager->getOutput());
        $this->addFlash('error', $cronManager->getError());
        $cronManager->remove($id);
        $this->addFlash('message', $cronManager->getOutput());
        $this->addFlash('error', $cronManager->getError());

        return $this->redirect($this->generateUrl('BCCCronManagerBundle_index'));
    }

    /**
     * Gets a log file
     *
     * @param $id - the line of the cron in the cron table
     * @param $type - the type of file, log or error
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function fileAction($id, $type)
    {
        $cronManager = new CronManager();
        $cronList = $cronManager->get();

        /**
         * @var \FOA\CronBundle\Manager\Cron $cron
         */
        $cron = $cronList[$id];

        $data = array();
        $data['file'] =  ($type == 'log') ? $cron->getLogFile(): $cron->getErrorFile();
        $data['content'] = \file_get_contents($data['file']);

        $serializer = new Serializer(array(), array('json' => new JsonEncoder()));

        return new Response($serializer->serialize($data, 'json'));
    }

    /**
     * Adds a flash to the flash bag where flashes are array of messages
     *
     * @param $type
     * @param $message
     * @return mixed
     */
    protected function addFlash($type, $message)
    {
        if (empty($message)) {
            return;
        }

        /* @var \Symfony\Component\HttpFoundation\Session\SessionInterface $session */
        $session = $this->get('session');

        $session->getFlashBag()->add($type, $message);
    }
}

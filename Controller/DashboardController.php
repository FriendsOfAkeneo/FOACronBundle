<?php

namespace FOA\CronBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use FOA\CronBundle\Form\Type\CronType;
use FOA\CronBundle\Manager\Cron;
use FOA\CronBundle\Manager\CronManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Oro\Bundle\SecurityBundle\Annotation\AclAncestor;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * Display dashboard and manage CRUD operations
 * @author Novikov Viktor
 */
class DashboardController extends Controller
{
    /**
     * Displays the current crontab and a form to add a new one.
     *
     * @AclAncestor("foa_cron_management_index")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        $cronManager = new CronManager();
        $this->addFlash('message', $cronManager->getOutput());
        $this->addFlash('error', $cronManager->getError());

        $form = $this->createForm(new CronType(), new Cron());

        return $this->render('FOACronBundle:Dashboard:index.html.twig', [
            'crons' => $cronManager->getCrons(),
            'raw'   => $cronManager->getRaw(),
            'form'  => $form->createView(),
        ]);
    }

    /**
     * Add a cron to the cron table
     *
     * @param Request $request
     *
     * @return RedirectResponse|Response
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

            return $this->redirect($this->generateUrl('foa_cron_index'));
        }

        return $this->render('FOACronBundle:Dashboard:index.html.twig', [
            'crons' => $cronManager->getCrons(),
            'raw'   => $cronManager->getRaw(),
            'form'  => $form->createView(),
        ]);
    }

    /**
     * Edit a cron
     *
     * @param $id - the line of the cron in the cron table
     *
     * @return RedirectResponse|Response
     */
    public function editAction($id)
    {
        $cronManager = new CronManager();
        $this->addFlash('message', $cronManager->getOutput());
        $this->addFlash('error', $cronManager->getError());
        $cron = $cronManager->getById($id);
        $form = $this->createForm(new CronType(), $cron);

        $request = $this->get('request');
        $form->handleRequest($request);
        if ($form->isValid()) {
            $cronManager->write();

            $this->addFlash('message', $cronManager->getOutput());
            $this->addFlash('error', $cronManager->getError());

            return $this->redirect($this->generateUrl('foa_cron_index'));
        }

        return $this->render('FOACronBundle:Dashboard:edit.html.twig', [
            'id'   => $id,
            'form' => $form->createView(),
        ]);
    }

    /**
     * Wake up a cron from the cron table
     *
     * @param $id - the line of the cron in the cron table
     *
     * @return RedirectResponse
     */
    public function wakeupAction($id)
    {
        $this->suspendTask($id, false);

        return $this->redirect($this->generateUrl('foa_cron_index'));
    }

    /**
     * Suspend a cron from the cron table
     *
     * @param $id - the line of the cron in the cron table
     *
     * @return RedirectResponse
     */
    public function suspendAction($id)
    {
        $this->suspendTask($id, true);

        return $this->redirect($this->generateUrl('foa_cron_index'));
    }

    /**
     * Suspend a task from the cron table
     *
     * @param int $id - the line of the cron in the cron table
     * @param bool $state
     */
    protected function suspendTask($id, $state)
    {
        $cronManager = new CronManager();
        $this->addFlash('message', $cronManager->getOutput());
        $this->addFlash('error', $cronManager->getError());

        $cron = $cronManager->getById($id);
        $cron->setSuspended($state);

        $cronManager->write();
        $this->addFlash('message', $cronManager->getOutput());
        $this->addFlash('error', $cronManager->getError());
    }

    /**
     * Remove a cron from the cron table
     *
     * @param $id - the line of the cron in the cron table
     *
     * @return RedirectResponse
     */
    public function removeAction($id)
    {
        $cronManager = new CronManager();
        $this->addFlash('message', $cronManager->getOutput());
        $this->addFlash('error', $cronManager->getError());
        $cronManager->remove($id);
        $this->addFlash('message', $cronManager->getOutput());
        $this->addFlash('error', $cronManager->getError());

        return $this->redirect($this->generateUrl('foa_cron_index'));
    }

    /**
     * Adds a flash to the flash bag where flashes are array of messages
     *
     * @param $type
     * @param $message
     */
    protected function addFlash($type, $message)
    {
        if (empty($message)) {
            return;
        }

        $session = $this->get('session');
        $session->getFlashBag()->add($type, $message);
    }
}

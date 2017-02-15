<?php

namespace FOA\CronBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use FOA\CronBundle\Manager\CronManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Display and manage log files
 */
class LogController extends Controller
{
    /**
     * Gets a log file
     *
     * @param $id   - the line of the cron in the cron table
     * @param $type - the type of file, log or error
     *
     * @return Response
     */
    public function fileAction($id, $type)
    {
        $cronManager = new CronManager();
        $cron = $cronManager->getById($id);
        $filepath = ($type == 'log') ? $cron->getLogFile() : $cron->getErrorFile();
        $content = file_get_contents($filepath);

        return $this->render('FOACronBundle:Dashboard:log.html.twig', [
            'filepath' => $filepath,
            'content'  => $content,
        ]);
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

<?php

namespace FOA\CronBundle\Controller\Rest;

use FOA\CronBundle\Manager\Cron;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @author Novikov Viktor
 * @author JM Leroux <jean-marie.leroux@akeneo.com>
 */
class CronController extends Controller
{
    public function indexAction(): JsonResponse
    {
        $cronManager = $this->get('foa.cron_bundle.cron_manager');
        $crons = $cronManager->getCrons();

        $list = array_map(function (Cron $cron){
            return $cron->__toString();
        }, $crons);

        return new JsonResponse($list);
    }
}

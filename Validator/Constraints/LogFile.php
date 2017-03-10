<?php

namespace FOA\CronBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 * @author JM Leroux <jmleroux.pro@gmail.com>
 */
class LogFile extends Constraint
{
    public $message = 'Invalid log path "%string%".';
}

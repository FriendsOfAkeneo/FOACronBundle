<?php

namespace FOA\CronBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 * @author JM Leroux <jmleroux.pro@gmail.com>
 */
class CronMinuteFormat extends Constraint
{
    public $message = 'Invalid minute format "%string%".';
}

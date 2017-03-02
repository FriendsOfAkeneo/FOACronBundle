<?php

namespace FOA\CronBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 * @author JM Leroux <jmleroux.pro@gmail.com>
 */
class CronMonthFormat extends Constraint
{
    public $message = 'Invalid month format "%string%".';
}

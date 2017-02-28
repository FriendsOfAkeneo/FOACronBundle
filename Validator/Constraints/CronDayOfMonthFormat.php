<?php

namespace FOA\CronBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 * @author JM Leroux <jmleroux.pro@gmail.com>
 */
class CronDayOfMonthFormat extends Constraint
{
    public $message = 'Invalid day of month format "%string%".';
}

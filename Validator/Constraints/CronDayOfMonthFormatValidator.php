<?php

namespace FOA\CronBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * @author JM Leroux <jmleroux.pro@gmail.com>
 */
class CronDayOfMonthFormatValidator extends ConstraintValidator
{
    /**
     * @param string|int $value
     * @param Constraint $constraint
     */
    public function validate($value, Constraint $constraint)
    {
        if (is_numeric($value) && ($value < 1 || $value > 31)) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('%string%', $value)
                ->addViolation();
        }
    }
}

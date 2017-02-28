<?php

namespace FOA\CronBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * @author JM Leroux <jmleroux.pro@gmail.com>
 */
class CronHourFormatValidator extends ConstraintValidator
{
    /**
     * @param string|int $value
     * @param Constraint $constraint
     */
    public function validate($value, Constraint $constraint)
    {
        if (is_numeric($value) && ($value < 0 || $value > 23)) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('%string%', $value)
                ->addViolation();
        }
    }
}

<?php

namespace FOA\CronBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * @author JM Leroux <jmleroux.pro@gmail.com>
 */
abstract class AbstractCronTimeFormatValidator extends ConstraintValidator
{
    /**
     * @param string|int $value
     * @param Constraint $constraint
     */
    public function validate($value, Constraint $constraint)
    {
        if (false !== strpos($value, ',')) {
            $isValid = $this->validateList(explode(',', $value));
        } else {
            $isValid = $this->validateItem($value);
        }

        if (!$isValid) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('%string%', $value)
                ->addViolation();
        }
    }

    /**
     * @param array $list
     *
     * @return bool
     */
    private function validateList($list)
    {
        foreach ($list as $item) {
            if (!$this->validateItem($item)) {
                return false;
            }
        }

        return true;
    }

    /**
     * @param int|string $item
     *
     * @return bool
     */
    private function validateItem($item)
    {
        if (false !== strpos($item, '-')) {
            return $this->validateRange($item);
        }

        return $this->validateTimeEntry($item);
    }

    /**
     * @param int|string $range
     *
     * @return bool
     */
    private function validateRange($range)
    {
        $items = explode('-', $range);

        if (count($items) !== 2) {
            return false;
        }

        foreach ($items as $item) {
            if (!$this->validateTimeEntry($item)) {
                return false;
            }
        }

        return true;
    }

    /**
     * @param int|string $item
     *
     * @return bool
     */
    abstract function validateTimeEntry($item);
}

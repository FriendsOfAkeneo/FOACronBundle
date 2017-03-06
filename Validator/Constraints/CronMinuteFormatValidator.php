<?php

namespace FOA\CronBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * @author JM Leroux <jmleroux.pro@gmail.com>
 */
class CronMinuteFormatValidator extends ConstraintValidator
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

        return $this->validateMinute($item);
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
            if (!$this->validateMinute($item)) {
                return false;
            }
        }

        return true;
    }

    /**
     * @param int|string $minuteItem
     *
     * @return bool
     */
    private function validateMinute($minuteItem)
    {
        if ('' === trim($minuteItem)) {
            return false;
        }

        if (is_numeric($minuteItem) && ($minuteItem < 0 || $minuteItem > 59)) {
            return false;
        }

        if (!is_numeric($minuteItem) && !preg_match('#(^\*$)|(^\*/[0-9]+$)#', $minuteItem)) {
            return false;
        }

        return true;
    }
}

<?php

namespace FOA\CronBundle\Validator\Constraints;

/**
 * @author JM Leroux <jmleroux.pro@gmail.com>
 */
class CronDayOfMonthFormatValidator extends AbstractCronTimeFormatValidator
{
    /**
     * @inheritdoc
     */
    protected function validateTimeEntry($item)
    {
        if ('' === trim($item)) {
            return false;
        }

        if (is_numeric($item) && ($item < 1 || $item > 31)) {
            return false;
        }

        if (!is_numeric($item) && !preg_match('#(^\*$)|(^\*/[0-9]+$)#', $item)) {
            return false;
        }

        return true;
    }
}

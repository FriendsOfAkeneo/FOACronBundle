<?php

namespace FOA\CronBundle\Validator\Constraints;

/**
 * @author JM Leroux <jmleroux.pro@gmail.com>
 */
class CronHourFormatValidator extends AbstractCronTimeFormatValidator
{
    /**
     * @inheritdoc
     */
    public function validateTimeEntry($item)
    {
        if ('' === trim($item)) {
            return false;
        }

        if (is_numeric($item) && ($item < 0 || $item > 23)) {
            return false;
        }

        if (!is_numeric($item) && !preg_match('#(^\*$)|(^\*/[0-9]+$)#', $item)) {
            return false;
        }

        return true;
    }
}

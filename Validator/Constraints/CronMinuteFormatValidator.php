<?php

namespace FOA\CronBundle\Validator\Constraints;

/**
 * @author JM Leroux <jmleroux.pro@gmail.com>
 */
class CronMinuteFormatValidator extends AbstractCronTimeFormatValidator
{
    /**
     * @inheritdoc
     */
    public function validateTimeEntry($item)
    {
        if ('' === trim($item)) {
            return false;
        }

        if (is_numeric($item) && ($item < 0 || $item > 59)) {
            return false;
        }

        if (!is_numeric($item) && !preg_match('#(^\*$)|(^\*/[0-9]+$)#', $item)) {
            return false;
        }

        return true;
    }
}

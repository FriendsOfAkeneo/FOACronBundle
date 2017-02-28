<?php

namespace Tests\FOA\CronBundle\Validator\Constraints;

use FOA\CronBundle\Validator\Constraints\CronDayOfWeekFormat;
use FOA\CronBundle\Validator\Constraints\CronDayOfWeekFormatValidator;
use Symfony\Component\Validator\Tests\Constraints\AbstractConstraintValidatorTest;

/**
 * @author JM Leroux <jmleroux.pro@gmail.com>
 */
class CronDayOfWeekFormatValidatorTest extends AbstractConstraintValidatorTest
{
    /**
     * {@inheritdoc}
     */
    protected function createValidator()
    {
        return new CronDayOfWeekFormatValidator();
    }

    /**
     * @return array
     */
    public function getValidValues()
    {
        return [
            [0],
            [1],
            [7],
        ];
    }

    /**
     * @dataProvider getValidValues
     *
     * @param string $value
     */
    public function testValidValue($value)
    {
        $constraint = new CronDayOfWeekFormat();
        $this->validator->validate($value, $constraint);
        $this->assertNoViolation();
    }

    /**
     * @return array
     */
    public function getInvalidValues()
    {
        return [
            [-1],
            [8],
        ];
    }

    /**
     * @dataProvider getInvalidValues
     *
     * @param string $value
     */
    public function testInvalidValues($value)
    {
        $constraint = new CronDayOfWeekFormat();
        $this->validator->validate($value, $constraint);
        $this->buildViolation($constraint->message)
            ->setParameter('%string%', $value)
            ->assertRaised();
    }
}

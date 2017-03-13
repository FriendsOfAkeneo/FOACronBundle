<?php

namespace Tests\FOA\CronBundle\Validator\Constraints;

use FOA\CronBundle\Validator\Constraints\CronDayOfMonthFormat;
use FOA\CronBundle\Validator\Constraints\CronDayOfMonthFormatValidator;
use Symfony\Component\Validator\Tests\Constraints\AbstractConstraintValidatorTest;

/**
 * @author JM Leroux <jmleroux.pro@gmail.com>
 */
class CronDayOfMonthFormatValidatorTest extends AbstractConstraintValidatorTest
{
    /**
     * {@inheritdoc}
     */
    protected function createValidator()
    {
        return new CronDayOfMonthFormatValidator();
    }

    /**
     * @return array
     */
    public function getValidValues()
    {
        return [
            [1],
            [31],
            ['2,15'],
            ['4-15'],
            ['1-9,15-25'],
            ['5,15-30'],
            ['*/10'],
            ['*'],
            ['*,7,*/10'],
        ];
    }

    /**
     * @dataProvider getValidValues
     *
     * @param string $value
     */
    public function testValidValue($value)
    {
        $constraint = new CronDayOfMonthFormat();
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
            [0],
            [32],
            ['5,35'],
            ['3-35'],
            ['-1'],
            ['1-'],
            ['3,20-35'],
            ['1-10,20-45'],
            ['25/*'],
            ['2-10,25/*'],
            ['**'],
        ];
    }

    /**
     * @dataProvider getInvalidValues
     *
     * @param string $value
     */
    public function testInvalidValues($value)
    {
        $constraint = new CronDayOfMonthFormat();
        $this->validator->validate($value, $constraint);
        $this->buildViolation($constraint->message)
            ->setParameter('%string%', $value)
            ->assertRaised();
    }
}

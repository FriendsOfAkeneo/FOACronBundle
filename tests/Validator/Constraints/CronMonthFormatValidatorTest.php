<?php

namespace Tests\FOA\CronBundle\Validator\Constraints;

use FOA\CronBundle\Validator\Constraints\CronMonthFormat;
use FOA\CronBundle\Validator\Constraints\CronMonthFormatValidator;
use Symfony\Component\Validator\Tests\Constraints\AbstractConstraintValidatorTest;

/**
 * @author JM Leroux <jmleroux.pro@gmail.com>
 */
class CronMonthFormatValidatorTest extends AbstractConstraintValidatorTest
{
    /**
     * {@inheritdoc}
     */
    protected function createValidator()
    {
        return new CronMonthFormatValidator();
    }

    /**
     * @return array
     */
    public function getValidValues()
    {
        return [
            [5],
            [1],
            [12],
        ];
    }

    /**
     * @dataProvider getValidValues
     *
     * @param string $value
     */
    public function testValidValue($value)
    {
        $constraint = new CronMonthFormat();
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
            [13],
        ];
    }

    /**
     * @dataProvider getInvalidValues
     *
     * @param string $value
     */
    public function testInvalidValues($value)
    {
        $constraint = new CronMonthFormat();
        $this->validator->validate($value, $constraint);
        $this->buildViolation($constraint->message)
            ->setParameter('%string%', $value)
            ->assertRaised();
    }
}

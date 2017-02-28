<?php

namespace Tests\FOA\CronBundle\Validator\Constraints;

use FOA\CronBundle\Validator\Constraints\CronHourFormat;
use FOA\CronBundle\Validator\Constraints\CronHourFormatValidator;
use Symfony\Component\Validator\Tests\Constraints\AbstractConstraintValidatorTest;

/**
 * @author JM Leroux <jmleroux.pro@gmail.com>
 */
class CronHourFormatValidatorTest extends AbstractConstraintValidatorTest
{
    /**
     * {@inheritdoc}
     */
    protected function createValidator()
    {
        return new CronHourFormatValidator();
    }

    /**
     * @return array
     */
    public function getValidValues()
    {
        return [
            [0],
            [1],
            [23],
        ];
    }

    /**
     * @dataProvider getValidValues
     *
     * @param string $value
     */
    public function testValidValue($value)
    {
        $constraint = new CronHourFormat();
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
            [24],
        ];
    }

    /**
     * @dataProvider getInvalidValues
     *
     * @param string $value
     */
    public function testInvalidValues($value)
    {
        $constraint = new CronHourFormat();
        $this->validator->validate($value, $constraint);
        $this->buildViolation($constraint->message)
            ->setParameter('%string%', $value)
            ->assertRaised();
    }
}

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
            ['5,15'],
            ['5-15'],
            ['11-15,16-20'],
            ['5,15-20,23'],
            ['*/15'],
            ['*'],
            ['*,7,*/15'],
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
            ['5,30'],
            ['32,9'],
            ['24-50'],
            ['-1'],
            ['1-'],
            ['22,23-70'],
            ['10-20,45'],
            ['10-20,50-65'],
            ['20/*'],
            ['2-3,20/*'],
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
        $constraint = new CronHourFormat();
        $this->validator->validate($value, $constraint);
        $this->buildViolation($constraint->message)
            ->setParameter('%string%', $value)
            ->assertRaised();
    }
}

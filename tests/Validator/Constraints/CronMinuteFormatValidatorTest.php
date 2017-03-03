<?php

namespace Tests\FOA\CronBundle\Validator\Constraints;

use FOA\CronBundle\Validator\Constraints\CronMinuteFormat;
use FOA\CronBundle\Validator\Constraints\CronMinuteFormatValidator;
use Symfony\Component\Validator\Tests\Constraints\AbstractConstraintValidatorTest;

/**
 * @author JM Leroux <jmleroux.pro@gmail.com>
 */
class CronMinuteFormatValidatorTest extends AbstractConstraintValidatorTest
{
    /**
     * {@inheritdoc}
     */
    protected function createValidator()
    {
        return new CronMinuteFormatValidator();
    }

    /**
     * @return array
     */
    public function getValidValues()
    {
        return [
            [5],
            [0],
            [59],
            ['5,15'],
            ['5-15'],
            ['10-20,40-50'],
            ['5,15-20,30'],
            ['*/15'],
        ];
    }

    /**
     * @dataProvider getValidValues
     *
     * @param string $value
     */
    public function testValidValue($value)
    {
        $constraint = new CronMinuteFormat();
        $this->validator->validate($value, $constraint);
        $this->assertNoViolation();
    }

    /**
     * @return array
     */
    public function getInvalidValues()
    {
        return [
            [61],
            ['5,89'],
            ['95,9'],
            ['50-70'],
            ['-1'],
            ['1-'],
            ['25,50-70'],
            ['10-20,85'],
            ['10-20,50-65'],
            ['20/*'],
        ];
    }

    /**
     * @dataProvider getInvalidValues
     *
     * @param string $value
     */
    public function testInvalidValues($value)
    {
        $constraint = new CronMinuteFormat();
        $this->validator->validate($value, $constraint);
        $this->buildViolation($constraint->message)
            ->setParameter('%string%', $value)
            ->assertRaised();
    }
}

<?php

namespace Tests\FOA\CronBundle\Validator\Constraints;

use FOA\CronBundle\Validator\Constraints\CliCommandPath;
use FOA\CronBundle\Validator\Constraints\CliCommandPathValidator;
use Symfony\Component\Validator\Tests\Constraints\AbstractConstraintValidatorTest;

/**
 * @author JM Leroux <jmleroux.pro@gmail.com>
 */
class CliCommandPathValidatorTest extends AbstractConstraintValidatorTest
{
    /**
     * {@inheritdoc}
     */
    protected function createValidator()
    {
        return new CliCommandPathValidator('/home/akeneo/pim/app');
    }

    public function testValidCommand()
    {
        $constraint = new CliCommandPath();
        $this->validator->validate('php /home/akeneo/pim/bin/console debug:container', $constraint);
        $this->assertNoViolation();
    }

    /**
     * @return array
     */
    public function getInvalidValues()
    {
        return [
            ['php /home/akeneo/pim/app/hack.php'],
            ['php /usr/bin/console'],
            ['/home/akeneo/pim/bin/console'],
            ['php /home/akeneo/pim/bin/console_hacked'],
            ['bin/console'],
        ];
    }

    /**
     * @dataProvider getInvalidValues
     *
     * @param string $value
     */
    public function testInvalidValues($value)
    {
        $constraint = new CliCommandPath();

        $this->validator->validate($value, $constraint);

        $this->buildViolation($constraint->message)
            ->setParameter('%string%', $value)
            ->assertRaised();
    }
}

<?php
namespace Tests\FOA\CronBundle\Validator\Constraints;

use FOA\CronBundle\Manager\Cron;
use FOA\CronBundle\Validator\Constraints\CliCommandPath;
use FOA\CronBundle\Validator\Constraints\CliCommandPathValidator;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Validator\Tests\Constraints\AbstractConstraintValidatorTest;

class CliCommandPathValidatorTest extends AbstractConstraintValidatorTest
{
    protected function createValidator()
    {
        return new CliCommandPathValidator('/home/akeneo/pim/app');
    }

    public function testValidCommand()
    {
        $constraint = new CliCommandPath();
        $this->validator->validate('php /home/akeneo/pim/app/console debug:container', $constraint);
        $this->assertNoViolation();
    }

    /**
     * @dataProvider getInvalidValues
     */
    public function testInvalidValues($value)
    {
        $constraint = new CliCommandPath();

        $this->validator->validate($value, $constraint);

        $this->buildViolation($constraint->message)
            ->setParameter('%string%', $value)
            ->assertRaised();
    }

    public function getInvalidValues()
    {
        return [
            ['php /home/akeneo/pim/app/hack.php'],
            ['php /usr/bin/console'],
            ['/home/akeneo/pim/app/console'],
            ['php /home/akeneo/pim/app/console_hacked'],
            ['app/console'],
        ];
    }
}

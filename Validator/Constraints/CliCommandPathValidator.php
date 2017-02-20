<?php

namespace FOA\CronBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class CliCommandPathValidator extends ConstraintValidator
{
    /**
     * @var string
     */
    private $kernelDir;

    /**
     * @param $kernelDir
     */
    public function __construct($kernelDir)
    {
        $this->kernelDir = $kernelDir;
    }

    public function validate($value, Constraint $constraint)
    {
        $pattern = '/^php\s' . str_replace('/', '\/', $this->kernelDir . '/console') . '\s*/';
        if (!preg_match($pattern, $value, $matches)) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('%string%', $value)
                ->addViolation();
        }
    }
}

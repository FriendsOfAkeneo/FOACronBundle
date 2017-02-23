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
        $pattern = sprintf('#^php \s+ %s/console \s+#x', preg_quote($this->kernelDir));
        if (!preg_match($pattern, $value, $matches)) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('%string%', $value)
                ->addViolation();
        }
    }
}

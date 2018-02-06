<?php

namespace FOA\CronBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * @author Novikov Viktor
 */
class CliCommandPathValidator extends ConstraintValidator
{
    /** @var string */
    private $projectDir;

    /**
     * @param string $projectDir
     */
    public function __construct($projectDir)
    {
        $this->projectDir = $projectDir;
    }

    /**
     * @param string     $value The command to check
     * @param Constraint $constraint
     */
    public function validate($value, Constraint $constraint)
    {
        $pattern = sprintf('#^php \s+ %s/bin/console \s+#x', preg_quote($this->projectDir));
        if (!preg_match($pattern, $value, $matches)) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('%string%', $value)
                ->addViolation();
        }
    }
}

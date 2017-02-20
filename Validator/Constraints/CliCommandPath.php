<?php

namespace FOA\CronBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class CliCommandPath extends Constraint
{
    public $message = 'The path "%string%" is not valid Symfony command path.';

    /**
     * @inheritdoc
     */
    public function validatedBy()
    {
        return 'foa.cli_command_path.validator';
    }
}

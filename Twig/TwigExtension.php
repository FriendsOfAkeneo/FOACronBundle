<?php

namespace FOA\CronBundle\Twig;

/**
 * @author Novikov Viktor
 */
class TwigExtension extends \Twig_Extension
{
    /**
     * @var array
     */
    protected $wwwUser;

    /**
     * @var string
     */
    protected $logDir;

    /**
     * @var string
     */
    protected $symfonyCommand;

    /**
     * @param string $logDir
     * @param string $projectDir
     */
    public function __construct($logDir, $projectDir)
    {
        if (function_exists('posix_getpwuid')) {
            $this->wwwUser = posix_getpwuid(posix_geteuid());
        } else {
            $this->wwwUser = [
                'name' => get_current_user(),
                'dir'  => '-',
            ];
        }
        $this->logDir = $logDir;
        $this->symfonyCommand = 'php ' . $projectDir . '/bin/console';
    }

    /**
     * @return string[]
     */
    public function getGlobals()
    {
        return [
            'wwwUser'        => $this->wwwUser,
            'logDir'         => $this->logDir,
            'symfonyCommand' => $this->symfonyCommand,
        ];
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'bcc-cron-manager';
    }
}

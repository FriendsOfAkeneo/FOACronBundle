<?php
namespace FOA\CronBundle\Manager;

use Symfony\Component\Process\Process;

/**
 * CronManager provides easy access to the crontable
 *
 * @author Novikov Viktor
 */
class CronManager
{
    /**
     * The lines of the cron table, can be cron command or comment
     *
     * @var string[]|Cron[]
     */
    protected $lines = [];

    /**
     * The error when using the comment 'crontab'
     *
     * @var string
     */
    protected $error;

    /**
     * The output when using the command 'crontab'
     *
     * @var string
     */
    protected $output;

    public function __construct()
    {
        // parsing cron file
        $process = new Process('crontab -l');
        $process->run();
        $lines = array_filter(explode(PHP_EOL, $process->getOutput()), function ($line) {
            return '' != trim($line);
        });

        foreach ($lines as $lineNumber => $line) {
            // if line is not a comment, convert it to a cron
            if (strpos($line, '#suspended: ', 0) === 0 || 0 !== strpos($line, '#', 0)) {
                try {
                    $line = Cron::parse($line);
                } catch (\Exception $e) {
                    $process->addErrorOutput('CronManager was unable to parse crontab at line ' . $lineNumber);
                }
            }
            $this->lines['l' . $lineNumber] = $line;
        }

        $this->error = $process->getErrorOutput();
    }

    /**
     * Gets the array of crons indexed by line number
     *
     * @return Cron[]
     */
    public function getCrons()
    {
        return array_filter($this->lines, function ($line) {
            return $line instanceof Cron;
        });
    }

    /**
     * Get a specific cron by its id
     *
     * @param int $id
     *
     * @return Cron
     */
    public function getById($id)
    {
        $cronList = $this->getCrons();
        if (!isset($cronList[$id])) {
            throw new \InvalidArgumentException(sprintf('Unknown cron ID %d', $id));
        }

        return $cronList[$id];
    }

    /**
     * Add a cron to the cron table
     *
     * @param Cron $cron
     */
    public function add(Cron $cron)
    {
        $this->lines[] = $cron;
        $this->write();
    }

    /**
     * Remove a cron from the cron table
     *
     * @param int $index - the line number
     */
    public function remove($index)
    {
        $this->lines = array_diff_key($this->lines, [$index => '']);
        $this->write();
    }

    /**
     * Write the current crons in the cron table
     */
    public function write()
    {
        $file = tempnam(sys_get_temp_dir(), 'cron');

        file_put_contents($file, $this->getRaw() . PHP_EOL);

        $process = new Process('crontab ' . $file);
        $process->run();

        $this->error = $process->getErrorOutput();
        $this->output = $process->getOutput();
    }

    /**
     * Gets the error output when using the 'crontab' command
     *
     * @return string
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * Gets the output when using the 'crontab' command
     *
     * @return string
     */
    public function getOutput()
    {
        return $this->output;
    }

    /**
     * Gets a representation of the cron table file
     *
     * @return string
     */
    public function getRaw()
    {
        return implode(PHP_EOL, $this->lines);
    }
}

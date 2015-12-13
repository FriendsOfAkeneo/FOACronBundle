<?php

namespace FOA\CronBundle\Manager;

/**
 * Cron represents a cron command. It holds:
 * - time data
 * - command
 * - comment
 * - log files
 * - cron execution status
 */
class Cron
{
    /**
     * @var string
     */
    protected $minute = '*';

    /**
     * @var string
     */
    protected $hour = '*';

    /**
     * @var string
     */
    protected $dayOfMonth = '*';

    /**
     * @var string
     */
    protected $month = '*';

    /**
     * @var string
     */
    protected $dayOfWeek = '*';

    /**
     * @var string
     */
    protected $command;

    /**
     * @var string
     */
    protected $logFile = null;

    /**
     * The size of the log file
     *
     * @var string
     */
    protected $logSize = null;

    /**
     * @var string
     */
    protected $errorFile = null;

    /**
     * The size of the error file
     *
     * @var string
     */
    protected $errorSize = null;

    /**
     * The last run time based on when log files have been written
     *
     * @var int
     */
    protected $lastRunTime = null;

    /**
     * The status of the cron, based on the log files
     *
     * @var string
     */
    protected $status;

    /**
     * @var string
     */
    protected $comment;

    /**
     * isSuspended
     *
     * @var boolean
     * @access protected
     */
    protected $isSuspended = false;

    /**
     * Parses a cron line into a Cron instance
     *
     * @static
     * @param $cron string The cron line
     * @return Cron
     */
    public static function parse($cron)
    {
        if (substr($cron, 0, 12) == '#suspended: ') {
            $cron = substr($cron, 12);
            $isSuspended = true;
        }

        $parts = explode(' ', $cron);

        $command = implode(' ', array_slice($parts, 5));

        // extract comment
        if (strpos($command, '#')) {
            list($command, $comment) = explode('#', $command);
            $comment = trim($comment);
        }

        // extract error file
        if (strpos($command, '2>')) {
            list($command, $errorFile) = explode('2>', $command);
            $errorFile = trim($errorFile);
        }

        // extract log file
        if (strpos($command, '>')) {
            list($command, $logFile) = explode('>', $command);
            $logFile = trim($logFile);
        }

        // compute last run time, and file size
        $lastRunTime = null;
        $logSize = null;
        $errorSize = null;
        if (isset($logFile) && file_exists($logFile)) {
            $lastRunTime = filemtime($logFile);
            $logSize = filesize($logFile);
        }
        if (isset($errorFile) && file_exists($errorFile)) {
            $lastRunTime = max($lastRunTime ? : 0, filemtime($errorFile));
            $errorSize = filesize($errorFile);
        }

        // compute status
        $status = 'error';
        if ($logSize === null && $errorSize === null) {
            $status = 'unknown';
        } else if ($errorSize === null || $errorSize == 0) {
            $status = 'success';
        }

        // create cron instance
        $cron = new self();
        $cron->setMinute($parts[0])
            ->setHour($parts[1])
            ->setDayOfMonth($parts[2])
            ->setMonth($parts[3])
            ->setDayOfWeek($parts[4])
            ->setCommand(\trim($command))
            ->setLastRunTime($lastRunTime)
            ->setLogSize($logSize)
            ->setErrorSize($errorSize)
            ->setStatus($status);

        if (isset($isSuspended)) {
            $cron->setSuspended($isSuspended);
        }
        if (isset($comment)) {
            $cron->setComment($comment);
        }
        if (isset($logFile)) {
            $cron->setLogFile($logFile);
        }
        if (isset($errorFile)) {
            $cron->setErrorFile($errorFile);
        }

        return $cron;
    }

    /**
     * @param string $command
     * @return $this
     */
    public function setCommand($command)
    {
        $this->command = $command;

        return $this;
    }

    /**
     * @return string
     */
    public function getCommand()
    {
        return $this->command;
    }

    /**
     * @param string $dayOfMonth
     * @return $this
     */
    public function setDayOfMonth($dayOfMonth)
    {
        $this->dayOfMonth = $dayOfMonth;

        return $this;
    }

    /**
     * @return string
     */
    public function getDayOfMonth()
    {
        return $this->dayOfMonth;
    }

    /**
     * @param string $dayOfWeek
     * @param $dayOfWeek
     * @return $this
     */
    public function setDayOfWeek($dayOfWeek)
    {
        $this->dayOfWeek = $dayOfWeek;

        return $this;
    }

    /**
     * @return string
     */
    public function getDayOfWeek()
    {
        return $this->dayOfWeek;
    }

    /**
     * @param string $hour
     * @param $hour
     * @return $this
     */
    public function setHour($hour)
    {
        $this->hour = $hour;

        return $this;
    }

    /**
     * @return string
     */
    public function getHour()
    {
        return $this->hour;
    }

    /**
     * @param string $minute
     * @return $this
     */
    public function setMinute($minute)
    {
        $this->minute = $minute;

        return $this;
    }

    /**
     * @return string
     */
    public function getMinute()
    {
        return $this->minute;
    }

    /**
     * @param string $month
     * @return $this
     */
    public function setMonth($month)
    {
        $this->month = $month;

        return $this;
    }

    /**
     * @return string
     */
    public function getMonth()
    {
        return $this->month;
    }

    /**
     * @param string $comment
     * @return $this
     */
    public function setComment($comment)
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * @param string $logFile
     * @return $this
     */
    public function setLogFile($logFile)
    {
        $this->logFile = $logFile;

        return $this;
    }

    /**
     * @return string
     */
    public function getLogFile()
    {
        return $this->logFile;
    }

    /**
     * @param string $errorFile
     * @return $this
     */
    public function setErrorFile($errorFile)
    {
        $this->errorFile = $errorFile;

        return $this;
    }

    /**
     * @return string
     */
    public function getErrorFile()
    {
        return $this->errorFile;
    }

    /**
     * @param int $lastRunTime
     * @return $this
     */
    public function setLastRunTime($lastRunTime)
    {
        $this->lastRunTime = $lastRunTime;

        return $this;
    }

    /**
     * @return int
     */
    public function getLastRunTime()
    {
        return $this->lastRunTime;
    }

    /**
     * @param string $errorSize
     * @return $this
     */
    public function setErrorSize($errorSize)
    {
        $this->errorSize = $errorSize;

        return $this;
    }

    /**
     * @return string
     */
    public function getErrorSize()
    {
        return $this->errorSize;
    }

    /**
     * @param string $logSize
     * @return $this
     */
    public function setLogSize($logSize)
    {
        $this->logSize = $logSize;

        return $this;
    }

    /**
     * @return string
     */
    public function getLogSize()
    {
        return $this->logSize;
    }

    /**
     * @param string $status
     * @return $this
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Concatenate time data to get the time expression
     *
     * @return string
     */
    public function getExpression()
    {
        return sprintf('%s %s %s %s %s', $this->minute, $this->hour, $this->dayOfMonth, $this->month, $this->dayOfWeek);
    }

    /**
     * Gets the value of isSuspended
     *
     * @return boolean
     */
    public function isSuspended()
    {
        return $this->isSuspended;
    }

    /**
     * Sets the value of isSuspended
     *
     * @param boolean $isSuspended status
     *
     * @return Cron
     */
    public function setSuspended($isSuspended = true)
    {
        if ($this->isSuspended != $isSuspended) {
            $this->isSuspended = $isSuspended;
        }

        return $this;
    }

    /**
     * Transforms the cron instance into a cron line
     *
     * @return string
     */
    public function __toString()
    {
        $cronLine = '';
        if ($this->isSuspended()) {
            $cronLine .= '#suspended: ';
        }

        $cronLine .= $this->getExpression() . ' ' . $this->command;
        if ('' != $this->logFile) {
            $cronLine .= ' > ' . $this->logFile;
        }
        if ('' != $this->errorFile) {
            $cronLine .= ' 2> ' . $this->errorFile;
        }
        if ('' != $this->comment) {
            $cronLine .= ' #' . $this->comment;
        }
        return $cronLine;
    }
}

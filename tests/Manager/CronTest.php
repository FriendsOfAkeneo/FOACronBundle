<?php

namespace Tests\FOA\CronBundle\Manager;

use FOA\CronBundle\Manager\Cron;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

/**
 * @author JM Leroux <jmleroux.pro@gmail.com>
 */
class CronTest extends TestCase
{
    public function testAdd()
    {
        $cron = new Cron();
        $cron->setCommand('my_command');
        $this->assertEquals('my_command', $cron->getCommand());
    }

    public function testParseValidCron()
    {
        $cron = Cron::parse('1 2 3 4 5 my_command');
        $this->assertEquals('1', $cron->getMinute());
        $this->assertEquals('2', $cron->getHour());
        $this->assertEquals('3', $cron->getDayOfMonth());
        $this->assertEquals('4', $cron->getMonth());
        $this->assertEquals('5', $cron->getDayOfWeek());
        $this->assertEquals('my_command', $cron->getCommand());
        $this->assertEquals(null, $cron->getLogFile());
    }
}

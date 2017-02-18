<?php

namespace Tests\FOA\CronBundle\Manager;

use FOA\CronBundle\Manager\Cron;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

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

        $cron = Cron::parse('1 2 3 4 15 my_command');
        $this->assertEquals('1', $cron->getMinute());
        $this->assertEquals('2', $cron->getHour());
        $this->assertEquals('3', $cron->getDayOfMonth());
        $this->assertEquals('4', $cron->getMonth());
        $this->assertEquals('15', $cron->getDayOfWeek());
        $this->assertEquals('my_command', $cron->getCommand());
        $this->assertEquals(null, $cron->getLogFile());
    }

    public function testParseInvalidMinute()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionCode(Cron::ERROR_MINUTE);
        Cron::parse('80 * * * * my_command');
    }

    public function testParseInvalidHour()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionCode(Cron::ERROR_HOUR);
        Cron::parse('* 35 * * * my_command');
    }

    public function testParseInvalidMonth()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionCode(Cron::ERROR_MONTH);
        Cron::parse('* * * 14 * my_command');
    }
}

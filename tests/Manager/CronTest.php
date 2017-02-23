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

    /**
     * @return array
     */
    public function invalidMinutes()
    {
        return [
            ['-1 * * * * my_command'],
            ['60 * * * * my_command'],
        ];
    }

    /**
     * @dataProvider invalidMinutes
     * @expectedException InvalidArgumentException
     *
     * @param string $cronString
     */
    public function testParseInvalidMinute($cronString)
    {
        $this->expectExceptionCode(Cron::ERROR_MINUTE);
        Cron::parse($cronString);
    }

    public function invalidHours()
    {
        return [
            ['* -1 * * * my_command'],
            ['* 24 * * * my_command'],
        ];
    }

    /**
     * @dataProvider invalidHours
     * @expectedException InvalidArgumentException
     *
     * @param string $cronString
     */
    public function testParseInvalidHour($cronString)
    {
        $this->expectExceptionCode(Cron::ERROR_HOUR);
        Cron::parse($cronString);
    }

    public function invalidMonthDays()
    {
        return [
            ['* * 0 * * my_command'],
            ['* * 32 * * my_command'],
        ];
    }

    /**
     * @dataProvider invalidMonthDays
     * @expectedException InvalidArgumentException
     *
     * @param string $cronString
     */
    public function testParseInvalidDayOfMonth($cronString)
    {
        $this->expectExceptionCode(Cron::ERROR_DAY_OF_MONTH);
        Cron::parse($cronString);
    }

    public function invalidMonthes()
    {
        return [
            ['* * * 0 * my_command'],
            ['* * * 13 * my_command'],
        ];
    }

    /**
     * @dataProvider invalidMonthes
     * @expectedException InvalidArgumentException
     *
     * @param string $cronString
     */
    public function testParseInvalidMonth($cronString)
    {
        $this->expectExceptionCode(Cron::ERROR_MONTH);
        Cron::parse($cronString);
    }

    public function invalidWeekDays()
    {
        return [
            ['* * * * -1 my_command'],
            ['* * * * 8 my_command'],
        ];
    }

    /**
     * @dataProvider invalidWeekDays
     * @expectedException InvalidArgumentException
     *
     * @param string $cronString
     */
    public function testParseInvalidDayOfWeek($cronString)
    {
        $this->expectExceptionCode(Cron::ERROR_DAY_OF_WEEK);
        Cron::parse($cronString);
    }
}

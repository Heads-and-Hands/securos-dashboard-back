<?php

namespace Tests\Unit;

use App\Dashboard\Reports\ReportPeriod;
use Carbon\Carbon;
use PHPUnit\Framework\TestCase;

class ReportPeriodTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testSplitByHoursBoundsMatch()
    {
        $period = new ReportPeriod(
            Carbon::parse('20210421T130000'),
            Carbon::parse('20210421T160000'),
            0
        );

        $this->assertCount(3, $period->intervals);
        $this->assertEquals(ReportPeriod::INTERVAL_HOUR, $period->intervalType);
        $this->assertTrue($period->intervals[0]->start->equalTo(Carbon::parse('20210421T130000')));
        $this->assertTrue($period->intervals[0]->end->equalTo(Carbon::parse('20210421T140000')));
        $this->assertTrue($period->intervals[2]->start->equalTo(Carbon::parse('20210421T150000')));
        $this->assertTrue($period->intervals[2]->end->equalTo(Carbon::parse('20210421T160000')));
    }

    public function testSplitByHoursBoundsNotMatch()
    {
        $period = new ReportPeriod(
            Carbon::parse('20210421T131500'),
            Carbon::parse('20210421T162000'),
            0
        );

        $this->assertCount(4, $period->intervals);
        $this->assertEquals(ReportPeriod::INTERVAL_HOUR, $period->intervalType);
        $this->assertTrue($period->intervals[0]->start->equalTo(Carbon::parse('20210421T131500')));
        $this->assertTrue($period->intervals[0]->end->equalTo(Carbon::parse('20210421T140000')));
        $this->assertTrue($period->intervals[3]->start->equalTo(Carbon::parse('20210421T160000')));
        $this->assertTrue($period->intervals[3]->end->equalTo(Carbon::parse('20210421T162000')));
    }

    public function testSplitByHoursMaxPeriod()
    {
        $period = new ReportPeriod(
            Carbon::parse('20210421T000000'),
            Carbon::parse('20210422T000000'),
            0
        );

        $this->assertCount(24, $period->intervals);
        $this->assertEquals(ReportPeriod::INTERVAL_HOUR, $period->intervalType);
    }

    public function testSplitByDaysMinPeriod()
    {
        $period = new ReportPeriod(
            Carbon::parse('20210421T000000'),
            Carbon::parse('20210422T000100'),
            0
        );

        $this->assertCount(2, $period->intervals);
        $this->assertEquals(ReportPeriod::INTERVAL_DAY, $period->intervalType);
        $this->assertTrue($period->intervals[0]->start->equalTo(Carbon::parse('20210421T000000')));
        $this->assertTrue($period->intervals[1]->end->equalTo(Carbon::parse('20210422T000100')));
    }

    public function testSplitByDaysBoundsMatch()
    {
        $period = new ReportPeriod(
            Carbon::parse('20210421T000000'),
            Carbon::parse('20210425T000000'),
            0
        );

        $this->assertCount(4, $period->intervals);
        $this->assertTrue($period->intervals[0]->start->equalTo(Carbon::parse('20210421T000000')));
        $this->assertTrue($period->intervals[0]->end->equalTo(Carbon::parse('20210422T000000')));
        $this->assertTrue($period->intervals[3]->start->equalTo(Carbon::parse('20210424T000000')));
        $this->assertTrue($period->intervals[3]->end->equalTo(Carbon::parse('20210425T000000')));
    }

    public function testSplitByDaysBoundsBoundsNotMatch()
    {
        $period = new ReportPeriod(
            Carbon::parse('20210420T230000'),
            Carbon::parse('20210424T230000'),
            0
        );

        $this->assertCount(5, $period->intervals);
        $this->assertTrue($period->intervals[0]->start->equalTo(Carbon::parse('20210420T230000')));
        $this->assertTrue($period->intervals[0]->end->equalTo(Carbon::parse('20210421T000000')));
        $this->assertTrue($period->intervals[4]->start->equalTo(Carbon::parse('20210424T000000')));
        $this->assertTrue($period->intervals[4]->end->equalTo(Carbon::parse('20210424T230000')));
    }

    public function testSplitByWeeksMinPeriod()
    {
        $period = new ReportPeriod(
            Carbon::parse('20210401T000000'),
            Carbon::parse('20210501T000000'),
            0
        );

        $this->assertCount(5, $period->intervals);
        $this->assertEquals(ReportPeriod::INTERVAL_WEEK, $period->intervalType);
        $this->assertTrue($period->intervals[0]->start->equalTo(Carbon::parse('20210401T000000')));
        $this->assertTrue($period->intervals[0]->end->equalTo(Carbon::parse('20210405T000000')));
    }

    public function testSplitByWeeksBoundsMatch()
    {
        $period = new ReportPeriod(
            Carbon::parse('20210405T000000'),
            Carbon::parse('20210510T000000'),
            0
        );

        $this->assertCount(5, $period->intervals);
        $this->assertEquals(ReportPeriod::INTERVAL_WEEK, $period->intervalType);
        $this->assertTrue($period->intervals[0]->start->equalTo(Carbon::parse('20210405T000000')));
        $this->assertTrue($period->intervals[0]->end->equalTo(Carbon::parse('20210412T000000')));
        $this->assertTrue($period->intervals[4]->start->equalTo(Carbon::parse('20210503T000000')));
        $this->assertTrue($period->intervals[4]->end->equalTo(Carbon::parse('20210510T000000')));
    }

    public function testSplitByWeeksBoundsNotMatch()
    {
        $period = new ReportPeriod(
            Carbon::parse('20210407T000000'),
            Carbon::parse('20210509T000000'),
            0
        );

        $this->assertCount(5, $period->intervals);
        $this->assertEquals(ReportPeriod::INTERVAL_WEEK, $period->intervalType);
        $this->assertTrue($period->intervals[0]->start->equalTo(Carbon::parse('20210407T000000')));
        $this->assertTrue($period->intervals[0]->end->equalTo(Carbon::parse('20210412T000000')));
        $this->assertTrue($period->intervals[4]->start->equalTo(Carbon::parse('20210503T000000')));
        $this->assertTrue($period->intervals[4]->end->equalTo(Carbon::parse('20210509T000000')));
    }

    public function testSplitByMonthMinPeriod()
    {
        $period = new ReportPeriod(
            Carbon::parse('20200201T000000'),
            Carbon::parse('20200801T000000'),
            0
        );

        $this->assertCount(6, $period->intervals);
        $this->assertEquals(ReportPeriod::INTERVAL_MONTH, $period->intervalType);
        $this->assertTrue($period->intervals[0]->start->equalTo(Carbon::parse('20200201T000000')));
        $this->assertTrue($period->intervals[0]->end->equalTo(Carbon::parse('20200301T000000')));
        $this->assertTrue($period->intervals[5]->start->equalTo(Carbon::parse('20200701T000000')));
        $this->assertTrue($period->intervals[5]->end->equalTo(Carbon::parse('20200801T000000')));
    }

    public function testSplitByMonthBoundsMatch()
    {
        $period = new ReportPeriod(
            Carbon::parse('20200201T000000'),
            Carbon::parse('20210301T000000'),
            0
        );

        $this->assertCount(13, $period->intervals);
        $this->assertEquals(ReportPeriod::INTERVAL_MONTH, $period->intervalType);
        $this->assertTrue($period->intervals[0]->start->equalTo(Carbon::parse('20200201T000000')));
        $this->assertTrue($period->intervals[0]->end->equalTo(Carbon::parse('20200301T000000')));
        $this->assertTrue($period->intervals[12]->start->equalTo(Carbon::parse('20210201T000000')));
        $this->assertTrue($period->intervals[12]->end->equalTo(Carbon::parse('20210301T000000')));
    }

    public function testSplitByMonthBoundsNotMatch()
    {
        $period = new ReportPeriod(
            Carbon::parse('20200205T100000'),
            Carbon::parse('20210305T100000'),
            0
        );

        $this->assertCount(14, $period->intervals);
        $this->assertEquals(ReportPeriod::INTERVAL_MONTH, $period->intervalType);
        $this->assertTrue($period->intervals[0]->start->equalTo(Carbon::parse('20200205T100000')));
        $this->assertTrue($period->intervals[0]->end->equalTo(Carbon::parse('20200301T000000')));
        $this->assertTrue($period->intervals[13]->start->equalTo(Carbon::parse('20210301T000000')));
        $this->assertTrue($period->intervals[13]->end->equalTo(Carbon::parse('20210305T100000')));
    }

    public function testSplitByQuarterMinPeriod()
    {
        $period = new ReportPeriod(
            Carbon::parse('20180201T000000'),
            Carbon::parse('20200201T000000'),
            0
        );

        $this->assertCount(9, $period->intervals);
        $this->assertEquals(ReportPeriod::INTERVAL_QUARTER, $period->intervalType);
        $this->assertTrue($period->intervals[0]->start->equalTo(Carbon::parse('20180201T000000')));
        $this->assertTrue($period->intervals[0]->end->equalTo(Carbon::parse('20180401T000000')));
        $this->assertTrue($period->intervals[8]->start->equalTo(Carbon::parse('20200101T000000')));
        $this->assertTrue($period->intervals[8]->end->equalTo(Carbon::parse('20200201T000000')));
    }

    public function testSplitByQuarterBoundsMatch()
    {
        $period = new ReportPeriod(
            Carbon::parse('20180401T000000'),
            Carbon::parse('20200701T000000'),
            0
        );

        $this->assertCount(9, $period->intervals);
        $this->assertEquals(ReportPeriod::INTERVAL_QUARTER, $period->intervalType);
        $this->assertTrue($period->intervals[0]->start->equalTo(Carbon::parse('20180401T000000')));
        $this->assertTrue($period->intervals[0]->end->equalTo(Carbon::parse('20180701T000000')));
        $this->assertTrue($period->intervals[8]->start->equalTo(Carbon::parse('20200401T000000')));
        $this->assertTrue($period->intervals[8]->end->equalTo(Carbon::parse('20200701T000000')));
    }

    public function testSplitByQuarterBoundsNotMatch()
    {
        $period = new ReportPeriod(
            Carbon::parse('20180303T100000'),
            Carbon::parse('20200606T100000'),
            0
        );

        $this->assertCount(10, $period->intervals);
        $this->assertEquals(ReportPeriod::INTERVAL_QUARTER, $period->intervalType);
        $this->assertTrue($period->intervals[0]->start->equalTo(Carbon::parse('20180303T100000')));
        $this->assertTrue($period->intervals[0]->end->equalTo(Carbon::parse('20180401T000000')));
        $this->assertTrue($period->intervals[9]->start->equalTo(Carbon::parse('20200401T000000')));
        $this->assertTrue($period->intervals[9]->end->equalTo(Carbon::parse('20200606T100000')));
    }

    public function testSplitByYearMinPeriod()
    {
        $period = new ReportPeriod(
            Carbon::parse('20150101T000000'),
            Carbon::parse('20210101T000000'),
            0
        );

        $this->assertCount(6, $period->intervals);
        $this->assertEquals(ReportPeriod::INTERVAL_YEAR, $period->intervalType);
        $this->assertTrue($period->intervals[0]->start->equalTo(Carbon::parse('20150101T000000')));
        $this->assertTrue($period->intervals[0]->end->equalTo(Carbon::parse('20160101T000000')));
        $this->assertTrue($period->intervals[5]->start->equalTo(Carbon::parse('20200101T000000')));
        $this->assertTrue($period->intervals[5]->end->equalTo(Carbon::parse('20210101T000000')));
    }

    public function testSplitByYearBoundsMatch()
    {
        $period = new ReportPeriod(
            Carbon::parse('20130101T000000'),
            Carbon::parse('20210101T000000'),
            0
        );

        $this->assertCount(8, $period->intervals);
        $this->assertEquals(ReportPeriod::INTERVAL_YEAR, $period->intervalType);
        $this->assertTrue($period->intervals[0]->start->equalTo(Carbon::parse('20130101T000000')));
        $this->assertTrue($period->intervals[0]->end->equalTo(Carbon::parse('20140101T000000')));
        $this->assertTrue($period->intervals[7]->start->equalTo(Carbon::parse('20200101T000000')));
        $this->assertTrue($period->intervals[7]->end->equalTo(Carbon::parse('20210101T000000')));
    }

    public function testSplitByYearBoundsNotMatch()
    {
        $period = new ReportPeriod(
            Carbon::parse('20130201T000000'),
            Carbon::parse('20210501T000000'),
            0
        );

        $this->assertCount(9, $period->intervals);
        $this->assertEquals(ReportPeriod::INTERVAL_YEAR, $period->intervalType);
        $this->assertTrue($period->intervals[0]->start->equalTo(Carbon::parse('20130201T000000')));
        $this->assertTrue($period->intervals[0]->end->equalTo(Carbon::parse('20140101T000000')));
        $this->assertTrue($period->intervals[8]->start->equalTo(Carbon::parse('20210101T000000')));
        $this->assertTrue($period->intervals[8]->end->equalTo(Carbon::parse('20210501T000000')));
    }

    public function testTimezoneOffsetPositive()
    {
        $period = new ReportPeriod(
            Carbon::parse('20210420T230000'),
            Carbon::parse('20210424T230000'),
            60
        );

        $this->assertCount(4, $period->intervals);
        $this->assertTrue($period->intervals[0]->start->equalTo(Carbon::parse('20210420T230000')));
        $this->assertTrue($period->intervals[0]->end->equalTo(Carbon::parse('20210421T230000')));
        $this->assertTrue($period->intervals[3]->start->equalTo(Carbon::parse('20210423T230000')));
        $this->assertTrue($period->intervals[3]->end->equalTo(Carbon::parse('20210424T230000')));
    }

    public function testTimezoneOffsetNegative()
    {
        $period = new ReportPeriod(
            Carbon::parse('20210420T230000'),
            Carbon::parse('20210424T230000'),
            -60
        );

        $this->assertCount(5, $period->intervals);
        $this->assertTrue($period->intervals[0]->start->equalTo(Carbon::parse('20210420T230000')));
        $this->assertTrue($period->intervals[0]->end->equalTo(Carbon::parse('20210421T010000')));
        $this->assertTrue($period->intervals[4]->start->equalTo(Carbon::parse('20210424T010000')));
        $this->assertTrue($period->intervals[4]->end->equalTo(Carbon::parse('20210424T230000')));
    }


}

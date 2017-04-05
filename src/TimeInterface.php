<?php
/**
 * Vainyl
 *
 * PHP Version 7
 *
 * @package   vain-core
 * @license   https://opensource.org/licenses/MIT MIT License
 * @link      https://github.com/allflame/vain-core
 */
declare(strict_types = 1);

namespace Vainyl\Time;

use Vainyl\Core\ArrayX\ArrayInterface;
use Vainyl\Locale\LocaleInterface;

/**
 * Class TimeInterface
 *
 * @author Taras P. Girnyk <taras.p.gyrnik@gmail.com>
 */
interface TimeInterface extends ArrayInterface, \DateTimeInterface
{
    const SUNDAY = 0;
    const MONDAY = 1;
    const TUESDAY = 2;
    const WEDNESDAY = 3;
    const THURSDAY = 4;
    const FRIDAY = 5;
    const SATURDAY = 6;
    const WEEKDAYS = [
        self::SUNDAY    => 'Sunday',
        self::MONDAY    => 'Monday',
        self::TUESDAY   => 'Tuesday',
        self::WEDNESDAY => 'Wednesday',
        self::THURSDAY  => 'Thursday',
        self::FRIDAY    => 'Friday',
        self::SATURDAY  => 'Saturday',
    ];
    const MONTHS_PER_YEAR = 12;
    const WEEKS_PER_YEAR = 52;
    const DAYS_PER_WEEK = 7;
    const HOURS_PER_DAY = 24;
    const MINUTES_PER_HOUR = 60;
    const SECONDS_PER_MINUTE = 60;

    /**
     * @param int $value
     *
     * @return TimeInterface
     */
    public function setYear(int $value) : TimeInterface;

    /**
     * @param int $value
     *
     * @return TimeInterface
     */
    public function setMonth(int $value) : TimeInterface;

    /**
     * @param int $value
     *
     * @return TimeInterface
     */
    public function setDay(int $value) : TimeInterface;

    /**
     * @param int $value
     *
     * @return TimeInterface
     */
    public function setHours(int $value) : TimeInterface;

    /**
     * @param int $value
     *
     * @return TimeInterface
     */
    public function setMinutes(int $value) : TimeInterface;

    /**
     * @param int $value
     *
     * @return TimeInterface
     */
    public function setSeconds(int $value) : TimeInterface;

    /**
     * @param int $year
     * @param int $month
     * @param int $day
     * @param int $hour
     * @param int $minute
     * @param int $second
     *
     * @return TimeInterface
     */
    public function setDateTime(
        int $year,
        int $month,
        int $day,
        int $hour,
        int $minute,
        int $second = 0
    ) : TimeInterface;

    /**
     * @param int $hour
     * @param int $minute
     * @param int $second
     *
     * @return TimeInterface
     */
    public function setTime($hour, $minute, $second = 0);

    /**
     * @param int $year
     * @param int $month
     * @param int $day
     *
     * @return TimeInterface
     */
    public function setDate($year, $month, $day);

    /**
     * @param string $time
     *
     * @return TimeInterface
     */
    public function setTimeFromTimeString(string $time) : TimeInterface;

    /**
     * @param TimeZoneInterface $value
     *
     * @return TimeInterface
     */
    public function setTimezone($value);

    /**
     * @return int
     */
    public function getWeekOfMonth() : int;

    /**
     * @return int
     */
    public function getYear() : int;

    /**
     * @return int
     */
    public function getYearIso() : int;

    /**
     * @return int
     */
    public function getMonth() : int;

    /**
     * @return int
     */
    public function getDay() : int;

    /**
     * @return int
     */
    public function getHour() : int;

    /**
     * @return int
     */
    public function getMinutes() : int;

    /**
     * @return int
     */
    public function getSeconds() : int;

    /**
     * @return int
     */
    public function getMicroseconds() : int;

    /**
     * @return int
     */
    public function getDayOfWeek() : int;

    /**
     * @return int
     */
    public function getIsoDayOfWeek() : int;

    /**
     * @return int
     */
    public function getDayOfYear() : int;

    /**
     * @return int
     */
    public function getWeekOfYear() : int;

    /**
     * @return int
     */
    public function getDaysInMonth() : int;

    /**
     * @return int
     */
    public function getAge() : int;

    /**
     * @return int
     */
    public function getQuarter() : int;

    /**
     * @return float
     */
    public function getOffsetHours() : float;

    /**
     * @return bool
     */
    public function getDst() : bool;

    /**
     * @return string
     */
    public function getTimezoneName() : string;

    /**
     * @param LocaleInterface $locale
     *
     * @return TimeInterface
     */
    public function setLocale(LocaleInterface $locale) : TimeInterface;

    /**
     * @return LocaleInterface
     */
    public function getLocale() : LocaleInterface;

    /**
     * Format the instance as date
     *
     * @return string
     */
    public function toDate() : string;

    /**
     * @return string
     */
    public function toTime() : string;

    /**
     * @return string
     */
    public function toDateTime() : string;

    /**
     * @return string
     */
    public function toDayDateTime() : string;

    /**
     * @return string
     */
    public function toAtom() : string;

    /**
     * @return string
     */
    public function toCookie() : string;

    /**
     * @return string
     */
    public function toIso8601() : string;

    /**
     * @return string
     */
    public function toRfc822() : string;

    /**
     * @return string
     */
    public function toRfc850() : string;

    /**
     * @return string
     */
    public function toRfc1036() : string;

    /**
     * @return string
     */
    public function toRfc1123() : string;

    /**
     * @return string
     */
    public function toRfc2822() : string;

    /**
     * @return string
     */
    public function toRfc3339() : string;

    /**
     * @return string
     */
    public function toRss() : string;

    /**
     * @return string
     */
    public function toW3c() : string;

    /**
     * @return string
     */
    public function toSystem() : string;

    /**
     * @param TimeInterface $dt1
     * @param TimeInterface $dt2
     * @param bool          $equal
     *
     * @return bool
     */
    public function between(TimeInterface $dt1, TimeInterface $dt2, bool $equal = true) : bool;

    /**
     * @param TimeInterface $dt1
     * @param TimeInterface $dt2
     *
     * @return TimeInterface
     */
    public function closest(TimeInterface $dt1, TimeInterface $dt2) : TimeInterface;

    /**
     * @param TimeInterface $dt1
     * @param TimeInterface $dt2
     *
     * @return TimeInterface
     */
    public function farthest(TimeInterface $dt1, TimeInterface $dt2) : TimeInterface;

    /**
     * @return bool
     */
    public function isWeekday() : bool;

    /**
     * @return bool
     */
    public function isWeekend() : bool;

    /**
     * @return bool
     */
    public function isYesterday() : bool;

    /**
     * @return bool
     */
    public function isToday() : bool;

    /**
     * @return bool
     */
    public function isTomorrow() : bool;

    /**
     * @return bool
     */
    public function isFuture() : bool;

    /**
     * @return bool
     */
    public function isPast() : bool;

    /**
     * @return bool
     */
    public function isLeapYear() : bool;

    /**
     * @param TimeInterface $dt
     *
     * @return bool
     */
    public function isSameDay(TimeInterface $dt) : bool;

    /**
     * Checks if this day is a Sunday.
     *
     * @return bool
     */
    public function isSunday() : bool;

    /**
     * Checks if this day is a Monday.
     *
     * @return bool
     */
    public function isMonday() : bool;

    /**
     * Checks if this day is a Tuesday.
     *
     * @return bool
     */
    public function isTuesday() : bool;

    /**
     * Checks if this day is a Wednesday.
     *
     * @return bool
     */
    public function isWednesday() : bool;

    /**
     * Checks if this day is a Thursday.
     *
     * @return bool
     */
    public function isThursday() : bool;

    /**
     * Checks if this day is a Friday.
     *
     * @return bool
     */
    public function isFriday() : bool;

    /**
     * Checks if this day is a Saturday.
     *
     * @return bool
     */
    public function isSaturday() : bool;

    /**
     * @param int $value
     *
     * @return TimeInterface
     */
    public function modifyYears(int $value) : TimeInterface;

    /**
     * @param int $value
     *
     * @return TimeInterface
     */
    public function addYears(int $value = 1) : TimeInterface;

    /**
     * Remove a year from the instance
     *
     * @param int $value
     *
     * @return TimeInterface
     */
    public function subYears(int $value = 1) : TimeInterface;

    /**
     * @param int $value
     *
     * @return TimeInterface
     */
    public function modifyMonths(int $value = 1) : TimeInterface;

    /**
     * @param int $value
     *
     * @return TimeInterface
     */
    public function addMonths(int $value = 1) : TimeInterface;

    /**
     * @param int $value
     *
     * @return TimeInterface
     */
    public function subMonths(int $value = 1) : TimeInterface;

    /**
     * @param int $value
     *
     * @return TimeInterface
     */
    public function modifyDays(int $value) : TimeInterface;

    /**
     * @param int $value
     *
     * @return TimeInterface
     */
    public function addDays(int $value = 1) : TimeInterface;

    /**
     * @param int $value
     *
     * @return TimeInterface
     */
    public function subDays(int $value = 1) : TimeInterface;

    /**
     * @param int $value
     *
     * @return TimeInterface
     */
    public function modifyWeekdays(int $value = 1) : TimeInterface;

    /**
     * @param int $value
     *
     * @return TimeInterface
     */
    public function addWeekdays(int $value = 1) : TimeInterface;

    /**
     * @param int $value
     *
     * @return TimeInterface
     */
    public function subWeekdays(int $value = 1) : TimeInterface;

    /**
     * @param int $value
     *
     * @return TimeInterface
     */
    public function modifyWeeks(int $value = 1) : TimeInterface;

    /**
     * @param int $value
     *
     * @return TimeInterface
     */
    public function addWeeks(int $value = 1) : TimeInterface;

    /**
     * @param int $value
     *
     * @return TimeInterface
     */
    public function subWeeks(int $value = 1) : TimeInterface;

    /**
     * @param int $value
     *
     * @return TimeInterface
     */
    public function modifyHours(int $value = 1) : TimeInterface;

    /**
     * @param int $value
     *
     * @return TimeInterface
     */
    public function addHours(int $value = 1) : TimeInterface;

    /**
     * @param int $value
     *
     * @return TimeInterface
     */
    public function subHours(int $value = 1)  : TimeInterface;

    /**
     * @param int $value
     *
     * @return TimeInterface
     */
    public function modifyMinutes(int $value = 1) : TimeInterface;

    /**
     * @param int $value
     *
     * @return TimeInterface
     */
    public function addMinutes(int $value = 1) : TimeInterface;

    /**
     * @param int $value
     *
     * @return TimeInterface
     */
    public function subMinutes(int $value = 1) : TimeInterface;

    /**
     * @param int $value
     *
     * @return TimeInterface
     */
    public function modifySeconds(int $value = 1) : TimeInterface;

    /**
     * @param int $value
     *
     * @return TimeInterface
     */
    public function addSeconds(int $value = 1) : TimeInterface;

    /**
     * @param int $value
     *
     * @return TimeInterface
     */
    public function subSeconds(int $value = 1) : TimeInterface;

    /**
     * @param TimeInterface|null $dt
     * @param bool               $abs
     *
     * @return int
     */
    public function diffInYears(TimeInterface $dt = null, bool $abs = true) : int;

    /**
     * @param TimeInterface|null $dt
     * @param bool               $abs
     *
     * @return int
     */
    public function diffInMonths(TimeInterface $dt = null, bool $abs = true) : int;

    /**
     * @param TimeInterface|null $dt
     * @param bool               $abs
     *
     * @return int
     */
    public function diffInWeeks(TimeInterface $dt = null, bool $abs = true) : int;

    /**
     * @param TimeInterface|null $dt
     * @param bool               $abs
     *
     * @return int
     */
    public function diffInDays(TimeInterface $dt = null, bool $abs = true) : int;

    /**
     * @param TimeInterface|null $dt
     * @param bool               $abs
     *
     * @return int
     */
    public function diffInWeekdays(TimeInterface $dt = null, bool $abs = true) : int;

    /**
     * @param TimeInterface|null $dt
     * @param bool               $abs
     *
     * @return int
     */
    public function diffInWeekendDays(TimeInterface $dt = null, bool $abs = true) : int;

    /**
     * @param TimeInterface|null $dt
     * @param bool               $abs
     *
     * @return int
     */
    public function diffInHours(TimeInterface $dt = null, bool $abs = true) : int;

    /**
     * @param TimeInterface|null $dt
     * @param bool               $abs
     *
     * @return int
     */
    public function diffInMinutes(TimeInterface $dt = null, bool $abs = true) : int;

    /**
     * @param TimeInterface|null $dt
     * @param bool               $abs
     *
     * @return int
     */
    public function diffInSeconds(TimeInterface $dt = null, bool $abs = true) : int;

    /**
     * @return int
     */
    public function secondsSinceMidnight() : int;

    /**
     * @return int
     */
    public function secondsUntilEndOfDay() : int;

    /**
     * @return TimeInterface
     */
    public function startOfDay() : TimeInterface;

    /**
     * @return TimeInterface
     */
    public function endOfDay() : TimeInterface;

    /**
     * @return TimeInterface
     */
    public function startOfMonth() : TimeInterface;

    /**
     * @return TimeInterface
     */
    public function endOfMonth() : TimeInterface;

    /**
     * @return TimeInterface
     */
    public function startOfYear() : TimeInterface;

    /**
     * @return TimeInterface
     */
    public function endOfYear() : TimeInterface;

    /**
     * @return TimeInterface
     */
    public function startOfWeek() : TimeInterface;

    /**
     * @return TimeInterface
     */
    public function endOfWeek() : TimeInterface;

    /**
     * @param int|null $dayOfWeek
     *
     * @return TimeInterface
     */
    public function next(int $dayOfWeek = null) : TimeInterface;

    /**
     * @param int|null $dayOfWeek
     *
     * @return TimeInterface
     */
    public function previous(int $dayOfWeek = null) : TimeInterface;

    /**
     * @param int|null $dayOfWeek
     *
     * @return TimeInterface
     */
    public function firstOfMonth(int $dayOfWeek = null) : TimeInterface;

    /**
     * @param int|null $dayOfWeek
     *
     * @return TimeInterface
     */
    public function lastOfMonth(int $dayOfWeek = null) : TimeInterface;

    /**
     * @param int $nth
     * @param int $dayOfWeek
     *
     * @return TimeInterface
     */
    public function nthOfMonth(int $nth, int $dayOfWeek) : TimeInterface;

    /**
     * @param int|null $dayOfWeek
     *
     * @return TimeInterface
     */
    public function firstOfYear(int $dayOfWeek = null) : TimeInterface;

    /**
     * @param int|null $dayOfWeek
     *
     * @return TimeInterface
     */
    public function lastOfYear(int $dayOfWeek = null) : TimeInterface;

    /**
     * @param int $nth
     * @param int $dayOfWeek
     *
     * @return TimeInterface
     */
    public function nthOfYear(int $nth, int $dayOfWeek) : TimeInterface;

    /**
     * @param TimeInterface|null $dt
     *
     * @return TimeInterface
     */
    public function average(TimeInterface $dt = null) : TimeInterface;

    /**
     * @param TimeInterface|null $dt
     *
     * @return bool
     */
    public function isBirthday(TimeInterface $dt = null) : bool;

    /**
     * @param string $string
     *
     * @return TimeInterface
     */
    public function modify($string);

    /**
     * @param string $format
     *
     * @return string
     */
    public function format($format);

    /**
     * @return int
     */
    public function getOffset();

    /**
     * @return int
     */
    public function getTimestamp();

    /**
     * @return TimeZoneInterface
     */
    public function getTimezone();

    /**
     * @return string
     */
    public function getTimeZoneSpec() : string;

    /**
     * @return void
     */
    public function __wakeup();
}

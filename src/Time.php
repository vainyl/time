<?php
/**
 * Vainyl
 *
 * PHP Version 7
 *
 * @package   Time
 * @license   https://opensource.org/licenses/MIT MIT License
 * @link      https://vainyl.com
 */
declare(strict_types=1);

namespace Vainyl\Time;

use Vainyl\Locale\LocaleInterface;
use Vainyl\Time\Exception\UnsupportedTimeZoneException;

/**
 * Class Time
 *
 * @author Taras P. Girnyk <taras.p.gyrnik@gmail.com>
 */
class Time extends \DateTimeImmutable implements TimeInterface
{
    private $now;

    private $locale;

    private $timeZone;

    /**
     * Time constructor.
     *
     * @param string            $time
     * @param LocaleInterface   $locale
     * @param TimeZoneInterface $zone
     * @param TimeInterface     $now
     */
    public function __construct(
        string $time,
        LocaleInterface $locale,
        TimeZoneInterface $zone,
        TimeInterface $now = null
    ) {
        $this->locale = $locale;
        $this->now = $now;
        $this->timeZone = $zone;
        parent::__construct($time, $zone);
    }

    /**
     * @inheritDoc
     */
    public function __clone()
    {
        $this->timeZone = clone $this->timeZone;
        $this->locale = clone $this->locale;
    }

    /**
     * @inheritDoc
     */
    public function __toString(): string
    {
        return $this->format($this->locale->getDefaultFormat());
    }

    /**
     * @inheritDoc
     */
    public function addDays(int $value = 1): TimeInterface
    {
        return $this->modifyDays($value);
    }

    /**
     * @inheritDoc
     */
    public function addHours(int $value = 1): TimeInterface
    {
        return $this->modifyHours($value);
    }

    /**
     * @inheritDoc
     */
    public function addMinutes(int $value = 1): TimeInterface
    {
        return $this->modifyMinutes($value);
    }

    /**
     * @inheritDoc
     */
    public function addMonths(int $value = 1): TimeInterface
    {
        return $this->modifyMonths($value);
    }

    /**
     * @inheritDoc
     */
    public function addSeconds(int $value = 1): TimeInterface
    {
        return $this->modifySeconds($value);
    }

    /**
     * @inheritDoc
     */
    public function addWeekdays(int $value = 1): TimeInterface
    {
        return $this->modifyWeekdays($value);
    }

    /**
     * @inheritDoc
     */
    public function addWeeks(int $value = 1): TimeInterface
    {
        return $this->modify((int)$value . ' week');
    }

    /**
     * @inheritDoc
     */
    public function addYears(int $value = 1): TimeInterface
    {
        return $this->modifyYears($value);
    }

    /**
     * @inheritDoc
     */
    public function average(TimeInterface $dateTime = null): TimeInterface
    {
        $dateTime = $dateTime ?: $this->now;

        return $this->addSeconds((int)($this->diffInSeconds($dateTime, false) / 2));
    }

    /**
     * @inheritDoc
     */
    public function between(TimeInterface $dateTime1, TimeInterface $dateTime2, bool $equal = true): bool
    {
        if ($dateTime1 > $dateTime2) {
            $temp = $dateTime1;
            $dateTime1 = $dateTime2;
            $dateTime2 = $temp;
        }
        if ($equal) {
            return $this >= $dateTime1 && $this <= $dateTime2;
        }

        return $this > $dateTime1 && $this < $dateTime2;
    }

    /**
     * @inheritDoc
     */
    public function closest(TimeInterface $dateTime1, TimeInterface $dateTime2): TimeInterface
    {
        return $this->diffInSeconds($dateTime1) < $this->diffInSeconds($dateTime2) ? $dateTime1 : $dateTime2;
    }

    /**
     * @inheritDoc
     */
    public function diffInDays(TimeInterface $dateTime = null, bool $abs = true): int
    {
        $dateTime = $dateTime ?: $this->now;

        return (int)$this->diff($dateTime, $abs)->format('%r%a');
    }

    /**
     * @inheritDoc
     */
    public function diffInHours(TimeInterface $dateTime = null, bool $abs = true): int
    {
        return (int)($this->diffInSeconds($dateTime, $abs) / static::SECONDS_PER_MINUTE / static::MINUTES_PER_HOUR);
    }

    /**
     * @inheritDoc
     */
    public function diffInMinutes(TimeInterface $dateTime = null, bool $abs = true): int
    {
        return (int)($this->diffInSeconds($dateTime, $abs) / static::SECONDS_PER_MINUTE);
    }

    /**
     * @inheritDoc
     */
    public function diffInMonths(TimeInterface $dateTime = null, bool $abs = true): int
    {
        $dateTime = $dateTime ?: $this->now;

        return $this->diffInYears($dateTime, $abs) * static::MONTHS_PER_YEAR
               + (int)$this->diff($dateTime, $abs)->format('%r%m');
    }

    /**
     * @inheritDoc
     */
    public function diffInSeconds(TimeInterface $dateTime = null, bool $abs = true): int
    {
        $dateTime = $dateTime ?: $this->now;
        $value = $dateTime->getTimestamp() - $this->getTimestamp();

        return $abs ? (int)abs($value) : $value;
    }

    /**
     * @inheritDoc
     */
    public function diffInWeekdays(TimeInterface $dateTime = null, bool $abs = true): int
    {
        if ($this > $dateTime) {
            return $dateTime->diffInDays($this);
        }
        $diff = 0;
        for ($counter = $this->getDayOfWeek(); $counter < $this->locale->getWeekEndsAt(); $counter++) {
            if (in_array($counter, $this->locale->getWeekendDays())) {
                continue;
            }
            $diff++;
        }
        for ($counter = $this->locale->getWeekStartsAt(); $counter < $dateTime->getDayOfWeek(); $counter++) {
            if (in_array($counter, $this->locale->getWeekendDays())) {
                continue;
            }
            $diff++;
        }
        $diff += $this->diffInWeeks($dateTime) * (self::DAYS_PER_WEEK - count($this->locale->getWeekendDays()));

        return ($abs) ? $diff : -1 * $diff;
    }

    /**
     * @inheritDoc
     */
    public function diffInWeekendDays(TimeInterface $dateTime = null, bool $abs = true): int
    {
        if ($this > $dateTime) {
            return $dateTime->diffInDays($this);
        }
        $diff = 0;
        for ($counter = $this->getDayOfWeek(); $counter < $this->locale->getWeekEndsAt(); $counter++) {
            if (false === in_array($counter, $this->locale->getWeekendDays())) {
                continue;
            }
            $diff++;
        }
        for ($counter = $this->locale->getWeekStartsAt(); $counter < $dateTime->getDayOfWeek(); $counter++) {
            if (false === in_array($counter, $this->locale->getWeekendDays())) {
                continue;
            }
            $diff++;
        }
        $diff += $this->diffInWeeks($dateTime) * count($this->locale->getWeekendDays());

        return ($abs) ? $diff : -1 * $diff;
    }

    /**
     * @inheritDoc
     */
    public function diffInWeeks(TimeInterface $dateTime = null, bool $abs = true): int
    {
        return (int)($this->diffInDays($dateTime, $abs) / static::DAYS_PER_WEEK);
    }

    /**
     * @inheritDoc
     */
    public function diffInYears(TimeInterface $dateTime = null, bool $abs = true): int
    {
        $dateTime = $dateTime ?: $this->now;

        return (int)$this->diff($dateTime, $abs)->format('%r%y');
    }

    /**
     * @inheritDoc
     */
    public function endOfDay(): TimeInterface
    {
        return $this->setHours(23)->setMinutes(59)->setSeconds(59);
    }

    /**
     * @inheritDoc
     */
    public function endOfMonth(): TimeInterface
    {
        return $this->setDay($this->getDaysInMonth())->endOfDay();
    }

    /**
     * @inheritDoc
     */
    public function endOfWeek(): TimeInterface
    {
        if ($this->getDayOfWeek() !== $this->locale->getWeekEndsAt()) {
            $this->next($this->locale->getWeekEndsAt());
        }

        return $this->endOfDay();
    }

    /**
     * @inheritDoc
     */
    public function endOfYear(): TimeInterface
    {
        return $this->setMonth(self::MONTHS_PER_YEAR)->endOfMonth();
    }

    /**
     * @param Time $obj
     *
     * @return bool
     */
    public function equals($obj): bool
    {
        return $this->getId() === $obj->getId();
    }

    /**
     * @inheritDoc
     */
    public function farthest(TimeInterface $dateTime1, TimeInterface $dateTime2): TimeInterface
    {
        return $this->diffInSeconds($dateTime1) > $this->diffInSeconds($dateTime2) ? $dateTime1 : $dateTime2;
    }

    /**
     * @inheritDoc
     */
    public function firstOfMonth(int $dayOfWeek = null): TimeInterface
    {
        if ($dayOfWeek === null) {
            return $this->setDay(1)->startOfDay();
        }

        return $this->modify(
            'first ' . self::WEEKDAYS[$dayOfWeek] . ' of ' . $this->format('F') . ' ' . $this->getYear()
        );
    }

    /**
     * @inheritDoc
     */
    public function firstOfYear(int $dayOfWeek = null): TimeInterface
    {
        return $this->setMonth(1)->firstOfMonth($dayOfWeek);
    }

    /**
     * @inheritDoc
     */
    public function getAge(): int
    {
        return (int)$this->diffInYears();
    }

    /**
     * @inheritDoc
     */
    public function getDay(): int
    {
        return (int)$this->format('j');
    }

    /**
     * @inheritDoc
     */
    public function getDayOfWeek(): int
    {
        return (int)$this->format('w');
    }

    /**
     * @inheritDoc
     */
    public function getDayOfYear(): int
    {
        return (int)$this->format('z');
    }

    /**
     * @inheritDoc
     */
    public function getDaysInMonth(): int
    {
        return (int)$this->format('t');
    }

    /**
     * @inheritDoc
     */
    public function getDst(): bool
    {
        return $this->format('I') === '1';
    }

    /**
     * @inheritDoc
     */
    public function getHour(): int
    {
        return (int)$this->format('G');
    }

    /**
     * @inheritDoc
     */
    public function getId(): string
    {
        return spl_object_hash($this);
    }

    /**
     * @inheritDoc
     */
    public function getIsoDayOfWeek(): int
    {
        return (int)$this->format('N');
    }

    /**
     * @inheritDoc
     */
    public function getLocale(): LocaleInterface
    {
        return $this->locale;
    }

    /**
     * @inheritDoc
     */
    public function setLocale(LocaleInterface $locale): TimeInterface
    {
        $copy = clone $this;
        $copy->locale = $locale;

        return $copy;
    }

    /**
     * @inheritDoc
     */
    public function getMicroseconds(): int
    {
        return (int)$this->format('u');
    }

    /**
     * @inheritDoc
     */
    public function getMinutes(): int
    {
        return (int)$this->format('i');
    }

    /**
     * @inheritDoc
     */
    public function getMonth(): int
    {
        return (int)$this->format('n');
    }

    /**
     * @inheritDoc
     */
    public function getOffsetHours(): float
    {
        return $this->getOffset() / self::SECONDS_PER_MINUTE / self::MINUTES_PER_HOUR;
    }

    /**
     * @inheritDoc
     */
    public function getQuarter(): int
    {
        return (int)ceil($this->getMonth() / 3);
    }

    /**
     * @inheritDoc
     */
    public function getSeconds(): int
    {
        return (int)$this->format('s');
    }

    /**
     * @inheritDoc
     */
    public function getTimeZoneSpec(): string
    {
        $timeZone = $this->getTimezone();

        return sprintf(
            '%s (%s GMT%s)',
            $timeZone->getSynonym(),
            $timeZone->getAbbreviation(),
            $this->format('O')
        );
    }

    /**
     * @return TimeZoneInterface
     */
    public function getTimezone(): TimeZoneInterface
    {
        return $this->timeZone;
    }

    /**
     * @inheritDoc
     */
    public function setTimezone($timezone)
    {
        if (false === ($timezone instanceof TimeZone)) {
            throw new UnsupportedTimeZoneException($this, $timezone);
        }

        $copy = parent::setTimezone($timezone);
        $copy->timeZone = $timezone;

        return $copy;
    }

    /**
     * @inheritDoc
     */
    public function getTimezoneName(): string
    {
        return $this->getTimezone()->getName();
    }

    /**
     * @inheritDoc
     */
    public function getWeekOfMonth(): int
    {
        return (int)ceil($this->getDay() / self::DAYS_PER_WEEK);
    }

    /**
     * @inheritDoc
     */
    public function getWeekOfYear(): int
    {
        return (int)$this->format('W');
    }

    /**
     * @inheritDoc
     */
    public function getYear(): int
    {
        return (int)$this->format('Y');
    }

    /**
     * @inheritDoc
     */
    public function getYearIso(): int
    {
        return (int)$this->format('o');
    }

    /**
     * @inheritDoc
     */
    public function hash()
    {
        return $this->getId();
    }

    /**
     * @inheritDoc
     */
    public function isBirthday(TimeInterface $dateTime = null): bool
    {
        $dateTime = $dateTime ?: $this->now;

        return $this->format('md') === $dateTime->format('md');
    }

    /**
     * @inheritDoc
     */
    public function isFriday(): bool
    {
        return $this->getDayOfWeek() === static::FRIDAY;
    }

    /**
     * @inheritDoc
     */
    public function isFuture(): bool
    {
        return $this > $this->now;
    }

    /**
     * @inheritDoc
     */
    public function isLeapYear(): bool
    {
        return $this->format('L') === '1';
    }

    /**
     * @inheritDoc
     */
    public function isMonday(): bool
    {
        return $this->getDayOfWeek() === static::MONDAY;
    }

    /**
     * @inheritDoc
     */
    public function isPast(): bool
    {
        return $this < $this->now;
    }

    /**
     * @inheritDoc
     */
    public function isSameDay(TimeInterface $dateTime): bool
    {
        return $this->toDate() === $dateTime->toDate();
    }

    /**
     * @inheritDoc
     */
    public function isSaturday(): bool
    {
        return $this->getDayOfWeek() === static::SATURDAY;
    }

    /**
     * @inheritDoc
     */
    public function isSunday(): bool
    {
        return $this->getDayOfWeek() === static::SUNDAY;
    }

    /**
     * @inheritDoc
     */
    public function isThursday(): bool
    {
        return $this->getDayOfWeek() === static::THURSDAY;
    }

    /**
     * @inheritDoc
     */
    public function isToday(): bool
    {
        return $this->now->toDate() === $this->toDate();
    }

    /**
     * @inheritDoc
     */
    public function isTomorrow(): bool
    {
        return $this->now->addDays()->toDate() === $this->toDate();
    }

    /**
     * @inheritDoc
     */
    public function isTuesday(): bool
    {
        return $this->getDayOfWeek() === static::TUESDAY;
    }

    /**
     * @inheritDoc
     */
    public function isWednesday(): bool
    {
        return $this->getDayOfWeek() === static::WEDNESDAY;
    }

    /**
     * @inheritDoc
     */
    public function isWeekday(): bool
    {
        return !$this->isWeekend();
    }

    /**
     * @inheritDoc
     */
    public function isWeekend(): bool
    {
        return in_array($this->getDayOfWeek(), $this->locale->getWeekendDays());
    }

    /**
     * @inheritDoc
     */
    public function isYesterday(): bool
    {
        return $this->now->subDays()->toDate() === $this->toDate();
    }

    /**
     * @inheritDoc
     */
    public function jsonSerialize()
    {
        return $this->toArray();
    }

    /**
     * @inheritDoc
     */
    public function lastOfMonth(int $dayOfWeek = null): TimeInterface
    {
        if ($dayOfWeek === null) {
            return $this->setDay($this->getDaysInMonth())->startOfDay();
        }

        return $this->modify(
            'last ' . self::WEEKDAYS[$dayOfWeek] . ' of ' . $this->format('F') . ' ' . $this->getYear()
        );
    }

    /**
     * @inheritDoc
     */
    public function lastOfYear(int $dayOfWeek = null): TimeInterface
    {
        return $this->setMonth(static::MONTHS_PER_YEAR)->lastOfMonth($dayOfWeek);
    }

    /**
     * @inheritDoc
     */
    public function modifyDays(int $value): TimeInterface
    {
        return $this->modify((string)$value . ' days');
    }

    /**
     * @inheritDoc
     */
    public function modifyHours(int $value = 1): TimeInterface
    {
        return $this->modify((string)$value . ' hour');
    }

    /**
     * @inheritDoc
     */
    public function modifyMinutes(int $value = 1): TimeInterface
    {
        return $this->modify((string)$value . ' minute');
    }

    /**
     * @inheritDoc
     */
    public function modifyMonths(int $value = 1): TimeInterface
    {
        return $this->modify((string)$value . ' months');
    }

    /**
     * @inheritDoc
     */
    public function modifySeconds(int $value = 1): TimeInterface
    {
        return $this->modify((string)$value . ' second');
    }

    /**
     * @inheritDoc
     */
    public function modifyWeekdays(int $value = 1): TimeInterface
    {
        return $this->modify((int)$value . ' weekday');
    }

    /**
     * @inheritDoc
     */
    public function modifyWeeks(int $value = 1): TimeInterface
    {
        return $this->modify((string)$value . ' week');
    }

    /**
     * @inheritDoc
     */
    public function modifyYears(int $value = 1): TimeInterface
    {
        return $this->modify((string)$value . ' year');
    }

    /**
     * @inheritDoc
     */
    public function next(int $dayOfWeek = null): TimeInterface
    {
        if ($dayOfWeek === null || $dayOfWeek === $this->getDayOfWeek()) {
            return $this->addWeeks()->startOfDay();
        }

        return $this
            ->addWeekdays($dayOfWeek - $this->getDayOfWeek() + self::DAYS_PER_WEEK % self::DAYS_PER_WEEK)
            ->startOfDay();
    }

    /**
     * @inheritDoc
     */
    public function nthOfMonth(int $nth, int $dayOfWeek): TimeInterface
    {
        $dateTime = $this->firstOfMonth();
        $check = $dateTime->format('Y-m');
        $dateTime = $dateTime->modify('+' . $nth . ' ' . self::WEEKDAYS[$dayOfWeek]);

        return $dateTime->format('Y-m') === $check ? $dateTime : null;
    }

    /**
     * @inheritDoc
     */
    public function nthOfYear(int $nth, int $dayOfWeek): TimeInterface
    {
        $dateTime = $this->firstOfYear()->modify('+' . $nth . ' ' . self::WEEKDAYS[$dayOfWeek]);

        return $this->getYear() === $dateTime->getYear() ? $dateTime : null;
    }

    /**
     * @inheritDoc
     */
    public function previous(int $dayOfWeek = null): TimeInterface
    {
        if ($dayOfWeek === null || $dayOfWeek === $this->getDayOfWeek()) {
            return $this->subWeeks()->startOfDay();
        }

        return $this
            ->subWeekdays($dayOfWeek - $this->getDayOfWeek() + self::DAYS_PER_WEEK % self::DAYS_PER_WEEK)
            ->startOfDay();
    }

    /**
     * @inheritDoc
     */
    public function secondsSinceMidnight(): int
    {
        return $this->diffInSeconds($this->startOfDay());
    }

    /**
     * @inheritDoc
     */
    public function secondsUntilEndOfDay(): int
    {
        return $this->diffInSeconds($this->endOfDay());
    }

    /**
     * @inheritDoc
     */
    public function setDateTime(
        int $year,
        int $month,
        int $day,
        int $hour,
        int $minute,
        int $second = 0
    ): TimeInterface {
        return $this->setDate($year, $month, $day)->setTime($hour, $minute, $second);
    }

    /**
     * @inheritDoc
     */
    public function setDay(int $value): TimeInterface
    {
        return $this->setDate($this->getYear(), $this->getMonth(), $value);
    }

    /**
     * @inheritDoc
     */
    public function setHours(int $value): TimeInterface
    {
        return $this->setTime($value, $this->getMinutes(), $this->getSeconds());
    }

    /**
     * @inheritDoc
     */
    public function setMinutes(int $value): TimeInterface
    {
        return $this->setTime($this->getHour(), $value, $this->getSeconds());
    }

    /**
     * @inheritDoc
     */
    public function setMonth(int $value): TimeInterface
    {
        return $this->setDate($this->getYear(), $value, $this->getDay());
    }

    /**
     * @inheritDoc
     */
    public function setSeconds(int $value): TimeInterface
    {
        return $this->setTime($this->getHour(), $this->getMinutes(), $value);
    }

    /**
     * Set the time by time string
     *
     * @param string $time
     *
     * @return TimeInterface
     */
    public function setTimeFromTimeString(string $time): TimeInterface
    {
        $time = explode(":", $time);
        $hour = $time[0];
        $minute = isset($time[1]) ? $time[1] : 0;
        $second = isset($time[2]) ? $time[2] : 0;

        return $this->setTime($hour, $minute, $second);
    }

    /**
     * @inheritDoc
     */
    public function setYear(int $value): TimeInterface
    {
        return $this->setDate($value, $this->getMonth(), $this->getDay());
    }

    /**
     * @inheritDoc
     */
    public function startOfDay(): TimeInterface
    {
        return $this->setHours(0)->setMinutes(0)->setSeconds(0);
    }

    /**
     * @inheritDoc
     */
    public function startOfMonth(): TimeInterface
    {
        return $this->startOfDay()->setDay(1);
    }

    /**
     * @inheritDoc
     */
    public function startOfWeek(): TimeInterface
    {
        if ($this->getDayOfWeek() !== $this->locale->getWeekStartsAt()) {
            $this->previous($this->locale->getWeekStartsAt());
        }

        return $this->startOfDay();
    }

    /**
     * @inheritDoc
     */
    public function startOfYear(): TimeInterface
    {
        return $this->setMonth(1)->startOfMonth();
    }

    /**
     * @inheritDoc
     */
    public function subDays(int $value = 1): TimeInterface
    {
        return $this->modifyDays(-1 * $value);
    }

    /**
     * @inheritDoc
     */
    public function subHours(int $value = 1): TimeInterface
    {
        return $this->modifyHours(-1 * $value);
    }

    /**
     * @inheritDoc
     */
    public function subMinutes(int $value = 1): TimeInterface
    {
        return $this->modifyMinutes(-1 * $value);
    }

    /**
     * @inheritDoc
     */
    public function subMonths(int $value = 1): TimeInterface
    {
        return $this->addMonths(-1 * $value);
    }

    /**
     * @inheritDoc
     */
    public function subSeconds(int $value = 1): TimeInterface
    {
        return $this->modifySeconds(-1 * $value);
    }

    /**
     * @inheritDoc
     */
    public function subWeekdays(int $value = 1): TimeInterface
    {
        return $this->modifyWeekdays(-1 * $value);
    }

    /**
     * @inheritDoc
     */
    public function subWeeks(int $value = 1): TimeInterface
    {
        return $this->modifyWeeks(-1 * $value);
    }

    /**
     * @inheritDoc
     */
    public function subYears(int $value = 1): TimeInterface
    {
        return $this->modifyYears(-1 * $value);
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return [
            'time'     => $this->toW3c(),
            'timeZone' => $this->timeZone->toArray(),
            'locale'   => $this->locale->toArray(),
        ];
    }

    /**
     * @inheritDoc
     */
    public function toAtom(): string
    {
        return $this->format(\DateTime::ATOM);
    }

    /**
     * @inheritDoc
     */
    public function toCookie(): string
    {
        return $this->format(\DateTime::COOKIE);
    }

    /**
     * @inheritDoc
     */
    public function toDate(): string
    {
        return $this->format('Y-m-d');
    }

    /**
     * @inheritDoc
     */
    public function toDateTime(): string
    {
        return $this->format('Y-m-d H:i:s');
    }

    /**
     * @inheritDoc
     */
    public function toDayDateTime(): string
    {
        return $this->format('D, M j, Y g:i A');
    }

    /**
     * @inheritDoc
     */
    public function toFormattedDate(): string
    {
        return $this->format('M j, Y');
    }

    /**
     * @inheritDoc
     */
    public function toIso8601(): string
    {
        return $this->format(\DateTime::ISO8601);
    }

    /**
     * @inheritDoc
     */
    public function toRfc1036(): string
    {
        return $this->format(\DateTime::RFC1036);
    }

    /**
     * @inheritDoc
     */
    public function toRfc1123(): string
    {
        return $this->format(\DateTime::RFC1123);
    }

    /**
     * @inheritDoc
     */
    public function toRfc2822(): string
    {
        return $this->format(\DateTime::RFC2822);
    }

    /**
     * @inheritDoc
     */
    public function toRfc3339(): string
    {
        return $this->format(\DateTime::RFC3339);
    }

    /**
     * @inheritDoc
     */
    public function toRfc822(): string
    {
        return $this->format(\DateTime::RFC822);
    }

    /**
     * @inheritDoc
     */
    public function toRfc850(): string
    {
        return $this->format(\DateTime::RFC850);
    }

    /**
     * @inheritDoc
     */
    public function toRss(): string
    {
        return $this->format(\DateTime::RSS);
    }

    /**
     * @inheritDoc
     */
    public function toSystem(): string
    {
        $timeZone = $this->getTimezone();

        return sprintf(
            '%s %s (%s GMT%s)',
            $this->format($this->locale->getDefaultFormat()),
            $timeZone->getSynonym(),
            $timeZone->getAbbreviation(),
            $this->format('O')
        );
    }

    /**
     * @inheritDoc
     */
    public function toTime(): string
    {
        return $this->format('H:i:s');
    }

    /**
     * @inheritDoc
     */
    public function toW3c(): string
    {
        return $this->format(\DateTime::W3C);
    }
}

<?php
/**
 * Vain Framework
 *
 * PHP Version 7
 *
 * @package   vain-time
 * @license   https://opensource.org/licenses/MIT MIT License
 * @link      https://github.com/allflame/vain-time
 */
declare(strict_types = 1);

namespace Vainyl\Time\Factory;

use Vainyl\Time\TimeZone;

/**
 * Class TimeZoneFullNameFactory
 *
 * @author Taras P. Girnyk <taras.p.gyrnik@gmail.com>
 */
class TimeZoneFullNameFactory implements TimeZoneFactoryInterface
{
    private $timeZones;

    /**
     * TimeZoneFullNameFactory constructor.
     *
     * @param array $timeZones
     */
    public function __construct(array $timeZones = [])
    {
        $this->timeZones = $timeZones;
    }

    /**
     * @inheritDoc
     */
    public function getTimeZone(string $fullName, \DateTimeInterface $dateTime) : TimeZone
    {
        if ('' === $fullName) {
            $fullName = 'UTC';
        }
        if (false === array_key_exists($fullName, $this->timeZones)) {
            $synonym = $fullName;
        } else {
            $synonym = $this->timeZones[$fullName];
        }
        $clone = clone $dateTime;

        return new TimeZone($fullName, $synonym, $clone->setTimezone(new \DateTimeZone($fullName))->format('T'));
    }
}
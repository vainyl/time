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
 * Interface TimeZoneFactoryInterface
 *
 * @author Taras P. Girnyk <taras.p.gyrnik@gmail.com>
 */
interface TimeZoneFactoryInterface
{
    /**
     * @param string             $fullName
     * @param \DateTimeInterface $dateTime
     *
     * @return TimeZone
     */
    public function getTimeZone(string $fullName, \DateTimeInterface $dateTime) : TimeZone;
}
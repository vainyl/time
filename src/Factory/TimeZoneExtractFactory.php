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
 * Class TimeZoneExtractFactory
 *
 * @author Taras P. Girnyk <taras.p.gyrnik@gmail.com>
 */
class TimeZoneExtractFactory extends AbstractTimeZoneFactory implements TimeZoneFactoryInterface
{
    /**
     * @inheritDoc
     */
    public function getTimeZone(string $fullName, \DateTimeInterface $dateTime) : TimeZone
    {
        $matches = [];
        preg_match('/([a-zA-Z\/\s]+)\s\(([A-Z]+)\s(GMT[\+\-]\d+)\)/', $fullName, $matches);
        if (4 !== count($matches)) {
            return $this->getNextFactory()->getTimeZone($fullName, $dateTime);
        }

        list ($string, $synonym, $abbreviation, $gmtOffset) = $matches;

        return new TimeZone($synonym, $synonym, $abbreviation);
    }
}
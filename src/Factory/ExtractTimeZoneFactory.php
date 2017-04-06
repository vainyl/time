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

namespace Vainyl\Time\Factory;

use Vainyl\Core\Id\AbstractIdentifiable;
use Vainyl\Time\TimeZone;
use Vainyl\Time\TimeZoneInterface;

/**
 * Class ExtractTimeZoneFactory
 *
 * @author Taras P. Girnyk <taras.p.gyrnik@gmail.com>
 */
class ExtractTimeZoneFactory extends AbstractIdentifiable implements TimeZoneFactoryInterface
{
    /**
     * @inheritDoc
     */
    public function getName(): string
    {
        return 'extract';
    }

    /**
     * @inheritDoc
     */
    public function getTimeZone(string $fullName, \DateTimeInterface $dateTime): ?TimeZoneInterface
    {
        $matches = [];
        preg_match('/([a-zA-Z\/\s]+)\s\(([A-Z]+)\s(GMT[\+\-]\d+)\)/', $fullName, $matches);
        if (4 !== count($matches)) {
            return null;
        }

        list ($string, $synonym, $abbreviation, $gmtOffset) = $matches;

        return new TimeZone($synonym, $synonym, $abbreviation);
    }
}
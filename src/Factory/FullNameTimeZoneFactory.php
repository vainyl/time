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

use Vainyl\Core\AbstractIdentifiable;
use Vainyl\Time\TimeZone;
use Vainyl\Time\TimeZoneInterface;

/**
 * Class FullNameTimeZoneFactory
 *
 * @author Taras P. Girnyk <taras.p.gyrnik@gmail.com>
 */
class FullNameTimeZoneFactory extends AbstractIdentifiable implements TimeZoneFactoryInterface
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
    public function getName(): string
    {
        return 'full';
    }

    /**
     * @inheritDoc
     */
    public function getTimeZone(string $fullName, \DateTimeInterface $dateTime): ?TimeZoneInterface
    {
        if (false === array_key_exists($fullName, $this->timeZones)) {
            $synonym = $fullName;
        } else {
            $synonym = $this->timeZones[$fullName];
        }
        $clone = clone $dateTime;

        return new TimeZone($fullName, $synonym, $clone->setTimezone(new \DateTimeZone($fullName))->format('T'));
    }
}
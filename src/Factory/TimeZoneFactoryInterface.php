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

use Vainyl\Core\Name\NameableInterface;
use Vainyl\Time\TimeZoneInterface;

/**
 * Interface TimeZoneFactoryInterface
 *
 * @author Taras P. Girnyk <taras.p.gyrnik@gmail.com>
 */
interface TimeZoneFactoryInterface extends NameableInterface
{
    /**
     * @param string             $fullName
     * @param \DateTimeInterface $dateTime
     *
     * @return TimeZoneInterface
     */
    public function getTimeZone(string $fullName, \DateTimeInterface $dateTime): ?TimeZoneInterface;
}
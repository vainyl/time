<?php
/**
 * Vainyl
 *
 * PHP Version 7
 *
 * @package   time
 * @license   https://opensource.org/licenses/MIT MIT License
 * @link      https://vainyl.com
 */
declare(strict_types=1);

namespace Vainyl\Time\Factory;

use Vainyl\Core\AbstractIdentifiable;
use Vainyl\Time\TimeZone;
use Vainyl\Time\TimeZoneInterface;

/**
 * Class DefaultTimeZoneFactory
 *
 * @author Taras P. Girnyk <taras.p.gyrnik@gmail.com>
 */
class DefaultTimeZoneFactory extends AbstractIdentifiable implements TimeZoneFactoryInterface
{
    private $default;

    /**
     * TimeZoneDefaultFactory constructor.
     *
     * @param string $default
     */
    public function __construct(string $default)
    {
        $this->default = $default;
    }

    /**
     * @inheritDoc
     */
    public function getName(): string
    {
        return 'default';
    }

    /**
     * @inheritDoc
     */
    public function getTimeZone(string $fullName, \DateTimeInterface $dateTime): ?TimeZoneInterface
    {
        return new TimeZone($this->default, $this->default, $this->default);
    }
}
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

namespace Vainyl\Time;

use Vainyl\Core\Id\AbstractIdentifiable;
use Vainyl\Data\DescriptorInterface;

/**
 * Class TimeZoneDescriptor
 *
 * @author Taras P. Girnyk <taras.p.gyrnik@gmail.com>
 */
class TimeZoneDescriptor extends AbstractIdentifiable implements DescriptorInterface
{
    private $name;

    private $dateTime;

    /**
     * TimeZoneDescriptor constructor.
     *
     * @param string             $name
     * @param \DateTimeInterface $dateTime
     */
    public function __construct(string $name, \DateTimeInterface $dateTime)
    {
        $this->name = $name;
        $this->dateTime = $dateTime;
    }

    /**
     * @inheritDoc
     */
    public function __toString(): string
    {
        return $this->name;
    }
}
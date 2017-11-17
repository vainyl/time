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

namespace Vainyl\Time\Exception;

use Vainyl\Time\Factory\TimeZoneFactoryInterface;

/**
 * Class UnknownTimeZoneException
 *
 * @author Taras P. Girnyk <taras.p.gyrnik@gmail.com>
 */
class UnknownTimeZoneException extends AbstractTimeZoneFactoryException
{
    private $timeZone;

    /**
     * UnknownTimeZoneException constructor.
     *
     * @param TimeZoneFactoryInterface $timeZoneFactory
     * @param string                   $timeZone
     */
    public function __construct(TimeZoneFactoryInterface $timeZoneFactory, string $timeZone)
    {
        parent::__construct(
            $timeZoneFactory,
            sprintf('Factory %s does not know how to construct time zone %s', $timeZoneFactory->getName(), $timeZone)
        );
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return array_merge(['time_zone' => $this->timeZone], parent::toArray());
    }
}

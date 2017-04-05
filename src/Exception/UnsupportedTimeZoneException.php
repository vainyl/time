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

namespace Vainyl\Time\Exception;

use Vainyl\Time\TimeInterface;
use Vainyl\Time\TimeZone;

/**
 * Class UnsupportedTimeZoneException
 *
 * @author Taras P. Girnyk <taras.p.gyrnik@gmail.com>
 */
class UnsupportedTimeZoneException extends AbstractTimeException
{
    private $timeZone;

    /**
     * UnsupportedTimeZoneException constructor.
     *
     * @param TimeInterface $time
     * @param string        $timeZone
     */
    public function __construct(TimeInterface $time, $timeZone)
    {
        $this->timeZone = $timeZone;
        parent::__construct(
            $time,
            sprintf('Only instances of %s are supported, %s given', TimeZone::class, gettype($timeZone))
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
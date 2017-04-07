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

use Vainyl\Time\TimeZoneInterface;

/**
 * Interface TimeZoneExceptionInterface
 *
 * @author Taras P. Girnyk <taras.p.gyrnik@gmail.com>
 */
interface TimeZoneExceptionInterface extends \Throwable
{
    /**
     * @return TimeZoneInterface
     */
    public function getTimeZone(): TimeZoneInterface;
}
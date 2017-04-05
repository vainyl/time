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
 * Interface TimeZoneFactoryExceptionInterface
 *
 * @author Taras P. Girnyk <taras.p.gyrnik@gmail.com>
 */
interface TimeZoneFactoryExceptionInterface extends \Throwable
{
    /**
     * @return TimeZoneFactoryInterface
     */
    public function getTimeZoneFactory() : TimeZoneFactoryInterface;
}
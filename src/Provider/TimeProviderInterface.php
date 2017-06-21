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

namespace Vainyl\Time\Provider;

use Vainyl\Time\TimeInterface;

/**
 * Interface TimeProviderInterface
 *
 * @author Taras P. Girnyk <taras.p.gyrnik@gmail.com>
 */
interface TimeProviderInterface
{
    /**
     * @param string $timeZone
     *
     * @return TimeInterface
     */
    public function getCurrentTime(string $timeZone = 'default'): TimeInterface;
}
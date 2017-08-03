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

use Vainyl\Time\TimeInterface;

/**
 * Interface TimeFactoryInterface
 *
 * @author Taras P. Girnyk <taras.p.gyrnik@gmail.com>
 */
interface TimeFactoryInterface
{
    /**
     * @param string $string
     * @param string $timeZoneName
     * @param string $locale
     *
     * @return \Vainyl\Time\TimeInterface
     */
    public function createFromString(
        string $string,
        string $timeZoneName = 'default',
        string $locale = 'default'
    ): TimeInterface;
}

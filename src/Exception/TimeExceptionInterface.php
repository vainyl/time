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

/**
 * Class TimeExceptionInterface
 *
 * @author Taras P. Girnyk <taras.p.gyrnik@gmail.com>
 */
interface TimeExceptionInterface extends \Throwable
{
    /**
     * @return TimeInterface
     */
    public function getTime(): TimeInterface;
}
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

namespace Vainyl\Time;

use Vainyl\Core\ArrayInterface;

/**
 * Class TimeZoneInterface
 *
 * @author Taras P. Girnyk <taras.p.gyrnik@gmail.com>
 */
interface TimeZoneInterface extends ArrayInterface
{
    /**
     * @return string
     */
    public function getSynonym(): string;

    /**
     * @return string
     */
    public function getAbbreviation(): string;
}

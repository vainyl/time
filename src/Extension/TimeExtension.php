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

namespace Vainyl\Time\Extension;

use Vainyl\Core\Extension\AbstractExtension;

/**
 * Class TimeExtension
 *
 * @author Taras P. Girnyk <taras.p.gyrnik@gmail.com>
 */
class TimeExtension extends AbstractExtension
{
    /**
     * @inheritDoc
     */
    public function getCompilerPasses(): array
    {
        return [new TimeZoneFactoryCompilerPass()];
    }
}
<?php
/**
 * Vain Framework
 *
 * PHP Version 7
 *
 * @package   vain-time
 * @license   https://opensource.org/licenses/MIT MIT License
 * @link      https://github.com/allflame/vain-time
 */
declare(strict_types = 1);

namespace Vainyl\Time\Extension;

use Symfony\Component\DependencyInjection\ContainerBuilder;
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
    public function load(array $configs, ContainerBuilder $container) : AbstractExtension
    {
        $container->addCompilerPass(new TimeZoneFactoryCompilerPass());

        return parent::load($configs, $container);
    }
}
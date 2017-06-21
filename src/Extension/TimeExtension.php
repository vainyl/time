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

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Vainyl\Core\Extension\AbstractExtension;
use Vainyl\Core\Extension\AbstractFrameworkExtension;

/**
 * Class TimeExtension
 *
 * @author Taras P. Girnyk <taras.p.gyrnik@gmail.com>
 */
class TimeExtension extends AbstractFrameworkExtension
{
    /**
     * @inheritDoc
     */
    public function getCompilerPasses(): array
    {
        return [new TimeZoneFactoryCompilerPass()];
    }

    /**
     * @inheritDoc
     */
    public function load(array $configs, ContainerBuilder $container): AbstractExtension
    {
        parent::load($configs, $container);

        $configuration = new TimeConfiguration();
        $timeConfiguration = $this->processConfiguration($configuration, $configs);

        $definition = $container->getDefinition('time.factory');
        $definition->replaceArgument(2, $timeConfiguration['timezone']);

        return $this;
    }
}
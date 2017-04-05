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
use Symfony\Component\DependencyInjection\Definition;
use Vainyl\Core\Extension\AbstractCompilerPass;
use Vainyl\Core\Extension\Exception\MissingRequiredFieldException;
use Vainyl\Core\Extension\Exception\MissingRequiredServiceException;

/**
 * Class TimeZoneFactoryCompilerPass
 *
 * @author Taras P. Girnyk <taras.p.gyrnik@gmail.com>
 */
class TimeZoneFactoryCompilerPass extends AbstractCompilerPass
{
    /**
     * @inheritDoc
     */
    public function process(ContainerBuilder $container)
    {
        if (false === $container->has('timezone.factory.chain')) {
            throw new MissingRequiredServiceException($container, 'timezone.factory.chain');
        }

        $definition = $container->getDefinition('timezone.factory.chain');
        foreach ($container->findTaggedServiceIds('timezone.factory') as $id => $tags) {
            foreach ($tags as $tag) {
                if ('timezone.factory' !== $tag['name']) {
                    continue;
                }
                if (false === array_key_exists('priority', $tag)) {
                    throw new MissingRequiredFieldException($container, $id, $tag, 'priority');
                }
                $definition->addMethodCall('addFactory', [$tag['priority'], new Definition($id)]);
            }
        }
    }
}
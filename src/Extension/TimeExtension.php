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
use Vainyl\Core\Application\EnvironmentInterface;
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
    public function load(array $configs, ContainerBuilder $container, EnvironmentInterface $environment = null): AbstractExtension
    {
        $container->addCompilerPass(new TimeZoneFactoryCompilerPass());

        return parent::load($configs, $container, $environment);
    }
}
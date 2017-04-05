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

namespace Vainyl\Time\Factory;

/**
 * Class AbstractTimeZoneFactory
 *
 * @author Taras P. Girnyk <taras.p.gyrnik@gmail.com>
 */
abstract class AbstractTimeZoneFactory implements TimeZoneFactoryInterface
{
    private $nextFactory;

    /**
     * AbstractTimeZoneFactory constructor.
     *
     * @param TimeZoneFactoryInterface $nextFactory
     */
    public function __construct(TimeZoneFactoryInterface $nextFactory)
    {
        $this->nextFactory = $nextFactory;
    }

    /**
     * @return TimeZoneFactoryInterface
     */
    public function getNextFactory() : TimeZoneFactoryInterface
    {
        return $this->nextFactory;
    }
}
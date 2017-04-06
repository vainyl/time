<?php
/**
 * Vainyl
 *
 * PHP Version 7
 *
 * @package   time
 * @license   https://opensource.org/licenses/MIT MIT License
 * @link      https://vainyl.com
 */
declare(strict_types=1);

namespace Vainyl\Time\Chain;

use Ds\PriorityQueue;
use Ds\Vector;
use Vainyl\Time\Exception\UnknownTimeZoneException;
use Vainyl\Time\Factory\TimeZoneFactoryInterface;
use Vainyl\Time\TimeZoneInterface;

/**
 * Class TimeZoneFactoryChain
 *
 * @author Taras P. Girnyk <taras.p.gyrnik@gmail.com>
 */
class TimeZoneFactoryChain implements TimeZoneFactoryInterface
{
    private $factories;

    private $queue;

    /**
     * ConfigSourceChain constructor.
     */
    public function __construct()
    {
        $this->factories = new Vector();
        $this->queue = new PriorityQueue();
    }

    /**
     * @inheritDoc
     */
    public function getName(): string
    {
        return 'config';
    }

    /**
     * @param int                      $priority
     * @param TimeZoneFactoryInterface $timeZoneFactory
     *
     * @return TimeZoneFactoryChain
     */
    public function addFactory(int $priority, TimeZoneFactoryInterface $timeZoneFactory): TimeZoneFactoryChain
    {
        $this->queue->push($timeZoneFactory, $priority);

        return $this->configure();
    }

    /**
     * @return TimeZoneFactoryChain
     */
    public function configure(): TimeZoneFactoryChain
    {
        $queue = clone $this->queue;
        $list = new Vector();

        while (false === $queue->isEmpty()) {
            $list->push($queue->pop());
        }

        $this->factories = $list;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getTimeZone(string $fullName, \DateTimeInterface $dateTime): ?TimeZoneInterface
    {
        /**
         * @var TimeZoneFactoryInterface $factory
         */
        foreach (clone $this->factories as $factory) {
            if (null === ($timeZone = $factory->getTimeZone($fullName, $dateTime))) {
                continue;
            }

            return $timeZone;
        }

        throw new UnknownTimeZoneException($this, $fullName);
    }
}
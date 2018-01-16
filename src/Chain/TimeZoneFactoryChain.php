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

use Vainyl\Core\AbstractIdentifiable;
use Vainyl\Core\Collection\VectorInterface;
use Vainyl\Core\Queue\PriorityQueueInterface;
use Vainyl\Time\Exception\UnknownTimeZoneException;
use Vainyl\Time\Factory\TimeZoneFactoryInterface;
use Vainyl\Time\TimeZoneInterface;

/**
 * Class TimeZoneFactoryChain
 *
 * @author Taras P. Girnyk <taras.p.gyrnik@gmail.com>
 */
class TimeZoneFactoryChain extends AbstractIdentifiable implements TimeZoneFactoryInterface
{
    private $queue;

    private $factories;

    /**
     * TimeZoneFactoryChain constructor.
     *
     * @param PriorityQueueInterface $queue
     * @param VectorInterface        $vector
     */
    public function __construct(PriorityQueueInterface $queue, VectorInterface $vector)
    {
        $this->queue = $queue;
        $this->factories = $vector;
    }

    /**
     * @inheritDoc
     */
    public function getName(): string
    {
        return 'chain';
    }

    /**
     * @param int                      $priority
     * @param TimeZoneFactoryInterface $timeZoneFactory
     *
     * @return TimeZoneFactoryChain
     */
    public function addFactory(int $priority, TimeZoneFactoryInterface $timeZoneFactory): TimeZoneFactoryChain
    {
        $this->queue->enqueue($timeZoneFactory, $priority);

        return $this->configure();
    }

    /**
     * @return TimeZoneFactoryChain
     */
    public function configure(): TimeZoneFactoryChain
    {
        $queue = clone $this->queue;
        $this->factories->clear();

        while ($queue->valid()) {
            $this->factories->push($queue->dequeue());
        }

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
        foreach ($this->factories as $factory) {
            if (null === ($timeZone = $factory->getTimeZone($fullName, $dateTime))) {
                continue;
            }

            return $timeZone;
        }

        throw new UnknownTimeZoneException($this, $fullName);
    }
}

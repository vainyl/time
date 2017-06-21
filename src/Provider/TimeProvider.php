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

namespace Vainyl\Time\Provider;

use Vainyl\Time\Factory\TimeFactoryInterface;
use Vainyl\Time\TimeInterface;

/**
 * Class TimeProvider
 *
 * @author Taras P. Girnyk <taras.p.gyrnik@gmail.com>
 */
class TimeProvider implements TimeProviderInterface
{
    private $timeFactory;

    /**
     * TimeProvider constructor.
     *
     * @param TimeFactoryInterface $timeFactory
     */
    public function __construct(TimeFactoryInterface $timeFactory)
    {
        $this->timeFactory = $timeFactory;
    }

    /**
     * @inheritDoc
     */
    public function getCurrentTime(string $timeZone = ''): TimeInterface
    {
        return $this->timeFactory->createFromString('now', $timeZone);
    }
}
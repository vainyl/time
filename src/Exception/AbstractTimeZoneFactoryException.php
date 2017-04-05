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

namespace Vainyl\Time\Exception;

use Vainyl\Core\Exception\AbstractCoreException;
use Vainyl\Time\Factory\TimeZoneFactoryInterface;

/**
 * Class AbstractTimeZoneFactoryException
 *
 * @author Taras P. Girnyk <taras.p.gyrnik@gmail.com>
 */
abstract class AbstractTimeZoneFactoryException extends AbstractCoreException implements
    TimeZoneFactoryExceptionInterface
{
    private $timeZoneFactory;

    /**
     * AbstractTimeZoneFactoryException constructor.
     *
     * @param TimeZoneFactoryInterface $timeZoneFactory
     * @param string                   $message
     * @param int                      $code
     * @param \Exception|null          $previous
     */
    public function __construct(
        TimeZoneFactoryInterface $timeZoneFactory,
        string $message,
        int $code = 500,
        \Exception $previous = null
    ) {
        $this->timeZoneFactory = $timeZoneFactory;
        parent::__construct($message, $code, $previous);
    }

    /**
     * @inheritDoc
     */
    public function getTimeZoneFactory(): TimeZoneFactoryInterface
    {
        return $this->timeZoneFactory;
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return array_merge(['time_zone_factory' => $this->timeZoneFactory], parent::toArray());
    }
}
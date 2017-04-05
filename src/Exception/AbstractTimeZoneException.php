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
use Vainyl\Time\TimeZoneInterface;

/**
 * Class AbstractTimeZoneException
 *
 * @author Taras P. Girnyk <taras.p.gyrnik@gmail.com>
 */
abstract class AbstractTimeZoneException extends AbstractCoreException implements TimeZoneExceptionInterface
{
    private $timeZone;

    /**
     * AbstractTimeZoneException constructor.
     *
     * @param TimeZoneInterface $timeZone
     * @param string            $message
     * @param int               $code
     * @param \Exception|null   $previous
     */
    public function __construct(
        TimeZoneInterface $timeZone,
        string $message,
        int $code = 500,
        \Exception $previous = null
    ) {
        $this->timeZone = $timeZone;
        parent::__construct($message, $code, $previous);
    }

    /**
     * @inheritDoc
     */
    public function getTimeZone(): TimeZoneInterface
    {
        return $this->timeZone;
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return array_merge(['time_zone' => $this->timeZone], parent::toArray());
    }
}
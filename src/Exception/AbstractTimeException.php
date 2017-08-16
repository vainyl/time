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

namespace Vainyl\Time\Exception;

use Vainyl\Core\Exception\AbstractCoreException;
use Vainyl\Time\TimeInterface;

/**
 * Class AbstractTimeException
 *
 * @author Taras P. Girnyk <taras.p.gyrnik@gmail.com>
 */
abstract class AbstractTimeException extends AbstractCoreException implements TimeExceptionInterface
{
    private $time;

    /**
     * AbstractTimeException constructor.
     *
     * @param TimeInterface   $time
     * @param string          $message
     * @param int             $code
     * @param \Throwable|null $previous
     */
    public function __construct(TimeInterface $time, string $message, int $code = 500, \Throwable $previous = null)
    {
        $this->time = $time;
        parent::__construct($message, $code, $previous);
    }

    /**
     * @inheritDoc
     */
    public function getTime(): TimeInterface
    {
        return $this->time;
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return array_merge(['time' => $this->time->toArray()], parent::toArray());
    }
}
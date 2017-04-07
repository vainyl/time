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

namespace Vainyl\Time;

/**
 * Class TimeZone
 *
 * @author Taras P. Girnyk <taras.p.gyrnik@gmail.com>
 */
class TimeZone extends \DateTimeZone implements TimeZoneInterface
{
    private $synonym;

    private $abbreviation;

    /**
     * TimeZone constructor.
     *
     * @param string $timezone
     * @param string $synonym
     * @param string $abbreviation
     */
    public function __construct(string $timezone, string $synonym, string $abbreviation)
    {
        $this->synonym = $synonym;
        $this->abbreviation = $abbreviation;
        parent::__construct($timezone);
    }

    /**
     * @inheritDoc
     */
    public function getId(): string
    {
        return spl_object_hash($this);
    }

    /**
     * @return string
     */
    public function getSynonym(): string
    {
        return $this->synonym;
    }

    /**
     * @return string
     */
    public function getAbbreviation(): string
    {
        return $this->abbreviation;
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return ['synonym' => $this->synonym, 'abbreviation' => $this->abbreviation];
    }
}
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

namespace Vainyl\Time\Factory;

use Vainyl\Time\Time;
use Vainyl\Time\TimeInterface;

/**
 * Class TimeFactory
 *
 * @author Taras P. Girnyk <taras.p.gyrnik@gmail.com>
 */
class TimeFactory implements TimeFactoryInterface
{
    private $localeStorage;

    private $timeZoneFactory;

    private $defaultTimeZone;

    private $defaultLocale;

    /**
     * TimeFactory constructor.
     *
     * @param \ArrayAccess             $localeStorage
     * @param TimeZoneFactoryInterface $timeZoneFactory
     * @param string                   $defaultLocale
     */
    public function __construct(
        \ArrayAccess $localeStorage,
        TimeZoneFactoryInterface $timeZoneFactory,
        string $defaultLocale
    ) {
        $this->localeStorage = $localeStorage;
        $this->timeZoneFactory = $timeZoneFactory;
        $this->defaultLocale = $defaultLocale;
    }

    /**
     * @inheritDoc
     */
    public function createFromString(
        string $string,
        string $timeZoneName = '',
        string $locale = ''
    ): TimeInterface {
        $dateTime = new \DateTime($string);
        $targetLocale = ('' !== $locale) ? $locale : $this->defaultLocale;
        $locale = $this->localeStorage[$targetLocale];
        $timeZone = $this->timeZoneFactory->getTimeZone($timeZoneName, $dateTime);
        $targetZone = $this->timeZoneFactory->getTimeZone($this->defaultTimeZone, $dateTime);

        return (new Time(
            $string, $locale, $timeZone, (new Time('now', $locale, $timeZone))->setTimezone($targetZone)
        ))->setTimezone($targetZone);
    }
}
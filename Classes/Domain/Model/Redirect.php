<?php
namespace KK\GeoIpHandler\Domain\Model;

/**
 * Redirect
 */
class Redirect extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * isocode
     * 
     * @var string
     */
    protected $isocode = '';

    /**
     * target
     * 
     * @var string
     */
    protected $target = '';

    /**
     * trigger
     * 
     * @var string
     */
    protected $trigger = 'in';

    /**
     * Returns the isocode
     * 
     * @return string $isocode
     */
    public function getIsocode()
    {
        return $this->isocode;
    }

    /**
     * Sets the isocode
     * 
     * @param string $isocode
     * @return void
     */
    public function setIsocode($isocode)
    {
        $this->isocode = $isocode;
    }

    /**
     * Returns the target
     * 
     * @return string $target
     */
    public function getTarget()
    {
        return $this->target;
    }

    /**
     * Sets the target
     * 
     * @param string $target
     * @return void
     */
    public function setTarget($target)
    {
        $this->target = $target;
    }

    /**
     * Returns the trigger
     * 
     * @return int $trigger
     */
    public function getTrigger()
    {
        return $this->trigger;
    }

    /**
     * Sets the trigger
     * 
     * @param string $trigger
     * @return void
     */
    public function setTrigger($trigger)
    {
        $this->trigger = $trigger;
    }
}

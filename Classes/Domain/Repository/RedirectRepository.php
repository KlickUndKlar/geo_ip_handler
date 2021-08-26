<?php
namespace KK\GeoIpHandler\Domain\Repository;

/**
 * The repository for Redirects
 */
class RedirectRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
{

    /**
     * @var array
     */
    protected $defaultOrderings = ['isocode' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING];
  
}

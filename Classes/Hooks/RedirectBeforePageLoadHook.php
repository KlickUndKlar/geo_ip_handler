<?php
namespace KK\GeoIpHandler\Hooks;



use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use GeoIp2\Database\Reader;

class RedirectBeforePageLoadHook{

    /**
     * @param array $params
     * @param \TYPO3\CMS\Core\Page\PageRenderer $pagerenderer
     */
    public function execute(&$params, &$pagerenderer)
    {
        if (TYPO3_MODE !== 'FE') {
             return;
        }
        $objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\Extbase\\Object\\ObjectManager');
        $configurationManager = $objectManager->get('TYPO3\\CMS\\Extbase\\Configuration\\ConfigurationManager');
        $extbaseFrameworkConfiguration = $configurationManager->getConfiguration(\TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_FULL_TYPOSCRIPT);
        $redirectRule = $extbaseFrameworkConfiguration['plugin.']['tx_geoiphandler_geoiphandler.']['settings.']['redirects.'];
        $extPath = ExtensionManagementUtility::extPath('geo_ip_handler');
        $reader = new Reader($extPath.'Resources/Public/GeoLite/GeoLite2-City.mmdb');
        $currentIp = $_SERVER['REMOTE_ADDR'];
        $record = $reader->city('128.101.101.101');
        $isoCode = $record->country->isoCode ;
        if(array_key_exists(strtolower($isoCode).'.', $redirectRule)){
            $target = $redirectRule[strtolower($isoCode).'.']['target'];
            $trigger = $redirectRule[strtolower($isoCode).'.']['trigger'];
            header("Location:".$target);
        }
        else{
            return;
        }
        
    }

}

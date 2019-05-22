<?php
namespace KK\GeoIpHandler\Hooks;



use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Extbase\Mvc\Web;
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
        $requestUrl = $_SERVER['HTTP_HOST'];
        $objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\Extbase\\Object\\ObjectManager');
        $configurationManager = $objectManager->get('TYPO3\\CMS\\Extbase\\Configuration\\ConfigurationManager');
        $request = $objectManager->get('TYPO3\\CMS\\Extbase\\Mvc\\Web\\Request');
        $extbaseFrameworkConfiguration = $configurationManager->getConfiguration(\TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_FULL_TYPOSCRIPT);
        $redirectRule = $extbaseFrameworkConfiguration['plugin.']['tx_geoiphandler_geoiphandler.']['settings.']['redirects.'];
        $extPath = ExtensionManagementUtility::extPath('geo_ip_handler');
        $reader = new Reader($extPath.'Resources/Public/GeoLite/GeoLite2-City.mmdb');
        $currentIp = $this->getUserIP();
        $record = $reader->city('128.101.101.101');//US
        //$record = $reader->city('13.106.118.255');//JP
        //$record = $reader->city('1.39.255.255');//IN
        $isoCode = $record->country->isoCode ;

        //\TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($currentIp);exit;
        if(array_key_exists(strtolower($isoCode).'.', $redirectRule)){
            $target = $redirectRule[strtolower($isoCode).'.']['target'];
            $trigger = $redirectRule[strtolower($isoCode).'.']['trigger'];
            if( $requestUrl != $target ){
                header("Location:".$target);
            }
            
        }

        return;
        
    }

    public function getUserIP()
    {
        $ipaddress = '';
        if (getenv('HTTP_CLIENT_IP'))
            $ipaddress = getenv('HTTP_CLIENT_IP');
        else if(getenv('HTTP_X_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
        else if(getenv('HTTP_X_FORWARDED'))
            $ipaddress = getenv('HTTP_X_FORWARDED');
        else if(getenv('HTTP_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_FORWARDED_FOR');
        else if(getenv('HTTP_FORWARDED'))
           $ipaddress = getenv('HTTP_FORWARDED');
        else if(getenv('REMOTE_ADDR'))
            $ipaddress = getenv('REMOTE_ADDR');
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress;
    }

}

<?php
namespace KK\GeoIpHandler\Hooks;



use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Extbase\Mvc\Web;
use TYPO3\CMS\Core\Utility\HttpUtility;
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

        $objectManager = GeneralUtility::makeInstance('TYPO3\\CMS\Extbase\\Object\\ObjectManager');
        $configurationManager = $objectManager->get('TYPO3\\CMS\\Extbase\\Configuration\\ConfigurationManager');
        $extbaseFrameworkConfiguration = $configurationManager->getConfiguration(\TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_FULL_TYPOSCRIPT);

        //get typoscript configuration for redirect rules
        $redirectRule = $extbaseFrameworkConfiguration['plugin.']['tx_geoiphandler_geoiphandler.']['settings.']['redirects.'];

        $extPath = ExtensionManagementUtility::extPath('geo_ip_handler');
        $reader = new Reader($extPath.'Resources/Public/GeoLite/GeoLite2-City.mmdb');
        $currentIp = GeneralUtility::getIndpEnv('REMOTE_ADDR');
        $record = $reader->city($currentIp);
        $record = $reader->city('128.101.101.101');//US
        //$record = $reader->city('13.106.118.255');//JP
        //$record = $reader->city('1.39.255.255');//IN
        $isoCode = $record->country->isoCode ;
 
        //if iso code of clients's ip exists in redirect rule
        if(array_key_exists(strtolower($isoCode).'.', $redirectRule)){
            $target = $redirectRule[strtolower($isoCode).'.']['target'];
            $trigger = $redirectRule[strtolower($isoCode).'.']['trigger'];
            if( $trigger === 'in' ){
                if( $requestUrl != $target ){
                    HttpUtility::redirect($target);
                }
            }
            elseif($trigger === 'out'){
                $this->redirectToTarget($redirectRule, strtolower($isoCode), $requestUrl);
            }
        }
        else{
            $this->redirectToTarget($redirectRule, strtolower($isoCode), $requestUrl);
        }
        return;
    }


    /**
    * function redirectToTarget
    * This function redirects to the target if iso of client's ip not exists in rules or value for trigger of the rule is 'out'
    *
    **/
    public function redirectToTarget($rules, string $iso, string $requestUrl){
        foreach ($rules as $key => $rule) {
            $target = $rule['target'];
            $trigger = $rule['trigger'];
            if($isoCode != rtrim($key,'.')){
                if( $trigger == 'out' ){
                    if( $requestUrl != $target ){
                        HttpUtility::redirect($target);
                        break;
                    }
                }
            }
        }
    }
}

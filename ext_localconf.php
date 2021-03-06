<?php
defined('TYPO3_MODE') || die('Access denied.');

call_user_func(
    function()
    {

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
            'KK.GeoIpHandler',
            'Geoiphandler',
            [
                
            ],
            // non-cacheable actions
            [
               
            ]
        );

    // wizards
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig(
        'mod {
            wizards.newContentElement.wizardItems.plugins {
                elements {
                    geoiphandler {
                        iconIdentifier = geo_ip_handler-plugin-geoiphandler
                        title = LLL:EXT:geo_ip_handler/Resources/Private/Language/locallang_db.xlf:tx_geo_ip_handler_geoiphandler.name
                        description = LLL:EXT:geo_ip_handler/Resources/Private/Language/locallang_db.xlf:tx_geo_ip_handler_geoiphandler.description
                        tt_content_defValues {
                            CType = list
                            list_type = geoiphandler_geoiphandler
                        }
                    }
                }
                show = *
            }
       }'
    );
		$iconRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Imaging\IconRegistry::class);
		
			$iconRegistry->registerIcon(
				'geo_ip_handler-plugin-geoiphandler',
				\TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
				['source' => 'EXT:ext_icon.png']
			);
		
    }
);



// Hook for post-processing of page content cached/non-cached:
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['tslib/class.tslib_fe.php']['contentPostProc-all'][\KK\GeoIpHandler\Hooks\RedirectBeforePageLoadHook::class] = \KK\GeoIpHandler\Hooks\RedirectBeforePageLoadHook::class . '->execute';
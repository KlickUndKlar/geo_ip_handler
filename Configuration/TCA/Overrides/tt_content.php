<?php
defined('TYPO3_MODE') or die();

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
            'KK.GeoIpHandler',
            'Geoiphandler',
            'geoiphandler'
);
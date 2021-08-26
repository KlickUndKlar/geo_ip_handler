<?php
defined('TYPO3_MODE') || die('Access denied.');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile('geo_ip_handler', 'Configuration/TypoScript', 'Geo IP Handler');
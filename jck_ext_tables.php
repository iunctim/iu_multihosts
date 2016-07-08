<?php
if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Configuration/TypoScript', 'multihosts');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_iumultihosts_domain_model_host', 'EXT:iu_multihosts/Resources/Private/Language/locallang_csh_tx_iumultihosts_domain_model_host.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_iumultihosts_domain_model_host');

if (TYPO3_MODE === 'BE') {
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
        $_EXTKEY,
        'web',          // Main area
        'Multihosts',   // Name of the module
        '',             // Position of the module
        array(          // Allowed controller action combinations
            'Host' => 'list',
        ),
        array(          // Additional configuration
            'access'    => 'user,group',
            'icon'      => 'EXT:' . $_EXTKEY . '/ext_icon.gif',
            'labels'    => 'LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang_mod.xml',
        )
    );
}

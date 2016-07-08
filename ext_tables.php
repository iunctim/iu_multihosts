<?php
if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

if (TYPO3_MODE === 'BE') {

	/**
	 * Registers a Backend Module
	 */
	\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
		'Iunctim.' . $_EXTKEY,
		'tools',	 // Make module a submodule of 'tools'
		'managehosts',	// Submodule key
		'',						// Position
		array(
			'Host' => 'list, edit, create, new, update, delete',
			'Color' => 'list, edit, create, new, update, delete',
			'Language' => 'list, edit, create, new, update, delete',
			
		),
		array(
			'access' => 'user,group',
			'icon'   => 'EXT:' . $_EXTKEY . '/ext_icon.svg',
			'labels' => 'LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang_managehosts.xlf',
		)
	);

}

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Configuration/TypoScript', 'multihosts');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_iumultihosts_domain_model_host', 'EXT:iu_multihosts/Resources/Private/Language/locallang_csh_tx_iumultihosts_domain_model_host.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_iumultihosts_domain_model_host');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_iumultihosts_domain_model_color', 'EXT:iu_multihosts/Resources/Private/Language/locallang_csh_tx_iumultihosts_domain_model_color.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_iumultihosts_domain_model_color');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_iumultihosts_domain_model_language', 'EXT:iu_multihosts/Resources/Private/Language/locallang_csh_tx_iumultihosts_domain_model_language.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_iumultihosts_domain_model_language');

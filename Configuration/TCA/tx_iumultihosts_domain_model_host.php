<?php
return array(
	'ctrl' => array(
		'title'	=> 'LLL:EXT:iu_multihosts/Resources/Private/Language/locallang_db.xlf:tx_iumultihosts_domain_model_host',
		'label' => 'url',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'dividers2tabs' => TRUE,
		'versioningWS' => 2,
		'versioning_followPages' => TRUE,

		'languageField' => 'sys_language_uid',
		'transOrigPointerField' => 'l10n_parent',
		'transOrigDiffSourceField' => 'l10n_diffsource',
		'delete' => 'deleted',
		'enablecolumns' => array(
			'disabled' => 'hidden',
			'starttime' => 'starttime',
			'endtime' => 'endtime',
		),
		'searchFields' => 'url,title,email,extensions,usergroup,piwik,color,language,',
		'iconfile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath('iu_multihosts') . 'Resources/Public/Icons/tx_iumultihosts_domain_model_host.gif'
	),
	'interface' => array(
		'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, url, title, email, extensions, usergroup, piwik, color, language',
	),
	'types' => array(
		'1' => array('showitem' => 'sys_language_uid;;;;1-1-1, l10n_parent, l10n_diffsource, hidden;;1, url, title, email, extensions, usergroup, piwik, color, language, --div--;LLL:EXT:cms/locallang_ttc.xlf:tabs.access, starttime, endtime'),
	),
	'palettes' => array(
		'1' => array('showitem' => ''),
	),
	'columns' => array(
	
		'sys_language_uid' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.language',
			'config' => array(
				'type' => 'select',
				'renderType' => 'selectSingle',
				'foreign_table' => 'sys_language',
				'foreign_table_where' => 'ORDER BY sys_language.title',
				'items' => array(
					array('LLL:EXT:lang/locallang_general.xlf:LGL.allLanguages', -1),
					array('LLL:EXT:lang/locallang_general.xlf:LGL.default_value', 0)
				),
			),
		),
		'l10n_parent' => array(
			'displayCond' => 'FIELD:sys_language_uid:>:0',
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.l18n_parent',
			'config' => array(
				'type' => 'select',
				'renderType' => 'selectSingle',
				'items' => array(
					array('', 0),
				),
				'foreign_table' => 'tx_iumultihosts_domain_model_host',
				'foreign_table_where' => 'AND tx_iumultihosts_domain_model_host.pid=###CURRENT_PID### AND tx_iumultihosts_domain_model_host.sys_language_uid IN (-1,0)',
			),
		),
		'l10n_diffsource' => array(
			'config' => array(
				'type' => 'passthrough',
			),
		),

		't3ver_label' => array(
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.versionLabel',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'max' => 255,
			)
		),
	
		'hidden' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.hidden',
			'config' => array(
				'type' => 'check',
			),
		),
		'starttime' => array(
			'exclude' => 1,
			'l10n_mode' => 'mergeIfNotBlank',
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.starttime',
			'config' => array(
				'type' => 'input',
				'size' => 13,
				'max' => 20,
				'eval' => 'datetime',
				'checkbox' => 0,
				'default' => 0,
				'range' => array(
					'lower' => mktime(0, 0, 0, date('m'), date('d'), date('Y'))
				),
			),
		),
		'endtime' => array(
			'exclude' => 1,
			'l10n_mode' => 'mergeIfNotBlank',
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.endtime',
			'config' => array(
				'type' => 'input',
				'size' => 13,
				'max' => 20,
				'eval' => 'datetime',
				'checkbox' => 0,
				'default' => 0,
				'range' => array(
					'lower' => mktime(0, 0, 0, date('m'), date('d'), date('Y'))
				),
			),
		),

		'url' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:iu_multihosts/Resources/Private/Language/locallang_db.xlf:tx_iumultihosts_domain_model_host.url',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'title' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:iu_multihosts/Resources/Private/Language/locallang_db.xlf:tx_iumultihosts_domain_model_host.title',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'email' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:iu_multihosts/Resources/Private/Language/locallang_db.xlf:tx_iumultihosts_domain_model_host.email',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'extensions' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:iu_multihosts/Resources/Private/Language/locallang_db.xlf:tx_iumultihosts_domain_model_host.extensions',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'usergroup' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:iu_multihosts/Resources/Private/Language/locallang_db.xlf:tx_iumultihosts_domain_model_host.usergroup',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'piwik' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:iu_multihosts/Resources/Private/Language/locallang_db.xlf:tx_iumultihosts_domain_model_host.piwik',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'color' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:iu_multihosts/Resources/Private/Language/locallang_db.xlf:tx_iumultihosts_domain_model_host.color',
			'config' => array(
				'type' => 'inline',
				'foreign_table' => 'tx_iumultihosts_domain_model_color',
				'minitems' => 0,
				'maxitems' => 1,
				'appearance' => array(
					'collapseAll' => 0,
					'levelLinksPosition' => 'top',
					'showSynchronizationLink' => 1,
					'showPossibleLocalizationRecords' => 1,
					'showAllLocalizationLink' => 1
				),
			),
		),
		'language' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:iu_multihosts/Resources/Private/Language/locallang_db.xlf:tx_iumultihosts_domain_model_host.language',
			'config' => array(
				'type' => 'inline',
				'foreign_table' => 'tx_iumultihosts_domain_model_language',
				'minitems' => 0,
				'maxitems' => 1,
				'appearance' => array(
					'collapseAll' => 0,
					'levelLinksPosition' => 'top',
					'showSynchronizationLink' => 1,
					'showPossibleLocalizationRecords' => 1,
					'showAllLocalizationLink' => 1
				),
			),
		),
		
	),
);
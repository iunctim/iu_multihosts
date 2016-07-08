<?php
namespace Iunctim\IuMultihosts\Controller;


use Iunctim\IuMultihosts\Utility\Datahandler;

/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2016 Jan-C. Kranefeld <kranefeld@iunctim.com>, iunctim GmbH & Co. KG
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 * HostController
 */
class HostController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{

    /**
     * hostRepository
     *
     * @var \Iunctim\IuMultihosts\Domain\Repository\HostRepository
     * @inject
     */
    protected $hostRepository = NULL;

    /**
     * colorRepository
     *
     * @var \Iunctim\IuMultihosts\Domain\Repository\ColorRepository
     * @inject
     */
    protected $colorRepository = NULL;

    /**
     * languageRepository
     *
     * @var \Iunctim\IuMultihosts\Domain\Repository\LanguageRepository
     * @inject
     */
    protected $languageRepository = NULL;
 
    
    /**
     * action list
     *
     * @return void
     */
    public function listAction()
    {
        $hosts = $this->hostRepository->findAll();
        $this->view->assign('hosts', $hosts);
    }
    

    /**
    * initialize create action
    *
    * @return void
    */
    public function initializeCreateAction() {
      if ($this->arguments->hasArgument('newHost')) {
         $this->arguments->getArgument('newHost')->getPropertyMappingConfiguration()->setTargetTypeForSubProperty('extensions', 'array');
      }
    }

    /**
     * action create
     *
     * @param \Iunctim\IuMultihosts\Domain\Model\Host $newHost
     * @return void
     */
    public function createAction(\Iunctim\IuMultihosts\Domain\Model\Host $newHost = NULL)
    {
	// check url format:
	if (Datahandler::checkUrlFormat($newHost->getUrl()) == false) {
	        $this->addFlashMessage("'" . $newHost->getUrl() . "' is not a valid url!", "Error:", \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR);
        	$this->redirect('list');
	}

	// check if host already exists:
	if ($this->hostRepository->countByUrl($newHost->getUrl()) > 0) {
	        $this->addFlashMessage("The host '" . $newHost->getUrl() . "' already exists!", "Error:", \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR);
        	$this->redirect('list');
	}

	// check if title already exists:
	if ($this->hostRepository->countByTitle($newHost->getTitle()) > 0) {
	        $this->addFlashMessage("The title '" . $newHost->getTitle() . "' already exists!", "Error:", \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR);
        	$this->redirect('list');
	}

	// check dns settings:
	if (Datahandler::checkDns($newHost->getUrl()) == false) {
	        $this->addFlashMessage("The DNS A-Record for '" . $newHost->getUrl() . "' does not point to this server!", "Don't forget:", \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
	}

	// create user password:
	$userPwd = Datahandler::generatePassword();
	$this->addFlashMessage("Username: " . $newHost->getUrl() . " | Password: '" . $userPwd . "'", "Credentials:", \TYPO3\CMS\Core\Messaging\AbstractMessage::NOTICE);

	// create piwik site id:
	/*
	if (!is_numeric($piwikId = Datahandler::addPiwikSite(urlencode($newHost->getUrl()), urlencode($newHost->getTitle())))) {
	        $this->addFlashMessage("Piwik returned the following error: '" . $piwikId . " – Piwik entry was not created!", "Warning:", \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
	} else {
		$this->addFlashMessage("Piwik entry was created with ID '" . $piwikId . "'!", "New Piwik entry:", \TYPO3\CMS\Core\Messaging\AbstractMessage::OK);
	}
	*/
	

	// create fileadmin folder for new host:
	$hostFolder = PATH_site . "/fileadmin/user_upload/" . $newHost->getUrl();
	mkdir($hostFolder);


	// create the page tree for the new host:
	$params = array(
		"pid" => 0,
		"title" => $newHost->getTitle(),
		"url" => $newHost->getUrl(),
		"color" => $newHost->getColor()->getUid(),
		"language" => $newHost->getLanguage()->getName(),
		"piwik" => $newHost->getPiwik(),
		"hostFolder" => $hostFolder,
		"usergroup" => $newHost->getTitle(),
		"extensions" => $newHost->getExtensions(),
		"userpwd" => $userPwd,
	);
	Datahandler::addPageTree($params);

        $this->hostRepository->add($newHost);

	$this->addFlashMessage("Host '" . $newHost->getUrl() . "' was successfully created!", "New Host:", \TYPO3\CMS\Core\Messaging\AbstractMessage::OK);
        $this->redirect('list');
    }
    
    /**
     * @param \Iunctim\IuMultihosts\Domain\Model\Host $newHost
     */
    public function newAction(\Iunctim\IuMultihosts\Domain\Model\Host $newHost = NULL)
    {
	$colors = $this->colorRepository->findAll();
	$languages = $this->languageRepository->findAll();
        $this->view->assign('newHost', $newHost);
        $this->view->assign('colors', $colors);
        $this->view->assign('languages', $languages);
    }
    
    /**
     * action delete
     *
     * @param \Iunctim\IuMultihosts\Domain\Model\Host $host
     * @return void
     */
    public function deleteAction(\Iunctim\IuMultihosts\Domain\Model\Host $host)
    {
        $this->addFlashMessage('The object was deleted. Please be aware that this action is publicly accessible unless you implement an access check. See http://wiki.typo3.org/T3Doc/Extension_Builder/Using_the_Extension_Builder#1._Model_the_domain', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR);
        Datahandler::disablePageTree($host);
        $this->hostRepository->remove($host);
        $this->redirect('list');
    }

    /**
     * action edit
     *
     * @param \Iunctim\IuMultihosts\Domain\Model\Host $host
     * @ignorevalidation $host
     * @return void
     */
    public function editAction(\Iunctim\IuMultihosts\Domain\Model\Host $host)
    {
	$colors = $this->colorRepository->findAll();
	$languages = $this->languageRepository->findAll();
        $this->view->assign('host', $host);
	$this->view->assign('colors', $colors);
        $this->view->assign('languages', $languages);
    }

   /**
    * initialize create action
    *
    * @return void
    */
   public function initializeUpdateAction() {
      if ($this->arguments->hasArgument('host')) {
         $this->arguments->getArgument('host')->getPropertyMappingConfiguration()->setTargetTypeForSubProperty('extensions', 'array');
      }
   }
    
    /**
     * action update
     *
     * @param \Iunctim\IuMultihosts\Domain\Model\Host $host
     * @return void
     */
    public function updateAction(\Iunctim\IuMultihosts\Domain\Model\Host $host)
    {
        $this->addFlashMessage('The object was updated. Please be aware that this action is publicly accessible unless you implement an access check. See http://wiki.typo3.org/T3Doc/Extension_Builder/Using_the_Extension_Builder#1._Model_the_domain', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR);
        $this->hostRepository->update($host);
        $this->redirect('list');
    }

}

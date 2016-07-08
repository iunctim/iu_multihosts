<?php
namespace Iunctim\IuMultihosts\Controller;

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
 * LanguageController
 */
class LanguageController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{

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
        $languages = $this->languageRepository->findAll();
        $this->view->assign('languages', $languages);
    }
    
    /**
     * action new
     *
     * @return void
     */
    public function newAction()
    {
        
    }
    
    /**
     * action create
     *
     * @param \Iunctim\IuMultihosts\Domain\Model\Language $newLanguage
     * @return void
     */
    public function createAction(\Iunctim\IuMultihosts\Domain\Model\Language $newLanguage)
    {
        $this->addFlashMessage('The object was created. Please be aware that this action is publicly accessible unless you implement an access check. See http://wiki.typo3.org/T3Doc/Extension_Builder/Using_the_Extension_Builder#1._Model_the_domain', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR);
        $this->languageRepository->add($newLanguage);
        $this->redirect('list');
    }
    
    /**
     * action edit
     *
     * @param \Iunctim\IuMultihosts\Domain\Model\Language $language
     * @ignorevalidation $language
     * @return void
     */
    public function editAction(\Iunctim\IuMultihosts\Domain\Model\Language $language)
    {
        $this->view->assign('language', $language);
    }
    
    /**
     * action update
     *
     * @param \Iunctim\IuMultihosts\Domain\Model\Language $language
     * @return void
     */
    public function updateAction(\Iunctim\IuMultihosts\Domain\Model\Language $language)
    {
        $this->addFlashMessage('The object was updated. Please be aware that this action is publicly accessible unless you implement an access check. See http://wiki.typo3.org/T3Doc/Extension_Builder/Using_the_Extension_Builder#1._Model_the_domain', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR);
        $this->languageRepository->update($language);
        $this->redirect('list');
    }
    
    /**
     * action delete
     *
     * @param \Iunctim\IuMultihosts\Domain\Model\Language $language
     * @return void
     */
    public function deleteAction(\Iunctim\IuMultihosts\Domain\Model\Language $language)
    {
        $this->addFlashMessage('The object was deleted. Please be aware that this action is publicly accessible unless you implement an access check. See http://wiki.typo3.org/T3Doc/Extension_Builder/Using_the_Extension_Builder#1._Model_the_domain', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR);
        $this->languageRepository->remove($language);
        $this->redirect('list');
    }

}
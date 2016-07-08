<?php
namespace Iunctim\IuMultihosts\Tests\Unit\Controller;
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2016 Jan-C. Kranefeld <kranefeld@iunctim.com>, iunctim GmbH & Co. KG
 *  			
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
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
 * Test case for class Iunctim\IuMultihosts\Controller\LanguageController.
 *
 * @author Jan-C. Kranefeld <kranefeld@iunctim.com>
 */
class LanguageControllerTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{

	/**
	 * @var \Iunctim\IuMultihosts\Controller\LanguageController
	 */
	protected $subject = NULL;

	public function setUp()
	{
		$this->subject = $this->getMock('Iunctim\\IuMultihosts\\Controller\\LanguageController', array('redirect', 'forward', 'addFlashMessage'), array(), '', FALSE);
	}

	public function tearDown()
	{
		unset($this->subject);
	}

	/**
	 * @test
	 */
	public function listActionFetchesAllLanguagesFromRepositoryAndAssignsThemToView()
	{

		$allLanguages = $this->getMock('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage', array(), array(), '', FALSE);

		$languageRepository = $this->getMock('Iunctim\\IuMultihosts\\Domain\\Repository\\LanguageRepository', array('findAll'), array(), '', FALSE);
		$languageRepository->expects($this->once())->method('findAll')->will($this->returnValue($allLanguages));
		$this->inject($this->subject, 'languageRepository', $languageRepository);

		$view = $this->getMock('TYPO3\\CMS\\Extbase\\Mvc\\View\\ViewInterface');
		$view->expects($this->once())->method('assign')->with('languages', $allLanguages);
		$this->inject($this->subject, 'view', $view);

		$this->subject->listAction();
	}

	/**
	 * @test
	 */
	public function createActionAddsTheGivenLanguageToLanguageRepository()
	{
		$language = new \Iunctim\IuMultihosts\Domain\Model\Language();

		$languageRepository = $this->getMock('Iunctim\\IuMultihosts\\Domain\\Repository\\LanguageRepository', array('add'), array(), '', FALSE);
		$languageRepository->expects($this->once())->method('add')->with($language);
		$this->inject($this->subject, 'languageRepository', $languageRepository);

		$this->subject->createAction($language);
	}

	/**
	 * @test
	 */
	public function editActionAssignsTheGivenLanguageToView()
	{
		$language = new \Iunctim\IuMultihosts\Domain\Model\Language();

		$view = $this->getMock('TYPO3\\CMS\\Extbase\\Mvc\\View\\ViewInterface');
		$this->inject($this->subject, 'view', $view);
		$view->expects($this->once())->method('assign')->with('language', $language);

		$this->subject->editAction($language);
	}

	/**
	 * @test
	 */
	public function updateActionUpdatesTheGivenLanguageInLanguageRepository()
	{
		$language = new \Iunctim\IuMultihosts\Domain\Model\Language();

		$languageRepository = $this->getMock('Iunctim\\IuMultihosts\\Domain\\Repository\\LanguageRepository', array('update'), array(), '', FALSE);
		$languageRepository->expects($this->once())->method('update')->with($language);
		$this->inject($this->subject, 'languageRepository', $languageRepository);

		$this->subject->updateAction($language);
	}

	/**
	 * @test
	 */
	public function deleteActionRemovesTheGivenLanguageFromLanguageRepository()
	{
		$language = new \Iunctim\IuMultihosts\Domain\Model\Language();

		$languageRepository = $this->getMock('Iunctim\\IuMultihosts\\Domain\\Repository\\LanguageRepository', array('remove'), array(), '', FALSE);
		$languageRepository->expects($this->once())->method('remove')->with($language);
		$this->inject($this->subject, 'languageRepository', $languageRepository);

		$this->subject->deleteAction($language);
	}
}

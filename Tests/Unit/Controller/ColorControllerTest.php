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
 * Test case for class Iunctim\IuMultihosts\Controller\ColorController.
 *
 * @author Jan-C. Kranefeld <kranefeld@iunctim.com>
 */
class ColorControllerTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{

	/**
	 * @var \Iunctim\IuMultihosts\Controller\ColorController
	 */
	protected $subject = NULL;

	public function setUp()
	{
		$this->subject = $this->getMock('Iunctim\\IuMultihosts\\Controller\\ColorController', array('redirect', 'forward', 'addFlashMessage'), array(), '', FALSE);
	}

	public function tearDown()
	{
		unset($this->subject);
	}

	/**
	 * @test
	 */
	public function listActionFetchesAllColorsFromRepositoryAndAssignsThemToView()
	{

		$allColors = $this->getMock('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage', array(), array(), '', FALSE);

		$colorRepository = $this->getMock('Iunctim\\IuMultihosts\\Domain\\Repository\\ColorRepository', array('findAll'), array(), '', FALSE);
		$colorRepository->expects($this->once())->method('findAll')->will($this->returnValue($allColors));
		$this->inject($this->subject, 'colorRepository', $colorRepository);

		$view = $this->getMock('TYPO3\\CMS\\Extbase\\Mvc\\View\\ViewInterface');
		$view->expects($this->once())->method('assign')->with('colors', $allColors);
		$this->inject($this->subject, 'view', $view);

		$this->subject->listAction();
	}

	/**
	 * @test
	 */
	public function createActionAddsTheGivenColorToColorRepository()
	{
		$color = new \Iunctim\IuMultihosts\Domain\Model\Color();

		$colorRepository = $this->getMock('Iunctim\\IuMultihosts\\Domain\\Repository\\ColorRepository', array('add'), array(), '', FALSE);
		$colorRepository->expects($this->once())->method('add')->with($color);
		$this->inject($this->subject, 'colorRepository', $colorRepository);

		$this->subject->createAction($color);
	}

	/**
	 * @test
	 */
	public function editActionAssignsTheGivenColorToView()
	{
		$color = new \Iunctim\IuMultihosts\Domain\Model\Color();

		$view = $this->getMock('TYPO3\\CMS\\Extbase\\Mvc\\View\\ViewInterface');
		$this->inject($this->subject, 'view', $view);
		$view->expects($this->once())->method('assign')->with('color', $color);

		$this->subject->editAction($color);
	}

	/**
	 * @test
	 */
	public function updateActionUpdatesTheGivenColorInColorRepository()
	{
		$color = new \Iunctim\IuMultihosts\Domain\Model\Color();

		$colorRepository = $this->getMock('Iunctim\\IuMultihosts\\Domain\\Repository\\ColorRepository', array('update'), array(), '', FALSE);
		$colorRepository->expects($this->once())->method('update')->with($color);
		$this->inject($this->subject, 'colorRepository', $colorRepository);

		$this->subject->updateAction($color);
	}

	/**
	 * @test
	 */
	public function deleteActionRemovesTheGivenColorFromColorRepository()
	{
		$color = new \Iunctim\IuMultihosts\Domain\Model\Color();

		$colorRepository = $this->getMock('Iunctim\\IuMultihosts\\Domain\\Repository\\ColorRepository', array('remove'), array(), '', FALSE);
		$colorRepository->expects($this->once())->method('remove')->with($color);
		$this->inject($this->subject, 'colorRepository', $colorRepository);

		$this->subject->deleteAction($color);
	}
}

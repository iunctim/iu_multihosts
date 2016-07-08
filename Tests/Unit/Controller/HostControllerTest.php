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
 * Test case for class Iunctim\IuMultihosts\Controller\HostController.
 *
 * @author Jan-C. Kranefeld <kranefeld@iunctim.com>
 */
class HostControllerTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{

	/**
	 * @var \Iunctim\IuMultihosts\Controller\HostController
	 */
	protected $subject = NULL;

	public function setUp()
	{
		$this->subject = $this->getMock('Iunctim\\IuMultihosts\\Controller\\HostController', array('redirect', 'forward', 'addFlashMessage'), array(), '', FALSE);
	}

	public function tearDown()
	{
		unset($this->subject);
	}

	/**
	 * @test
	 */
	public function listActionFetchesAllHostsFromRepositoryAndAssignsThemToView()
	{

		$allHosts = $this->getMock('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage', array(), array(), '', FALSE);

		$hostRepository = $this->getMock('Iunctim\\IuMultihosts\\Domain\\Repository\\HostRepository', array('findAll'), array(), '', FALSE);
		$hostRepository->expects($this->once())->method('findAll')->will($this->returnValue($allHosts));
		$this->inject($this->subject, 'hostRepository', $hostRepository);

		$view = $this->getMock('TYPO3\\CMS\\Extbase\\Mvc\\View\\ViewInterface');
		$view->expects($this->once())->method('assign')->with('hosts', $allHosts);
		$this->inject($this->subject, 'view', $view);

		$this->subject->listAction();
	}

	/**
	 * @test
	 */
	public function createActionAddsTheGivenHostToHostRepository()
	{
		$host = new \Iunctim\IuMultihosts\Domain\Model\Host();

		$hostRepository = $this->getMock('Iunctim\\IuMultihosts\\Domain\\Repository\\HostRepository', array('add'), array(), '', FALSE);
		$hostRepository->expects($this->once())->method('add')->with($host);
		$this->inject($this->subject, 'hostRepository', $hostRepository);

		$this->subject->createAction($host);
	}

	/**
	 * @test
	 */
	public function editActionAssignsTheGivenHostToView()
	{
		$host = new \Iunctim\IuMultihosts\Domain\Model\Host();

		$view = $this->getMock('TYPO3\\CMS\\Extbase\\Mvc\\View\\ViewInterface');
		$this->inject($this->subject, 'view', $view);
		$view->expects($this->once())->method('assign')->with('host', $host);

		$this->subject->editAction($host);
	}

	/**
	 * @test
	 */
	public function updateActionUpdatesTheGivenHostInHostRepository()
	{
		$host = new \Iunctim\IuMultihosts\Domain\Model\Host();

		$hostRepository = $this->getMock('Iunctim\\IuMultihosts\\Domain\\Repository\\HostRepository', array('update'), array(), '', FALSE);
		$hostRepository->expects($this->once())->method('update')->with($host);
		$this->inject($this->subject, 'hostRepository', $hostRepository);

		$this->subject->updateAction($host);
	}

	/**
	 * @test
	 */
	public function deleteActionRemovesTheGivenHostFromHostRepository()
	{
		$host = new \Iunctim\IuMultihosts\Domain\Model\Host();

		$hostRepository = $this->getMock('Iunctim\\IuMultihosts\\Domain\\Repository\\HostRepository', array('remove'), array(), '', FALSE);
		$hostRepository->expects($this->once())->method('remove')->with($host);
		$this->inject($this->subject, 'hostRepository', $hostRepository);

		$this->subject->deleteAction($host);
	}
}

<?php

namespace Iunctim\IuMultihosts\Tests\Unit\Domain\Model;

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
 * Test case for class \Iunctim\IuMultihosts\Domain\Model\Host.
 *
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 * @author Jan-C. Kranefeld <kranefeld@iunctim.com>
 */
class HostTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{
	/**
	 * @var \Iunctim\IuMultihosts\Domain\Model\Host
	 */
	protected $subject = NULL;

	public function setUp()
	{
		$this->subject = new \Iunctim\IuMultihosts\Domain\Model\Host();
	}

	public function tearDown()
	{
		unset($this->subject);
	}

	/**
	 * @test
	 */
	public function getUrlReturnsInitialValueForString()
	{
		$this->assertSame(
			'',
			$this->subject->getUrl()
		);
	}

	/**
	 * @test
	 */
	public function setUrlForStringSetsUrl()
	{
		$this->subject->setUrl('Conceived at T3CON10');

		$this->assertAttributeEquals(
			'Conceived at T3CON10',
			'url',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getTitleReturnsInitialValueForString()
	{
		$this->assertSame(
			'',
			$this->subject->getTitle()
		);
	}

	/**
	 * @test
	 */
	public function setTitleForStringSetsTitle()
	{
		$this->subject->setTitle('Conceived at T3CON10');

		$this->assertAttributeEquals(
			'Conceived at T3CON10',
			'title',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getEmailReturnsInitialValueForString()
	{
		$this->assertSame(
			'',
			$this->subject->getEmail()
		);
	}

	/**
	 * @test
	 */
	public function setEmailForStringSetsEmail()
	{
		$this->subject->setEmail('Conceived at T3CON10');

		$this->assertAttributeEquals(
			'Conceived at T3CON10',
			'email',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getExtensionsReturnsInitialValueForString()
	{
		$this->assertSame(
			'',
			$this->subject->getExtensions()
		);
	}

	/**
	 * @test
	 */
	public function setExtensionsForStringSetsExtensions()
	{
		$this->subject->setExtensions('Conceived at T3CON10');

		$this->assertAttributeEquals(
			'Conceived at T3CON10',
			'extensions',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getUsergroupReturnsInitialValueForString()
	{
		$this->assertSame(
			'',
			$this->subject->getUsergroup()
		);
	}

	/**
	 * @test
	 */
	public function setUsergroupForStringSetsUsergroup()
	{
		$this->subject->setUsergroup('Conceived at T3CON10');

		$this->assertAttributeEquals(
			'Conceived at T3CON10',
			'usergroup',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getPiwikReturnsInitialValueForString()
	{
		$this->assertSame(
			'',
			$this->subject->getPiwik()
		);
	}

	/**
	 * @test
	 */
	public function setPiwikForStringSetsPiwik()
	{
		$this->subject->setPiwik('Conceived at T3CON10');

		$this->assertAttributeEquals(
			'Conceived at T3CON10',
			'piwik',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getColorReturnsInitialValueForColor()
	{
		$this->assertEquals(
			NULL,
			$this->subject->getColor()
		);
	}

	/**
	 * @test
	 */
	public function setColorForColorSetsColor()
	{
		$colorFixture = new \Iunctim\IuMultihosts\Domain\Model\Color();
		$this->subject->setColor($colorFixture);

		$this->assertAttributeEquals(
			$colorFixture,
			'color',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getLanguageReturnsInitialValueForLanguage()
	{
		$this->assertEquals(
			NULL,
			$this->subject->getLanguage()
		);
	}

	/**
	 * @test
	 */
	public function setLanguageForLanguageSetsLanguage()
	{
		$languageFixture = new \Iunctim\IuMultihosts\Domain\Model\Language();
		$this->subject->setLanguage($languageFixture);

		$this->assertAttributeEquals(
			$languageFixture,
			'language',
			$this->subject
		);
	}
}

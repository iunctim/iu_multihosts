<?php
namespace Iunctim\IuMultihosts\Domain\Model;

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
 * Host defines the single hosts within the TYPO3 page tree
 */
class Host extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * url
     *
     * @var string
     */
    protected $url = '';
    
    /**
     * title
     *
     * @var string
     */
    protected $title = '';
    
    /**
     * email
     *
     * @var string
     */
    protected $email = '';
    
    /**
     * extensions
     *
     * @var string
     */
    protected $extensions = '';
    
    /**
     * usergroup
     *
     * @var string
     */
    protected $usergroup = '';
    
    /**
     * piwik
     *
     * @var string
     */
    protected $piwik = '';
    
    /**
     * color
     *
     * @var \Iunctim\IuMultihosts\Domain\Model\Color
     */
    protected $color = null;
    
    /**
     * language
     *
     * @var \Iunctim\IuMultihosts\Domain\Model\Language
     */
    protected $language = null;
    
    /**
     * Returns the url
     *
     * @return string $url
     */
    public function getUrl()
    {
        return $this->url;
    }
    
    /**
     * Sets the url
     *
     * @param string $url
     * @return void
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }
    
    /**
     * Returns the email
     *
     * @return string $email
     */
    public function getEmail()
    {
        return $this->email;
    }
    
    /**
     * Sets the email
     *
     * @param string $email
     * @return void
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }
    
    /**
     * Returns the title
     *
     * @return string $title
     */
    public function getTitle()
    {
        return $this->title;
    }
    
    /**
     * Sets the title
     *
     * @param string $title
     * @return void
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }
    
    /**
     * __construct
     *
     * @param string $url
     * @param string $title
     * @param string $email
     * @param string $piwik
     * @param array $extensions
     * @param \Iunctim\IuMultihosts\Domain\Model\Color $color
     * @param \Iunctim\IuMultihosts\Domain\Model\Language $language
     */
    public function __construct($url = '', $title = '', $email = '', $piwik = '', array $extensions = array(),
        \Iunctim\IuMultihosts\Domain\Model\Color $color = NULL, \Iunctim\IuMultihosts\Domain\Model\Language $language = NULL)
    {
        $this->setUrl(trim($url));
        $this->setTitle(trim($title));
        $this->setEmail(trim($email));
        $this->setPiwik(trim($piwik));
        $this->setExtensions($extensions);
        $this->setColor($color);
        $this->setLanguage($language);
        //Do not remove the next line: It would break the functionality
        $this->initStorageObjects();
    }
    
    /**
     * Initializes all ObjectStorage properties
     * Do not modify this method!
     * It will be rewritten on each save in the extension builder
     * You may modify the constructor of this class instead
     *
     * @return void
     */
    protected function initStorageObjects()
    {
        
    }
    
    /**
     * Returns the color
     *
     * @return \Iunctim\IuMultihosts\Domain\Model\Color $color
     */
    public function getColor()
    {
        return $this->color;
    }
    
    /**
     * Sets the color
     *
     * @param \Iunctim\IuMultihosts\Domain\Model\Color $color
     * @return void
     */
    public function setColor(\Iunctim\IuMultihosts\Domain\Model\Color $color)
    {
        $this->color = $color;
    }
    
    /**
     * Returns the language
     *
     * @return \Iunctim\IuMultihosts\Domain\Model\Language $language
     */
    public function getLanguage()
    {
        return $this->language;
    }
    
    /**
     * Sets the language
     *
     * @param \Iunctim\IuMultihosts\Domain\Model\Language $language
     * @return void
     */
    public function setLanguage(\Iunctim\IuMultihosts\Domain\Model\Language $language)
    {
        $this->language = $language;
    }
    
    /**
     * Returns the extensions
     *
     * @return array $extensions
     */
    public function getExtensions()
    {
        return unserialize($this->extensions);
    }
    
    /**
     * Sets the extensions
     *
     * @param array $extensions
     * @return void
     */
    public function setExtensions(array $extensions)
    {
        $this->extensions = serialize($extensions);
    }
    
    /**
     * Returns the usergroup
     *
     * @return string $usergroup
     */
    public function getUsergroup()
    {
        return $this->usergroup;
    }
    
    /**
     * Sets the usergroup
     *
     * @param string $usergroup
     * @return void
     */
    public function setUsergroup($usergroup)
    {
        $this->usergroup = $usergroup;
    }
    
    /**
     * Returns the piwik
     *
     * @return string $piwik
     */
    public function getPiwik()
    {
        return $this->piwik;
    }
    
    /**
     * Sets the piwik
     *
     * @param string $piwik
     * @return void
     */
    public function setPiwik($piwik)
    {
        $this->piwik = $piwik;
    }

}

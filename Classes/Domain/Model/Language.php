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
 * Language
 */
class Language extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * locale
     *
     * @var string
     */
    protected $locale = '';
    
    /**
     * name
     *
     * @var string
     */
    protected $name = '';
    
    /**
     * localeall
     *
     * @var string
     */
    protected $localeall = '';
    
    /**
     * Returns the name
     *
     * @return string $name
     */
    public function getName()
    {
        return $this->name;
    }
    
    /**
     * Sets the name
     *
     * @param string $name
     * @return void
     */
    public function setName($name)
    {
        $this->name = $name;
    }
    
    /**
     * Returns the locale
     *
     * @return string $locale
     */
    public function getLocale()
    {
        return $this->locale;
    }
    
    /**
     * Sets the locale
     *
     * @param string $locale
     * @return void
     */
    public function setLocale($locale)
    {
        $this->locale = $locale;
    }
    
    /**
     * Returns the localeall
     *
     * @return string $localeall
     */
    public function getLocaleall()
    {
        return $this->localeall;
    }
    
    /**
     * Sets the localeall
     *
     * @param string $localeall
     * @return void
     */
    public function setLocaleall($localeall)
    {
        $this->localeall = $localeall;
    }

}
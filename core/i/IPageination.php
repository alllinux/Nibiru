<?php
namespace Nibiru;
/**
 * Created by PhpStorm.
 * User: mithril
 * Date: 15.09.18
 * Time: 03:17
 */

interface IPageination
{
    const CURRENT_PAGE              = 0;
    const PAGE_ITERATION            = 1;

    /**
     * @desc All the following methods have to be implemented into the class
     *      constructor of the class that extends pagination
     */

    /**
     * @return void
     */
    public static function setContentTable();

    /**
     * @return void
     */
    public static function loadPageNumber();
    
}
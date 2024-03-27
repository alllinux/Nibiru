<?php
namespace Nibiru;
/**
 * Created by PhpStorm.
 * User: kasdorf
 * Date: 08.12.17
 * Time: 11:05
 */

interface IPsql extends IMysql
{
    const PLACE_READONLY        = "readonly";
    const FILTER_COLUMN_NAME    = "COLUMN_NAME";
}
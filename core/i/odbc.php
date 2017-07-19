<?php
/**
 * Created by PhpStorm.
 * User: skasdorf
 * Date: 10.07.17
 * Time: 13:48
 */

namespace Nibiru;


interface IOdbc extends IMysql
{
    const PLACE_READONLY = "readonly";
    const FILTER_COLUMN_NAME = "COLUMN_NAME";
}
<?php
namespace Nibiru;
/**
 * User       - stephan
 * Date       - 01.02.17
 * Time       - 17:27
 * @author    - alllinux.de GbR
 * @category  - [PLEASE SPECIFIY]
 * @license   - BSD License
 */
interface IMysql
{
	const SETTINGS_DATABASE         = "DATABASE";

	const PLACE_NO_QUERY            = "NO QUERY";
	const NO_ID                     = false;
	const PLACE_TABLE_NAME          = "NO TABLENAME";
	const PLACE_ARRAY_NAME          = "NO ARRAY";
    const PLACE_QUERY_LIMIT	        = "NO LIMIT";
    const PLACE_SORT_ORDER	        = "NO ORDER";
	const PLACE_DSN                 = "NO CONNECTION STRING";
	const PLACE_IS_ACTIVE           = "is.active";
	const PLACE_USERNAME            = "username";
	const PLACE_PASSWORD            = "password";
	const PLACE_HOSTNAME            = "hostname";
	const PLACE_DRIVER              = "driver";
	const PLACE_DATABASE            = "basename";
	const PLACE_PORT                = "port";
    const PLACE_MULTI_THREADING     = "multithreading";
	const PLACE_CONNECTION          = "NO CONNECTION";
	const PLACE_PRIMARY_KEY         = "PRI";
	const PLACE_COLUMN_NAME         = "NO COLUMN NAME";
	const PLACE_SEARCH_TERM         = "NO SEARCH PARAMETER";
	const PLACE_FIELD_NAME	        = "NO FIELD NAME";
	const PLACE_WHERE_VALUE	        = "NO WHERE VALUE";
	const PLACE_DES_ENCRYPT         = false;
    const PLACE_ENCODING            = "encoding";
    const PLACE_SQL_UPDATE          = "UPDATE";
    const PLACE_SQL_INSERT          = "INSERT";

}
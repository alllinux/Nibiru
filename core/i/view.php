<?php
namespace Nibiru;
/**
 * User       - stephan
 * Date       - 24.01.17
 * Time       - 22:41
 * @author    - Stephan Kasdorf
 * @category  - [PLEASE SPECIFIY]
 * @license   - BSD License
 */
interface IView
{
    const NIBIRU_SETTINGS 	             = "SETTINGS";
    const NIBIRU_URL		             = "pageurl";
    const NIBIRU_ERROR 		             = "ERROR";
    const NIBIRU_SECURITY 	             = "SECURITY";
    const NIBIRU_ROUTING 	             = "ROUTING";
    const NIBIRU_EMAIL		             = "EMAIL";
    const NIBIRU_FILE_END 	             = ".tpl";
    const NIBIRU_CONTENT_TYPE_JSON       = "Content-Type: application/json";
    const NIBIRU_CONTENT_TYPE_CONNECTION = "Connection: keep-alive";
    const NIBIRU_CONTENT_RESPONSE_OK     = "HTTP/1.1 200 OK";
}
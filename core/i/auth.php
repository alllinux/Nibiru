<?php
namespace Nibiru;
/**
 * User       - stephan
 * Date       - 01.02.17
 * Time       - 17:18
 * @author    - alllinux.de GbR
 * @category  - [PLEASE SPECIFIY]
 * @license   - BSD License
 */
interface IAuth
{
	const NIBIRU_SECURITY = "SECURITY";

	public function auth( $username, $password );

}
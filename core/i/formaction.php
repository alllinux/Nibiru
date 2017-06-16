<?php
namespace Nibiru;
/**
 * User       - stephan
 * Date       - 24.01.17
 * Time       - 14:39
 * @author    - Stephan Kasdorf
 * @category  - [PLEASE SPECIFIY]
 * @license   - BSD License
 */
interface IFormaction
{
	public function getPostData();

	public function getGetData();

	public function getRequestData();

	public function saveData();
}
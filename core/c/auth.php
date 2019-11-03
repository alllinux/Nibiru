<?php
namespace Nibiru;
/**
 * User       - stephan
 * Date       - 01.02.17
 * Time       - 17:20
 * @author    - alllinux.de GbR
 * @category  - [PLEASE SPECIFIY]
 * @license   - BSD License
 */
class Auth extends Controller implements IAuth
{
	private static $_instance;

	private $_password_salt = "";
	private $_username      = "";
	private $_password      = "";

	protected function __construct()
	{
		parent::__construct();
		$this->_setPasswordSalt();

	}

	public static function getInstance()
	{
		$className = get_called_class();
		if( self::$_instance == null )
		{
			self::$_instance = new $className();
		}
		return self::$_instance;
	}

	public function auth( $login, $password )
	{
		// TODO: Implement auth($username, $password) method.
        $this->_setPassword($password);
        $this->_setUsername($login);

		if(!array_key_exists('auth', $_SESSION))
		{
			$user_password = Pdo::query("SELECT DES_DECRYPT(user_pass, '".Config::getInstance()->getConfig()["SECURITY"]["password_hash"]."') AS pass FROM user WHERE user_login = '".$login."';");
			if( $user_password["pass"] == $password )
			{
				$session_id = session_id();
				$_SESSION['auth']['id']	   		 = $session_id;
				$_SESSION['auth']['login'] 		 = $login;
				return true;
			}
			else
			{
				return false;
			}
		}
	}

	/**
	 * @return string
	 */
	protected function getPasswordSalt()
	{
		return $this->_password_salt;
	}

	/**
	 * @param string $password_salt
	 */
	private function _setPasswordSalt( )
	{
		$this->_password_salt = $this->getConfig()[self::NIBIRU_SECURITY];
	}

	/**
	 * @return string
	 */
	protected function getUsername()
	{
		return $this->_username;
	}

	/**
	 * @param string $username
	 */
	private function _setUsername( $username )
	{
		$this->_username = $username;
	}

	/**
	 * @return string
	 */
	protected function getPassword()
	{
		return $this->_password;
	}

	/**
	 * @param string $password
	 */
	private function _setPassword( $password )
	{
		$this->_password = $password;
	}

    /**
     * This should be part of any extended controller
     * class in order to implement a page structure
     * @return array
     */
    public function pageAction()
    {
        // TODO: Implement pageAction() method.
    }

    /**
     * This is the part where you can add titles to
     * your page navigation.
     */
    public function navigationAction()
    {
        // TODO: Implement navigationAction() method.
    }
}
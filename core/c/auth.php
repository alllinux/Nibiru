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

    /**
     * Auth constructor.
     */
    protected function __construct()
    {
        parent::__construct();
        $this->_setPasswordSalt();

    }

    /**
     * @return View
     */
    public static function getInstance(): View
    {
        $className = get_called_class();
        if( self::$_instance == null )
        {
            self::$_instance = new $className();
        }
        return self::$_instance;
    }

    /**
     * @param $login
     * @param $password
     * @return bool
     */
    public function auth( $login, $password ): bool
    {
        // TODO: Implement auth($username, $password) method.
        $this->_setPassword($password);
        $this->_setUsername($login);
        if(!array_key_exists('auth', $_SESSION) || $_SESSION['auth'] == null)
        {
            $user_password = Pdo::query("SELECT user_account_active, AES_DECRYPT(user_pass, '".Config::getInstance()->getConfig()[IView::NIBIRU_SECURITY]["password_hash"]."') AS pass, user_id FROM user WHERE user_login = '".$login."';");
            if( $user_password["pass"] == $password && $user_password['user_account_active'] == 1 )
            {
                $session_id = session_id();
                $_SESSION = [
                    'auth' => [
                        'session_id' => $session_id,
                        'user_id'    => $user_password['user_id'],
                        'login'      => $login
                    ]
                ];
                return true;
            }
            else
            {
                return false;
            }
        }
        else
        {
            if($_SESSION['auth']['login'] == $login)
            {
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
}
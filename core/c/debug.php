<?php
namespace Nibiru;
/**
 * Created by PhpStorm.
 * User: stephan
 * Date: 24.01.17
 * Time: 12:31
 *
 */
final class Debug
{
    /**
     * class wide constances
     */
    use Messages;

    /**
     * @var debug variables currently only super globals
     *
     */
    private $_raw_output;
    private $_request_data;
    private $_server_data;
    private $_post_data;
    private $_get_data;
    private $_files_data;
    private $_cookie_data;
    private $_session_data;
    private $_env_data;
    private $_globals_data;

    public function __construct()
    {
        Controller::getInstance()->varname(View::getInstance()->getEngine(), array('ndbinfo' => Messages::msg_bottom_bar()));
        $this->_setRequestData();
        $this->_setPostData();
        $this->_setGetData();
        $this->_setCookieData();
        $this->_setEnvData();
        $this->_setGlobalsData();
        $this->_setSessionData();
        $this->_setFilesData();
        $this->_setServerData();
    }

    /**
     * Call this method to get singleton
     * @return Debug
     */
    public static function getInstance()
    {
        static $instance = null;
        if ($instance === null)
        {
            $instance = new Debug();
        }
        return $instance;
    }

    public function toDebug( $data )
    {
        try {
            $this->_setRawOutput( $data );
        } catch(Exception $e)
        {
            throw new Exception("ERROR: No data for debugging handled!");
        }
    }

    /**
     * @return mixed
     */
    protected function getRawOutput()
    {
        return $this->_raw_output;
    }

    /**
     * @param mixed $raw_output
     */
    private function _setRawOutput($raw_output=false)
    {
        if(sizeof($raw_output)>0)
        {
            $this->_raw_output = $raw_output;
        }
        else
        {
            $this->_raw_output = Messages::msg_raw_output();
        }
        Controller::getInstance()->varname( View::getInstance()->getEngine(), array('ndbraw_output' => $this->getRawOutput()) );
    }

    /**
     * @return mixed
     */
    private function getGetData()
    {
        return $this->_get_data;
    }

    /**
     * @param mixed $get_data
     */
    private function _setGetData()
    {
        if(sizeof($_GET)>0)
        {
            $this->_get_data = '<pre>' . print_r($_GET, true) . '</pre>';
        }
        else
        {
            $this->_get_data = Messages::msg_get();
        }
        Controller::getInstance()->varname( View::getInstance()->getEngine(), array('ndbget' => $this->getGetData()) );
    }

    /**
     * @return mixed
     */
    private function getFilesData()
    {
        return $this->_files_data;
    }

    /**
     * @param mixed $files_data
     */
    private function _setFilesData()
    {
        if(sizeof($_FILES)>0)
        {
            $this->_files_data = '<pre>' . print_r($_FILES, true) . '</pre>';
        }
        else
        {
            $this->_files_data = Messages::msg_files();
        }
        Controller::getInstance()->varname( View::getInstance()->getEngine(), array('ndbfiles' => $this->getFilesData()) );
    }

    /**
     * @return mixed
     */
    private function getCookieData()
    {
        return $this->_cookie_data;
    }

    /**
     * @param mixed $cookie_data
     */
    private function _setCookieData()
    {
        if(sizeof($_COOKIE)>0)
        {
            $this->_cookie_data = '<pre>' . print_r($_COOKIE, true) . '</pre>';
        }
        else
        {
            $this->_cookie_data = Messages::msg_cookie();
        }
        Controller::getInstance()->varname( View::getInstance()->getEngine(), array('ndbcookie' => $this->getCookieData()) );
    }

    /**
     * @return mixed
     */
    private function getSessionData()
    {
        return $this->_session_data;
    }

    /**
     * @param mixed $session_data
     */
    private function _setSessionData()
    {
        if(sizeof($_SESSION)>0)
        {
            $this->_session_data = '<pre>' . print_r($_SESSION, true) . '</pre>';
        }
        else
        {
            $this->_session_data = Messages::msg_cookie();
        }
        Controller::getInstance()->varname( View::getInstance()->getEngine(), array('ndbsession' => $this->getSessionData()) );
    }

    /**
     * @return mixed
     */
    private function getEnvData()
    {
        return $this->_env_data;
    }

    /**
     * @param mixed $env_data
     */
    private function _setEnvData()
    {
        if(sizeof($_ENV)>0)
        {
            $this->_env_data = '<pre>' . print_r($_ENV, true) . '</pre>';
        }
        else
        {
            $this->_env_data = Messages::msg_env();
        }
        Controller::getInstance()->varname( View::getInstance()->getEngine(), array('ndbenv' => $this->getEnvData()) );
    }

    /**
     * @return mixed
     */
    private function getGlobalsData()
    {
        return $this->_globals_data;
    }

    /**
     * @param mixed $globals_data
     */
    private function _setGlobalsData()
    {
        if(sizeof($GLOBALS)>0)
        {
            $this->_globals_data = '<pre>' . print_r($GLOBALS, true) . '</pre>';
        }
        else
        {
            $this->_globals_data = Messages::msg_globals();
        }
        Controller::getInstance()->varname( View::getInstance()->getEngine(), array('ndbglobals' => $this->getGlobalsData()) );
    }

    /**
     * @return mixed
     */
    private function getPostData()
    {
        return $this->_post_data;
    }

    /**
     * @param mixed $post_data
     */
    private function _setPostData()
    {
        if(sizeof($_POST)>0)
        {
            $this->_post_data = '<pre>' . print_r($_POST, true) . '</pre>';
        }
        else
        {
            $this->_post_data = Messages::msg_post();
        }
        Controller::getInstance()->varname( View::getInstance()->getEngine(), array('ndbpost' => $this->getPostData()) );
    }


    /**
     * @desc loads the request data to the
     *       debugbar
     */
    private function _setRequestData()
    {
        if(sizeof($_REQUEST)>0)
        {
            $this->_request_data = '<pre>' . print_r($_REQUEST, true) . '</pre>';
        }
        else
        {
            $this->_request_data = Messages::msg_request();
        }
        Controller::getInstance()->varname( View::getInstance()->getEngine(), array('ndbrequest' => $this->getRequestData()) );
    }
    private function getRequestData()
    {
        return $this->_request_data;
    }

    /**
     * @desc loads the server data array to the
     *       debugbar
     */
    private function _setServerData()
    {
        if(sizeof($_SERVER)>0)
        {
            $this->_server_data = '<pre>' . print_r($_SERVER, true) . '</pre>';
        }
        else
        {
            $this->_server_data = Messages::msg_server();
        }
        Controller::getInstance()->varname( View::getInstance()->getEngine(), array('ndbserver' => $this->getServerData() ));
    }
    private function getServerData()
    {
        return $this->_server_data;
    }
}
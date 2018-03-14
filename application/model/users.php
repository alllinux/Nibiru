<?php
namespace Nibiru\Model;
use Nibiru\Adapter\Db;
use Nibiru\Pdo;
/**
 * Created by PhpStorm.
 * User: kasdorf
 * Date: 21.11.17
 * Time: 11:22
 */

class User extends Db
{
    const TALBE = array(
        'table' => 'user',
        'field' => array(
            'user_id'               => 'user_id',
            'user_name'             => 'user_name',
            'user_pass'             => 'user_pass',
            'user_email'            => 'user_email',
            'user_firstname'        => 'user_firstname',
            'user_login'            => 'user_login',
            'user_account_active'   => 'user_account_active'
        )
    );
    
    public function __construct()
    {
        self::initTable( self::TABLE );
    }

    public function selectRowsetById($id = false)
    {
        $id = array(
                        self::TABLE['field']['user_id'] => $id
        );
        return Pdo::fetchRowInArrayById(
                                            self::TABLE['table'], $id
        );
    }
    /**
     * @desc saves user data to the user table in the database
     * @param $userdata
     */
    public function saveUserDataToTable( $userdata )
    {
        $insert = array();
        foreach ($userdata as $key=>$entry)
        {
            if(array_key_exists($key, self::TALBE['field']))
            {
                $insert[$key] = $entry;
            }
        }
        $this->insertArrayIntoTable($insert, 'user_pass');
    }
}
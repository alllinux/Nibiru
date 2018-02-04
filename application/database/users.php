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

class Users extends Db 
{
    const TABLE = array(
        'table' => 'user',
        'field'    => array(
                                'user_id'       => 'user_id',
                                'user_name'     => 'user_name',
                                'user_pass'     => 'user_pass',
                                'user_active'   => 'user_active',
                                'user_date'     => 'user_date'
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

}
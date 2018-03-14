<?php
namespace Nibiru\Attributes;
use Nibiru\Settings;
use Nibiru\View;
/**
 * Created by PhpStorm.
 * User: mithril
 * Date: 07.02.18
 * Time: 22:52
 */

trait Form
{
    protected static function loadAttributeValues( $attributes = array() )
    {
        $attributKeys = array_keys( $attributes );
        foreach($attributKeys as $key)
        {
            switch ($key)
            {
                case 'id':
                    $attributes['id'] = ' id="'.$attributes['id'].'"';
                    break;
                case 'class':
                    $attributes['class'] = ' class="'.$attributes['class'].'"';
                    break;
                case 'form':
                    $attributes['form'] = ' form="'.$attributes['form'].'"';
                    break;
            }
        }
        return $attributes;
    }
    
    protected static function errorMessage( $filename, $line )
    {
        $file = parse_ini_file( Settings::SETTINGS_PATH . 'error.message.ini', View::NIBIRU_ERROR);
        return $file[View::NIBIRU_ERROR][$filename][$line];
    }
    
    protected static function exceptionMessage( $exceptoin )
    {
        echo '<pre>';
        print_r( $exceptoin->getMessage() . '<br>FILENAME: ' . $exceptoin->getFile() . '<br>LINENUMBER: ' . $exceptoin->getLine() );
        echo '</pre>';
    }
}
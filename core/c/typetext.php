<?php
namespace Nibiru\Form;
use Nibiru\Adapter;

/**
 * Created by PhpStorm.
 * User: mithril
 * Date: 26.01.18
 * Time: 21:42
 */

class TypeText implements IForm
{
    private $_attributes = array(
        self::FORM_NAME  => '',
        self::FORM_VALUE => '',
        self::FORM_ATTRIBUTE_SPEECH => ''
    );

    private $_element;
    
    public function loadElement( $attributes )
    {
        if(!array_key_exists('speech', $attributes))
        {
            $attributes['speech'] = '';
        }
        else
        {
            $attributes['speech'] = ' x-webkit-speech';
        }
        $this->_setElement();
        $this->_setAttributes( $attributes );
        return $this->getElement();
    }

    /**
     * @return array
     */
    protected function getAttributes( )
    {
        return $this->_attributes;
    }

    /**
     * @param array $attributes
     */
    private function _setAttributes( $attributes )
    {
        foreach( $attributes as $key=>$entry )
        {
            switch ($key)
            {
                case array_key_exists($key, $this->_attributes):
                    $this->_element = str_replace(strtoupper($key), $entry, $this->getElement());
                break;
            }
        }
    }

    /**
     * @return mixed
     */
    protected function getElement( )
    {
        return $this->_element;
    }

    /**
     * @param mixed $element
     */
    private function _setElement( )
    {
        $this->_element = '<input type="text" name="NAME" value="VALUE"SPEECH>' . "\n";
    }
    
    

}
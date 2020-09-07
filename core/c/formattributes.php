<?php
namespace Nibiru\Form;
/**
 * Created by PhpStorm.
 * User: mithril
 * Date: 07.02.18
 * Time: 21:57
 */
class FormAttributes
{

    private $_attributes = array();
    protected $_element;

    use \Nibiru\Attributes\Form;

    public function __construct( $attributes = false )
    {
        if($attributes)
        {
            try {
                if( is_array( $attributes ) )
                {
                    $this->_attributes = $attributes;
                }
                else
                {
                    throw new \Exception( self::errorMessage( str_replace('.php', '', basename( __FILE__ )), __LINE__ ) );
                }
            } catch (\Exception $e)
            {
                self::exceptionMessage( $e );
            }
        }
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
    protected function _setAttributes( $attributes )
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
        $this->_element = str_replace(' ID', '', $this->_element);
        $this->_element = str_replace(' CLASS', '', $this->_element);
        $this->_element = str_replace(' enctype="ENCTYPE"', '', $this->_element);
        $this->_element = str_replace(' checked="CHECKED"', '', $this->_element);
        $this->_element = str_replace(' onsubmit="ONSUBMIT"', '', $this->_element);
        $this->_element = str_replace(' onclick="ONCLICK"', '', $this->_element);
        $this->_element = str_replace(' action="ACTION"', '', $this->_element);
        $this->_element = str_replace(' maxlength="MAXLENGTH"', '', $this->_element);
        $this->_element = str_replace(' tabindex="TABINDEX"', '', $this->_element);
        $this->_element = str_replace(' SPEECH', '', $this->_element);
        $this->_element = str_replace(' FORM', '', $this->_element);
        $this->_element = str_replace(' placeholder="PLACEHOLDER"', '', $this->_element);
        $this->_element = str_replace(' required="REQUIRED"', '', $this->_element);
        $this->_element = str_replace(' value="VALUE"', '', $this->_element);
        $this->_element = str_replace(' name="NAME"', '', $this->_element);
        $this->_element = str_replace('  ', ' ', $this->_element);
        $this->_element = str_replace(' type="TYPE"', '', $this->_element);
        $this->_element = str_replace(' onchange="ONCHANGE"', '', $this->_element);
        $this->_element = str_replace(' target="TARGET"', '', $this->_element);
        $this->_element = str_replace(' method="METHOD"', '', $this->_element);
        $this->_element = str_replace(' data-toggle="DATA-TOGGLE"', '', $this->_element);
        $this->_element = str_replace(' SELECTED', '', $this->_element);
        $this->_element = str_replace(' CONTEXT', '', $this->_element);
        $this->_element = str_replace(' CHECKED', '', $this->_element);
        $this->_element = str_replace(' VALUE', '', $this->_element);
    }

    /**
     * @return mixed
     */
    protected function getElement( )
    {
        return $this->_element;
    }
}

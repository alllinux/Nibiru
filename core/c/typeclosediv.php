<?php
namespace Nibiru\Form;
use Nibiru\Adapter;
/**
 * Copyright 2020 Nibiru Framework
 * Licence:     BSD 4-Old License
 * Author:      Stephan Kasdorf
 * File:        typeclosediv.php
 * Date:        05.09.20
 */
class TypeCloseDiv extends FormAttributes implements IForm
{
    /**
     * @param $attributes
     * @return mixed
     */
    public function loadElement($attributes)
    {
        parent::__construct( );
        $this->_setElement();
        return $this->getElement();
    }

    /**
     * just a closing div element
     */
    private function _setElement( )
    {
        $this->_element = '</div>' . "\n";
    }
}
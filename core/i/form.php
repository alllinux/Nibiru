<?php
namespace Nibiru\Form;
/**
 * Created by PhpStorm.
 * User: mithril
 * Date: 26.01.18
 * Time: 20:59
 */

interface IForm
{
    /**
     * @desc Constant Form attributes
     */
    const FORM_NAME                 = 'name';
    const FORM_VALUE                = 'value';
    const FORM_METHOD               = 'method';
    const FORM_METHOD_TYPE          = array('post', 'get');
    const FORM_ACTION               = 'action';
    const FORM_TARGET               = 'target';
    const FORM_TARGET_TYPE          = array('_blank', '_self', '_parent', '_top');
    const FORM_TYPE_TEXT            = 'text';
    const FORM_TYPE_SUBMIT          = 'submit';
    const FORM_TYPE_BUTTON          = 'button';
    const FORM_ATTRIBUTE_ROWS       = 'rows';
    const FORM_ATTRIBUTE_COLS       = 'cols';
    const FORM_ATTRIBUTE_SPEECH     = 'speech';
    const FORM_ATTRIBUTE_SRC        = 'src';
    const FORM_ATTRIBUTE_ALT        = 'alt';
    const FORM_ATTRIBUTE_ID         = 'id';
    
    /**
     * @desc loads the current Form element to the form
     * @param $element
     * @return mixed
     */
    public function loadElement( $attributes );
}
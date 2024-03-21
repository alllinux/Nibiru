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
    const FORM_NAME                     = 'name';
    const FORM_VALUE                    = 'value';
    const FORM_METHOD                   = 'method';
    const FORM_METHOD_TYPE              = array('post', 'get');
    const FORM_ACTION                   = 'action';
    const FORM_TARGET                   = 'target';
    const FORM_ENCTYPE                  = 'enctype';
    const FORM_TARGET_TYPE              = array('_blank', '_self', '_parent', '_top');
    const FORM_TYPE_TEXT                = 'text';
    const FORM_TYPE_SUBMIT              = 'submit';
    const FORM_TYPE_BUTTON              = 'button';
    const FORM_ATTRIBUTE_ROWS           = 'rows';
    const FORM_ATTRIBUTE_COLS           = 'cols';
    const FORM_ATTRIBUTE_MIN            = 'min';
    const FORM_ATTRIBUTE_MAX            = 'max';
    const FORM_ATTRIBUTE_STEP           = 'step';
    const FORM_ATTRIBUTE_SPEECH         = 'speech';
    const FORM_ATTRIBUTE_SRC            = 'src';
    const FORM_ATTRIBUTE_ALT            = 'alt';
    const FORM_ATTRIBUTE_ID             = 'id';
    const FORM_ATTRIBUTE_CLASS          = 'class';
    const FORM_ATTRIBUTE_FOR            = 'for';
    const FORM_ATTRIBUTE_FORM           = 'form';
    const FORM_ATTRIBUTE_PLACEHOLDER    = 'placeholder';
    const FORM_ATTRIBUTE_REQUIRED       = 'required';
    const FORM_ATTRIBUTE_TYPE           = 'type';
    const FORM_ATTRIBUTE_ONCHANGE       = 'onchange';
    const FORM_ATTRIBUTE_ONSUBMIT       = 'onsubmit';
    const FORM_ATTRIBUTE_ONBLUR         = 'onblur';
    const FORM_ATTRIBUTE_ONFOCUS        = 'onfocus';
    const FORM_ATTRIBUTE_ONCLICK        = 'onclick';
    const FORM_ATTRIBUTE_SELECTED       = 'selected';
    const FORM_ATTRIBUTE_CONTEXT        = 'context';
    const FORM_ATTRIBUTE_CHECKED        = 'checked';
    const FORM_ATTRIBUTE_MAXLENGTH      = 'maxlength';
    const FORM_ATTRIBUTE_TABINDEX       = 'tabindex';
    const FORM_ATTRIBUTE_DISABLED       = 'disabled';
    const FORM_ATTRIBUTE_PATTERN        = 'pattern';
    const FORM_ATTRIBUTE_ANY            = 'any';
    const FORM_ATTRIBUTE_HREF           = 'href';
    const FORM_ATTRIBUTE_TS_DECIMALS    = "data-bts-decimals";
    const FORM_ATTRIBUTE_TS_STEPS       = "data-bts-step";

    /**
     * @desc loads the current Form element to the form
     * @param $attributes
     * @return mixed
     */
    public function loadElement( $attributes );
}
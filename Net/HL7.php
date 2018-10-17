<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
// +----------------------------------------------------------------------+
// | PHP version 5                                                        |
// +----------------------------------------------------------------------+
// | Copyright (c) 2004 D.A.Dokter                                        |
// +----------------------------------------------------------------------+
// | This source file is subject to version 3.0 of the PHP license,       |
// | that is bundled with this package in the file LICENSE, and is        |
// | available through the world-wide-web at the following url:           |
// | http://www.php.net/license/3_0.txt.                                  |
// | If you did not receive a copy of the PHP license and are unable to   |
// | obtain it through the world-wide-web, please send a note to          |
// | license@php.net so we can mail you a copy immediately.               |
// +----------------------------------------------------------------------+
// | Authors: D.A.Dokter <dokter@w20e.com>                                |
// +----------------------------------------------------------------------+
//
// $Id: HL7.php,v 1.7 2004/08/06 07:38:54 wyldebeast Exp $

/**
 * The Net_HL7 class is a factory class for HL7 messages.
 *
 * The factory class provides the convenience of changing several
 * defaults for HL7 messaging globally, like separators, etc. Note
 * that some default settings use characters that have special meaning
 * in PHP, like the HL7 escape character. To be able to set these
 * values, escape the special characters.
 *
 * @category Networking
 * @package  Net_HL7
 * @author   D.A.Dokter <dokter@w20e.com>
 * @license  http://www.php.net/license/3_0.txt  PHP License 3.0
 * @version  0.1.0
 * @access   public
 */
class Net_HL7
{

    /**
     * Holds all global HL7 settings.
     */
    var $_hl7Globals = array();


    /**
     * Create a new instance of the HL7 factory, and set global
     * defaults.
     */
    public function __construct()
    {

        $this->_hl7Globals['SEGMENT_SEPARATOR'] = '\015';
        $this->_hl7Globals['FIELD_SEPARATOR'] = '|';
        $this->_hl7Globals['NULL'] = '""';
        $this->_hl7Globals['COMPONENT_SEPARATOR'] = '^';
        $this->_hl7Globals['REPETITION_SEPARATOR'] = '~';
        $this->_hl7Globals['ESCAPE_CHARACTER'] = '\\';
        $this->_hl7Globals['SUBCOMPONENT_SEPARATOR'] = '&';
        $this->_hl7Globals['HL7_VERSION'] = '2.2';
    }


    /**
     * Create a new Net_HL7_Message, using the global HL7 variables as
     * defaults.
     *
     * @param string $msgStr Text representation of an HL7 message
     *
     * @return object Net_HL7_Message
     */
    public function createMessage($msgStr = "")
    {
        return new Net_HL7_Message($msgStr, $this->_hl7Globals);
    }


    /**
     * Create a new Net_HL7_Segments_MSH segment, using the global HL7
     * variables as defaults.
     *
     * @return object Net_HL7_Segments_MSH
     */
    function createMSH()
    {
        return new Net_HL7_Segments_MSH($this->_hl7Globals);
    }


    /**
     * Set the component separator to be used by the factory. Should
     * be a single character. Default ^
     *
     * @param string $value Component separator char.
     *
     * @return boolean true if value has been set.
     */
    public function setComponentSeparator($value)
    {
        if (strlen($value) != 1) {
            return false;
        }

        return $this->_setGlobal('COMPONENT_SEPARATOR', $value);
    }


    /**
     * Set the subcomponent separator to be used by the factory. Should
     * be a single character. Default: &
     *
     * @param string $value Subcomponent separator char.
     *
     * @return boolean true if value has been set.
     */
    public function setSubcomponentSeparator($value)
    {
        if (strlen($value) != 1) {
            return false;
        }

        return $this->_setGlobal('SUBCOMPONENT_SEPARATOR', $value);
    }


    /**
     * Set the repetition separator to be used by the factory. Should
     * be a single character. Default: ~
     *
     * @param string $value Repetition separator char.
     *
     * @return boolean true if value has been set.
     */
    public function setRepetitionSeparator($value)
    {
        if (strlen($value) != 1) {
            return false;
        }

        return $this->_setGlobal('REPETITION_SEPARATOR', $value);
    }


    /**
     * Set the field separator to be used by the factory. Should
     * be a single character. Default: |
     *
     * @param string $value Field separator char.
     *
     * @return boolean true if value has been set.
     */
    public function setFieldSeparator($value)
    {
        if (strlen($value) != 1) {
            return false;
        }

        return $this->_setGlobal('FIELD_SEPARATOR', $value);
    }


    /**
     * Set the segment separator to be used by the factory. Should
     * be a single character. Default: \015
     *
     * @param string $value Segment separator char.
     *
     * @return boolean true if value has been set.
     */
    public function setSegmentSeparator($value)
    {
        if (strlen($value) != 1) {
            return false;
        }

        return $this->_setGlobal('SEGMENT_SEPARATOR', $value);
    }


    /**
     * Set the escape character to be used by the factory. Should
     * be a single character. Default: \
     *
     * @param string $value Escape character.
     *
     * @return boolean true if value has been set.
     */
    public function setEscapeCharacter($value)
    {
        if (strlen($value) != 1) {
            return false;
        }

        return $this->_setGlobal('ESCAPE_CHARACTER', $value);
    }


    /**
     * Set the HL7 version to be used by the factory.
     *
     * @param string $value HL7 version character.
     *
     * @return boolean true if value has been set.
     */
    public function setHL7Version($value)
    {
        return $this->_setGlobal('HL7_VERSION', $value);
    }


    /**
     * Set the NULL string to be used by the factory.
     *
     * @param string $value NULL string.
     *
     * @return boolean true if value has been set.
     */
    public function setNull($value)
    {
        return $this->_setGlobal('NULL', $value);
    }


    /**
     * Convenience method for obtaining the special NULL value.
     *
     * @return string null value
     */
    public function getNull() 
    {

        return $this->_hl7Globals['NULL'];
    }


    /**
     * Set the HL7 global variable
     *
     * @param string $name  name
     * @param string $value value
     *
     * @return boolean True when value has been set, false otherwise.
     */
    private function _setGlobal($name, $value)
    {
        $this->_hl7Globals[$name] = $value;

        return true;
    }

}

<?php namespace ProcessWire;

/**
 * Class InputfieldHelper
 *
 * @author			: İskender TOTOĞLU, @ukyo (community), @trk (Github)
 * @website			: https://www.altivebir.com
 * @projectWebsite	: https://github.com/trk/InputfieldHelper
 */
class InputfieldHelper extends ModuleConfig implements Module {

    /**
     * InputfieldWrapper
     *
     * @var null
     */
    public $wrapper = null;

    /**
     * Inputfield Name Prefix
     *
     * @var string
     */
    public $name_prefix = "";

    /**
     * Inputfield Name Suffix
     *
     * @var string
     */
    public $name_suffix = "";

    /**
     * Inputfield ID Prefix
     *
     * @var string
     */
    public $id_prefix = "";

    /**
     * Inputfield ID Suffix
     *
     * @var string
     */
    public $id_suffix = "";

    /**
     * Inputfields Values
     *
     * array(
     *  "key" => "value"
     * )
     *
     * @var array
     */
    public $values = array();

    /**
     * Module info
     *
     * @see Module
     * @return array
     */
    public static function getModuleInfo() {
        return array(
            "title" => "InputfieldHelper",
            "version" => 2,
            "summary" => __("This module extends base `ModuleConfig` class add some features to this class."),
            "href" => "https://github.com/trk/InputfieldHelper",
            "author" => "İskender TOTOĞLU | @ukyo(community), @trk (Github), https://www.altivebir.com",
            "requires" => array(
                "ProcessWire>=3.0.0"
            ),
            // "installs" => array(),
            // "permanent" => false
            // "permission" => "permission-name",
            // "permissions" => array()
            "icon" => "steam",
            // "singular" => false,
            // "autoload" => false
        );
    }

    // ------------------------------------------------------------------------

    /**
     * Populate the default config data
     *
     * WireMailPHPMailer constructor.
     */
    public function __construct() {

    }

    // ------------------------------------------------------------------------

    /**
     * Return an InputfieldWrapper of Inputfields necessary to configure this module
     *
     * Values will be populated to the Inputfields automatically. However, you may also retrieve
     * any of the values from $this->[property]; as needed.
     *
     * Descending classes should call this method at the top of their getInputfields() method.
     *
     * Use this method only if defining Inputfield objects programatically. If definining via
     * an array then you should not implement this method.
     *
     * @return InputfieldWrapper
     * @throws WireException
     */
    public function getInputfields() {
        foreach($this->getDefaults() as $key => $value) {
            $this->set($key, $value);
        }

        if(is_null($this->wrapper)) $inputfields = $this->wire(new InputfieldWrapper());
        else $inputfields = $this->wrapper;

        if(count($this->inputfieldsArray)) {
            $inputfieldsArray = $this->prepareInputfields($this->inputfieldsArray);
            $inputfields->add($inputfieldsArray);
        }
        return $inputfields;
    }

    // ------------------------------------------------------------------------

    /**
     * Prepare $this->inputfieldsArray for render
     *
     * @param array $inputfields
     * @return array
     */
    public function prepareInputfields($inputfields = array()) {
        if(count($inputfields)) {
            foreach ($inputfields as $key => $inputfield) {
                $children = $this->element("children", $inputfield, array());

                $id = $this->element("id", $inputfield, $key);
                $name = $this->element("name", $inputfield, $key);
                $value = $this->element($key, $this->values, $this->element("value", $inputfield, ""));

                $inputfields[$key]["id"] = $this->id_prefix . $id . $this->id_suffix;
                $inputfields[$key]["name"] = $this->name_prefix . $name . $this->name_suffix;
                $inputfields[$key]["value"] = $value;

                if($showIf = $this->element('showIf', $inputfield, '')) {
                    $inputfields[$key]["showIf"] = $this->showIf($showIf);
                }
                if(count($children)) $inputfields[$key]["children"] = $this->prepareInputfields($children);
            }
        }
        return $inputfields;
    }

    // ------------------------------------------------------------------------

    /**
     * Prepare showIf condition for Fieldset and Field
     *
     * @param $showIf
     * @return string
     */
    protected function showIf($showIf) {
        if(is_array($showIf) && count($showIf)) {
            $i = 1;
            $separator = ', ';
            $if = '';
            foreach ($showIf as $key => $condition) {
                $x = $i++;
                $if .= $this->name_prefix . $key . $this->name_suffix . $condition;
                if($x < count($showIf)) $if .= $separator;
            }
            return $if;
        } else {
            return $showIf;
        }
    }

    // ------------------------------------------------------------------------

    /**
     * Element
     *
     * Lets you determine whether an array index is set and whether it has a value.
     * If the element is empty it returns NULL (or whatever you specify as the default value.)
     *
     * @param	string
     * @param	array
     * @param	mixed
     * @return	mixed	depends on what the array contains
     */
    public function element($item, array $array, $default = NULL) {
        return array_key_exists($item, $array) && $array[$item] ? $array[$item] : $default;
    }
}
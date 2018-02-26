<?php namespace ProcessWire;

/**
 * Class WirePHPMailer
 *
 * @author			: İskender TOTOĞLU, @ukyo (community), @trk (Github)
 * @website			: https://www.altivebir.com
 * @projectWebsite	: https://github.com/trk/InputfieldHelper
 */
class InputfieldHelper extends WireData implements Module, ConfigurableModule {

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
     * Module Configs
     *
     * @var array
     */
    protected $configs = array();

    /**
     * Module Configs Defaults
     *
     * @var array
     */
    protected $defaults = array();

    /**
     * Module info
     *
     * @return array
     */
    public static function getModuleInfo() {
        return array(
            "title" => "InputfieldHelper",
            "summary" => "This module creates Inputfields from config file.",
            "version" => 1,
            "author" => "İskender TOTOĞLU | @ukyo(community), @trk (Github), https://www.altivebir.com",
            "icon" => "envelope-o",
            "href" => "https://github.com/trk/InputfieldHelper",
            "autoload" => true,
            "singular" => true
        );
    }

    // ------------------------------------------------------------------------

    /**
     * Populate the default config data
     *
     * WireMailPHPMailer constructor.
     */
    public function __construct() {
        $this->configs = $this->getModuleConfigs($this->className);
        $this->defaults = $this->getDefaults($this->configs);
        foreach($this->defaults as $key => $value) {
            $this->$key = $value;
        }
    }

    // ------------------------------------------------------------------------

    /**
     * Initialize the module
     */
    public function init() {

    }

    // ------------------------------------------------------------------------

    /**
     * Return configs file for given path
     *
     * @param string $path
     * @return mixed
     */
    public function getConfigs($path = "") {
        if(file_exists($path)) return include $path;
        return array();
    }

    // ------------------------------------------------------------------------

    /**
     * Get module configs
     *
     * @return array
     */
    public function getModuleConfigs($module_name = "", $filename = "") {
        $filename = $filename ? $filename : $module_name . ".configs";
        $path = $this->config->path($module_name) . $filename . ".php";
        if(file_exists($path)) {
            return include $path;
        }
        return array();
    }

    // ------------------------------------------------------------------------

    /**
     * Get config defaults
     *
     * @param array $fields
     * @return array
     */
    public function getDefaults($fields = array()) {
        $return = array();
        if(is_array($fields) && count($fields)) {
            foreach ($fields as $key => $inputfield) {
                if(is_array($inputfield)) {
                    $type = $this->element('type', $inputfield);
                    $children = $this->element('fields', $inputfield);
                    if($type == 'InputfieldFieldset' && count($children)) {
                        $return = array_merge($return, $this->getDefaults($children));
                    } else {
                        $return[$key] = $this->element("default", $inputfield, "");
                    }
                }
            }
        }
        return $return;
    }

    // ------------------------------------------------------------------------

    /**
     * Build Inputfields
     *
     * @param array $fields
     * @param null $wrapper
     * @param array $data
     * @return null|InputfieldWrapper
     * @throws WireException
     * @throws WirePermissionException
     */
    public function buildInputfields($fields = array(), $wrapper = null, $data = array()) {
        $wrapper = is_null($wrapper) ? new InputfieldWrapper() : $wrapper;
        if(is_array($fields) && count($fields)) {
            foreach ($fields as $key => $inputfield) {
                if(is_array($inputfield)) {
                    $type = $this->element('type', $inputfield);
                    $children = $this->element('fields', $inputfield, array());

                    $build = true;
                    if(array_key_exists('build', $inputfield)) $build = $inputfield['build'];
                    if($build === true) {
                        $element = null;
                        if(($type == 'fieldset' || $type == 'InputfieldFieldset') && count($children)) {
                            $fieldset = $this->buildFieldset($key, $inputfield);
                            $element = $this->buildInputfields($children, $fieldset, $data);
                        } else {
                            $element = $this->buildInputfield($key, $inputfield, $data);
                        }
                        if(!is_null($element)) {
                            $insertBefore = $this->element('insertBefore', $inputfield, '');
                            $insertAfter = $this->element('insertAfter', $inputfield, '');
                            if($insertBefore && $wrapper->get($insertBefore) instanceof Inputfield) {
                                $wrapper->insertBefore($element, $wrapper->get($insertBefore));
                            } if($insertAfter && $wrapper->get($insertAfter) instanceof Inputfield) {
                                $wrapper->insertAfter($element, $wrapper->get($insertAfter));
                            } else {
                                $wrapper->add($element);
                            }
                        }
                    }
                }
            }
        }
        return $wrapper;
    }

    // ------------------------------------------------------------------------

    /**
     * Build Fieldset
     *
     * @param string $name
     * @param array $settings
     * @return array|mixed|null|_Module|Field|Fieldtype|Module|NullPage|Page|Permission|Role|Template|WireData|WireInputData|string
     * @throws WireException
     */
    protected function buildFieldset($name = '', $settings = array()) {
        $InputfieldFieldset = $this->modules->get('InputfieldFieldset');
        // Fieldset id+name
        if($_nameID = $this->element('id+name', $settings, $name)) {
            $InputfieldFieldset->attr('id+name', $_nameID);
        }
        // Fieldset id
        $InputfieldFieldset->attr('id', $this->id_prefix . $this->element('id', $settings, $name) . $this->id_suffix);
        // Fieldset name
        $InputfieldFieldset->attr('name', $this->name_prefix . $this->element('name', $settings, $name) . $this->name_suffix);

        // Fieldset label
        if($label = $this->element('label', $settings, '')) {
            $InputfieldFieldset->label = $label;
        }
        // Fieldset description
        if($description = $this->element('description', $settings, '')) {
            $InputfieldFieldset->description = $description;
        }
        // Field collapsed
        // @NOTE : Inputfield::collapsedNever not working for fieldset
        if($collapsed = $this->element('collapsed', $settings, Inputfield::collapsedYes)) {
            $InputfieldFieldset->collapsed = $collapsed;
        }
        // Fieldset showIf
        if($showIf = $this->element('showIf', $settings, '')) {
            $InputfieldFieldset->showIf = $this->showIf($showIf);
        }

        return $InputfieldFieldset;
    }

    // ------------------------------------------------------------------------

    /**
     * Build Inputfield*
     *
     * @param string $name
     * @param array $settings
     * @param array $data
     * @return null|_Module|Module
     * @throws WirePermissionException
     */
    protected function buildInputfield($name = '', $settings = array(), $data = array()) {
        $return = null;
        $type = $this->element("type", $settings, "");
        if(strpos($type, 'Inputfield') === false) {
            $type = 'Inputfield' . ucfirst($type);
        }
        if($Inputfield = $this->modules->get($type)) {
            // Inputfield name+id
            if($_nameID = $this->element('name+id', $settings, $name)) {
                $Inputfield->attr('name+id', $_nameID);
            }
            // Inputfield id
            $Inputfield->attr('id', $this->id_prefix . $this->element('id', $settings, $name) . $this->id_suffix);
            // Inputfield name
            $Inputfield->attr('name', $this->name_prefix . $this->element('name', $settings, $name) . $this->name_suffix);

            // Inputfield label
            if($label = $this->element('label', $settings, null)) {
                $Inputfield->label = $label;
            }
            // Inputfield checkboxLabel
            if($checkboxLabel = $this->element('checkboxLabel', $settings, null)) {
                $Inputfield->checkboxLabel = $checkboxLabel;
            }
            // Inputfield description
            if($description = $this->element('description', $settings, null)) {
                $Inputfield->description = $description;
            }
            // Inputfield notes
            if($notes = $this->element('notes', $settings, null)) {
                $Inputfield->notes = $notes;
            }
            // Inputfield required
            if($required = $this->element('required', $settings, null)) {
                $Inputfield->required = true;
            }
            // Inputfield value
            $default = $this->element("default", $settings, "");
            $value = $this->element($name, $data, $default);
            if($type == 'InputfieldCheckbox' && $value) {
                $Inputfield->attr('checked', 'checked');
            } else {
                $Inputfield->attr('value', $value);
            }
            // Inputfield options
            if($options = $this->element('options', $settings, null)) {
                $Inputfield->addOptions($options);
            }
            // Inputfield columnWidth
            if($columnWidth = $this->element('columnWidth', $settings, null)) {
                $Inputfield->columnWidth = $columnWidth;
            }
            // Inputfield showIf
            if($showIf = $this->element('showIf', $settings, '')) {
                $Inputfield->showIf = $this->showIf($showIf);
            }
            // Inputfield collapsed
            if($collapsed = $this->element('collapsed', $settings, "")) {
                $Inputfield->collapsed = $collapsed;
            }
            // Inputfield icon
            if($icon = $this->element('icon', $settings, '')) {
                $Inputfield->icon = $icon;
            }
            // Inputfield attributes
            $attrs = $this->element('attrs', $settings, array());
            if(count($attrs)) {
                foreach ($attrs as $key => $attr) $Inputfield->attr($key, $attr);
            }
            // Inputfield set options
            $set = $this->element('set', $settings, array());
            if(count($set)) {
                foreach ($set as $key => $val) $Inputfield->set($key, $val);
            }

            $return = $Inputfield;
        }

        return $return;
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

    // ------------------------------------------------------------------------

    /**
     * Module configuration
     *
     * @param array $data
     * @return null|InputfieldWrapper
     * @throws WireException
     * @throws WirePermissionException
     */
    public function getModuleConfigInputfields(array $data) {
        return $this->buildInputfields($this->configs, null, array_merge($this->defaults, $data));
    }
}
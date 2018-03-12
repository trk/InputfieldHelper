<?php namespace ProcessWire;

/**
 * Class InputfieldHelper
 *
 * @author			: İskender TOTOĞLU, @ukyo (community), @trk (Github)
 * @website			: https://www.altivebir.com
 * @projectWebsite	: https://github.com/trk/InputfieldHelper
 *
 * @method $this form_class($value = "")
 * @method $this list_class($value = "")
 * @method $this list_clearfix_class($value = "")
 * @method $this item_class($value = "")
 * @method $this item_label_class($value = "")
 * @method $this item_content_class($value = "")
 * @method $this item_required_class($value = "")
 * @method $this item_error_class($value = "")
 * @method $this item_collapsed_class($value = "")
 * @method $this item_column_width_class($value = "")
 * @method $this item_column_width_first_class($value = "")
 * @method $this item_show_if_class($value = "")
 * @method $this item_required_if_class($value = "")
 *
 * @method $this list_markup($value = "")
 * @method $this item_markup($value = "")
 * @method $this item_label_markup($value = "")
 * @method $this item_label_hidden_markup($value = "")
 * @method $this item_content_markup($value = "")
 * @method $this item_error_markup($value = "")
 * @method $this item_description_markup($value = "")
 * @method $this item_head_markup($value = "")
 * @method $this item_notes_markup($value = "")
 * @method $this item_icon_markup($value = "")
 * @method $this item_toggle_markup($value = "")
 */
class InputfieldHelper extends ModuleConfig implements Module {

    /**
     * InputfieldWrapper
     *
     * @var null
     */
    public $wrapper = null;

    /**
     * Clear InputfieldWrapper Markup
     *
     * @var bool
     */
    public $resetMarkup = false;

    /**
     * Markups
     *
     * @var string
     */
    public $markup = array();

    /**
     * Clean Markup
     *
     * @var array
     */
    protected $cleanMarkup = array(
        "list" => "{out}",
        "item" => "{out}",
        "item_label" => "{out}",
        "item_label_hidden" => "{out}",
        "item_content" => "{out}",
        "item_error" => "{out}",
        "item_description" => "{out}",
        "item_head" => "{out}",
        "item_notes" => "{out}",
        "item_icon" => "",
        "item_toggle" => ""
    );

    /**
     * Clear InputfieldWrapper classes
     *
     * @var bool
     */
    public $resetClasses = false;

    /**
     * Clean Classes
     *
     * @var array
     */
    protected $cleanClasses = array(
        "form" => "",
        "list" => "",
        "list_clearfix" => "",
        "item" => "{class} {name}",
        "item_label" => "",
        "item_content" => "",
        "item_required" => "",
        "item_error" => "",
        "item_collapsed" => "",
        "item_column_width" => "",
        "item_column_width_first" => "",
        "item_show_if" => "",
        "item_required_if" => ""
        // ALSO:
        // InputfieldAnything => array( any of the properties above to override on a per-Inputifeld basis)
    );

    /**
     * Classes
     *
     * @var string
     */
    public $classes = array();

    /**
     * Inputfield Variations
     *
     * Allow to use inputfield based markup, append and prepend
     *
     * @var array
     */
    protected $inputfield = array(
        "markup" => "{input}",
        // "classes" => array(),
        "append" => "",
        "prepend" => ""
    );

    /**
     * Front-end Framework
     *
     * @var string $this->frameworks["uikit3"]
     */
    public $framework = "uikit3";

    /**
     * Breakpoint for Front-end framework
     *
     * @var string
     */
    public $frameworkBreakpoint = "@m";

    /**
     * Front-end Frameworks
     *
     * @var array
     */
    protected $frameworks = array("uikit2", "uikit3");

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
     * If not null apply collapsed value to all inputfields
     *
     * @var null
     */
    public $collapsed = null;

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
            "version" => 5,
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
            "singular" => true,
            "autoload" => true
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

    /**
     * Set markup or classes with magic function call
     *
     * @param string $name
     * @param array $args
     * @return $this
     */
    public function __call($name = "", $args = array()) {
        $value = $this->element(0, $args, "");
        if(strpos($name, "_markup") !== FALSE) {
            $this->setMarkup(str_replace("_markup", "", $name), $value);
        }
        if(strpos($name, "_class") !== FALSE) {
            $this->setClass(str_replace("_class", "", $name), $value);
        }
        return $this;
    }

    // ------------------------------------------------------------------------

    /**
     * Set element markups
     *
     * @param string $key
     * @param string $value
     */
    public function setMarkup($key = "", $value = "") {
        $this->markup[$key] = $value;
    }

    // ------------------------------------------------------------------------

    /**
     * Set element classes
     *
     * @param string $key
     * @param string $value
     */
    public function setClass($key = "", $value = "") {
        $this->classes[$key] = $value;
    }

    // ------------------------------------------------------------------------

    public function ___prepareInputfields() {
        $this->addHookBefore('InputfieldWrapper::render', function($event) {
            $inputfieldWrapper = $event->object;

            // Clean markup and classes
            if($this->resetMarkup) $inputfieldWrapper->setMarkup($this->cleanMarkup);
            if($this->resetClasses) $inputfieldWrapper->setClasses($this->cleanClasses);

            // Get markup and classes
            $markupWrapper = $inputfieldWrapper->getMarkup();
            $classesWrapper = $inputfieldWrapper->getClasses();

            // Set markup and classes
            if(is_array($this->markup) && count($this->markup)) {
                $markupWrapper = array_merge($markupWrapper, $this->markup);
                $inputfieldWrapper->setMarkup($markupWrapper);
            }
            if(is_array($this->classes) && count($this->classes)) {
                $classesWrapper = array_merge($classesWrapper, $this->classes);
                $inputfieldWrapper->setClasses($classesWrapper);
            }

            foreach ($inputfieldWrapper->children as $inputfield) {
                $name = $inputfield->name;
                // Get inputfield
                $inputfieldArray = $this->element($name, $this->inputfieldsArray, array());

                /*
                $append = $this->element("append", $inputfieldArray, "");
                $prepend = $this->element("prepend", $inputfieldArray, "");
                $markup = $this->element("markup", $inputfieldArray, array());
                $classes = $this->element("classes", $inputfieldArray, array());

                // Field name based markup
                if(count($markup)) {
                    $inputfieldMarkup = array_merge($markupWrapper, $markup);
                    $inputfieldWrapper->setMarkup($inputfieldMarkup);
                } else {
                    $inputfieldWrapper->setMarkup($markupWrapper);
                }
                // Field name based classes
                if(count($classes)) {
                    $inputfieldClasses = array_merge($classesWrapper, $classes);
                    $inputfieldWrapper->setClasses($inputfieldClasses);
                } else {
                    $inputfieldWrapper->setClasses($classesWrapper);
                }
                */

                if(in_array($this->framework, $this->frameworks)) {
                    if($this->framework == "uikit2" || $this->framework == "uikit3") {
                        if($inputfield instanceof InputfieldTextarea) {
                            $inputfield->addClass('uk-textarea');
                        } else if($inputfield instanceof InputfieldSelect) {
                            $inputfield->addClass('uk-select');
                        } else if($inputfield instanceof InputfieldPassword) {
                            $inputfield->addClass('uk-input uk-form-width-medium');
                        } else if($inputfield instanceof InputfieldText || $inputfield instanceof InputfieldInteger) {
                            $inputfield->addClass('uk-input');
                        } else if($inputfield instanceof InputfieldCheckboxes || $inputfield instanceof InputfieldCheckbox) {
                            $inputfield->addClass('uk-checkbox');
                            $inputfield->addClass('uk-form-controls-text', 'contentClass');
                        } else if($inputfield instanceof InputfieldRadios) {
                            $inputfield->addClass('uk-radio');
                            $inputfield->addClass('uk-form-controls-text', 'contentClass');
                        } else if($inputfield instanceof InputfieldSubmit || $inputfield instanceof InputfieldButton) {
                            $inputfield->addClass('uk-button uk-button-primary');
                        } else if($inputfield instanceof InputfieldHidden) {
                            $inputfield->wrapAttr('class', 'uk-hidden');
                        }
                    }

                    if($this->framework == "uikit2") {
                        $inputfield->wrapAttr('class', $this->frameworkUikit2($inputfield->columnWidth));
                    } elseif($this->framework == "uikit3") {
                        $inputfield->wrapAttr('class', $this->frameworkUikit3($inputfield->columnWidth));
                    }
                }

                $append = $this->element("append", $inputfieldArray, "");
                $prepend = $this->element("prepend", $inputfieldArray, "");
                $markup = $this->element("markup", $inputfieldArray, array());
                if($append || $prepend) {
                    $inputfield->addHookAfter('render', function($inputfieldEvent) use($append, $prepend, $markup) {
                        $inputfieldEvent->replace = true;
                        $return = $prepend . $inputfieldEvent->return . $append;
                        $inputfieldEvent->return = str_replace("{input}", $return, $markup);
                    });
                }
            }
        });
    }

    // ------------------------------------------------------------------------

    /**
     * Uikit 2 Front-end framework for modifier
     *
     * @param string $columnWidth
     * @return string
     */
    protected function frameworkUikit2($columnWidth="") {
        $width = "";
        $class = "uk-width-1-1";
        if($columnWidth != "") {
            if($columnWidth > 0 && $columnWidth < 11) {
                $width = 1;
            } elseif ($columnWidth > 10 && $columnWidth < 21) {
                $width = 2;
            } elseif ($columnWidth > 20 && $columnWidth < 31) {
                $width = 3;
            } elseif ($columnWidth > 30 && $columnWidth < 41) {
                $width = 4;
            } elseif ($columnWidth > 40 && $columnWidth < 51) {
                $width = 5;
            } elseif ($columnWidth > 50 && $columnWidth < 61) {
                $width = 6;
            } elseif ($columnWidth > 60 && $columnWidth < 71) {
                $width = 7;
            } elseif ($columnWidth > 70 && $columnWidth < 81) {
                $width = 7;
            } elseif ($columnWidth > 80 && $columnWidth < 91) {
                $width = 9;
            } elseif ($columnWidth > 90) {
                $width = 10;
            }
            if($width == 10) $class = "uk-width-1-1";
            else $class = "uk-width-{$this->frameworkBreakpoint}{$width}-10";
        }
        return $class;
    }

    // ------------------------------------------------------------------------

    /**
     * Uikit 3 inputfield modifier for ProcessWire Inputfields
     *
     * @param string $columnWidth
     * @return string
     */
    protected function frameworkUikit3($columnWidth = "") {
        $ukWidthClass = '1-1';
        // determine column width class
        // uk class => width %
        $ukGridWidths = array(
            "80%" => "4-5",
            "75%" => "3-4",
            "70%" => "2-3",
            "64%" => "2-3",
            "60%" => "3-5",
            "50%" => "1-2",
            "45%" => "1-2",
            "40%" => "2-5",
            "34%" => "1-3",
            "33%" => "1-3",
            "32%" => "2-6",
            "30%" => "1-3",
            "25%" => "1-4",
            "20%" => "1-5",
            "16%" => "1-6"
        );

        if($columnWidth && $columnWidth < 100) {
            if($columnWidth < 16) $columnWidth = 16;
            foreach($ukGridWidths as $pct => $uk) {
                $pct = (int) $pct;
                if($columnWidth >= $pct) {
                    $ukWidthClass = $uk;
                    break;
                }
            }
        }

        return "uk-width-" . $ukWidthClass . $this->frameworkBreakpoint;
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
        $this->___prepareInputfields();
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
     * Render Inputfields
     *
     * @return string
     * @throws WireException
     */
    public function render() {
        return $this->getInputfields()->render();
    }

    // ------------------------------------------------------------------------

    /**
     * Prepare $this->inputfieldsArray for render
     *
     * @param array $inputfields
     * @return array
     */
    protected function prepareInputfields($inputfields = array()) {
        if(count($inputfields)) {
            foreach ($inputfields as $key => $inputfield) {
                $children = $this->element("children", $inputfield, array());

                $id = $this->element("id", $inputfield, $key);
                $name = $this->element("name", $inputfield, $key);
                $value = $this->element($key, $this->values, $this->element("value", $inputfield, ""));

                $inputfields[$key]["id"] = $this->id_prefix . $id . $this->id_suffix;
                $inputfields[$key]["name"] = $this->name_prefix . $name . $this->name_suffix;
                $inputfields[$key]["value"] = $value;
                if(!is_null($this->collapsed)) $inputfields[$key]["collapsed"] = $this->collapsed;

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

if(!function_exists('iHelper')) {
    /**
     * Shortcut function for InputfieldHelper class
     *
     * @return InputfieldHelper
     */
    function iHelper() {
        return new InputfieldHelper();
    }
}
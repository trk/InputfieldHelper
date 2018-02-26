# InputfieldHelper

This module creates Inputfields from array configs. You can see example usage below.

### Example config file :
```php
<?php namespace ProcessWire;
$configs = array(
    "test_text" => array(
        "label" => __("Text field"),
        "type" => "text",
        "default" => "",
        "attrs" => array(
            "placeholder" => __("Enter a value")
        )
    ),
    "test_text_show_if" => array(
        "label" => __("Text field show if"),
        "type" => "text",
        "default" => "",
        "attrs" => array(
            "placeholder" => __("Enter a value")
        ),
        "showIf" => array(
            "test_text" => "!=''"
        )
    ),
    "test_textarea" => array(
        "label" => __("Test field"),
        "description" => __("This is a test Inputfield created by this module."),
        "type" => "textarea",
        "set" => array(
            "rows" => 12
        ),
        "attrs" => array(
            "placeholder" => __("You can enter some text here")
        ),
        "default" => ""
    )
);

$InputfieldHelper = wire("modules")->get("InputfieldHelper");
$defaults = $InputfieldHelper->getDefaults($configs);
echo "<pre>" . print_r($defaults, true) . "</pre>";
echo $InputfieldHelper->buildInputfields($configs)->render();

// ------------------------------------------------------------------------

// Create a form with same configs by passing a wrapper
$form = modules()->get("InputfieldForm");
$form->action = "./";
$form->method = "post";
echo $InputfieldHelper->buildInputfields($configs, $form)->render();
```
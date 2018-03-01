# InputfieldHelper

This module extends base `ModuleConfig` class add some features to this class.

### Usage almost same with base `ModuleConfig` class :
```php
<?php namespace ProcessWire;
$InputfieldHelper = wire("modules")->get("InputfieldHelper");
$InputfieldHelper->wrapper = null;
$InputfieldHelper->name_prefix = "";
$InputfieldHelper->name_suffix = "";
$InputfieldHelper->id_prefix = "";
$InputfieldHelper->id_suffix = "";
$InputfieldHelper->values = array();
$InputfieldHelper->add(
    array(
        "firstname" => array(
            "label" => __("Firs name"),
            "type" => "text",
            "placeholder" => __("Enter your first name"),
            "columnWidth" => 50
        ),
        "lastname" => array(
            "label" => __("Last name"),
            "type" => "text",
            "placeholder" => __("Enter your last name"),
            "showIf" => "firstname!=''",
            "columnWidth" => 50
        ),
        "subject" => array(
            "label" => __("Subject"),
            "type" => "text",
            "placeholder" => __("Enter a subject"),
            "showIf" => array(
                "firstname" => "!=''",
                "lastname" => "!=''"
            )
        ),
        "message" => array(
            "label" => __("Message"),
            "type" => "textarea",
            "placeholder" => __("Enter your message"),
            "showIf" => "subject!=''"
        )
    )
);

echo $InputfieldHelper->getInputfields()->render();
```
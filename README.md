# InputfieldHelper

This module extends base `ModuleConfig` class add some features to this class.

[Cahangelog](https://github.com/trk/InputfieldHelper/raw/master/CHANGELOG.md)

### Usage almost same with base `ModuleConfig` class, but we have more :
![Example code output](https://github.com/trk/InputfieldHelper/raw/master/example-output.png)
```php
<?php namespace ProcessWire;
// An example code for creating search form. This form using get method
$iHelper = iHelper();
$iHelper->collapsed = Inputfield::collapsedNever;
$iHelper->resetMarkup = true;
$iHelper->resetClasses = true;
// You can set form values from here or directly to inputfield options by using `"value" => "field-value"`
$iHelper->values = array(
    "yacht_type" => "sailing",
    "number_of_guests" => 5,
    "destination" => "turkey"
);
$iHelper->markup = array(
    "list" => "<div class='uk-grid'>{out}</div>",
    "item" => "<div class='uk-width-1-4@m uk-margin-top'>{out}</div>",
    "InputfieldSubmit" => array(
            "item" => "<div class='uk-width-1-4 uk-text-right@m uk-margin-top'>{out}</div>",
    )
);

$iHelper->wrapper = modules()->get("InputfieldForm");
$iHelper->wrapper->action = "./";
$iHelper->wrapper->method = "get";
$iHelper->wrapper->attr("name", "search-from");
$iHelper->wrapper->attr("id", "search-from");

$iHelper->add(array(
    "yacht_type" => array(
        "type" => "select",
        "options" => array(
            "" => __("Type of Yacht"),
            "sailing" => __("Sailing Yachts"),
            "motor" => __("Motor Yachts"),
            "gulet" => __("Gulets"),
            "catamaran" => __("Catamarans")
        ),
        "skipLabel" => Inputfield::skipLabelBlank
    ),
    "number_of_guests" => array(
        "type" => "select",
        "options" => array(
            "" => __("Number of Guests"),
            1 => 1,
            2 => 2,
            3 => 3,
            4 => 4,
            5 => 5,
            6 => 6,
            7 => 7,
            8 => 8, 
            9 => 9,
            10 => 10,
            "10+" => "10+"
        ),
        "skipLabel" => Inputfield::skipLabelBlank
    ),
    "destination" => array(
        "type" => "select",
        "options" => array(
            "" => __("Destinations"),
            "turkey" => __("Turkey"),
            "greece" => __("Greece"),
            "croatia" => __("Croatia")            
        ),
        "skipLabel" => Inputfield::skipLabelBlank
    ),
    "submit" => array(
        "type" => "submit",
        "value" => __("Filer Yachts"),
        "skipLabel" => Inputfield::skipLabelBlank
    )
));
echo $iHelper->render();
```
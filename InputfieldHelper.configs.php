<?php namespace ProcessWire;
return array(
    "name_prefix" => array(
        "label" => __("Name Prefix"),
        "type" => "InputfieldText",
        "description" => __("This will aplly given name prefix to all inputfields created by this module"),
        "default" => "",
        "columnWidth" => 50
    ),
    "name_suffix" => array(
        "label" => __("Name Suffix"),
        "type" => "InputfieldText",
        "description" => __("This will aplly given name suffix to all inputfields created by this module"),
        "default" => "",
        "columnWidth" => 50
    ),
    "id_prefix" => array(
        "label" => __("ID Prefix"),
        "type" => "InputfieldText",
        "description" => __("This will aplly given id prefix to all inputfields created by this module"),
        "default" => "",
        "columnWidth" => 50
    ),
    "id_suffix" => array(
        "label" => __("ID Suffix"),
        "type" => "InputfieldText",
        "description" => __("This will aplly given id suffix to all inputfields created by this module"),
        "default" => "",
        "columnWidth" => 50
    )
);
<?php namespace ProcessWire;
return array(
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
        "label" => __("Textarea field"),
        "description" => __("This is a test Inputfield created by this module."),
        "type" => "textarea",
        "set" => array(
            "rows" => 14
        ),
        "attrs" => array(
            "placeholder" => __("You can enter some text here")
        ),
        "default" => "return array(
            'test_fied' => array(
                'label' => __('Test field'),
                'description' => __('This is a test Inputfield created by this module.')
                'type' => 'textarea',
                'set' => array(
                    'rows' => 14
                ),
                'attrs' => array(
                    'placeholder' => __('You can enter some text here')
                ),
                'default' => 'example usage'
            );
        )"
    )
);
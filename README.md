# InputfieldHelper

This module extends base `ModuleConfig` class add some features to this class.

[Cahangelog](CHANGELOG.md)

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

### Contact form example - [uikit3](https://github.com/uikit/uikit) with [intl-tel-input](https://github.com/jackocnr/intl-tel-input)  :

![Example code output](https://github.com/trk/InputfieldHelper/raw/master/contact-example-output.png)

```php
<!-- inside <head> tag </head> -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/12.1.7/css/intlTelInput.css" />
<?php
$formHelper = iHelper();
$formWrapper = modules()->get("InputfieldForm");
$formWrapper->action = "./#request-form";
$formWrapper->method = "post";
$formWrapper->attr('name', "request");
$formWrapper->attr("id", 'request-form');

$formHelper->wrapper = $formWrapper;
$formHelper->add(array(
    "firstname" => array(
        "label" => "First name",
        "type" => "text",
        "required" => true,
        "requiredAttr" => true,
        "columnWidth" => 50
    ),
    "lastname" => array(
        "label" => "Last name",
        "type" => "text",
        "required" => true,
        "requiredAttr" => true,
        "columnWidth" => 50
    ),
    "email" => array(
        "label" => "Email",
        "type" => "email",
        "required" => true,
        "requiredAttr" => true,
        "columnWidth" => 50
    ),
    "phone_dial_code" => array(
        "label" => "Dial code",
        "type" => "hidden",
        "wrapClass" => "uk-hidden"
    ),
    "phone" => array(
        "label" => "Phone",
        "type" => "text",
        "class" => "tel-input",
        "_markup" => '<div>{out}'
            . "\n" . '<span id="phone-valid-msg" class="uk-alert uk-alert-success uk-text-small uk-hidden">✓ valid</span>'
            . "\n" . '<span id="phone-error-msg" class="uk-alert uk-alert-danger uk-text-small uk-hidden">invalid</span>'
            . '</div>',
        "required" => true,
        "requiredAttr" => true,
        "columnWidth" => 50
    ),
    "subject" => array(
        "label" => "Subject",
        "type" => "text",
        "required" => true,
        "requiredAttr" => true
    ),
    "message" => array(
        "label" => "Message",
        "type" => "textarea",
        "rows" => 5,
        "required" => true,
        "requiredAttr" => true
    ),
    "submit" => array(
        "value" => "Submit",
        "type" => "submit"
    )
));

$form = $formHelper->getInputfields();

// form was submitted so we process the form
if(input()->post->submit) {
    // Process form and check errors
    $form->processInput(input()->post);
    
    // Set labels
    $labels = $formHelper->labels();
    // Set values
    $values = $formHelper->values();
    // Set posted values
    foreach ($values as $k => $v) {
        if(isset(inputPost()->$k)) {
            $values[$k] = sanitizer()->text(inputPost()->$k);
        }
    }
    // Check form errors
    if($form->getErrors() || $error) {
        $out .= '<h3 class="uk-text-danger">Please fill all required fields</h3>';
        $out .= $form->render();
    } else {
        $out .= '<h3 class="uk-text-success">Your form submission completed.</h3>';
    }
} else {
    $out .= $form->render();
}
echo $out;
?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/12.1.7/js/intlTelInput.min.js"></script>
<script type="text/javascript">
(function() {
    var telInputs = $(".tel-input");
    if(telInputs.length) {
        jQuery.each(telInputs, function(i, item) {
            if(item.getAttribute('id') !== undefined || item.getAttribute('id') !== null) {
                var telInputID = item.getAttribute('id'),
                    telInput = $("#" + telInputID);
                telInput.intlTelInput({
                    separateDialCode: true,
                    nationalMode: false,
                    initialCountry: "auto",
                    geoIpLookup: function(callback) {
                        $.get('https://ipinfo.io', function() {}, "jsonp").always(function(resp) {
                            var countryCode = (resp && resp.country) ? resp.country : "";
                            callback(countryCode);
                        });
                    },
                    // the countries at the top of the list. defaults to united states and united kingdom
                    preferredCountries: ["gb", "tr", "ru", "jo", "lb", "ua", "nl", "dk", "de", "se"],
                    // just for formatting/placeholders etc
                    utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/12.1.7/js/utils.js"
                });
                var errorMsg = $("#" + telInputID + "-error-msg"),
                    validMsg = $("#" + telInputID + "-valid-msg"),
                    dialCodeInput = $("#" + telInputID + "_dial_code");
                if(errorMsg.length && validMsg.length) {
                    var reset = function() {
                        telInput.removeClass("uk-alert");
                        errorMsg.addClass("uk-hidden");
                        validMsg.addClass("uk-hidden");
                    };

                    // on blur: validate
                    telInput.blur(function() {
                        reset();
                        if ($.trim(telInput.val())) {
                            if (telInput.intlTelInput("isValidNumber")) {
                                validMsg.removeClass("uk-hidden");
                                if(dialCodeInput.length) {
                                    var dialCode = telInput.intlTelInput('getSelectedCountryData').dialCode;
                                    dialCodeInput.val(dialCode);
                                }
                            } else {
                                errorMsg.removeClass("uk-hidden");
                            }
                        }
                    });

                    // on keyup / change flag: reset
                    telInput.on("keyup change", reset);
                }
            }
        });
    }
})();
</script>
```
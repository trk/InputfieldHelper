# Changelog

### Updated

- Set value if we have a value or if we have placeholder set value

## v.0.0.9

### Added

- `setExclude($name = "label|desctiption|notes|required|value", $value => array(), $type = "name|type")` function for set exclude value
- `labels()` function for get list of labels
- `descriptions()` function for get list of descriptions
- `notes()` function for get list of notes
- `values()` function for get list of values
- `requiredFields()` function for get list of required fields
- `contact form` example to readme.md

## v.0.0.8


### Added

- Default uikit2 and uikit3 options
- `isUikit()` function for checking framework is Uikit ? If it is, return version number.

## Fixed

- Hiding `hidden` input type on Wrapper

## v.0.0.7

### Added

- Uikit 3 icon support
- `iconPosition` *options : * `left (default)`, `right`
- `iconClickable` *options: * `false (default), true`
- `iconClass` you can set a icon class
- Inputfield `"_markup" => "{out}"` for add custom markup for rendered inputfield

### Changed

- Inputfield `"markup" => "{input}",` to `"markup" => array()` *note :* we will use `markup` for change wrapper markup for each inputfield

## v.0.0.6

### Added

- `InputfieldForm` to README.md example

### Updated

- Allow to use custom markup for each `inputfield`

### Removed

- Adding custom classes by using `'inputfield' => array("classes" => array())`, this could be done by using custom markup

## v.0.0.5

### Updated

- Grid widths for `uikit3`

## v.0.0.4

### Updated

- README.md

### Added

- `render()` function added

## v.0.0.3

### Added

- `iHelper();` shortcut function added
- `public $values` variable added for send values to module
- `public $collapsed` variable added for set global collapsed option
- `public $name_prefix`, `public $name_suffix`, `public $id_prefix` and `public $id_suffix` variables added for add prefix or suffix to name or id
- `public $resetMarkup = false;` for clearing markup
- `public $markup = array();` for set markup
- `public $resetClasses = false;` for clearing classes
- `public $classes = array();` for set classes
- Easily set markup or classes as function (`__call($value, $args = array())` method used)
- Hook after `InputfieldWrapper::render`
- Support for styling forms currently its support : `uikit2`, `uikit3`
- `public $frameworkBreakpoint` for set breakpoint of front-end framework
- Append & Prepend option for Inputfield

## v.0.0.2

### First commit

- Initial commit

## v.0.0.1
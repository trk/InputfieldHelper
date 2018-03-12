# Changelog

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
# Changelog

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
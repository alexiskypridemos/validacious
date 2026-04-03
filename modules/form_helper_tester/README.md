# Form Helper Tester Module

This module provides unit tests for the `form_helper` functions in the Trongate framework.

## Purpose

The `form_helper` functions were found to have bugs where they ignored certain parameters, potentially causing form fields to be generated without proper attributes, leading to missing POST data or incorrect HTML.

This tester module verifies that all form helper functions work correctly.

## Usage

1. Navigate to `/form_helper_tester` in your browser.
2. The page will display test results for each form helper function.
3. Green results indicate the function correctly generates expected HTML.
4. Red results indicate a failure.

## Tests Performed

The module tests all public `form_helper` functions:

- **form_input**: Checks that `name`, `value`, and additional attributes are included.
- **form_password**: Verifies `name`, `value`, and `type="password"`.
- **form_email**: Checks `name`, `value`, and `type="email"`.
- **form_search**: Verifies `name`, `value`, and `type="search"`.
- **form_number**: Checks `name`, `value` (converted to string), and `type="number"`.
- **form_input_no_value**: Ensures `name` is present but `value` is omitted when null.
- **form_checkbox**: Tests `name`, `value`, `checked` attribute when true, and `type="checkbox"`.
- **form_radio**: Similar to checkbox but `type="radio"`.
- **form_hidden**: Verifies `name`, `value`, and `type="hidden"`.
- **form_open**: Checks for `<form>`, `action`, `method="post"`, and additional attributes.
- **form_open_upload**: Includes `enctype="multipart/form-data"`.
- **form_close**: Verifies `</form>` tag.
- **form_label**: Tests `<label>`, `for` attribute, content, and additional attributes.
- **form_textarea**: Checks `name`, content between tags, and attributes.
- **form_date**: Verifies `name`, `value`, and `type="date"`.
- **form_datetime_local**: Checks `name`, `value`, and `type="datetime-local"`.
- **form_time**: Verifies `name`, `value`, and `type="time"`.
- **form_month**: Checks `name`, `value`, and `type="month"`.
- **form_week**: Verifies `name`, `value`, and `type="week"`.
- **form_submit**: Tests `name`, `value`, and `type="submit"`.

## Troubleshooting

- If tests fail, check that the `form_helper.php` has been updated with the fixes.
- Ensure the `modules/form/Form.php` module correctly handles the attributes passed from the helper.
- Clear any cached files or restart the web server if changes don't take effect.
- Some tests may fail if BASE_URL is not set correctly (for form_open tests).

## Dependencies

- Requires the `form` module to be available.
- Assumes `form_helper.php` is loaded (typically auto-loaded in Trongate).

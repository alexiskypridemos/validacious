# Flashdata Helper Tester Module

This module provides unit tests for the `flashdata_helper` functions in the Trongate framework.

## Purpose

The `flashdata_helper` functions (`set_flashdata` and `flashdata`) are tested to ensure they correctly store and retrieve one-time session messages.

## Usage

1. Navigate to `/flashdata_helper_tester` in your browser.
2. The page will display test results for each flashdata helper function.
3. Green results indicate the functions work correctly.
4. Red results indicate a failure.

## Tests Performed

- **set_flashdata_and_flashdata**: Tests setting a message and retrieving it with default HTML wrapping.
- **flashdata_custom_html**: Tests retrieving with custom opening and closing HTML.
- **flashdata_no_message**: Tests that null is returned when no flashdata exists.

## Troubleshooting

- If tests fail, check that the `flashdata` module is available and session handling is working.
- Ensure `flashdata_helper.php` is loaded (typically auto-loaded in Trongate).

## Dependencies

- Requires the `flashdata` module to be available.
- Assumes `flashdata_helper.php` is loaded (typically auto-loaded in Trongate).

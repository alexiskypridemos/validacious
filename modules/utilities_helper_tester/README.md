# Utilities Helper Tester Module

This module provides unit tests for the `utilities_helper` functions in the Trongate framework.

## Purpose

The `utilities_helper` functions are tested to ensure they correctly perform various utility operations.

## Usage

1. Navigate to `/utilities_helper_tester` in your browser.
2. The page will display test results for each utilities helper function.
3. Green results indicate the functions work correctly.
4. Red results indicate a failure.

## Tests Performed

- **ip_address**: Tests that a valid IP string is returned.
- **from_trongate_mx**: Tests header checking (returns boolean).
- **return_file_info**: Tests file name and extension extraction.
- **sort_by_property**: Tests sorting arrays of arrays by property.
- **sort_rows_by_property**: Tests sorting arrays of objects by property.

## Notes

- `block_url` and `json` are not tested here as they have side effects (403 response and script termination).
- `display` is a view helper and not tested.

## Troubleshooting

- If tests fail, check that the `utilities` module is available.
- Ensure `utilities_helper.php` is loaded (typically auto-loaded in Trongate).

## Dependencies

- Requires the `utilities` module to be available.
- Assumes `utilities_helper.php` is loaded (typically auto-loaded in Trongate).

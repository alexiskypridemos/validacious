# URL Helper Tester Module

This module provides unit tests for the `url_helper` functions in the Trongate framework.

## Purpose

The `url_helper` functions are tested to ensure they correctly handle URL manipulation and segment extraction.

## Usage

1. Navigate to `/url_helper_tester` in your browser.
2. The page will display test results for each URL helper function.
3. Green results indicate the functions work correctly.
4. Red results indicate a failure.

## Tests Performed

- **current_url**: Tests that a valid URL string is returned.
- **segment**: Tests segment extraction (may vary by current URL).
- **get_num_segments**: Tests counting URL segments.
- **get_last_segment**: Tests retrieving the last segment.
- **remove_query_string**: Tests query string removal.
- **anchor**: Tests HTML link generation with attributes.
- **previous_url**: Tests previous URL retrieval.

## Troubleshooting

- If tests fail, check that the `url` module is available.
- Ensure `url_helper.php` is loaded (typically auto-loaded in Trongate).
- Some tests depend on the current request URL and may vary.

## Dependencies

- Requires the `url` module to be available.
- Assumes `url_helper.php` is loaded (typically auto-loaded in Trongate).

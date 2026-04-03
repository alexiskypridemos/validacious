# String Helper Tester Module

This module provides unit tests for the `string_helper` functions in the Trongate framework.

## Purpose

The `string_helper` functions are tested to ensure they correctly manipulate and process strings.

## Usage

1. Navigate to `/string_helper_tester` in your browser.
2. The page will display test results for each string helper function.
3. Green results indicate the functions work correctly.
4. Red results indicate a failure.

## Tests Performed

- **truncate_str**: Tests string truncation with ellipsis.
- **truncate_words**: Tests word-based truncation.
- **get_last_part**: Tests extracting the last part of a delimited string.
- **extract_content**: Tests content extraction between delimiters.
- **nice_price**: Tests number formatting as currency.
- **url_title**: Tests slug generation from text.
- **make_rand_str**: Tests random string generation.
- **filter_str**: Tests HTML filtering and sanitization.

## Troubleshooting

- If tests fail, check that the `string_service` module is available.
- Ensure `string_helper.php` is loaded (typically auto-loaded in Trongate).
- Some tests may depend on PHP extensions (e.g., intl for transliteration).

## Dependencies

- Requires the `string_service` module to be available.
- Assumes `string_helper.php` is loaded (typically auto-loaded in Trongate).

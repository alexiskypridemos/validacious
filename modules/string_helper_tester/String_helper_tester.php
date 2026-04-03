<?php

/**
 * String Helper Tester Module
 *
 * This module provides unit tests for the string_helper functions to ensure
 * they correctly process strings.
 */
class String_helper_tester extends Trongate {

  /**
   * Display the test results page
   *
   * @return void
   */
  public function index(): void {
    $data['test_results'] = $this->run_tests();
    $data['view_module'] = $this->module_name;
    $data['view_file'] = 'test_results';
    $this->view('test_results', $data);
  }

  /**
   * Run the unit tests for string_helper functions
   *
   * @return array Test results
   */
  private function run_tests(): array {
    $results = [];

    // Test truncate_str
    $truncated = truncate_str('This is a long string', 10);
    $results['truncate_str'] = $truncated === 'This is a ...';
    $truncated_words = truncate_words('This is a long string with many words', 3);
    $results['truncate_words'] = str_contains($truncated_words, 'This is a...');

    // Test get_last_part
    $last_part = get_last_part('user-profile-settings', '-');
    $results['get_last_part'] = $last_part === 'settings';

    // Test extract_content
    $content = extract_content('Start content here End', 'Start ', ' End');
    $results['extract_content'] = $content === 'content here';

    // Test nice_price
    $price = nice_price(1234.56);
    $results['nice_price'] = $price === '1,234.56';

    // Test url_title
    $slug = url_title('Hello World!');
    $results['url_title'] = $slug === 'hello-world';

    // Test make_rand_str
    $rand_str = make_rand_str(10);
    $results['make_rand_str'] = strlen($rand_str) === 10 && ctype_alnum($rand_str);

    // Test filter_str (basic)
    $filtered = filter_str('<script>alert(1)</script>Hello');
    $results['filter_str'] = !str_contains($filtered, '<script>') && str_contains($filtered, 'Hello');

    return $results;
  }
}

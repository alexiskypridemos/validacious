<?php

/**
 * URL Helper Tester Module
 *
 * This module provides unit tests for the url_helper functions to ensure
 * they correctly handle URLs and segments.
 */
class Url_helper_tester extends Trongate {

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
   * Run the unit tests for url_helper functions
   *
   * @return array Test results
   */
  private function run_tests(): array {
    $results = [];

    // Test current_url returns a string
    $current = current_url();
    $results['current_url'] = is_string($current) && !empty($current);

    // Test segment (assuming this is segment 1)
    $seg1 = segment(1);
    $results['segment_1'] = is_string($seg1); // May be empty if no segments

    // Test get_num_segments
    $num_seg = get_num_segments();
    $results['get_num_segments'] = is_int($num_seg) && $num_seg >= 0;

    // Test get_last_segment
    $last_seg = get_last_segment();
    $results['get_last_segment'] = is_string($last_seg);

    // Test remove_query_string
    $clean_url = remove_query_string('http://example.com/page?param=value');
    $results['remove_query_string'] = $clean_url === 'http://example.com/page';

    // Test anchor
    $link = anchor('test/page', 'Test Link', ['class' => 'btn']);
    $results['anchor'] = str_contains($link, 'href="') && str_contains($link, 'Test Link') && str_contains($link, 'class="btn"');

    // Test previous_url (may be null)
    $prev = previous_url();
    $results['previous_url'] = is_string($prev) || $prev === '';

    return $results;
  }
}

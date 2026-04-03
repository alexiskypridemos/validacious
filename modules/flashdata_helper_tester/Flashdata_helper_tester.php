<?php

/**
 * Flashdata Helper Tester Module
 *
 * This module provides unit tests for the flashdata_helper functions to ensure
 * they correctly set and retrieve flash messages.
 */
class Flashdata_helper_tester extends Trongate {

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
   * Run the unit tests for flashdata_helper functions
   *
   * @return array Test results
   */
  private function run_tests(): array {
    $results = [];

    // Test set_flashdata and flashdata
    set_flashdata('Test message');
    $retrieved = flashdata();
    $results['set_flashdata_and_flashdata'] = $this->check_flashdata($retrieved, 'Test message');

    // Test flashdata with custom HTML
    set_flashdata('Custom message');
    $custom = flashdata('<div>', '</div>');
    $results['flashdata_custom_html'] = $this->check_flashdata($custom, 'Custom message', '<div>', '</div>');

    // Test flashdata returns null when no message
    $empty = flashdata();
    $results['flashdata_no_message'] = $empty === null;

    return $results;
  }

  /**
   * Check if flashdata output contains expected content
   *
   * @param string|null $output The output from flashdata()
   * @param string $message The expected message
   * @param string $opening Optional opening HTML
   * @param string $closing Optional closing HTML
   * @return bool True if checks pass
   */
  private function check_flashdata(?string $output, string $message, string $opening = '<p style="color: green;">', string $closing = '</p>'): bool {
    if ($output === null) {
      return false;
    }
    return str_contains($output, $opening) && str_contains($output, $message) && str_contains($output, $closing);
  }
}

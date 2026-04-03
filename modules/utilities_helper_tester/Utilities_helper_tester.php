<?php

/**
 * Utilities Helper Tester Module
 *
 * This module provides unit tests for the utilities_helper functions to ensure
 * they correctly perform utility operations.
 */
class Utilities_helper_tester extends Trongate {

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
   * Run the unit tests for utilities_helper functions
   *
   * @return array Test results
   */
  private function run_tests(): array {
    $results = [];

    // Test ip_address returns a string
    $ip = ip_address();
    $results['ip_address'] = is_string($ip) && !empty($ip);

    // Test from_trongate_mx (should be false in normal request)
    $is_mx = from_trongate_mx();
    $results['from_trongate_mx'] = is_bool($is_mx);

    // Test return_file_info
    $file_info = return_file_info('test.jpg');
    $results['return_file_info'] = isset($file_info['file_name']) && isset($file_info['file_extension']) &&
      $file_info['file_name'] === 'test' && $file_info['file_extension'] === '.jpg';

    // Test sort_by_property (array of arrays)
    $array = [['name' => 'b'], ['name' => 'a']];
    $sorted_array = sort_by_property($array, 'name');
    $results['sort_by_property'] = $sorted_array[0]['name'] === 'a' && $sorted_array[1]['name'] === 'b';

    // Test sort_rows_by_property (array of objects)
    $obj1 = (object)['name' => 'b'];
    $obj2 = (object)['name' => 'a'];
    $objects = [$obj1, $obj2];
    $sorted = sort_rows_by_property($objects, 'name');
    $results['sort_rows_by_property'] = $sorted[0]->name === 'a' && $sorted[1]->name === 'b';

    // Note: block_url and json are not tested here as they have side effects
    // block_url would trigger 403, json outputs and exits

    return $results;
  }
}

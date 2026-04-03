<?php

/**
 * Form Helper Tester Module
 *
 * This module provides unit tests for the form_helper functions to ensure
 * they correctly generate HTML form elements with proper name and value attributes.
 */
class Form_helper_tester extends Trongate {

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
   * Run the unit tests for form_helper functions
   *
   * @return array Test results
   */
  private function run_tests(): array {
    $results = [];

    // Test form_input
    $html = form_input('test_field', 'test_value', ['id' => 'test_id']);
    $results['form_input'] = $this->check_html_contains($html, 'name="test_field"', 'value="test_value"', 'id="test_id"');

    // Test form_password
    $html = form_password('password_field', 'secret', ['id' => 'pass_id']);
    $results['form_password'] = $this->check_html_contains($html, 'name="password_field"', 'value="secret"', 'type="password"');

    // Test form_email
    $html = form_email('email_field', 'user@example.com', ['id' => 'email_id']);
    $results['form_email'] = $this->check_html_contains($html, 'name="email_field"', 'value="user@example.com"', 'type="email"');

    // Test form_search
    $html = form_search('search_field', 'query', ['id' => 'search_id']);
    $results['form_search'] = $this->check_html_contains($html, 'name="search_field"', 'value="query"', 'type="search"');

    // Test form_number
    $html = form_number('number_field', 42, ['id' => 'num_id']);
    $results['form_number'] = $this->check_html_contains($html, 'name="number_field"', 'value="42"', 'type="number"');

    // Test form_input without value
    $html = form_input('no_value_field', null, ['id' => 'no_val_id']);
    $results['form_input_no_value'] = $this->check_html_contains($html, 'name="no_value_field"', 'id="no_val_id"') && !str_contains($html, 'value=');

    // Test form_checkbox
    $html = form_checkbox('agree', 'yes', true, ['id' => 'agree_id']);
    $results['form_checkbox'] = $this->check_html_contains($html, 'name="agree"', 'value="yes"', 'checked="checked"', 'type="checkbox"');

    // Test form_radio
    $html = form_radio('color', 'red', true, ['id' => 'color_id']);
    $results['form_radio'] = $this->check_html_contains($html, 'name="color"', 'value="red"', 'checked="checked"', 'type="radio"');

    // Test form_hidden
    $html = form_hidden('hidden_field', 'secret_value', ['id' => 'hidden_id']);
    $results['form_hidden'] = $this->check_html_contains($html, 'name="hidden_field"', 'value="secret_value"', 'type="hidden"');

    // Test form_open
    $html = form_open('test/action', ['id' => 'form_id']);
    $results['form_open'] = $this->check_html_contains($html, '<form', 'action="', 'test/action', 'method="post"', 'id="form_id"');

    // Test form_open_upload
    $html = form_open_upload('upload/action', ['id' => 'upload_id']);
    $results['form_open_upload'] = $this->check_html_contains($html, '<form', 'action="', 'upload/action', 'method="post"', 'enctype="multipart/form-data"', 'id="upload_id"');

    // Test form_close
    $html = form_close();
    $results['form_close'] = $this->check_html_contains($html, '</form>');

    // Test form_label
    $html = form_label('Test Label', 'test_id', ['class' => 'label_class']);
    $results['form_label'] = $this->check_html_contains($html, '<label', 'for="test_id"', 'class="label_class"', '>Test Label</label>');

    // Test form_textarea
    $html = form_textarea('textarea_field', 'initial text', ['id' => 'textarea_id', 'rows' => '5']);
    $results['form_textarea'] = $this->check_html_contains($html, '<textarea', 'name="textarea_field"', 'id="textarea_id"', 'rows="5"', '>initial text</textarea>');

    // Test form_date
    $html = form_date('date_field', '2024-01-01', ['id' => 'date_id']);
    $results['form_date'] = $this->check_html_contains($html, 'name="date_field"', 'value="2024-01-01"', 'type="date"');

    // Test form_datetime_local
    $html = form_datetime_local('datetime_field', '2024-01-01T12:00', ['id' => 'datetime_id']);
    $results['form_datetime_local'] = $this->check_html_contains($html, 'name="datetime_field"', 'value="2024-01-01T12:00"', 'type="datetime-local"');

    // Test form_time
    $html = form_time('time_field', '12:00', ['id' => 'time_id']);
    $results['form_time'] = $this->check_html_contains($html, 'name="time_field"', 'value="12:00"', 'type="time"');

    // Test form_month
    $html = form_month('month_field', '2024-01', ['id' => 'month_id']);
    $results['form_month'] = $this->check_html_contains($html, 'name="month_field"', 'value="2024-01"', 'type="month"');

    // Test form_week
    $html = form_week('week_field', '2024-W01', ['id' => 'week_id']);
    $results['form_week'] = $this->check_html_contains($html, 'name="week_field"', 'value="2024-W01"', 'type="week"');

    // Test form_submit
    $html = form_submit('submit_btn', 'Save', ['id' => 'submit_id']);
    $results['form_submit'] = $this->check_html_contains($html, 'name="submit_btn"', 'value="Save"', 'type="submit"');

    return $results;
  }

  /**
   * Check if HTML contains all specified substrings
   *
   * @param string $html The HTML to check
   * @param string ...$checks The substrings to look for
   * @return bool True if all checks pass
   */
  private function check_html_contains(string $html, string ...$checks): bool {
    foreach ($checks as $check) {
      if (!str_contains($html, $check)) {
        return false;
      }
    }
    return true;
  }
}

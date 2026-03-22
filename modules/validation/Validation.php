<?php

/**
 * Validation Class
 *
 * Handles form validation logic, rule parsing, and error reporting.
 * Coordinates with Validation_model for rule execution.
 */
class Validation extends Trongate {

    public array $form_submission_errors = [];
    public array $posted_fields = [];
    private ?object $caller = null;

    public function __construct(?string $module_name = null, ?object $caller = null) {
        parent::__construct($module_name);
        $this->caller = $caller;
        block_url('validation');
    }

    public function set_language(string $lang): void {
        $_SESSION['validation_lang'] = $lang;
        $this->model->load_validation_language($lang);
    }

    /**
     * Resets the validation language to the system default.
     * Removes the sticky language preference from the session.
     *
     * @return void
     */
    public function reset_language(): void {
        if (isset($_SESSION['validation_lang'])) {
            unset($_SESSION['validation_lang']);
        }
    }

    /**
     * Sets the calling controller instance to allow for callback methods.
     */
    public function set_caller(object $caller): void {
        $this->caller = $caller;
    }

    /**
     * Configures validation rules for a specific field.
     */
    public function set_rules(string $key, string $label, string $rules): void {
        $validation_data['key'] = $key;
        $validation_data['label'] = $label;

        if (isset($_FILES[$key]) && $_FILES[$key]['error'] !== UPLOAD_ERR_NO_FILE) {
            $validation_data['posted_value'] = $_FILES[$key];
            $validation_data['is_file'] = true;
        } else {
            $validation_data['posted_value'] = post($key, true);
            $validation_data['is_file'] = false;
        }

        $tests_to_run = explode('|', $rules);
        $this->posted_fields[$key] = $label;

        foreach ($tests_to_run as $test_to_run) {
            $validation_data['test_to_run'] = $test_to_run;
            $this->run_validation_test($validation_data);

            // EARLY EXIT: If an error was added for this field, stop processing further rules
            if (isset($this->form_submission_errors[$key])) {
                break;  // Stop processing more rules for this field
            }
        }

        $_SESSION['form_submission_errors'] = $this->form_submission_errors;
    }

    /**
     * Parses and executes a single validation rule.
     */
    private function run_validation_test(array $validation_data): void {
        $test_to_run = $validation_data['test_to_run'];
        $param = null;

        // Parse rules with parameters, e.g., max_length[10]
        if (strpos($test_to_run, '[') !== false && strpos($test_to_run, ']') !== false) {
            $parts = explode('[', $test_to_run);
            $method = $parts[0];
            $param = rtrim($parts[1], ']');
        } else {
            $method = $test_to_run;
        }

        $validation_data['param'] = $param;

        // Handle Callbacks
        if (str_starts_with($method, 'callback_')) {
            $callback_method = str_replace('callback_', '', $method);

            if (isset($this->caller) && method_exists($this->caller, $callback_method)) {
                $result = $this->caller->$callback_method($validation_data['posted_value']);

                if ($result !== true) {
                    $error_msg = $this->model->resolve_error_message($result, $validation_data);
                    $this->form_submission_errors[$validation_data['key']][] = $error_msg;
                }
            } else {
                $error_msg = "Validation failed: Callback method '$callback_method' not found.";
                $this->form_submission_errors[$validation_data['key']][] = $error_msg;
            }
            return;
        }

        // Delegate to Validation_model
        $this->form_submission_errors = $this->model->execute_rule($method, $validation_data, $this->form_submission_errors);
    }

    /**
     * Protects against Cross-Site Request Forgery (CSRF) attacks.
     *
     * @return void
     */
    private function csrf_protect(): void {
        // Make sure they have posted csrf_token
        $posted_csrf_token = post('csrf_token');
        if ($posted_csrf_token === '') {
            $this->csrf_block_request();
        } else {
            $expected = $_SESSION['csrf_token'] ?? '';
            if (!is_string($posted_csrf_token) || !hash_equals($expected, $posted_csrf_token)) {
                $this->csrf_block_request();
            }
        }
    }

    /**
     * Blocks a request that failed CSRF validation.
     *
     * @return void
     */
    private function csrf_block_request(): void {
        // Check if this is an AJAX/API request (XML HTTP Request)
        $is_ajax = (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
            strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest');

        if ($is_ajax) {
            // Return 403 Forbidden for API/AJAX requests
            http_response_code(403);
            die('CSRF token validation failed');
        } else {
            // Redirect to home page for standard form submissions
            redirect(BASE_URL);
        }
    }

    /**
     * Finalizes validation. Returns true if no errors found.
     * Supports passing an array of rules directly (Option 2 syntax).
     * * @param array|null $rules Optional associative array of validation rules
     * @return bool True if validation passes, false otherwise
     */
    public function run(?array $rules = null): bool {
        // 1. Security First - Validate CSRF token before any processing
        $this->csrf_protect();

        // 2. If rules are passed as an array, parse and execute them
        if (isset($rules)) {
            foreach ($rules as $field => $data) {
                // Use provided label, or fallback to field name
                $label = $data['label'] ?? $field;
                $rule_list = [];

                foreach ($data as $rule => $value) {
                    // Skip the label key as it's not a validation test
                    if ($rule === 'label') {
                        continue;
                    }

                    // If value is true, it's a basic rule (e.g., 'required' => true)
                    // If value is anything else, it's a param (e.g., 'min_length' => 3)
                    if ($value === true) {
                        $rule_list[] = $rule;
                    } else {
                        $rule_list[] = $rule . '[' . $value . ']';
                    }
                }

                // Register and execute the rules for this field
                $this->set_rules($field, $label, implode('|', $rule_list));
            }
        }

        // 3. Final check for errors (gathered during set_rules phase)
        if (count($this->form_submission_errors) > 0) {
            $_SESSION['form_submission_errors'] = $this->form_submission_errors;
            return false;
        }

        return true;
    }

    public function display_errors($first_arg = null, $closing_html = null): ?string {
        $render_type = $this->get_render_type($first_arg, $closing_html);

        if ($render_type === 'null') {
            return null;
        }

        $form_submission_errors = $_SESSION['form_submission_errors'];

        return match ($render_type) {
            'json'     => $this->json_validation_errors($form_submission_errors, $first_arg),
            'inline'   => $this->inline_validation_errors($form_submission_errors, $first_arg),
            'standard' => $this->general_validation_errors($form_submission_errors, $first_arg, $closing_html),
        };
    }

    private function json_validation_errors(array $errors, int $http_code): void {
        http_response_code($http_code);
        header('Content-Type: application/json');
        echo json_encode($errors);

        // RENDERED = DELETED
        // unset($_SESSION['form_submission_errors']);
        // die();
    }

    private function inline_validation_errors(array $errors, string $field): string {
        if (!isset($errors[$field])) {
            return '';
        }

        $html = '<ul class="validation-errors validation-errors--inline">';
        foreach ($errors[$field] as $error) {
            $html .= '<li>' . out($error) . '</li>';
        }
        $html .= '</ul>';

        // SURGICAL DELETION: Remove only this field's errors
        // unset($_SESSION['form_submission_errors'][$field]);

        // // Cleanup: If the array is now empty, remove the parent key
        // if (count($_SESSION['form_submission_errors']) === 0) {
        //     unset($_SESSION['form_submission_errors']);
        // }

        return $html;
    }

    private function general_validation_errors(array $errors, ?string $open = null, ?string $close = null): string {
        $open  = $open ?? (defined('ERROR_OPEN') ? ERROR_OPEN : '<li>');
        $close = $close ?? (defined('ERROR_CLOSE') ? ERROR_CLOSE : '</li>');

        $items = '';
        foreach ($errors as $field_errors) {
            foreach ($field_errors as $error) {
                $items .= $open . out($error) . $close;
            }
        }

        $html = '<ul class="validation-errors validation-errors--summary">' . $items . '</ul>';

        // RENDERED = DELETED
        unset($_SESSION['form_submission_errors']);
        return $html;
    }

    private function get_render_type($first_arg, $closing_html): string {
        if (!isset($_SESSION['form_submission_errors'])) {
            return 'null';
        }

        if (is_int($first_arg) && $first_arg >= 400 && $first_arg <= 499) {
            return 'json';
        }

        if (isset($first_arg) && !isset($closing_html)) {
            return 'inline';
        }

        return 'standard';
    }

    /**
     * Generates JS injection for automatic error highlighting.
     */
    public function get_js_injection(): string {
        if (!isset($_SESSION['form_submission_errors'])) {
            return '';
        }

        $errors_json = json_encode($_SESSION['form_submission_errors'], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT);
        $html = '<script>window.trongateValidationErrors = ' . $errors_json . ';</script>';

        $trigger = defined('MODULE_ASSETS_TRIGGER') ? MODULE_ASSETS_TRIGGER : '_module';
        $js_url = BASE_URL . $this->module_name . $trigger . '/js/highlight_validation_errors.js';

        $html .= '<script src="' . $js_url . '"></script>';

        return $html;
    }
}

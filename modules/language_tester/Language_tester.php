<?php
class Language_tester extends Trongate {
    
    public function index(): void {
        $output = '<h2>Language Validation Tester</h2>';
        $output .= '<p>Click below to run the tests. (English, French, English)</p>';
        
        $output .= form_open('language_tester/run_tests');
        $output .= form_submit('submit', 'Run Tests');
        $output .= form_close();

        echo $output;
    }

    public function run_tests(): void {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('language_tester');
        }

        $output = '<h2>Language Validation Test Results</h2>';
        $output .= '<p>Test module that generates inline errors - rule triggered is "required", which prints the "required_error" key from the language dictionary arrays.</p><hr>';
        
        // --- TEST 1: DEFAULT LANGUAGE (ENGLISH) ---
        // $this->validation->set_language('en');
        $this->validation->reset_language();
        $this->validation->set_rules('test_1', 'Test 1', 'required');
        
        // --- TEST 2: FRENCH ---
        $this->validation->set_language('fr');
        $this->validation->set_rules('test_2', 'Test 2', 'required');
        
        // --- TEST 3: ENGLISH (AGAIN) ---
        $this->validation->set_language('en');
        $this->validation->set_rules('test_3', 'Test 3', 'required');
        
        $this->validation->run();

        // Render test form
        $output .= form_open('language_tester/run_tests', array('class' => 'highlight-errors'));
        $output .= '<div style="background:#f4f4f4; padding: 20px;; max-width: 600px;">';

        // Test 1
        $output .= '<div style="margin-bottom: 25px;">';
        $output .= '<h4>Test 1: Default English Validaton (required_error)</h4>';
        $output .= form_label('Test 1 Input');
        $output .= validation_errors('test_1');
        $output .= form_input('test_1', '');
        $output .= '</div>';
        
        // Test 2
        $output .= '<div style="margin-bottom: 25px;">';
        $output .= '<h4>Test 2: Switching to French (required_error)</h4>';
        $output .= form_label('Test 2 Input');
        $output .= validation_errors('test_2');
        $output .= form_input('test_2', '');
        $output .= '</div>';

        // Test 3
        $output .= '<div style="margin-bottom: 25px;">';
        $output .= '<h4>Test 3: Switching back to English (required_error)</h4>';
        $output .= form_label('Test 3 Input');
        $output .= validation_errors('test_3');
        $output .= form_input('test_3', '');
        $output .= '</div>';

        $output .= '</div>';
        
        $output .= '<div style="margin-top:20px;">';
        // Add a back button as an anchor
        $output .= anchor('language_tester', 'Reset Tests');
        $output .= '</div>';

        $output .= form_close();

        echo $output;
    }

}

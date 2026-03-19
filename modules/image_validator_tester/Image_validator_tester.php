<?php
class Image_validator_tester extends Trongate {

    /**
     * Display the test form
     */
    public function index(): void {
        $data['view_module'] = 'image_validator_tester';
        $data['view_file'] = 'upload_form';
        $this->view('upload_form', $data);
    }

    /**
     * Process the upload with various validation rules
     */
    public function submit(): void {
        // Set validation rules based on selected test type
        $test_type = post('test_type', true);
        
        switch ($test_type) {
            case 'allowed_types':
                $this->test_allowed_types();
                break;
            case 'is_image':
                $this->test_is_image();
                break;
            case 'max_dimensions':
                $this->test_max_dimensions();
                break;
            case 'min_dimensions':
                $this->test_min_dimensions();
                break;
            case 'exact_dimensions':
                $this->test_exact_dimensions();
                break;
            case 'square':
                $this->test_square();
                break;
            case 'security':
                $this->test_security();
                break;
            case 'combined':
                $this->test_combined();
                break;
            default:
                $this->test_basic();
                break;
        }
    }

    /**
     * Test 1: Basic image upload with allowed types
     */
    private function test_basic(): void {
        $this->validation->set_rules(
            'userfile',
            'Test Image',
            'required|is_image|max_size[5000]'
        );

        $this->process_upload('Basic Image Test');
    }

    /**
     * Test 2: Allowed types only (JPG, PNG)
     */
    private function test_allowed_types(): void {
        $this->validation->set_rules(
            'userfile',
            'Test Image',
            'required|is_image|allowed_types[jpg,png]|max_size[5000]'
        );

        $this->process_upload('Allowed Types Test (JPG, PNG only)');
    }

    /**
     * Test 3: Is Image validation
     */
    private function test_is_image(): void {
        $this->validation->set_rules(
            'userfile',
            'Test Image',
            'required|is_image|max_size[5000]'
        );

        $this->process_upload('Is Image Test');
    }

    /**
     * Test 4: Max dimensions (800x600)
     */
    private function test_max_dimensions(): void {
        $this->validation->set_rules(
            'userfile',
            'Test Image',
            'required|is_image|max_width[800]|max_height[600]|max_size[5000]'
        );

        $this->process_upload('Max Dimensions Test (800x600)');
    }

    /**
     * Test 5: Min dimensions (300x200)
     */
    private function test_min_dimensions(): void {
        $this->validation->set_rules(
            'userfile',
            'Test Image',
            'required|is_image|min_width[300]|min_height[200]|max_size[5000]'
        );

        $this->process_upload('Min Dimensions Test (300x200)');
    }

    /**
     * Test 6: Exact dimensions (500x500)
     */
    private function test_exact_dimensions(): void {
        $this->validation->set_rules(
            'userfile',
            'Test Image',
            'required|is_image|exact_width[500]|exact_height[500]|max_size[5000]'
        );

        $this->process_upload('Exact Dimensions Test (500x500)');
    }

    /**
     * Test 7: Square image (must be 1:1 aspect ratio)
     */
    private function test_square(): void {
        $this->validation->set_rules(
            'userfile',
            'Test Image',
            'required|is_image|square|max_size[5000]'
        );

        $this->process_upload('Square Image Test (must be square)');
    }

    /**
     * Test 8: Security threat detection
     */
    private function test_security(): void {
        $this->validation->set_rules(
            'userfile',
            'Test Image',
            'required|is_image|max_size[5000]'
        );

        $this->process_upload('Security Threat Detection Test');
    }

    /**
     * Test 9: Combined strict rules
     */
    private function test_combined(): void {
        $this->validation->set_rules(
            'userfile',
            'Test Image',
            'required|is_image|allowed_types[jpg,png]|min_width[400]|max_width[1200]|min_height[300]|max_height[900]|max_size[3000]'
        );

        $this->process_upload('Combined Strict Rules Test');
    }

    /**
     * Common upload processing logic
     */
    private function process_upload(string $test_name): void {
        if ($this->validation->run() === true) {
            // Configure image upload with processing
            $config = [
                'destination' => 'uploads',
                'upload_to_module' => true,
                'make_rand_name' => true,
                'max_width' => 1200,  // Resize if larger
                'max_height' => 900,   // Resize if larger
                'thumbnail_dir' => 'uploads/thumbs',
                'thumbnail_max_width' => 150,
                'thumbnail_max_height' => 150
            ];
            
            try {
                $file_info = $this->image->upload($config);
                
                $data = [
                    'test_name' => $test_name,
                    'file_name' => $file_info['file_name'],
                    'file_path' => $file_info['file_path'],
                    'file_size' => $file_info['file_size'],
                    'file_type' => $file_info['file_type'],
                    'thumbnail_path' => $file_info['thumbnail_path'] ?? 'Not generated',
                    'message' => 'Upload successful!'
                ];
                
                set_flashdata('Image uploaded and processed successfully!');
                
            } catch (Exception $e) {
                $data = [
                    'test_name' => $test_name,
                    'error' => $e->getMessage(),
                    'message' => 'Upload failed during processing'
                ];
            }
            
            // Store results in session for display
            $_SESSION['test_results'] = $data;
            redirect('image_validator_tester/results');
            
        } else {
            // Validation failed - show form with errors
            $this->index();
        }
    }

    /**
     * Display test results
     */
    public function results(): void {
        $data = $_SESSION['test_results'] ?? [
            'test_name' => 'No Test Results',
            'message' => 'No test results available.'
        ];
        
        $data['view_module'] = 'image_validator_tester';
        $data['view_file'] = 'upload_success';
        $this->view('upload_success', $data);
        
        // Clear results after displaying
        unset($_SESSION['test_results']);
    }

    /**
     * Clear all uploaded files (for testing cleanup)
     */
    public function cleanup(): void {
        $uploads_dir = APPPATH . 'modules/image_validator_tester/uploads/';
        $thumbs_dir = $uploads_dir . 'thumbs/';
        
        // Delete all files in uploads
        if (is_dir($uploads_dir)) {
            $files = glob($uploads_dir . '*');
            foreach ($files as $file) {
                if (is_file($file) && basename($file) !== 'index.html') {
                    unlink($file);
                }
            }
        }
        
        // Delete all files in thumbs
        if (is_dir($thumbs_dir)) {
            $files = glob($thumbs_dir . '*');
            foreach ($files as $file) {
                if (is_file($file) && basename($file) !== 'index.html') {
                    unlink($file);
                }
            }
        }
        
        set_flashdata('Upload directories cleaned up!');
        redirect('image_validator_tester');
    }

}
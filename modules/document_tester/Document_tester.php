<?php
class Document_tester extends Trongate {

    function index() {
        $data['view_module'] = 'document_tester';
        $data['view_file'] = 'upload_form';
        $this->view('upload_form', $data);
    }

    function submit() {

        //$this->validation->set_language('es');
        $this->validation->reset_language();

        $this->validation->set_rules(
            'userfile', 
            'document', 
            'required|allowed_types[pdf,zip,txt]|max_size[2000]'
        );

        if ($this->validation->run() === true) {
            $config = [
                'destination' => 'uploads',
                'upload_to_module' => true,
                'make_rand_name' => true
            ];
            
            $file_info = $this->file->upload($config);
            
            set_flashdata('The file was successfully validated and uploaded.');
            
            // Just pass the filename. It's cleaner and avoids routing errors.
            redirect('document_tester/success/' . $file_info['file_name']);
        } else {
            $this->index();
        }
    }

    function success($filename = '') {
        // Reconstruct the browser-accessible URL here
        $data['download_url'] = 'document_tester_module/uploads/' . $filename;
        $data['filename'] = $filename;
        $data['view_module'] = 'document_tester';
        $data['view_file'] = 'upload_success';
        $this->view('upload_success', $data);
    }
}
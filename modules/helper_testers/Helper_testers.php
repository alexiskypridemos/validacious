<?php

/**
 * Helper Testers Module
 *
 * This module provides an overview page linking to all helper tester modules.
 */
class Helper_testers extends Trongate {

  /**
   * Display the overview page with links to all tester modules
   *
   * @return void
   */
  public function index(): void {
    $data['testers'] = $this->get_testers_info();
    $data['view_module'] = $this->module_name;
    $data['view_file'] = 'overview';
    $this->view('overview', $data);
  }

  /**
   * Display a README file for a specific tester module
   *
   * @return void
   */
  public function show_readme(): void {
    $module_name = segment(4, 'string');

    if (empty($module_name)) {
      $this->index();
      return;
    }

    $readme_path = APPPATH . 'modules/' . $module_name . '/README.md';

    if (!file_exists($readme_path)) {
      $data['error'] = 'README file not found for module: ' . htmlspecialchars($module_name);
      $data['view_module'] = $this->module_name;
      $data['view_file'] = 'readme_error';
      $this->view('readme_error', $data);
      return;
    }

    $content = file_get_contents($readme_path);
    $data['content'] = $this->markdown_to_html($content);
    $data['module_name'] = htmlspecialchars($module_name);
    $data['view_module'] = $this->module_name;
    $data['view_file'] = 'readme_display';
    $this->view('readme_display', $data);
  }

  /**
   * Get information about all tester modules
   *
   * @return array
   */
  private function get_testers_info(): array {
    return [
      [
        'name' => 'Form Helper Tester',
        'description' => 'Tests all form input generation functions (inputs, checkboxes, textareas, etc.)',
        'url' => 'form_helper_tester',
        'readme' => 'helper_testers/show_readme/form_helper_tester'
      ],
      [
        'name' => 'Flashdata Helper Tester',
        'description' => 'Tests flash message setting and retrieval with HTML wrapping',
        'url' => 'flashdata_helper_tester',
        'readme' => 'helper_testers/show_readme/flashdata_helper_tester'
      ],
      [
        'name' => 'String Helper Tester',
        'description' => 'Tests string manipulation functions (truncation, slug generation, filtering)',
        'url' => 'string_helper_tester',
        'readme' => 'helper_testers/show_readme/string_helper_tester'
      ],
      [
        'name' => 'URL Helper Tester',
        'description' => 'Tests URL parsing and link generation functions',
        'url' => 'url_helper_tester',
        'readme' => 'helper_testers/show_readme/url_helper_tester'
      ],
      [
        'name' => 'Utilities Helper Tester',
        'description' => 'Tests utility functions (IP detection, sorting, file info)',
        'url' => 'utilities_helper_tester',
        'readme' => 'helper_testers/show_readme/utilities_helper_tester'
      ]
    ];
  }

  /**
   * Convert basic Markdown to HTML
   *
   * @param string $markdown The markdown content
   * @return string HTML content
   */
  private function markdown_to_html(string $markdown): string {
    $html = $markdown;

    // Escape problematic characters first, but preserve structure
    $html = htmlspecialchars($html, ENT_QUOTES, 'UTF-8');

    // Headers (must be done before other replacements)
    $html = preg_replace_callback('/^### (.*)$/m', fn($m) => '<h3>' . $m[1] . '</h3>', $html);
    $html = preg_replace_callback('/^## (.*)$/m', fn($m) => '<h2>' . $m[1] . '</h2>', $html);
    $html = preg_replace_callback('/^# (.*)$/m', fn($m) => '<h1>' . $m[1] . '</h1>', $html);

    // Bold
    $html = preg_replace_callback('/\*\*(.*?)\*\*/', fn($m) => '<strong>' . $m[1] . '</strong>', $html);

    // Lists
    $html = preg_replace_callback('/^\* (.*)$/m', fn($m) => '<li>' . $m[1] . '</li>', $html);
    $html = preg_replace_callback('/^\d+\. (.*)$/m', fn($m) => '<li>' . $m[1] . '</li>', $html);

    // Code blocks (basic)
    $html = preg_replace_callback('/```(.*?)```/s', fn($m) => '<pre><code>' . $m[1] . '</code></pre>', $html);
    $html = preg_replace_callback('/`(.*?)`/', fn($m) => '<code>' . $m[1] . '</code>', $html);

    // Links
    $html = preg_replace_callback('/\[([^\]]+)\]\(([^)]+)\)/', fn($m) => '<a href="' . htmlspecialchars($m[2]) . '">' . $m[1] . '</a>', $html);

    // Line breaks
    $html = nl2br($html);

    return $html;
  }
}

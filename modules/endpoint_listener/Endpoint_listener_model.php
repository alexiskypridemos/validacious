<?php
class Endpoint_listener_model extends Model {

    /**
     * Fetch all logged requests.
     *
     * @return array
     */
    function get_all(): array {
        $sql = 'SELECT * FROM endpoint_listener';
        return $this->db->query($sql, 'object');
    }

    /**
     * Build the full request URL from server variables.
     *
     * @return string
     */
    function build_request_url(): string {
        $scheme = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') ? 'https' : 'http';
        $host = $_SERVER['HTTP_HOST'] ?? '';
        $uri = $_SERVER['REQUEST_URI'] ?? '/';
        return $scheme . '://' . $host . $uri;
    }

    /**
     * Check if URL targets the endpoint_listener module.
     *
     * @param string $url
     * @return bool
     */
    function is_internal_request(string $url): bool {
        $special_str = BASE_URL . 'endpoint_listener';
        return strpos($url, $special_str) !== false;
    }

    /**
     * Extract HTTP headers from $_SERVER.
     *
     * @return array
     */
    function extract_headers(): array {
        $headers = [];
        foreach ($_SERVER as $k => $v) {
            if (str_starts_with($k, 'HTTP_')) {
                $headers[str_replace('_', '-', substr($k, 5))] = $v;
            }
        }
        return $headers;
    }

    /**
     * Get request payload, JSON-decoded if applicable.
     *
     * @return mixed
     */
    function get_request_payload(): mixed {
        $content_type = $_SERVER['CONTENT_TYPE'] ?? '';
        if (stripos($content_type, 'application/json') !== false) {
            $raw = file_get_contents('php://input');
            $decoded = json_decode($raw, true);
            return json_last_error() === JSON_ERROR_NONE ? $decoded : $raw;
        }
        return $_POST ?: file_get_contents('php://input') ?: null;
    }

    /**
     * Store a request record.
     *
     * @param string $url
     * @param array $headers
     * @param mixed $payload
     * @return void
     */
    function store_request(string $url, array $headers, mixed $payload): void {
        $payload_string = is_array($payload) || is_object($payload)
            ? json_encode($payload, JSON_UNESCAPED_SLASHES)
            : $payload;

        $insert = [
            'url'          => $url,
            'request_type' => $_SERVER['REQUEST_METHOD'] ?? '',
            'ip_address'   => $_SERVER['REMOTE_ADDR'] ?? '',
            'user_agent'   => $_SERVER['HTTP_USER_AGENT'] ?? null,
            'referrer'     => $_SERVER['HTTP_REFERER'] ?? null,
            'headers'      => json_encode($headers, JSON_UNESCAPED_SLASHES),
            'payload'      => $payload_string,
            'date_created' => time()
        ];

        $this->db->insert($insert, 'endpoint_listener');
    }

    /**
     * Remove all logged requests.
     *
     * @return void
     */
    function clear_all(): void {
        $this->db->query('DELETE FROM endpoint_listener');
        $this->db->query('TRUNCATE endpoint_listener');
    }

}
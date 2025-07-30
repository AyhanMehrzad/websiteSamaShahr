<?php
/**
 * Base Controller Class
 */

abstract class Controller {
    protected $db;
    protected $logger;
    
    public function __construct() {
        $this->db = Database::getInstance();
        $this->logger = new Logger(TELEGRAM_BOT_TOKEN, TELEGRAM_CHAT_ID);
    }
    
    protected function json($data, $statusCode = 200) {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data, JSON_PRETTY_PRINT);
    }
    
    protected function view($template, $data = []) {
        extract($data);
        $templatePath = __DIR__ . "/../views/$template.php";
        
        if (!file_exists($templatePath)) {
            throw new Exception("View template not found: $template");
        }
        
        ob_start();
        include $templatePath;
        $content = ob_get_clean();
        
        return $content;
    }
    
    protected function redirect($url, $statusCode = 302) {
        http_response_code($statusCode);
        header("Location: $url");
        exit;
    }
    
    protected function getRequestData() {
        $input = file_get_contents('php://input');
        return json_decode($input, true) ?: $_POST;
    }
    
    protected function getQueryParams() {
        return $_GET;
    }
    
    protected function validateRequired($data, $fields) {
        $errors = [];
        foreach ($fields as $field) {
            if (empty($data[$field])) {
                $errors[] = "$field is required";
            }
        }
        return $errors;
    }
    
    protected function sanitizeInput($data) {
        if (is_array($data)) {
            return array_map([$this, 'sanitizeInput'], $data);
        }
        return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
    }
    
    protected function uploadFile($file, $destination, $allowedExtensions = null) {
        if ($allowedExtensions === null) {
            $allowedExtensions = ALLOWED_EXTENSIONS;
        }
        
        if (!isset($file['tmp_name']) || !is_uploaded_file($file['tmp_name'])) {
            throw new Exception('No file uploaded');
        }
        
        $fileInfo = pathinfo($file['name']);
        $extension = strtolower($fileInfo['extension']);
        
        if (!in_array($extension, $allowedExtensions)) {
            throw new Exception('File type not allowed');
        }
        
        if ($file['size'] > UPLOAD_MAX_SIZE) {
            throw new Exception('File too large');
        }
        
        $uploadDir = __DIR__ . "/../public/uploads/$destination";
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
        
        $filename = uniqid() . '.' . $extension;
        $filepath = $uploadDir . '/' . $filename;
        
        if (!move_uploaded_file($file['tmp_name'], $filepath)) {
            throw new Exception('Failed to move uploaded file');
        }
        
        return $filename;
    }
    
    protected function isAjax() {
        return !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && 
               strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
    }
    
    protected function setFlash($key, $message) {
        if (!isset($_SESSION['flash'])) {
            $_SESSION['flash'] = [];
        }
        $_SESSION['flash'][$key] = $message;
    }
    
    protected function getFlash($key) {
        if (isset($_SESSION['flash'][$key])) {
            $message = $_SESSION['flash'][$key];
            unset($_SESSION['flash'][$key]);
            return $message;
        }
        return null;
    }
} 
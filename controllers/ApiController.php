<?php
/**
 * API Controller for AJAX requests
 */

class ApiController extends Controller {
    
    public function contact() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return $this->json(['error' => 'Method not allowed'], 405);
        }
        
        $data = $this->getRequestData();
        $errors = $this->validateRequired($data, ['name', 'email', 'message']);
        
        if (!empty($errors)) {
            return $this->json(['errors' => $errors], 400);
        }
        
        // Validate email
        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            return $this->json(['errors' => ['email' => 'Invalid email format']], 400);
        }
        
        try {
            // Sanitize input
            $name = $this->sanitizeInput($data['name']);
            $email = $this->sanitizeInput($data['email']);
            $message = $this->sanitizeInput($data['message']);
            
            // Save to database
            $this->db->insert('contacts', [
                'name' => $name,
                'email' => $email,
                'message' => $message,
                'created_at' => date('Y-m-d H:i:s')
            ]);
            
            return $this->json(['message' => 'Message sent successfully']);
        } catch (Exception $e) {
            return $this->json(['error' => 'Failed to send message'], 500);
        }
    }
    
    public function projects() {
        try {
            $projects = $this->db->fetchAll("SELECT * FROM projects ORDER BY created_at DESC");
            return $this->json(['projects' => $projects]);
        } catch (Exception $e) {
            return $this->json(['error' => 'Failed to fetch projects'], 500);
        }
    }
    
    public function project($id) {
        try {
            $project = $this->db->fetch("SELECT * FROM projects WHERE id = ?", [$id]);
            
            if (!$project) {
                return $this->json(['error' => 'Project not found'], 404);
            }
            
            return $this->json(['project' => $project]);
        } catch (Exception $e) {
            return $this->json(['error' => 'Failed to fetch project'], 500);
        }
    }
    
    public function upload() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return $this->json(['error' => 'Method not allowed'], 405);
        }
        
        if (!isset($_FILES['file'])) {
            return $this->json(['error' => 'No file uploaded'], 400);
        }
        
        try {
            $filename = $this->uploadFile($_FILES['file'], 'images');
            return $this->json(['filename' => $filename]);
        } catch (Exception $e) {
            return $this->json(['error' => $e->getMessage()], 400);
        }
    }
    
    public function search() {
        $query = $_GET['q'] ?? '';
        
        if (empty($query)) {
            return $this->json(['results' => []]);
        }
        
        try {
            $results = $this->db->fetchAll(
                "SELECT * FROM projects WHERE title LIKE ? OR description LIKE ?",
                ["%$query%", "%$query%"]
            );
            
            return $this->json(['results' => $results]);
        } catch (Exception $e) {
            return $this->json(['error' => 'Search failed'], 500);
        }
    }
} 
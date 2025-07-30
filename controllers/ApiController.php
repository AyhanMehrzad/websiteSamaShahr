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
            
            // Log the contact form submission
            $this->logger->logAccess();
            
            return $this->json(['message' => 'Message sent successfully']);
        } catch (Exception $e) {
            return $this->json(['error' => 'Failed to send message'], 500);
        }
    }
    
    public function projects() {
        // Static projects data for single page website
        $projects = [
            [
                'id' => 1,
                'title' => 'Sama Shahr Development',
                'description' => 'A modern residential development project',
                'image' => 'pic/project1.jpg'
            ],
            [
                'id' => 2,
                'title' => 'Urban Planning Project',
                'description' => 'Comprehensive urban planning and design',
                'image' => 'pic/project2.jpg'
            ]
        ];
        
        return $this->json(['projects' => $projects]);
    }
    
    public function project($id) {
        // Static project data
        $projects = [
            1 => [
                'id' => 1,
                'title' => 'Sama Shahr Development',
                'description' => 'A modern residential development project',
                'image' => 'pic/project1.jpg'
            ],
            2 => [
                'id' => 2,
                'title' => 'Urban Planning Project',
                'description' => 'Comprehensive urban planning and design',
                'image' => 'pic/project2.jpg'
            ]
        ];
        
        $project = $projects[$id] ?? null;
        
        if (!$project) {
            return $this->json(['error' => 'Project not found'], 404);
        }
        
        return $this->json(['project' => $project]);
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
        
        // Static projects data for search
        $projects = [
            [
                'id' => 1,
                'title' => 'Sama Shahr Development',
                'description' => 'A modern residential development project',
                'image' => 'pic/project1.jpg'
            ],
            [
                'id' => 2,
                'title' => 'Urban Planning Project',
                'description' => 'Comprehensive urban planning and design',
                'image' => 'pic/project2.jpg'
            ]
        ];
        
        // Simple search through static data
        $results = array_filter($projects, function($project) use ($query) {
            return stripos($project['title'], $query) !== false || 
                   stripos($project['description'], $query) !== false;
        });
        
        return $this->json(['results' => array_values($results)]);
    }
} 
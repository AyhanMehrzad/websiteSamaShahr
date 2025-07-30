<?php
/**
 * Home Controller
 */

class HomeController extends Controller {
    
    public function index() {
        // Log access
        $this->logger->logAccess();
        
        // Get any flash messages
        $flashMessage = $this->getFlash('message');
        
        // Render the home page
        return $this->view('home', [
            'title' => 'Sama Shahr - Welcome',
            'flashMessage' => $flashMessage
        ]);
    }
    
    public function about() {
        return $this->view('about', [
            'title' => 'About Us - Sama Shahr'
        ]);
    }
    
    public function contact() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $this->getRequestData();
            $errors = $this->validateRequired($data, ['name', 'email', 'message']);
            
            if (empty($errors)) {
                // Sanitize input
                $name = $this->sanitizeInput($data['name']);
                $email = $this->sanitizeInput($data['email']);
                $message = $this->sanitizeInput($data['message']);
                
                // Save to database
                try {
                    $this->db->insert('contacts', [
                        'name' => $name,
                        'email' => $email,
                        'message' => $message,
                        'created_at' => date('Y-m-d H:i:s')
                    ]);
                    
                    $this->setFlash('message', 'Thank you for your message! We will get back to you soon.');
                    $this->redirect('/');
                } catch (Exception $e) {
                    $errors[] = 'Failed to send message. Please try again.';
                }
            }
            
            if ($this->isAjax()) {
                return $this->json(['errors' => $errors], 400);
            }
        }
        
        return $this->view('contact', [
            'title' => 'Contact Us - Sama Shahr',
            'errors' => $errors ?? []
        ]);
    }
    
    public function projects() {
        // Get projects from database
        $projects = $this->db->fetchAll("SELECT * FROM projects ORDER BY created_at DESC");
        
        return $this->view('projects', [
            'title' => 'Our Projects - Sama Shahr',
            'projects' => $projects
        ]);
    }
    
    public function project($id) {
        $project = $this->db->fetch("SELECT * FROM projects WHERE id = ?", [$id]);
        
        if (!$project) {
            http_response_code(404);
            return $this->view('404', ['title' => 'Project Not Found']);
        }
        
        return $this->view('project-detail', [
            'title' => $project['title'] . ' - Sama Shahr',
            'project' => $project
        ]);
    }
} 
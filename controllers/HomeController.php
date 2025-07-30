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
                
                // Log the contact form submission
                $this->logger->logAccess();
                
                $this->setFlash('message', 'Thank you for your message! We will get back to you soon.');
                $this->redirect('/');
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
        
        return $this->view('projects', [
            'title' => 'Our Projects - Sama Shahr',
            'projects' => $projects
        ]);
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
            http_response_code(404);
            return $this->view('404', ['title' => 'Project Not Found']);
        }
        
        return $this->view('project-detail', [
            'title' => $project['title'] . ' - Sama Shahr',
            'project' => $project
        ]);
    }
} 
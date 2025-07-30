# Sama Shahr Website

A single-page website for Sama Shahr development project. This is a static website that displays information about the development project without requiring a database.

## Features

- **Static Content**: All content is hardcoded in PHP files for simplicity
- **Responsive Design**: Built with Bootstrap and custom CSS
- **Contact Form**: Form submissions are logged via Telegram bot
- **Access Logging**: All page visits are logged with IP and location data
- **Modern UI**: Clean, modern design with animations and effects

## Project Structure

```
websiteSamaSHahr/
├── config/
│   └── config.php          # Application configuration
├── controllers/
│   ├── ApiController.php   # API endpoints (static data)
│   └── HomeController.php  # Main page controller
├── core/
│   ├── Controller.php      # Base controller class
│   └── Router.php          # URL routing
├── public/
│   ├── index.php           # Main entry point
│   ├── logger.php          # Access logging functionality
│   ├── font/               # Custom fonts
│   └── pic/                # Images and media files
├── sass/                   # SCSS source files
├── style/                  # Compiled CSS files
└── views/                  # PHP view templates
```

## Setup

1. **Install XAMPP** and place this project in `htdocs/`
2. **Start Apache** in XAMPP Control Panel
3. **Access the website** at `http://localhost/websiteSamaSHahr/public/`

## Database-Free Design

This website has been designed to work without a database:

- **Static Content**: All project information is hardcoded in PHP arrays
- **Contact Forms**: Form submissions are logged via Telegram instead of stored in database
- **Access Logging**: Page visits are logged to files and sent to Telegram
- **No Database Setup Required**: Simply start Apache and the website works

## Contact Form

The contact form sends notifications to a Telegram bot instead of storing data in a database. This provides:

- Instant notifications
- No database maintenance
- Simple setup
- Privacy-friendly (no data storage)

## Customization

To modify content:

- Edit the static arrays in `controllers/HomeController.php` and `controllers/ApiController.php`
- Update images in the `public/pic/` directory
- Modify styles in the `sass/` directory

## Requirements

- PHP 7.4+
- Apache web server
- cURL extension (for Telegram notifications)
- No database required!

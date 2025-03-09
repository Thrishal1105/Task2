# PHP Blog Application

A simple yet powerful blog application built with PHP, MySQL, and Bootstrap. This application allows users to create accounts, write blog posts, and manage their content with a clean and modern interface.

## Features

- **User Authentication**
  - Secure user registration and login
  - Password hashing for security
  - Session management
  - Protection against SQL injection

- **Blog Post Management**
  - Create new posts
  - Edit existing posts
  - Delete posts
  - View all posts with author information
  - Responsive design for all devices

- **Modern UI/UX**
  - Clean and intuitive interface
  - Bootstrap 4 styling
  - Font Awesome icons
  - Responsive layout
  - Interactive hover effects
  - Form validation with feedback

## Requirements

- PHP 7.0 or higher
- MySQL 5.6 or higher
- Apache/Nginx web server
- WAMP/XAMPP/MAMP (for local development)

## Installation

1. **Set up your web server**
   - If using WAMP, place the files in the `www` directory
   - For XAMPP, use the `htdocs` directory

2. **Database Configuration**
   - Create a MySQL database named `blog`
   - The application will automatically create the required tables
   - Default database configuration (in `config.php`):
     ```php
     define('DB_SERVER', 'localhost');
     define('DB_USERNAME', 'root');
     define('DB_PASSWORD', '');
     define('DB_NAME', 'blog');
     ```

3. **File Structure**
   ```
   blog-app/
   ├── config.php           # Database configuration
   ├── index.php           # Main blog listing page
   ├── login.php           # User login
   ├── register.php        # User registration
   ├── create_post.php     # Create new posts
   ├── edit_post.php       # Edit existing posts
   ├── logout.php          # User logout
   ├── style.css           # Custom styles
   ├── error.php           # Error handling page
   └── README.md           # Documentation
   ```

## Usage

1. **Registration**
   - Visit the registration page
   - Create an account with a username and password
   - Passwords must be at least 6 characters long

2. **Login**
   - Use your credentials to log in
   - Session will be maintained until logout

3. **Creating Posts**
   - Click "New Post" button
   - Enter title and content
   - Click "Publish Post" to save

4. **Managing Posts**
   - View all posts on the home page
   - Edit or delete your own posts
   - Posts show author name and timestamp

## Security Features

- Password hashing using PHP's `password_hash()`
- Prepared statements to prevent SQL injection
- Input validation and sanitization
- Session-based authentication
- CSRF protection through form tokens

## Styling Customization

The application uses CSS variables for easy theme customization. Main colors can be modified in `style.css`:

```css
:root {
    --primary-color: #2c3e50;
    --secondary-color: #3498db;
    --accent-color: #e74c3c;
    --background-color: #f8f9fa;
    --text-color: #2c3e50;
    --border-color: #e9ecef;
}
```

## Contributing

Feel free to fork this repository and submit pull requests for any improvements.

## License

This project is open-source and available under the MIT License.

## Support

For issues or questions, please open an issue in the repository.

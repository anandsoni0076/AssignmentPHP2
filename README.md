# Blog Post PHP Project

## Overview

This project is a simple PHP-based blog application that allows users to create, edit, and save blog posts. It features a rich text editor (TinyMCE) for content creation and supports auto-saving drafts to prevent data loss.

## Features

- **User Authentication**: Users can log in and manage their posts.
- **Post Creation**: Create new blog posts with a title, content, and tags.
- **Draft Management**: Save posts as drafts and automatically save content at regular intervals.
- **Editing**: Load existing drafts for editing.
- **Rich Text Editing**: Utilize TinyMCE for a user-friendly text editing experience.

## Requirements

- PHP 7.0 or higher
- MySQL or MariaDB
- Xampp
- Internet connection (for TinyMCE CDN)

## Installation

1. **Clone the Repository**:
   ```bash
   git clone https://github.com/anandsoni0076/blog-post-php.git
   cd blog-post-php
   Set Up Database:

2. Set Up Database:
Create a MySQL database (e.g., blog_db).
Import the SQL file (database.sql) provided in the project to set up the necessary tables.
Configure Database Connection:

Open the config.php file and update the database connection parameters

Usage
Navigate to the project in your web browser (e.g., http://localhost/blog-post-php).
Log in with your credentials (if authentication is implemented).
Create a new post or edit existing drafts using the provided forms.
Use the TinyMCE editor for rich text editing.
Your drafts will auto-save every 30 seconds, and you can publish them whenever you're ready.
Contributing
Contributions are welcome! If you have suggestions for improvements or new features, feel free to open an issue or submit a pull request.

License
This project is open-source and available under the MIT License.

Acknowledgments
TinyMCE: A powerful rich text editor used in this project.
Bootstrap: For responsive design and layout (if used).
PHP: The server-side language used for this project.

# Simple Blog Application

This is a simple blog application built using PHP and MySQL. The application allows users to create, read, update, and delete blog posts. User authentication is implemented to ensure that only authenticated users can create, edit, and delete their own posts. All users, including non-authenticated users, can view the list of blog posts and individual blog posts.

## Features

1. **User Authentication**:
   - Users can register with a username, email, and password.
   - Users can log in and log out.
   - Passwords are hashed before storing them in the database.

2. **Blog Posts**:
   - Only authenticated users can create, edit, and delete their own blog posts.
   - All users can view the list of blog posts and individual blog posts.

## Setup Instructions

1. **Clone the Repository**:
   ```bash
   git clone https://github.com/yourusername/simple-blog-application.git
   cd simple-blog-application

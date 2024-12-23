## Overview
Muse is a platform where users can upload, share, and discover artwork. Inspired by platforms like Instagram and Pinterest, it allows users to explore and generate random art prompts, create posts, and interact with a feed of content shared by others.

## Instructions on how to access:
- Link: http://muse.us-east-1.elasticbeanstalk.com/index.php
- **Important Note**:
    - All pages are functional except for the Register page, due to domain setup issues:
        - The Register page currently throws a security error because HTTPS is not enabled (pending domain registration).
    - **Testing Instructions**:
        - To test the JavaScript validation, please use the Login page with the following test user credentials:
            Username: luna
            Password: 123456

## Features
- **10+ Pages for Navigation**:
    - Home, Profile, Feed, Explore Prompts, Login, Register, Create Post, Edit Post, Image Detail, About, Contact, and Terms & Conditions.

- **Database Connection and Session Handling**:
    - Utilizes a MySQL database to manage user accounts, posts, and prompts.
    - Employs PHP sessions to securely manage user login states and personalized experiences.

- **Client-Side Validation with JavaScript**:
    - Ensures proper form validation before submission using JavaScript.
    - Provides real-time feedback to users for seamless interactions.

- **CRUD Functionality**:
    - Supports Create, Read, Update, and Delete operations for user posts.
    - Users can add, edit, or delete posts and captions directly from their profile.

- **Image Upload and Management**:
    - Allows users to upload images for posts.
    - Includes features to preview and resize images before uploading.

## Technologies Used
- **Front-End**: HTML, CSS, JavaScript
- **Back-End**: PHP, MySQL
- **Database**: MySQL
- **Version Control**: Git and GitHub
- **Deployment**: AWS Elastic Beanstalk

## Challenges
- **Issues with XAMPP Database Connections**:
    - Encountered difficulties in setting up and connecting to the MySQL database using XAMPP. 
    - Resolved by debugging the config.php file and ensuring proper database credentials and server configurations.

- **Problems with Image Upload and User Permissions**:
    - Faced challenges in handling file uploads, ensuring uploaded images were resized and displayed properly. 
    - Resolved permission issues by configuring the server and ensuring the correct file paths and access levels for uploaded files.

- **JavaScript Validation Issues**:
    - Initial issues with client-side form validation caused some inputs to bypass the expected constraints. 
    - Debugged JavaScript validation scripts to ensure proper error handling and user feedback.

## Learnings
- Improved knowledge of PHP and MySQL for back-end development.
- Enhanced understanding of JavaScript for interactive features.
- Learned effective debugging techniques for web applications.

## Future enhancements
- **Like and Comment Feature**: Allow users to interact with posts.
- **Search Functionality**: Add search/filter options for posts and users.
- **follow functionality**: Add follow/friend feature for registered users.
- **API Integration**: Use external APIs for additional art prompts.



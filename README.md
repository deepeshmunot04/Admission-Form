Full-Stack Web Application with React, Node.js, and MySQL
Overview
This is a full-stack web application that demonstrates CRUD (Create, Read, Update, Delete) operations on a MySQL database. The frontend is built using React for dynamic and interactive user interfaces, while the backend is implemented with Node.js and Express.js for API services. The database layer uses MySQL for data persistence.

Features
Frontend
Responsive design using React.
Interactive components for smooth user experience.
Integrated API calls using Axios or Fetch API for seamless communication with the backend.
Backend
RESTful API principles followed for consistent and scalable design.
Built with Node.js and Express.js for fast and efficient server-side operations.
Error handling and validation for robust functionality.
Database
MySQL used for structured data storage.
Schema designed to optimize queries and maintain data integrity.
Technologies Used
Frontend: React
Backend: Node.js, Express.js
Database: MySQL
Tools: Postman (for API testing), Visual Studio Code
Requirements
Frontend:
Node.js 16.x or higher
npm or Yarn for dependency management
Backend:
Node.js 16.x or higher
MySQL 8.0 or higher
Development Tools:
Visual Studio Code / WebStorm / any preferred IDE
Setup Instructions
1. Clone the Repository git clone https://github.com/your-username/your-repo-name.git cd your-repo-name

2. Install Dependencies Frontend: bash

cd frontend npm install

Backend: bash cd backend npm install

3. Configure the Database Create a MySQL database:

sql

CREATE DATABASE your_database_name; Update the database configuration file (e.g., .env or config.js) with your MySQL credentials:

DB_HOST=localhost DB_USER=root DB_PASSWORD=your_password DB_NAME=your_database_name

4. Run the Application Backend: bash cd backend node server.js Frontend: bash cd frontend npm start The application will run on: Frontend: http://localhost:3000 Backend: http://localhost:5000

API Endpoints
Category CRUD Operations GET All Categories: GET /api/categories

Create a New Category: POST /api/categories Sample Payload:

{ "categoryName": "Utilities" } GET Category by ID: GET /api/categories/{id}

Update Category by ID: PUT /api/categories/{id} Sample Payload: { "categoryName": "Most Sold" } Delete Category by ID: DELETE /api/categories/{id}

Testing Instructions
Use Postman or any REST client to test the API endpoints. Ensure the MySQL database is running before starting the backend server. Use the sample payloads provided above for API requests.

Notes
Ensure proper IDs are used for GET, PUT, and DELETE operations. Application supports pagination for listing categories or products (?page={number}).

Author
Name: Deepesh Munot
Email: deepeshmunot71@gmail.com
GitHub: deepeshmunot04
LinkedIn: https://www.linkedin.com/in/deepesh-munot-71b43b234

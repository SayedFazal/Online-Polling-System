**Online Polling System**
Description:
The Online Polling System is a web-based application that allows users to participate in voting for different groups. The application is designed with two types of users: voters and admin/group.
Voters can vote for their preferred group, while admins can publish the voting results. The system also provides a professional interface with dynamic features like confetti effects when the 
results are published.

Features:
1) User Authentication: Users must log in before accessing the system.
2) Voting Mechanism: Voters can vote for a group, and once they vote, their status is updated.
3) Admin Panel: Admins can view group votes, publish results, and handle voting data.
4) Result Display: After publishing, the group with the highest votes is shown as the winner.

Tech Stack: 
  Frontend: HTML, CSS, JavaScript
  Backend: PHP
  Database: MySQL (for storing user data and votes)

Prerequisites
To run this project locally, you'll need:
  PHP (version 7 or higher)
  MySQL or MariaDB for the database
  A web server like XAMPP local development

Setup
1. Clone the repository: git clone https://github.com/your-username/online-polling-system.git
2. Navigate to the project directory: cd online-polling-system
3. Setup the Database
  Create a database in MySQL (e.g., online_polling_system).
  Import the database schema and tables from the provided .sql file.
4. Configuration
  Open the project directory and navigate to the PHP files.
  Update the database connection settings in config.php (if you have a separate configuration file).
  Ensure the uploads folder is writable for user images and other file uploads.
5. Run the Project
  Launch your local server (e.g., XAMPP) and navigate to localhost or 127.0.0.1
  Open the index at localhost/online-polling-system/index.html.

Contributing:
  If you want to contribute to this project, feel free to fork the repository, make your changes, and create a pull request. Here are some steps to get started:
    Fork the repository
    Clone your fork locally
    Create a new branch
    Make changes and commit them
    Push the changes and create a pull request

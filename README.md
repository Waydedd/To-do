# To-Do List with Reminders

## Overview

This project is a simple PHP-based to-do list application with reminder functionality. Users can add tasks with optional due dates and reminders, view their tasks, and delete them as needed. Additionally, reminders for tasks set for the current date are displayed prominently.

## Features

* Add tasks with optional due dates and reminder dates.
* View all tasks in a user-friendly list format.
* Display tasks with reminders for the current day.
* Delete tasks when no longer needed.

## Technologies Used

* **Frontend**: HTML, CSS
* **Backend**: PHP
* **Database**: MySQL

## Prerequisites

* PHP (7.4 or higher)
* MySQL (or MariaDB)
* Web server (e.g., Apache, Nginx, or XAMPP for local development)

## Installation

1. Clone the repository or download the source code.
2. Create a MySQL database named `todo_list` and run the following SQL command to set up the `tasks` table:

   ```sql
   CREATE TABLE tasks (
       id INT AUTO_INCREMENT PRIMARY KEY,
       task_name VARCHAR(255) NOT NULL,
       due_date DATE,
       reminder_date DATE
   );
   ```
3. Update the database connection settings in the code:

   ```php
   $servername = "localhost";
   $username = "root";
   $password = "";
   $dbname = "todo_list";
   ```

   Modify these variables to match your environment.
4. Place the code in your web server’s root directory (e.g., `htdocs` for XAMPP).
5. Start your web server and open the application in a browser (e.g., `http://localhost/todo-list`).

## Usage

### Adding Tasks

1. Enter the task name in the input field.
2. Optionally, specify a due date and reminder date.
3. Click the "Add Task" button.

### Viewing Tasks

* All tasks are listed under the "Your Tasks" section.
* Tasks with reminders set for today are highlighted under "Today's Reminders."

### Deleting Tasks

* Click the "Delete" button next to a task to remove it.

## File Structure

* **index.php**: Main application logic and interface.
* **tasks**: MySQL table used to store task data.

## Potential Improvements

* Add user authentication to allow multiple users.
* Implement AJAX for smoother task management.
* Enhance the UI with a modern CSS framework (e.g., Bootstrap, Tailwind CSS).
* Add email notifications for reminders.

## License

This project is open-source and available under the [MIT License](LICENSE).

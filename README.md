# Task Manager Symfony Project Setup

This guide will help you set up the **Task Manager** project from scratch. It includes all the necessary steps to clone the project, 
configure the environment, and grant the necessary privileges to your MySQL database.

# Project Structure:

```bash
task-manager/
├── src/
│   ├── Controller/
│   │   └── TaskController.php
│   ├── Entity/
│   │   └── Task.php
│   ├── Repository/
│   │   └── TaskRepository.php
│   ├── Service/
│   │   └── TaskService.php
│   └── …
├── templates/
│   ├── base.html.twig
│   ├── task/
│   │   ├── index.html.twig
│   │   ├── create.html.twig
│   │   ├── edit.html.twig
```



## Prerequisites

Before starting, you need to have the following installed:

- **PHP** (version 8.0 or higher)
- **Composer** (PHP dependency manager)
- **MySQL** (or MariaDB) Database
- **Symfony** CLI (optional, but recommended for easier Symfony management)

## 1. Clone the Repository

First, clone this repository to your local machine.

```bash
git clone git@github.com:max-behrens/TaskManager.git
cd TaskManager
```

2. Set Up Your Environment
3.1. Database Configuration
Create a .env file in the root of your project if it doesn't exist already, or copy .env.dev to create it.
```bash
cp .env.dev .env
```
Add the following to your .env file:
```bash
DATABASE_URL="mysql://root:r00tadmin@127.0.0.1:3306/task_manager?serverVersion=5.7"
```
Make sure to replace r00tadmin with your MySQL root password.

Also, make sure that the following is in .emv.dev:
```bash
APP_SECRET=0c576a81577c27b66e249f687e317392
```

3. Install Dependencies
Install the project dependencies using Composer. In the root of the project directory, run:

```bash
composer install
```


3.2. Create the Database
If the task_manager database does not exist, create it by running the following command:

```bash
php bin/console doctrine:database:create
```

3.3. Grant Privileges (if needed)
In case you don't have the required privileges for the database, you can grant them with the following commands (run these in the MySQL CLI):

```bash
GRANT ALL PRIVILEGES ON task_manager.* TO 'root'@'127.0.0.1';
FLUSH PRIVILEGES;
This grants full access to the task_manager database for the root user.
```

4. Migrate the Database
Now, run the migrations to set up the database schema (tables, etc.):

```bash
php bin/console doctrine:migrations:migrate
```
This will create the necessary tables, including tasks, and set up the created_at, updated_at, and deleted_at fields for your entities.

5. Run npm Commands
Run both of these commands in the following order:
```bash
npm install
```
```bash
npm run dev
```
You may need to run npm run dev in the IDE terminal if it throws an error in powershell.

6. Configure Your Web Server
To run the application, enter the following command:

```bash
symfony server:start
```

7. Running the Application
To access the application, open your browser and go to:

http://127.0.0.1:8000/tasks
If everything is set up correctly, you should be able to see the Task Manager.

8. Test the Application
Test the CRUD functionality to ensure everything is working:

Create a Task: Add new tasks through the form.
Edit a Task: Edit the tasks you've added.
Delete a Task: Remove tasks.
Pagination: Ensure pagination works when there are more than 5 tasks per page.
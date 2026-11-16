
# Tasks for Today Management System

A Laravel-based task management application developed for IT0049 - Web System Technologies, Technical Summative Assessment 4.

## Project Overview

Tasks for Today is a web-based application that allows users to organize, manage, and monitor their daily tasks. It provides task creation, editing, updating, and archiving features, together with user authentication and automatic email notifications when a task is completed.

## Technologies Used

- Laravel 12
- PHP 8.2+
- MySQL
- Laravel Breeze
- Blade Templates
- Tailwind CSS
- JavaScript
- Vite
- Laravel Mail

## Features

### Task Management
- View all active tasks.
- Create new tasks.
- Edit existing tasks.
- Update task status.
- Archive tasks using soft deletion.
- Filter archived tasks from the active task list.

### Authentication
- User registration.
- User login and logout.
- Profile management.
- Protected task management routes.

### Email Notifications
- Automatically generates an email when a task changes from Pending to Done.
- Uses Laravel's Mail facade.
- Uses a Mailable class and Blade email template.
- Prevents repeated notifications when an already completed task is updated.
- Supports Laravel's log mail driver for testing.

### Dashboard
- Total active task count.
- Completed task count.
- Pending task count.
- Today's scheduled tasks.

## Installation and Setup

### 1. Clone the Repository

```bash
git clone https://github.com/alyanahh/tasks-for-today-tsa4.git
cd tasks-for-today-tsa4
```

### 2. Install Dependencies

```bash
composer install
npm install
```

### 3. Environment Configuration

Copy the example environment file:

```bash
cp .env.example .env
```

Generate an application key:

```bash
php artisan key:generate
```

Configure your database settings in `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=tasks_for_today
DB_USERNAME=root
DB_PASSWORD=
```

Create the `tasks_for_today` database in MySQL or phpMyAdmin.

### 4. Configure Email Notifications

For local email testing, configure:

```env
MAIL_MAILER=log
MAIL_FROM_ADDRESS="tasks@example.com"
MAIL_FROM_NAME="Tasks for Today"
TASK_NOTIFICATION_EMAIL="your-email@example.com"
```

Replace the recipient with your preferred test email address.

Generated email content can be checked in:

```text
storage/logs/laravel.log
```

### 5. Run Database Migrations

```bash
php artisan migrate
```

### 6. Build Frontend Assets

```bash
npm run build
```

### 7. Start the Application

```bash
php artisan serve
```

Open the application at:

http://127.0.0.1:8000

## Task Status

The application supports two task statuses:

- Pending
- Done

When a task changes from Pending to Done, Laravel generates a completion notification email.

## Soft Deletion

Tasks are archived using the `is_archived` database column.

Archived tasks are excluded from the active task list while remaining stored in the database.

## Security

- Authentication through Laravel Breeze.
- Protected task management routes.
- Server-side form validation.
- Password hashing.
- CSRF protection.
- Environment credentials excluded from version control.

## Project Information

**Course:** IT0049 - Web System Technologies

**Assessment:** Technical Summative Assessment 4

**Project:** Tasks for Today Management System

**GitHub Repository:**

https://github.com/alyanahh/tasks-for-today-tsa4

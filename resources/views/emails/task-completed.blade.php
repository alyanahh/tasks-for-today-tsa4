<!DOCTYPE html>
<html>
<head>
    <title>Task Completed</title>
</head>
<body>
    <h2>Task Completed!</h2>

    <p>Your task has been successfully marked as completed.</p>

    <p><strong>Task:</strong> {{ $task->title }}</p>
    <p><strong>Status:</strong> {{ ucfirst($task->status) }}</p>
    <p><strong>Date:</strong> {{ $task->task_date->format('Y-m-d') }}</p>

    <p>Thank you for using Tasks for Today!</p>
</body>
</html>

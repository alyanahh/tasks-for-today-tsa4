<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Mail\TaskCompleted;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class TaskController extends Controller
{
    // Dashboard / Welcome page
    public function welcome()
    {
        $activeTasks = Task::where('is_archived', false);

        $totalTasks = (clone $activeTasks)->count();

        $completedTasks = (clone $activeTasks)
            ->where('status', 'done')
            ->count();

        $pendingTasks = (clone $activeTasks)
            ->where('status', 'pending')
            ->count();

        $todayTasks = (clone $activeTasks)
            ->whereDate('task_date', today())
            ->orderBy('task_date')
            ->get();

        return view('welcome', compact(
            'totalTasks',
            'completedTasks',
            'pendingTasks',
            'todayTasks'
        ));
    }

    // Display all active tasks
    public function tasks()
    {
        $tasks = Task::where('is_archived', false)
            ->orderBy('task_date', 'asc')
            ->get();

        return view('tasks', compact('tasks'));
    }

    // Show create form
    public function create()
    {
        return view('tasks.create');
    }

    // Store new task
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:150',
            'status' => 'required|in:pending,done',
            'task_date' => 'required|date',
        ]);

        $validated['is_archived'] = false;

        Task::create($validated);

        return redirect()->route('tasks.index')
            ->with('success', 'Task created successfully!');
    }

    // Show edit form
    public function edit(Task $task)
    {
        abort_if($task->is_archived, 404);

        return view('tasks.edit', compact('task'));
    }

    // Update task and send completion email
    public function update(Request $request, Task $task)
    {
        abort_if($task->is_archived, 404);

        $validated = $request->validate([
            'title' => 'required|string|max:150',
            'status' => 'required|in:pending,done',
            'task_date' => 'required|date',
        ]);

        $wasNotDone = $task->status !== 'done';
        $isNowDone = $validated['status'] === 'done';

        $task->update($validated);

        if ($wasNotDone && $isNowDone) {
            Log::info('Task completion detected: ' . $task->title);

            $recipient = config('services.task_notification_email');

            if ($recipient) {
                Mail::to($recipient)->send(
                    new TaskCompleted($task)
                );

                Log::info(
                    'Task completion email sent to: ' . $recipient
                );
            } else {
                Log::error('Task notification recipient is missing.');
            }
        }

        return redirect()->route('tasks.index')
            ->with('success', 'Task updated successfully!');
    }

    // Archive task
    public function destroy(Task $task)
    {
        abort_if($task->is_archived, 404);

        $task->update([
            'is_archived' => true
        ]);

        return redirect()->route('tasks.index')
            ->with('success', 'Task archived successfully!');
    }

    // About page
    public function about()
    {
        return view('about');
    }
}

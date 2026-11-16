@extends('layouts.app')

@section('title', 'All Tasks')

@section('content')
<div class="hero">
    <h2>All Tasks</h2>
    <p>Complete list of active tasks.</p>
    <p>Total Tasks: {{ $tasks->count() }}</p>

    @auth
        <a href="{{ route('tasks.create') }}">+ Create Task</a>
    @endauth
</div>

<div class="card">
    @if(session('success'))
        <p>{{ session('success') }}</p>
    @endif

    <h3>Task List</h3>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Task</th>
                <th>Status</th>
                <th>Date</th>
                @auth
                    <th>Actions</th>
                @endauth
            </tr>
        </thead>

        <tbody>
            @forelse($tasks as $task)
                <tr>
                    <td>{{ $task->id }}</td>
                    <td>{{ $task->title }}</td>
                    <td>{{ ucfirst($task->status) }}</td>
                    <td>{{ $task->task_date->format('Y-m-d') }}</td>

                    @auth
                        <td>
                            <a href="{{ route('tasks.edit', $task->id) }}">Edit</a>

                            <form action="{{ route('tasks.destroy', $task->id) }}"
                                  method="POST"
                                  style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    onclick="return confirm('Archive this task?')">
                                    Archive
                                </button>
                            </form>
                        </td>
                    @endauth
                </tr>
            @empty
                <tr>
                    <td colspan="5">No tasks found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection

@extends('layouts.app')

@section('title', 'Edit Task')

@section('content')
<div class="hero">
    <h2>Edit Task</h2>
    <p>Update your task information.</p>
</div>

<div class="card">
    <form action="{{ route('tasks.update', $task->id) }}" method="POST">
        @csrf
        @method('PUT')

        <label>Task Title</label>
        <input type="text" name="title"
               value="{{ old('title', $task->title) }}" required>
        @error('title') <p>{{ $message }}</p> @enderror

        <label>Status</label>
        <select name="status" required>
            <option value="pending" {{ old('status', $task->status) == 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="done" {{ old('status', $task->status) == 'done' ? 'selected' : '' }}>Done</option>
        </select>

        <label>Task Date</label>
        <input type="date" name="task_date"
               value="{{ old('task_date', $task->task_date->format('Y-m-d')) }}" required>
        @error('task_date') <p>{{ $message }}</p> @enderror

        <button type="submit">Update Task</button>
        <a href="{{ route('tasks.index') }}">Cancel</a>
    </form>
</div>
@endsection

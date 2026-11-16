@extends('layouts.app')

@section('title', 'Create Task')

@section('content')
<div class="hero">
    <h2>Create Task</h2>
    <p>Add a new task to your list.</p>
</div>

<div class="card">
    <form action="{{ route('tasks.store') }}" method="POST">
        @csrf

        <label>Task Title</label>
        <input type="text" name="title" value="{{ old('title') }}" required>
        @error('title') <p>{{ $message }}</p> @enderror

        <label>Status</label>
        <select name="status" required>
            <option value="pending">Pending</option>
            <option value="done">Done</option>
        </select>

        <label>Task Date</label>
        <input type="date" name="task_date" value="{{ old('task_date') }}" required>
        @error('task_date') <p>{{ $message }}</p> @enderror

        <button type="submit">Save Task</button>
        <a href="{{ route('tasks.index') }}">Cancel</a>
    </form>
</div>
@endsection

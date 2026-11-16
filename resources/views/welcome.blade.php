@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

<style>
    .dashboard-wrapper {
        max-width: 1200px;
        margin: 30px auto;
        padding: 0 20px;
    }

    .dashboard-hero {
        background: linear-gradient(120deg, #a78bfa, #c4b5fd, #ddd6fe);
        border-radius: 24px;
        padding: 38px;
        color: #39245e;
        margin-bottom: 28px;
        box-shadow: 0 12px 30px rgba(139, 92, 246, .13);
    }

    .dashboard-hero h1 {
        font-size: 32px;
        font-weight: 800;
        margin-bottom: 10px;
    }

    .dashboard-hero p {
        color: #513b78;
        font-size: 15px;
    }

    .dashboard-actions {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
        margin-top: 22px;
    }

    .dashboard-btn {
        display: inline-block;
        padding: 11px 20px;
        border-radius: 11px;
        background: #ffffff;
        color: #7041bd !important;
        font-weight: 700;
        text-decoration: none;
        transition: .2s;
    }

    .dashboard-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(91, 33, 182, .15);
    }

    .dashboard-btn.primary {
        background: #7c3aed;
        color: white !important;
    }

    .dashboard-stats {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
        margin-bottom: 28px;
    }

    .stat-card {
        background: #ffffff;
        padding: 24px;
        border-radius: 20px;
        border: 1px solid #eee7ff;
        box-shadow: 0 6px 20px rgba(91, 33, 182, .05);
    }

    .stat-icon {
        width: 46px;
        height: 46px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        margin-bottom: 18px;
    }

    .stat-total .stat-icon {
        background: #eee7ff;
    }

    .stat-completed .stat-icon {
        background: #dcfce7;
    }

    .stat-pending .stat-icon {
        background: #fef3c7;
    }

    .stat-number {
        font-size: 30px;
        font-weight: 800;
        color: #39245e;
    }

    .stat-label {
        color: #81758f;
        font-size: 14px;
        margin-top: 4px;
    }

    .dashboard-section {
        background: #ffffff;
        border: 1px solid #eee7ff;
        border-radius: 22px;
        padding: 26px;
        box-shadow: 0 6px 20px rgba(91, 33, 182, .05);
        margin-bottom: 25px;
    }

    .section-heading {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 12px;
        margin-bottom: 22px;
        flex-wrap: wrap;
    }

    .section-heading h2 {
        font-size: 21px;
        font-weight: 800;
        color: #39245e;
    }

    .section-heading p {
        color: #81758f;
        font-size: 13px;
    }

    .dashboard-task {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 15px;
        padding: 17px;
        border: 1px solid #f0ebf8;
        border-radius: 14px;
        margin-bottom: 12px;
        transition: .2s;
    }

    .dashboard-task:hover {
        background: #faf7ff;
        border-color: #d8c6ff;
    }

    .task-name {
        color: #39245e;
        font-weight: 700;
        font-size: 15px;
    }

    .task-date {
        color: #9689a7;
        font-size: 12px;
        margin-top: 5px;
    }

    .task-badge {
        display: inline-block;
        padding: 6px 12px;
        border-radius: 30px;
        font-size: 11px;
        font-weight: 700;
        white-space: nowrap;
    }

    .badge-done {
        background: #dcfce7;
        color: #15803d;
    }

    .badge-pending {
        background: #fef3c7;
        color: #a16207;
    }

    .empty-state {
        text-align: center;
        padding: 45px 15px;
        color: #9689a7;
    }

    .empty-state .empty-icon {
        font-size: 42px;
        margin-bottom: 12px;
    }

    @media (max-width: 768px) {
        .dashboard-stats {
            grid-template-columns: 1fr;
        }

        .dashboard-hero {
            padding: 25px;
        }

        .dashboard-hero h1 {
            font-size: 25px;
        }

        .dashboard-section {
            padding: 18px;
        }
    }
</style>

<div class="dashboard-wrapper">

    <!-- Welcome Hero -->
    <div class="dashboard-hero">

        <h1>Welcome to Tasks for Today! 👋</h1>

        <p>
            Organize your schedule, manage your priorities,
            and keep track of your daily progress.
        </p>

        <p>
            {{ now()->format('l, F d, Y') }}
        </p>

        <div class="dashboard-actions">

            @auth
                <a href="{{ route('tasks.create') }}"
                   class="dashboard-btn primary">
                    + Create New Task
                </a>
            @endauth

            <a href="{{ route('tasks.index') }}"
               class="dashboard-btn">
                View All Tasks →
            </a>

        </div>

    </div>

    <!-- Statistics -->
    <div class="dashboard-stats">

        <div class="stat-card stat-total">

            <div class="stat-icon">📋</div>

            <div class="stat-number">
                {{ $totalTasks }}
            </div>

            <div class="stat-label">
                Total Active Tasks
            </div>

        </div>

        <div class="stat-card stat-completed">

            <div class="stat-icon">✓</div>

            <div class="stat-number">
                {{ $completedTasks }}
            </div>

            <div class="stat-label">
                Completed Tasks
            </div>

        </div>

        <div class="stat-card stat-pending">

            <div class="stat-icon">◷</div>

            <div class="stat-number">
                {{ $pendingTasks }}
            </div>

            <div class="stat-label">
                Pending Tasks
            </div>

        </div>

    </div>

    <!-- Today's Tasks -->
    <div class="dashboard-section">

        <div class="section-heading">

            <div>
                <h2>Today's Tasks</h2>
                <p>Your scheduled activities for today.</p>
            </div>

            <a href="{{ route('tasks.index') }}"
               style="color:#8b5cf6;font-weight:700;text-decoration:none;">
                View All →
            </a>

        </div>

        @forelse($todayTasks as $task)

            <div class="dashboard-task">

                <div>
                    <div class="task-name">
                        {{ $task->title }}
                    </div>

                    <div class="task-date">
                        {{ $task->task_date->format('F d, Y') }}
                    </div>
                </div>

                <div>
                    @if($task->status === 'done')
                        <span class="task-badge badge-done">
                            ✓ Completed
                        </span>
                    @else
                        <span class="task-badge badge-pending">
                            ◷ Pending
                        </span>
                    @endif
                </div>

            </div>

        @empty

            <div class="empty-state">

                <div class="empty-icon">📅</div>

                <h3 style="font-weight:700;color:#55436f;">
                    No Tasks Scheduled Today
                </h3>

                <p>
                    You're all clear! Add a task whenever you're ready.
                </p>

                @auth
                    <a href="{{ route('tasks.create') }}"
                       class="dashboard-btn primary"
                       style="margin-top:18px;">
                        Create a Task
                    </a>
                @endauth

            </div>

        @endforelse

    </div>

</div>

@endsection

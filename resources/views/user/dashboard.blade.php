@extends('layouts.app')

@section('title', 'User Dashboard')

@section('content')
<div class="container mt-5">
    <!-- Dashboard Header -->
    <div class="card shadow-sm">
        <div class="card-header text-center text-black">
            <h2 class="mb-0">User Dashboard</h2>
        </div>
        <div class="card-body">
            <!-- Search Bar -->
            <div class="mb-3">
                <input type="text" id="search" class="form-control" placeholder="Search tasks...">
            </div>

            <!-- Task Table -->
            <div class="table-responsive">
                <table class="table table-bordered table-striped text-center">
                    <thead class="bg-dark text-white">
                        <tr>
                            <th>Assigned By</th>
                            <th>Task Type</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="taskTable">
                        @foreach($tasks as $task)
                        <tr>
                            <td>{{ $task->admin->email }}</td>
                            <td>{{ ucfirst($task->task_type) }}</td>
                            <td>
                                <button class="btn btn-sm btn-success" onclick="completeTask({{ $task->id }}, '{{ $task->task_value }}')">Complete</button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Simple Pagination -->
            <div class="d-flex justify-content-center mt-3">
                @if ($tasks->lastPage() > 1)
                    <nav>
                        <ul class="pagination">
                            <li class="page-item {{ ($tasks->currentPage() == 1) ? ' disabled' : '' }}">
                                <a class="page-link" href="{{ $tasks->previousPageUrl() }}">Previous</a>
                            </li>
                            <li class="page-item next-page">
                                <a class="page-link" href="{{ $tasks->nextPageUrl() }}">Next</a>
                            </li>
                        </ul>
                    </nav>
                @endif
            </div>

            <!-- Message Box -->
            <div id="taskMessage" class="mt-3 text-center"></div>
        </div>
    </div>
</div>

<!-- Complete Task Modal -->
<div class="modal fade" id="taskModal" tabindex="-1" aria-labelledby="taskModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="taskModalLabel">Complete Task</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="taskId">
                <p id="taskPrompt"></p>
                <input type="text" id="taskValue" class="form-control" placeholder="Type the task value">
                <div id="errorMessage" class="text-danger mt-2" style="display: none;"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="submitCompletion()">Submit</button>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('search').addEventListener('keyup', function() {
            let value = this.value.toLowerCase();
            let visibleRows = 0;
            
            document.querySelectorAll("#taskTable tr").forEach(row => {
                let text = row.textContent.toLowerCase();
                if (text.includes(value)) {
                    row.style.display = "";
                    visibleRows++;
                } else {
                    row.style.display = "none";
                }
            });

            // Disable next button if search results are 10 or fewer
            let nextPageButton = document.querySelector(".next-page");
            if (nextPageButton) {
                nextPageButton.classList.toggle('disabled', visibleRows <= 10);
            }
        });
    });

    function completeTask(taskId, taskValue) {
        document.getElementById('taskId').value = taskId;
        document.getElementById('taskPrompt').innerText = "Type this: " + taskValue;
        document.getElementById('errorMessage').style.display = 'none';
        document.getElementById('taskValue').value = '';
        let modal = new bootstrap.Modal(document.getElementById('taskModal'));
        modal.show();
    }

    function submitCompletion() {
        let taskId = document.getElementById('taskId').value;
        let taskValue = document.getElementById('taskValue').value;
        let errorMessageBox = document.getElementById('errorMessage');
        
        fetch('/user/complete-task', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            body: JSON.stringify({ task_id: taskId, task_value: taskValue })
        })
        .then(res => res.json())
        .then(data => {
            if (data.message) {
                localStorage.setItem('taskSuccessMessage', data.message);
                location.reload();
            } else if (data.error) {
                errorMessageBox.innerHTML = data.error;
                errorMessageBox.style.display = 'block';
            }
        })
        .catch(error => console.error('Error:', error));
    }

    document.addEventListener('DOMContentLoaded', function() {
        let message = localStorage.getItem('taskSuccessMessage');
        if (message) {
            document.getElementById('taskMessage').innerHTML = `<div class="alert alert-success">${message}</div>`;
            localStorage.removeItem('taskSuccessMessage');
        }
    });
</script>
@endsection

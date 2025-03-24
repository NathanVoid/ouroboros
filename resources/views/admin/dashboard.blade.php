@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="container mt-5">
    <!-- Dashboard Header -->
    <div class="card shadow-sm">
        <div class="card-header text-center text-black">
            <h2 class="mb-0">Admin Dashboard</h2>
        </div>
        <div class="card-body">
            <!-- Success Message Box -->
            <div id="taskMessage" class="mt-3 text-center"></div>

            <!-- Searchable User List -->
            <input type="text" id="searchInput" class="form-control mb-3" placeholder="Search users...">
            <div class="table-responsive">
                <table class="table table-bordered table-striped text-center">
                    <thead class="bg-dark text-white">
                        <tr>
                            <th>User</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="userTable">
                        @foreach($users as $user)
                        <tr>
                            <td>{{ $user->email }}</td>
                            <td>
                                <button class="btn btn-sm btn-primary" onclick="openAssignTaskModal({{ $user->id }})">Assign Task</button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $users->links() }}
            </div>
        </div>
    </div>
</div>

<!-- Assign Task Modal -->
<div class="modal fade" id="assignTaskModal" tabindex="-1" aria-labelledby="assignTaskModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="assignTaskModalLabel">Assign Task</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="userId">
                <p>Select task type:</p>
                <div class="form-check">
                    <input type="radio" id="textTask" name="taskType" value="text" class="form-check-input">
                    <label for="textTask" class="form-check-label">Text</label>
                </div>
                <div class="form-check">
                    <input type="radio" id="numberTask" name="taskType" value="number" class="form-check-input">
                    <label for="numberTask" class="form-check-label">Number</label>
                </div>
                <div id="taskErrorMessage" class="text-danger mt-2" style="display: none;"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="assignTask()">Assign</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        let message = localStorage.getItem('taskSuccessMessage');
        if (message) {
            document.getElementById('taskMessage').innerHTML = `<div class="alert alert-success">${message}</div>`;
            localStorage.removeItem('taskSuccessMessage');
        }

        // Search functionality
        document.getElementById('searchInput').addEventListener('keyup', function() {
            let filter = this.value.toLowerCase();
            let rows = document.querySelectorAll("#userTable tr");

            rows.forEach(row => {
                let email = row.cells[0].textContent.toLowerCase();
                row.style.display = email.includes(filter) ? "" : "none";
            });
        });
    });

    function openAssignTaskModal(userId) {
        document.getElementById('userId').value = userId;
        document.getElementById('taskErrorMessage').style.display = 'none';

        // Reset radio button selection
        document.querySelectorAll('input[name="taskType"]').forEach(radio => {
            radio.checked = false;
            radio.nextElementSibling.style.color = "";
        });

        let modal = new bootstrap.Modal(document.getElementById('assignTaskModal'));
        modal.show();
    }

    function assignTask() {
        let userId = document.getElementById('userId').value;
        let taskType = document.querySelector('input[name="taskType"]:checked');
        let errorMessageBox = document.getElementById('taskErrorMessage');

        // Validate radio button selection
        if (!taskType) {
            errorMessageBox.innerHTML = 'Please select a task type.';
            errorMessageBox.style.display = 'block';
            document.querySelectorAll('input[name="taskType"]').forEach(radio => {
                radio.nextElementSibling.style.color = "red";
            });
            return;
        }

        fetch('/admin/assign-task', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            body: JSON.stringify({ user_id: userId, task_type: taskType.value })
        })
        .then(res => res.json())
        .then(data => {
            if (data.message) {
                // Store success message
                localStorage.setItem('taskSuccessMessage', data.message);

                // Hide modal
                let modal = bootstrap.Modal.getInstance(document.getElementById('assignTaskModal'));
                modal.hide();

                // Reset modal form
                document.querySelectorAll('input[name="taskType"]').forEach(radio => {
                    radio.checked = false;
                });

                // Refresh page
                location.reload();
            }
        })
        .catch(error => console.error('Error:', error));
    }
</script>
@endsection

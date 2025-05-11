@extends('layouts.admin')

@section('title')
    Admin : Users Management
@endsection

@section('style')
    <link rel="stylesheet" href="/css/admin.css">
@endsection

@section('content')
<div class="container">
    <div class="my-3">
        <h3>
            <i class="bi bi-people"></i>
            Users Management
        </h3>
    </div>

    {{-- Create user & Modal --}}
    <div class="my-2">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createUserModal">
            <i class="bi bi-person-plus"></i>
            New User
        </button>
    </div>
    {{-- Include the modal body --}}
    @include('admin.users.create')

    {{-- Success and Error Alerts --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show d-flex align-items-center alertDelete" role="alert">
            <div>
                <i class="bi bi-check2-circle"></i>
                {{ session('success') }}
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center alertDelete mt-3" role="alert">
            <div>
                @foreach ($errors->all() as $error)
                    <p><i class="bi bi-exclamation-circle"></i> {{ $error }}</p>
                @endforeach
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Spinner --}}
    <div id="spinner" class="text-center my-5">
        <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>

    {{-- User Table --}}
    <div class="table-responsive" id="userTable" style="display: none;">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="userTableBody">
                {{-- Dynamic content will be loaded here via JavaScript --}}
            </tbody>
        </table>
    </div>
</div>


@endsection

@section('script')
<script src="/js/admin.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const spinner = document.getElementById('spinner');
        const userTable = document.getElementById('userTable');
        const userTableBody = document.getElementById('userTableBody');

        // Simulate loading data (replace with actual AJAX call later)
        setTimeout(() => {
            const users = [
                { id: 1, name: "John Doe", email: "john@example.com", role: "admin" },
                { id: 2, name: "Jane Smith", email: "jane@example.com", role: "customer" },
            ];

            // Populate the table
            users.forEach(user => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${user.id}</td>
                    <td>${user.name}</td>
                    <td>${user.email}</td>
                    <td>${user.role.charAt(0).toUpperCase() + user.role.slice(1)}</td>
                    <td>
                        <a href="/admin/users/${user.id}/edit" class="btn btn-sm btn-primary">Edit</a>
                        <form action="/admin/users/${user.id}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                `;
                userTableBody.appendChild(row);
            });

            // Hide spinner and show table
            spinner.style.display = 'none';
            userTable.style.display = 'block';
        }, 1500); // Simulate 1.5-second delay for loading
    });
</script>
@endsection
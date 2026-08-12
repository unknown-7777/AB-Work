@extends('layouts.dashboard')
@section('title', 'Manage Users')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">Manage Users</h4>
</div>


<form method="GET" class="bg-white rounded-3 shadow-sm p-3 mb-4">
    <div class="row g-2">
        <div class="col-md-5">
            <input type="text" name="search" class="form-control"
                   placeholder="Search name or email..." value="{{ request('search') }}">
        </div>
        <div class="col-md-3">
            <select name="role" class="form-select">
                <option value="">All Roles</option>
                <option value="client"     {{ request('role') == 'client'     ? 'selected' : '' }}>Client</option>
                <option value="freelancer" {{ request('role') == 'freelancer' ? 'selected' : '' }}>Freelancer</option>
                <option value="admin"      {{ request('role') == 'admin'      ? 'selected' : '' }}>Admin</option>
            </select>
        </div>
        <div class="col-md-2">
            <button class="btn btn-primary w-100">Filter</button>
        </div>
        <div class="col-md-2">
            <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary w-100">Reset</a>
        </div>
    </div>
</form>

<div class="bg-white rounded-3 shadow-sm">
    <table class="table table-hover mb-0">
        <thead class="table-light">
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Status</th>
                <th>Joined</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td>
                    <div class="d-flex align-items-center gap-2">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=2563eb&color=fff&size=28"
                             class="rounded-circle" width="28" height="28">
                        {{ $user->name }}
                    </div>
                </td>
                <td>{{ $user->email }}</td>
                <td>
                    <span class="badge
                        @if($user->role == 'admin') bg-danger
                        @elseif($user->role == 'client') bg-info
                        @else bg-success @endif">
                        {{ ucfirst($user->role) }}
                    </span>
                </td>
                <td>
                    <span class="badge {{ $user->is_active ? 'bg-success' : 'bg-danger' }}">
                        {{ $user->is_active ? 'Active' : 'Banned' }}
                    </span>
                </td>
                <td>{{ $user->created_at->format('M d, Y') }}</td>
                <td>
                    @if(!$user->isAdmin())
                    <div class="d-flex gap-2">
                        <form action="{{ route('admin.users.toggle', $user) }}" method="POST">
                            @csrf @method('PATCH')
                            <button class="btn btn-sm {{ $user->is_active ? 'btn-warning' : 'btn-success' }}">
                                {{ $user->is_active ? 'Ban' : 'Unban' }}
                            </button>
                        </form>
                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger"
                                    onclick="return confirm('Delete this user?')">
                                Delete
                            </button>
                        </form>
                    </div>
                    @else
                        <span class="text-muted small">Protected</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="p-3">{{ $users->links() }}</div>
</div>
@endsection
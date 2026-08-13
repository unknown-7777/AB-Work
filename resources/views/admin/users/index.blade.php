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
    <table class="table table-hover align-middle mb-0">
        <thead class="table-light">
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>

                <th style="width: 100px;">Status</th>
                <th>Joined</th>

                <th style="width: 140px;">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td>
                    <div class="d-flex align-items-center gap-2">
                        
                        @if($user->avatar)
                            <img src="{{ $user->avatarUrl() }}"
                                 class="rounded-circle" width="28" height="28"
                                 style="object-fit:cover;">
                        @else
                            <i class="bi bi-person-circle text-primary" style="font-size:28px; line-height:1;"></i>
                        @endif
                        
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

                    <span class="badge {{ $user->is_active ? 'bg-success' : 'bg-danger' }} d-inline-block text-center" style="width: 72px;">
                        {{ $user->is_active ? 'Active' : 'Banned' }}
                    </span>
                </td>
                <td>{{ $user->created_at->format('M d, Y') }}</td>
                <td>
                    @if(!$user->isAdmin())
                    <div class="d-flex gap-2">
                        <form action="{{ route('admin.users.toggle', $user) }}" method="POST" class="m-0">
                            @csrf 
                            @method('PATCH')

                            <button class="btn btn-sm {{ $user->is_active ? 'btn-warning' : 'btn-success' }} text-center" style="width: 58px; padding-left: 0; padding-right: 0;">
                                {{ $user->is_active ? 'Ban' : 'Unban' }}
                            </button>
                        </form>
                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="m-0">
                            @csrf @method('DELETE')
                            <button type="button" 
                                    class="btn btn-sm btn-danger" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#deleteModal" 
                                    data-route="{{ route('admin.users.destroy', $user) }}">
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
@extends('admin.layout')

@section('title', 'Clients')

@section('content')
    @php($editing = request()->query('edit') ? $clients->firstWhere('id', request()->query('edit')) : null)

    <section class="admin-section">
        <div class="section-head">
            <h2>{{ $editing ? 'Edit Client' : 'Add Client' }}</h2>
        </div>

        <form method="POST" action="{{ $editing ? route('admin.clients.update', $editing) : route('admin.clients.store') }}" class="admin-form">
            @csrf
            @if ($editing)
                @method('PUT')
            @endif

            <div class="form-row">
                <div class="form-field">
                    <label for="name">Name</label>
                    <input type="text" id="name" name="name" value="{{ old('name', $editing?->name) }}" required>
                </div>
                <div class="form-field">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email', $editing?->email) }}" required>
                </div>
                <div class="form-field">
                    <label for="phone">Phone</label>
                    <input type="text" id="phone" name="phone" value="{{ old('phone', $editing?->phone) }}">
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">{{ $editing ? 'Update' : 'Add Client' }}</button>
                @if ($editing)
                    <a href="{{ route('admin.clients') }}" class="btn btn-secondary">Cancel</a>
                @endif
            </div>
        </form>
    </section>

    <section class="admin-section">
        <div class="section-head">
            <h2>All Clients</h2>
        </div>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Appointments</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($clients as $client)
                    <tr>
                        <td>{{ $client->id }}</td>
                        <td>{{ $client->name }}</td>
                        <td>{{ $client->email }}</td>
                        <td>{{ $client->phone ?? '—' }}</td>
                        <td>{{ $client->appointments_count }}</td>
                        <td>
                            <div class="actions">
                                <a href="{{ route('admin.clients', ['edit' => $client->id]) }}" class="btn btn-secondary">Edit</a>
                                <form method="POST" action="{{ route('admin.clients.destroy', $client) }}" class="inline-form" onsubmit="return confirm('Delete this client?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">No clients yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </section>
@endsection

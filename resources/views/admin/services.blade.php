@extends('admin.layout')

@section('title', 'Services')

@section('content')
    @php($editing = request()->query('edit') ? $services->firstWhere('id', request()->query('edit')) : null)

    <section class="admin-section">
        <div class="section-head">
            <h2>{{ $editing ? 'Edit Service' : 'Add Service' }}</h2>
        </div>

        <form method="POST" action="{{ $editing ? route('admin.services.update', $editing) : route('admin.services.store') }}" class="admin-form">
            @csrf
            @if ($editing)
                @method('PUT')
            @endif

            <div class="form-row">
                <div class="form-field">
                    <label for="service_category_id">Category</label>
                    <select id="service_category_id" name="service_category_id" required>
                        <option value="">Select category</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" @selected(old('service_category_id', $editing?->service_category_id) == $category->id)>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-field">
                    <label for="name">Service Name</label>
                    <input type="text" id="name" name="name" value="{{ old('name', $editing?->name) }}" required>
                </div>
                <div class="form-field">
                    <label for="price">Price (₱)</label>
                    <input type="number" id="price" name="price" step="0.01" min="0" value="{{ old('price', $editing?->price) }}" required>
                </div>
                <div class="form-field">
                    <label for="duration_minutes">Duration (minutes)</label>
                    <input type="number" id="duration_minutes" name="duration_minutes" min="1" value="{{ old('duration_minutes', $editing?->duration_minutes) }}" required>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">{{ $editing ? 'Update' : 'Add Service' }}</button>
                @if ($editing)
                    <a href="{{ route('admin.services') }}" class="btn btn-secondary">Cancel</a>
                @endif
            </div>
        </form>
    </section>

    <section class="admin-section">
        <div class="section-head">
            <h2>All Services</h2>
        </div>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Service Name</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Duration</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($services as $service)
                    <tr>
                        <td>{{ $service->id }}</td>
                        <td>{{ $service->name }}</td>
                        <td>{{ $service->category?->name ?? '—' }}</td>
                        <td>@peso($service->price)</td>
                        <td>{{ $service->duration_minutes }} min</td>
                        <td>
                            <div class="actions">
                                <a href="{{ route('admin.services', ['edit' => $service->id]) }}" class="btn btn-secondary">Edit</a>
                                <form method="POST" action="{{ route('admin.services.destroy', $service) }}" class="inline-form" onsubmit="return confirm('Delete this service?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">No services yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </section>
@endsection

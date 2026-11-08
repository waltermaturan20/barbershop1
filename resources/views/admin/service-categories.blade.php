@extends('admin.layout')

@section('title', 'Service Categories')

@section('content')
    @php($editing = request()->query('edit') ? $categories->firstWhere('id', request()->query('edit')) : null)

    <section class="admin-section">
        <div class="section-head">
            <h2>{{ $editing ? 'Edit Category' : 'Add Category' }}</h2>
        </div>

        <form method="POST" action="{{ $editing ? route('admin.service-categories.update', $editing) : route('admin.service-categories.store') }}" class="admin-form">
            @csrf
            @if ($editing)
                @method('PUT')
            @endif

            <div class="form-row">
                <div class="form-field">
                    <label for="name">Category Name</label>
                    <input type="text" id="name" name="name" value="{{ old('name', $editing?->name) }}" required>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">{{ $editing ? 'Update' : 'Add Category' }}</button>
                @if ($editing)
                    <a href="{{ route('admin.service-categories') }}" class="btn btn-secondary">Cancel</a>
                @endif
            </div>
        </form>
    </section>

    <section class="admin-section">
        <div class="section-head">
            <h2>All Categories</h2>
        </div>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Category Name</th>
                    <th>Services</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($categories as $category)
                    <tr>
                        <td>{{ $category->id }}</td>
                        <td>{{ $category->name }}</td>
                        <td>{{ $category->services_count }}</td>
                        <td>
                            <div class="actions">
                                <a href="{{ route('admin.service-categories', ['edit' => $category->id]) }}" class="btn btn-secondary">Edit</a>
                                <form method="POST" action="{{ route('admin.service-categories.destroy', $category) }}" class="inline-form" onsubmit="return confirm('Delete this category?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4">No service categories yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </section>
@endsection

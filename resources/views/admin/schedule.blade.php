@extends('admin.layout')

@section('title', 'Schedule')

@section('content')
    @php($editing = request()->query('edit') ? $appointments->firstWhere('id', request()->query('edit')) : null)

    <section class="admin-section">
        <div class="section-head">
            <h2>{{ $editing ? 'Edit Appointment' : 'Book Appointment' }}</h2>
        </div>

        <form method="POST" action="{{ $editing ? route('admin.schedule.update', $editing) : route('admin.schedule.store') }}" class="admin-form">
            @csrf
            @if ($editing)
                @method('PUT')
            @endif

            <div class="form-row">
                <div class="form-field">
                    <label for="client_id">Client</label>
                    <select id="client_id" name="client_id" required>
                        <option value="">Select client</option>
                        @foreach ($clients as $client)
                            <option value="{{ $client->id }}" @selected(old('client_id', $editing?->client_id) == $client->id)>
                                {{ $client->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-field">
                    <label for="barber_id">Barber</label>
                    <select id="barber_id" name="barber_id" required>
                        <option value="">Select barber</option>
                        @foreach ($barbers as $barber)
                            <option value="{{ $barber->id }}" @selected(old('barber_id', $editing?->barber_id) == $barber->id)>
                                {{ $barber->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-field">
                    <label for="service_id">Service</label>
                    <select id="service_id" name="service_id" required>
                        <option value="">Select service</option>
                        @foreach ($services as $service)
                            <option value="{{ $service->id }}" @selected(old('service_id', $editing?->service_id) == $service->id)>
                                {{ $service->name }} — @peso($service->price)
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-row">
                <div class="form-field">
                    <label for="appointment_date">Date</label>
                    <input type="date" id="appointment_date" name="appointment_date"
                           value="{{ old('appointment_date', $editing?->appointment_date?->format('Y-m-d')) }}" required>
                </div>
                <div class="form-field">
                    <label for="appointment_time">Time</label>
                    <input type="time" id="appointment_time" name="appointment_time"
                           value="{{ old('appointment_time', $editing?->appointment_time) }}" required>
                </div>
                <div class="form-field">
                    <label for="status">Status</label>
                    <select id="status" name="status" required>
                        @foreach ($statuses as $status)
                            <option value="{{ $status }}" @selected(old('status', $editing?->status ?? 'pending') === $status)>
                                {{ ucfirst($status) }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-row">
                <div class="form-field form-field-full">
                    <label for="notes">Notes</label>
                    <input type="text" id="notes" name="notes" maxlength="1000"
                           value="{{ old('notes', $editing?->notes) }}" placeholder="Optional notes (e.g. preferred style)">
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">{{ $editing ? 'Update' : 'Book Appointment' }}</button>
                @if ($editing)
                    <a href="{{ route('admin.schedule') }}" class="btn btn-secondary">Cancel</a>
                @endif
            </div>
        </form>
    </section>

    <section class="admin-section">
        <div class="section-head">
            <h2>Appointments Schedule</h2>
        </div>

        <form method="GET" action="{{ route('admin.schedule') }}" class="filter-bar">
            <div class="form-field">
                <label for="filter-search">Search</label>
                <input type="text" id="filter-search" name="search" value="{{ $filters['search'] }}" placeholder="Client, barber, service">
            </div>
            <div class="form-field">
                <label for="filter-status">Status</label>
                <select id="filter-status" name="status">
                    <option value="">All</option>
                    @foreach ($statuses as $status)
                        <option value="{{ $status }}" @selected($filters['status'] === $status)>
                            {{ ucfirst($status) }} ({{ $statusCounts[$status] ?? 0 }})
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-field">
                <label for="filter-date">Date</label>
                <input type="date" id="filter-date" name="date" value="{{ $filters['date'] }}">
            </div>
            <div class="filter-actions">
                <button type="submit" class="btn btn-primary">Filter</button>
                <a href="{{ route('admin.schedule') }}" class="btn btn-secondary">Reset</a>
            </div>
        </form>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Client</th>
                    <th>Barber</th>
                    <th>Service</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Price</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($appointments as $appointment)
                    <tr>
                        <td>{{ $appointment->id }}</td>
                        <td>
                            {{ $appointment->client?->name ?? '—' }}
                            @if ($appointment->notes)
                                <div class="muted-text">{{ \Illuminate\Support\Str::limit($appointment->notes, 40) }}</div>
                            @endif
                        </td>
                        <td>{{ $appointment->barber?->name ?? '—' }}</td>
                        <td>{{ $appointment->service?->name ?? '—' }}</td>
                        <td>{{ $appointment->appointment_date->format('M d, Y') }}</td>
                        <td>{{ $appointment->appointment_time }}</td>
                        <td>@peso($appointment->service?->price ?? 0)</td>
                        <td><span class="badge badge-{{ $appointment->status }}">{{ ucfirst($appointment->status) }}</span></td>
                        <td>
                            <div class="actions">
                                @foreach (\App\Models\Appointment::STATUSES as $quickStatus)
                                    @if ($appointment->status !== $quickStatus)
                                        <form method="POST" action="{{ route('admin.schedule.status', $appointment) }}" class="inline-form">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="{{ $quickStatus }}">
                                            <input type="hidden" name="filter_status" value="{{ $filters['status'] }}">
                                            <input type="hidden" name="filter_date" value="{{ $filters['date'] }}">
                                            <input type="hidden" name="filter_search" value="{{ $filters['search'] }}">
                                            <button type="submit" class="btn btn-mini btn-quick" title="Set {{ $quickStatus }}">{{ ucfirst(substr($quickStatus, 0, 4)) }}</button>
                                        </form>
                                    @endif
                                @endforeach
                                <a href="{{ route('admin.schedule', array_filter(['edit' => $appointment->id, 'status' => $filters['status'], 'date' => $filters['date'], 'search' => $filters['search']])) }}" class="btn btn-secondary">Edit</a>
                                <form method="POST" action="{{ route('admin.schedule.destroy', $appointment) }}" class="inline-form" onsubmit="return confirm('Delete this appointment?')">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="filter_status" value="{{ $filters['status'] }}">
                                    <input type="hidden" name="filter_date" value="{{ $filters['date'] }}">
                                    <input type="hidden" name="filter_search" value="{{ $filters['search'] }}">
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9">No appointments match.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </section>
@endsection

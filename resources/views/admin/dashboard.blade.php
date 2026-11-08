@extends('admin.layout')

@section('title', 'Dashboard')

@section('content')
    <div class="stats-grid">
        <div class="stat-card">
            <h2>{{ $appointmentsCount }}</h2>
            <p>Total Appointments</p>
        </div>
        <div class="stat-card">
            <h2>{{ $clientsCount }}</h2>
            <p>Total Clients</p>
        </div>
        <div class="stat-card">
            <h2>{{ $barbersCount }}</h2>
            <p>Total Barbers</p>
        </div>
        <div class="stat-card">
            <h2>{{ $servicesCount }}</h2>
            <p>Total Services</p>
        </div>
        <div class="stat-card">
            <h2>{{ $todayCount }}</h2>
            <p>Today's Appointments</p>
        </div>
        <div class="stat-card">
            <h2>{{ $pendingCount }}</h2>
            <p>Pending</p>
        </div>
        <div class="stat-card">
            <h2>{{ $confirmedCount }}</h2>
            <p>Confirmed</p>
        </div>
        <div class="stat-card">
            <h2>@peso($monthSales)</h2>
            <p>This Month's Sales</p>
        </div>
    </div>

    <section class="admin-section">
        <div class="section-head">
            <h2>Today's Schedule</h2>
            <a href="{{ route('admin.schedule') }}" class="btn btn-secondary">Manage Schedule</a>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Time</th>
                    <th>Client</th>
                    <th>Service</th>
                    <th>Barber</th>
                    <th>Price</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($todayAppointments as $appointment)
                    <tr>
                        <td>{{ $appointment->appointment_time }}</td>
                        <td>{{ $appointment->client?->name ?? '—' }}</td>
                        <td>{{ $appointment->service?->name ?? '—' }}</td>
                        <td>{{ $appointment->barber?->name ?? '—' }}</td>
                        <td>@peso($appointment->service?->price ?? 0)</td>
                        <td><span class="badge badge-{{ $appointment->status }}">{{ ucfirst($appointment->status) }}</span></td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">No appointments today.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </section>

    <div class="dashboard-grid">
        <section class="admin-section">
            <h2>Recent Appointments</h2>
            <table>
                <thead>
                    <tr>
                        <th>Client</th>
                        <th>Service</th>
                        <th>Barber</th>
                        <th>Date</th>
                        <th>Price</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($recentAppointments as $appointment)
                        <tr>
                            <td>{{ $appointment->client?->name ?? '—' }}</td>
                            <td>{{ $appointment->service?->name ?? '—' }}</td>
                            <td>{{ $appointment->barber?->name ?? '—' }}</td>
                            <td>{{ $appointment->appointment_date->format('M d, Y') }}</td>
                            <td>@peso($appointment->service?->price ?? 0)</td>
                            <td><span class="badge badge-{{ $appointment->status }}">{{ ucfirst($appointment->status) }}</span></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">No appointments yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </section>

        <section class="admin-section">
            <h2>Upcoming</h2>
            <table>
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Client</th>
                        <th>Barber</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($upcomingAppointments as $appointment)
                        <tr>
                            <td>{{ $appointment->appointment_date->format('M d') }}</td>
                            <td>{{ $appointment->appointment_time }}</td>
                            <td>{{ $appointment->client?->name ?? '—' }}</td>
                            <td>{{ $appointment->barber?->name ?? '—' }}</td>
                            <td><span class="badge badge-{{ $appointment->status }}">{{ ucfirst($appointment->status) }}</span></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">No upcoming appointments.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </section>
    </div>
@endsection

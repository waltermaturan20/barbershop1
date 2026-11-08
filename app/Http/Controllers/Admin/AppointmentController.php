<?php

namespace App\Http\Controllers\Admin;

use App\Models\Appointment;
use App\Models\Barber;
use App\Models\Client;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AppointmentController extends AdminController
{
    public function index(Request $request)
    {
        if ($denied = $this->checkAuth($request)) {
            return $denied;
        }

        $query = Appointment::with(['client', 'barber', 'service'])
            ->orderByDesc('appointment_date')
            ->orderByDesc('appointment_time');

        if ($request->filled('status') && in_array($request->query('status'), Appointment::STATUSES, true)) {
            $query->where('status', $request->query('status'));
        }

        if ($request->filled('date')) {
            $query->whereDate('appointment_date', $request->query('date'));
        }

        if ($request->filled('search')) {
            $search = $request->query('search');
            $query->where(function ($q) use ($search) {
                $q->whereHas('client', fn ($cq) => $cq->where('name', 'like', "%{$search}%"))
                    ->orWhereHas('barber', fn ($bq) => $bq->where('name', 'like', "%{$search}%"))
                    ->orWhereHas('service', fn ($sq) => $sq->where('name', 'like', "%{$search}%"));
            });
        }

        $statusCounts = Appointment::query()
            ->select('status', DB::raw('COUNT(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status');

        return view('admin.schedule', [
            'appointments' => $query->get(),
            'clients' => Client::orderBy('name')->get(),
            'barbers' => Barber::orderBy('name')->get(),
            'services' => Service::with('category')->orderBy('name')->get(),
            'statuses' => Appointment::STATUSES,
            'statusCounts' => $statusCounts,
            'filters' => [
                'status' => $request->query('status', ''),
                'date' => $request->query('date', ''),
                'search' => $request->query('search', ''),
            ],
        ]);
    }

    public function store(Request $request)
    {
        if ($denied = $this->checkAuth($request)) {
            return $denied;
        }

        Appointment::create($this->validateAppointment($request));

        return redirect()
            ->route('admin.schedule', $this->filterParams($request))
            ->with('success', 'Appointment booked.');
    }

    public function update(Request $request, Appointment $appointment)
    {
        if ($denied = $this->checkAuth($request)) {
            return $denied;
        }

        $appointment->update($this->validateAppointment($request));

        return redirect()
            ->route('admin.schedule', $this->filterParams($request))
            ->with('success', 'Appointment updated.');
    }

    public function updateStatus(Request $request, Appointment $appointment)
    {
        if ($denied = $this->checkAuth($request)) {
            return $denied;
        }

        $data = $request->validate([
            'status' => ['required', 'in:' . implode(',', Appointment::STATUSES)],
        ]);

        $appointment->update($data);

        return redirect()
            ->route('admin.schedule', $this->filterParams($request))
            ->with('success', 'Status updated to ' . $data['status'] . '.');
    }

    public function destroy(Request $request, Appointment $appointment)
    {
        if ($denied = $this->checkAuth($request)) {
            return $denied;
        }

        $appointment->delete();

        return redirect()
            ->route('admin.schedule', $this->filterParams($request))
            ->with('success', 'Appointment deleted.');
    }

    private function filterParams(Request $request): array
    {
        return array_filter([
            'status' => $request->input('filter_status'),
            'date' => $request->input('filter_date'),
            'search' => $request->input('filter_search'),
        ]);
    }

    private function validateAppointment(Request $request): array
    {
        return $request->validate([
            'client_id' => ['required', 'exists:clients,id'],
            'barber_id' => ['required', 'exists:barbers,id'],
            'service_id' => ['required', 'exists:services,id'],
            'appointment_date' => ['required', 'date'],
            'appointment_time' => ['required', 'date_format:H:i'],
            'status' => ['required', 'in:' . implode(',', Appointment::STATUSES)],
            'notes' => ['nullable', 'string', 'max:1000'],
        ]);
    }
}

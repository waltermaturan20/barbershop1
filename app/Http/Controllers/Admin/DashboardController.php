<?php

namespace App\Http\Controllers\Admin;

use App\Models\Appointment;
use App\Models\Barber;
use App\Models\Client;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends AdminController
{
    public function __invoke(Request $request)
    {
        if ($denied = $this->checkAuth($request)) {
            return $denied;
        }

        $todayCount = Appointment::today()->count();
        $pendingCount = (int) Appointment::where('status', 'pending')->count();
        $confirmedCount = (int) Appointment::where('status', 'confirmed')->count();
        $completedCount = (int) Appointment::where('status', 'completed')->count();
        $cancelledCount = (int) Appointment::where('status', 'cancelled')->count();

        $todaySales = (float) Appointment::today()
            ->where('status', 'completed')
            ->join('services', 'services.id', '=', 'appointments.service_id')
            ->sum('services.price');

        $monthSales = (float) Appointment::whereMonth('appointment_date', now()->month)
            ->whereYear('appointment_date', now()->year)
            ->where('status', 'completed')
            ->join('services', 'services.id', '=', 'appointments.service_id')
            ->sum('services.price');

        return view('admin.dashboard', [
            'appointmentsCount' => Appointment::count(),
            'clientsCount' => Client::count(),
            'barbersCount' => Barber::count(),
            'servicesCount' => Service::count(),
            'todayCount' => $todayCount,
            'pendingCount' => $pendingCount,
            'confirmedCount' => $confirmedCount,
            'completedCount' => $completedCount,
            'cancelledCount' => $cancelledCount,
            'todaySales' => $todaySales,
            'monthSales' => $monthSales,
            'todayAppointments' => Appointment::with(['client', 'barber', 'service'])
                ->today()
                ->orderBy('appointment_time')
                ->get(),
            'upcomingAppointments' => Appointment::with(['client', 'barber', 'service'])
                ->upcoming()
                ->orderBy('appointment_date')
                ->orderBy('appointment_time')
                ->take(6)
                ->get(),
            'recentAppointments' => Appointment::with(['client', 'barber', 'service'])
                ->latest()
                ->take(8)
                ->get(),
        ]);
    }
}

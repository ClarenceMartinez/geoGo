<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\Company;
use App\Models\Branch;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;


class ScheduleController extends Controller
{
    protected function authorizeCompany(Company $company)
    {
        $user = auth()->user();

        if ($user->isSuperAdmin()) return;

        if ($user->isCompanyAdmin() && $user->company_id === $company->id) return;

        abort(403);
    }

    public function index(Company $company, Branch $branch)
    {
        $this->authorizeCompany($company);

        if ($branch->company_id !== $company->id) abort(404);

        $schedules = Schedule::with('user')
            ->where('company_id', $company->id)
            ->where('branch_id', $branch->id)
            ->orderBy('work_date')
            ->orderBy('start_time')
            ->get();

        return view('schedules.index', compact('company', 'branch', 'schedules'));
    }

    public function create(Company $company, Branch $branch)
    {
        $this->authorizeCompany($company);
        if ($branch->company_id !== $company->id) abort(404);

        // empleados de esta sucursal
        $employees = User::where('company_id', $company->id)
                         ->where('branch_id', $branch->id)
                         ->orderBy('name')
                         ->get();

        return view('schedules.create', compact('company', 'branch', 'employees'));
    }

    public function store(Request $request, Company $company, Branch $branch)
    {
        $this->authorizeCompany($company);
        if ($branch->company_id !== $company->id) abort(404);

        $request->validate([
            'user_id'    => 'required|exists:users,id',
            'date_start' => 'required|date',
            'date_end'   => 'required|date|after_or_equal:date_start',
            'start_time' => 'required|date_format:H:i',
            'end_time'   => 'required|date_format:H:i|after:start_time',
        ]);

        $startDate = Carbon::parse($request->date_start);
        $endDate   = Carbon::parse($request->date_end);

        // Recorremos cada día del rango [startDate, endDate]
        for ($date = $startDate->copy(); $date->lte($endDate); $date->addDay()) {

            Schedule::create([
                'company_id' => $company->id,
                'branch_id'  => $branch->id,
                'user_id'    => $request->user_id,
                'work_date'  => $date->format('Y-m-d'),
                'start_time' => $request->start_time,
                'end_time'   => $request->end_time,
                'status'     => 'planned',
            ]);
        }

        return redirect()
            ->route('companies.branches.schedules.index', [$company, $branch])
            ->with('success', 'Schedules creados correctamente para el rango de fechas.');
    }


    public function edit(Company $company, Branch $branch, Schedule $schedule)
    {
        $this->authorizeCompany($company);
        if ($branch->company_id !== $company->id) abort(404);
        if ($schedule->company_id !== $company->id || $schedule->branch_id !== $branch->id) abort(404);

        $employees = User::where('company_id', $company->id)
                         ->where('branch_id', $branch->id)
                         ->orderBy('name')
                         ->get();

        return view('schedules.edit', compact('company', 'branch', 'schedule', 'employees'));
    }

    public function update(Request $request, Company $company, Branch $branch, Schedule $schedule)
    {
        $this->authorizeCompany($company);
        if ($branch->company_id !== $company->id) abort(404);
        if ($schedule->company_id !== $company->id || $schedule->branch_id !== $branch->id) abort(404);

        $request->validate([
            'user_id'    => 'required|exists:users,id',
            'work_date'  => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time'   => 'required|date_format:H:i|after:start_time',
            'status'     => 'required|string',
        ]);

        $schedule->update($request->only('user_id', 'work_date', 'start_time', 'end_time', 'status'));

        return redirect()
            ->route('companies.branches.schedules.index', [$company, $branch])
            ->with('success', 'Schedule actualizado correctamente.');
    }

    public function destroy(Company $company, Branch $branch, Schedule $schedule)
    {
        $this->authorizeCompany($company);
        if ($branch->company_id !== $company->id) abort(404);
        if ($schedule->company_id !== $company->id || $schedule->branch_id !== $branch->id) abort(404);

        $schedule->delete();

        return redirect()
            ->route('companies.branches.schedules.index', [$company, $branch])
            ->with('success', 'Schedule eliminado correctamente.');
    }
}

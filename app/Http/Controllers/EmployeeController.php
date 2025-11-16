<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Company;
use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller
{
    public function index(Company $company, Branch $branch)
    {
        $this->authorizeCompany($company);
        // Seguridad: que el branch pertenezca a la company
        if ($branch->company_id !== $company->id) {
            abort(404);
        }

        $employees = User::where('company_id', $company->id)
                         ->where('branch_id', $branch->id)
                         ->orderBy('id', 'desc')
                         ->get();

        return view('employees.index', compact('company', 'branch', 'employees'));
    }

    public function create(Company $company, Branch $branch)
    {
        $this->authorizeCompany($company);
        if ($branch->company_id !== $company->id) {
            abort(404);
        }

        return view('employees.create', compact('company', 'branch'));
    }

    public function store(Request $request, Company $company, Branch $branch)
    {
        $this->authorizeCompany($company);
        if ($branch->company_id !== $company->id) {
            abort(404);
        }

        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8',
            'role_id'  => 'required|integer', // 3 = Empleado, 2 = Manager, etc.
        ]);

        User::create([
            'name'       => $request->name,
            'email'      => $request->email,
            'password'   => Hash::make($request->password),
            'role_id'    => $request->role_id,
            'company_id' => $company->id,
            'branch_id'  => $branch->id,
        ]);

        return redirect()
            ->route('companies.branches.users.index', [$company, $branch])
            ->with('success', 'Empleado creado correctamente.');
    }

    public function edit(Company $company, Branch $branch, User $user)
    {
        $this->authorizeCompany($company); 
        if ($branch->company_id !== $company->id ||
            $user->company_id !== $company->id ||
            $user->branch_id !== $branch->id) {
            abort(404);
        }

        return view('employees.edit', compact('company', 'branch', 'user'));
    }

    public function update(Request $request, Company $company, Branch $branch, User $user)
    {
        if ($branch->company_id !== $company->id ||
            $user->company_id !== $company->id ||
            $user->branch_id !== $branch->id) {
            abort(404);
        }

        $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|max:255|unique:users,email,' . $user->id,
            'role_id' => 'required|integer',
            'password'=> 'nullable|string|min:8',
        ]);

        $data = [
            'name'    => $request->name,
            'email'   => $request->email,
            'role_id' => $request->role_id,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()
            ->route('companies.branches.users.index', [$company, $branch])
            ->with('success', 'Empleado actualizado correctamente.');
    }

    public function destroy(Company $company, Branch $branch, User $user)
    {
        if ($branch->company_id !== $company->id ||
            $user->company_id !== $company->id ||
            $user->branch_id !== $branch->id) {
            abort(404);
        }

        $user->delete();

        return redirect()
            ->route('companies.branches.users.index', [$company, $branch])
            ->with('success', 'Empleado eliminado correctamente.');
    }

    protected function authorizeCompany(Company $company)
    {
        $user = auth()->user();

        if ($user->isSuperAdmin()) return;

        if ($user->isCompanyAdmin() && $user->company_id === $company->id) return;

        abort(403);
    }
}

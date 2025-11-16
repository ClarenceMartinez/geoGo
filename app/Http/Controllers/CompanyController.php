<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;  

class CompanyController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth'); // solo logueados
    }

    public function index()
    {
        // Para DataTables cliente, traemos todo (si luego tienes miles vemos server-side)
        // $companies = Company::orderBy('id', 'desc')->get();

        // return view('companies.index', compact('companies'));

        $user = auth()->user();

        if ($user->isSuperAdmin()) {
            // ve todas las companies
            $companies = Company::orderBy('id', 'desc')->get();
        } elseif ($user->isCompanyAdmin()) {
            // solo su propia company
            $companies = Company::where('id', $user->company_id)->get();
        } else {
            // otros roles (manager/empleado) si quieres, por ahora 403
            abort(403);
        }

        return view('companies.index', compact('companies'));


    }

    public function create()
    {
        if (! auth()->user()->isSuperAdmin()) {
            abort(403);
        }
        return view('companies.create');
    }

    /*
    public function store(Request $request)
    {
        $request->validate([
            'name'          => 'required|string|max:255',
            'owner_name'    => 'nullable|string|max:255',
            'billing_email' => 'nullable|email|max:255',
        ]);

        Company::create($request->only('name', 'owner_name', 'billing_email'));

        return redirect()
            ->route('companies.index')
            ->with('success', 'Company creada correctamente.');
    }*/

    public function store(Request $request)
    {
        if (! auth()->user()->isSuperAdmin()) {
            abort(403);
        }


        $request->validate([
            'name'           => 'required|string|max:255',
            'owner_name'     => 'nullable|string|max:255',
            'billing_email'  => 'nullable|email|max:255',

            // datos del admin
            'admin_name'     => 'required|string|max:255',
            'admin_email'    => 'required|email|max:255|unique:users,email',
            'admin_password' => 'required|string|min:8',
        ]);

        DB::transaction(function () use ($request) {
            // 1) crear company
            $company = Company::create([
                'name'          => $request->name,
                'owner_name'    => $request->owner_name,
                'billing_email' => $request->billing_email,
            ]);

            // 2) crear usuario Admin Empresa
            User::create([
                'name'       => $request->admin_name,
                'email'      => $request->admin_email,
                'password'   => Hash::make($request->admin_password),
                'role_id'    => 2,                // Admin Empresa
                'company_id' => $company->id,
                'branch_id'  => null,
            ]);
        });

        return redirect()
            ->route('companies.index')
            ->with('success', 'Empresa y Admin creados correctamente.');
    }

    public function edit(Company $company)
    {

        $user = auth()->user();
        if ($user->isCompanyAdmin() && $user->company_id !== $company->id) {
            abort(403);
        }


        $admin = $company->mainAdmin;   // relación que definimos en el modelo

        return view('companies.edit', compact('company', 'admin'));
    }


    /*
    public function update(Request $request, Company $company)
    {
        $request->validate([
            'name'          => 'required|string|max:255',
            'owner_name'    => 'nullable|string|max:255',
            'billing_email' => 'nullable|email|max:255',
        ]);

        $company->update($request->only('name', 'owner_name', 'billing_email'));

        return redirect()
            ->route('companies.index')
            ->with('success', 'Company actualizada correctamente.');
    }*/

    public function update(Request $request, Company $company)
    {
        $user = auth()->user();

        if ($user->isCompanyAdmin() && $user->company_id !== $company->id) {
            abort(403);
        }

        $admin = $company->mainAdmin; // puede ser null en empresas antiguas

        $request->validate([
            'name'          => 'required|string|max:255',
            'owner_name'    => 'nullable|string|max:255',
            'billing_email' => 'nullable|email|max:255',

            'admin_name'  => 'nullable|string|max:255',
            'admin_email' => [
                'nullable',
                'email',
                'max:255',
                // que sea único excepto para el propio admin actual
                'unique:users,email,' . optional($admin)->id,
            ],
            'admin_password' => 'nullable|string|min:8',
        ]);

        DB::transaction(function () use ($request, $company, $admin) {
            // 1) Actualizar empresa
            $company->update([
                'name'          => $request->name,
                'owner_name'    => $request->owner_name,
                'billing_email' => $request->billing_email,
            ]);

            // 2) Crear o actualizar Admin Empresa
            if ($request->filled('admin_name') || $request->filled('admin_email') || $request->filled('admin_password')) {

                // Si no existe admin aún, lo creamos
                if (! $admin) {
                    User::create([
                        'name'       => $request->admin_name,
                        'email'      => $request->admin_email,
                        'password'   => Hash::make($request->admin_password ?? 'Admin123*'),
                        'role_id'    => 2,
                        'company_id' => $company->id,
                        'branch_id'  => null,
                    ]);
                } else {
                    $data = [
                        'name'  => $request->admin_name ?? $admin->name,
                        'email' => $request->admin_email ?? $admin->email,
                    ];

                    if ($request->filled('admin_password')) {
                        $data['password'] = Hash::make($request->admin_password);
                    }

                    $admin->update($data);
                }
            }
        });

        return redirect()
            ->route('companies.index')
            ->with('success', 'Empresa actualizada correctamente.');
    }


    public function destroy(Company $company)
    {
        if (! auth()->user()->isSuperAdmin()) {
            abort(403);
        }

        $company->delete();

        return redirect()
            ->route('companies.index')
            ->with('success', 'Company eliminada correctamente.');
    }
}

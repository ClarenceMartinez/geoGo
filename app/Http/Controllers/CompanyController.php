<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); // solo logueados
    }

    public function index()
    {
        // Para DataTables cliente, traemos todo (si luego tienes miles vemos server-side)
        $companies = Company::orderBy('id', 'desc')->get();

        return view('companies.index', compact('companies'));
    }

    public function create()
    {
        return view('companies.create');
    }

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
    }

    public function edit(Company $company)
    {
        return view('companies.edit', compact('company'));
    }

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
    }

    public function destroy(Company $company)
    {
        $company->delete();

        return redirect()
            ->route('companies.index')
            ->with('success', 'Company eliminada correctamente.');
    }
}

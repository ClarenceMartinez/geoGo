<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Company;
use Illuminate\Http\Request;

class BranchController extends Controller
{
    /**
     * Listado de sucursales de una empresa.
     */
    public function index(Company $company)
    {
        $this->authorizeCompany($company);
        // Todas las sucursales de la company
        $branches = $company->branches()->orderBy('id', 'desc')->get();

        return view('branches.index', compact('company', 'branches'));
    }

    /**
     * Formulario para crear una nueva sucursal.
     */
    public function create(Company $company)
    {
        $this->authorizeCompany($company);
        return view('branches.create', compact('company'));
    }

    /**
     * Guardar una nueva sucursal en BD.
     */
    public function store(Request $request, Company $company)
    {
        $this->authorizeCompany($company);
        $request->validate([
            'name'    => 'required|string|max:255',
            'address' => 'nullable|string|max:255',
            'lat'     => 'nullable|numeric',
            'lng'     => 'nullable|numeric',
            'radius'  => 'nullable|integer|min:1',
        ]);

        $company->branches()->create([
            'name'    => $request->name,
            'address' => $request->address,
            'lat'     => $request->lat,
            'lng'     => $request->lng,
            'radius'  => $request->radius ?? 80,
        ]);

        return redirect()
            ->route('companies.branches.index', $company)
            ->with('success', 'Sucursal creada correctamente.');
    }

    /**
     * Formulario para editar una sucursal.
     */
    public function edit(Company $company, Branch $branch)
    {
        $this->authorizeCompany($company);
        // Seguridad extra: que la sucursal pertenezca a la empresa
        if ($branch->company_id !== $company->id) {
            abort(404);
        }

        return view('branches.edit', compact('company', 'branch'));
    }

    /**
     * Actualizar una sucursal.
     */
    public function update(Request $request, Company $company, Branch $branch)
    {
        $this->authorizeCompany($company);
        if ($branch->company_id !== $company->id) {
            abort(404);
        }

        $request->validate([
            'name'    => 'required|string|max:255',
            'address' => 'nullable|string|max:255',
            'lat'     => 'nullable|numeric',
            'lng'     => 'nullable|numeric',
            'radius'  => 'nullable|integer|min:1',
        ]);

        $branch->update([
            'name'    => $request->name,
            'address' => $request->address,
            'lat'     => $request->lat,
            'lng'     => $request->lng,
            'radius'  => $request->radius,
        ]);

        return redirect()
            ->route('companies.branches.index', $company)
            ->with('success', 'Sucursal actualizada correctamente.');
    }

    /**
     * Eliminar una sucursal.
     */
    public function destroy(Company $company, Branch $branch)
    {
        $this->authorizeCompany($company);
        if ($branch->company_id !== $company->id) {
            abort(404);
        }

        $branch->delete();

        return redirect()
            ->route('companies.branches.index', $company)
            ->with('success', 'Sucursal eliminada correctamente.');
    }


    protected function authorizeCompany(Company $company)
    {
        $user = auth()->user();

        if ($user->isSuperAdmin()) {
            return;
        }

        if ($user->isCompanyAdmin() && $user->company_id === $company->id) {
            return;
        }

        // otros roles o admins de otra company → no autorizado
        abort(403);
    }

}

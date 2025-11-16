<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Companies') }}
                </h2>
                <p class="text-sm text-gray-500 mt-1">
                    Administración de empresas registradas en GeoGo.
                </p>
            </div>


            @php $user = auth()->user(); @endphp

            @if($user->isSuperAdmin())
                <a href="{{ route('companies.create') }}"
                   class="inline-flex items-center px-4 py-2 rounded-lg text-sm font-medium
                          bg-indigo-600 text-white shadow hover:bg-indigo-700">
                    + New Company
                </a>
            @endif



        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4">

            {{-- Alertas --}}
            @if(session('success'))
                <div class="rounded-md bg-green-50 border border-green-200 px-4 py-2 text-sm text-green-700">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white shadow-sm sm:rounded-xl overflow-hidden">

                {{-- Header modernizado --}}
                <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                    <h3 class="text-sm font-semibold text-gray-700">
                        Listado de companies
                    </h3>
                    <span class="text-xs text-gray-400">
                        Total: {{ $companies->count() }}
                    </span>
                </div>

                {{-- TABLA --}}
                <div class="p-4">
                    <table id="companies-table" class="w-full text-sm">
                        <thead>
                            <tr class="text-gray-500 text-xs uppercase tracking-wide bg-gray-50">
                                <th class="px-3 py-2 text-left">ID</th>
                                <th class="px-3 py-2 text-left">Name</th>
                                <th class="px-3 py-2 text-left">Owner</th>
                                <th class="px-3 py-2 text-left">Billing Email</th>
                                <th class="px-3 py-2 text-left">Created</th>
                                <th class="px-3 py-2 text-center">Actions</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-100">
                            @foreach ($companies as $company)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-3 py-2 text-gray-600">#{{ $company->id }}</td>
                                    <td class="px-3 py-2 font-medium text-gray-800">{{ $company->name }}</td>
                                    <td class="px-3 py-2 text-gray-600">{{ $company->owner_name }}</td>
                                    <td class="px-3 py-2 text-gray-600">{{ $company->billing_email }}</td>
                                    <td class="px-3 py-2 text-gray-500">{{ $company->created_at->format('Y-m-d') }}</td>
                                    <td class="px-3 py-2 text-center">

                                        <a href="{{ route('companies.branches.index', $company) }}"
                                           class="px-2 py-1 rounded-full text-xs bg-sky-100 text-sky-700 mr-2">
                                            Locales
                                        </a>
                                        <a href="{{ route('companies.edit', $company) }}"
                                           class="px-2 py-1 rounded-full text-xs bg-indigo-100 text-indigo-700 mr-2">
                                            Edit
                                        </a>

                                        <form action="{{ route('companies.destroy', $company) }}"
                                              method="POST"
                                              class="inline-block"
                                              onsubmit="return confirm('¿Eliminar esta company?');">
                                            @csrf
                                            @method('DELETE')
                                            <button class="px-2 py-1 rounded-full text-xs bg-red-100 text-red-700">
                                                Delete
                                            </button>
                                        </form>

                                    </td>
                                </tr>
                            @endforeach

                            @if ($companies->isEmpty())
                                <tr>
                                    <td colspan="6" class="px-3 py-6 text-center text-gray-400">
                                        No hay companies aún.
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>

            </div>

        </div>
    </div>

{{-- DATATABLES --}}
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/2.1.6/css/dataTables.dataTables.min.css">
<script src="https://cdn.datatables.net/2.1.6/js/dataTables.min.js"></script>

{{-- OVERRIDE con Tailwind para evitar cabecera fea --}}
<style>
    /* Oculta la barra de DataTables que se ve mal */
    div.dataTables_wrapper div.dataTables_length label,
    div.dataTables_wrapper div.dataTables_filter label {
        font-size: 13px;
        color: #6b7280 !important; /* gray-500 */
        margin-bottom: 8px;
    }

    /* Inputs bonitos */
    .dataTables_wrapper select,
    .dataTables_wrapper input {
        border: 1px solid #d1d5db !important; /* gray-300 */
        padding: 4px 7px;
        border-radius: 6px;
        outline: none;
    }

    /* Paginación Tailwind */
    .dataTables_wrapper .dataTables_paginate .paginate_button {
        padding: 4px 10px !important;
        margin: 0 2px;
        border-radius: 6px;
        border: 1px solid #e5e7eb !important;
        background: #fff !important;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button.current {
        background: #4f46e5 !important;
        color: #fff !important;
        border-color: #4f46e5 !important;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
        background: #e5e7eb !important;
    }
</style>

<script>
    $(document).ready(function () {
        $('#companies-table').DataTable({
            pageLength: 10,
            lengthMenu: [5, 10, 25, 50],
            language: {
                search: "Buscar:",
                lengthMenu: "Mostrar _MENU_",
                info: "Mostrando _START_ a _END_ de _TOTAL_",
                paginate: {
                    first: "Primero",
                    last: "Último",
                    next: "›",
                    previous: "‹"
                }
            }
        });
    });
</script>

</x-app-layout>

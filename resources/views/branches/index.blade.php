<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Branches of ') . $company->name }}
            </h2>
            <p class="text-sm text-gray-500 mt-1">
                Gestión de locales / sucursales de esta empresa.
            </p>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-4">

            @if(session('success'))
                <div class="rounded-md bg-green-50 border border-green-200 px-4 py-2 text-sm text-green-700">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white shadow-sm sm:rounded-xl overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                    <div>
                        <h3 class="text-sm font-semibold text-gray-700">
                            Locales / Sucursales
                        </h3>
                        <a href="{{ route('companies.index') }}"
                           class="text-xs text-indigo-600 hover:underline">
                            ← Volver a Companies
                        </a>
                    </div>

                    <a href="{{ route('companies.branches.create', $company) }}"
                       class="inline-flex items-center px-4 py-2 rounded-lg text-sm font-medium
                              bg-indigo-600 text-white shadow hover:bg-indigo-700">
                        + New Branch
                    </a>
                </div>

                <div class="p-4 overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="bg-gray-50 text-xs uppercase text-gray-500">
                                <th class="px-3 py-2 text-left">ID</th>
                                <th class="px-3 py-2 text-left">Name</th>
                                <th class="px-3 py-2 text-left">Address</th>
                                <th class="px-3 py-2 text-left">Lat</th>
                                <th class="px-3 py-2 text-left">Lng</th>
                                <th class="px-3 py-2 text-left">Radius (m)</th>
                                <th class="px-3 py-2 text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($branches as $branch)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-3 py-2 text-gray-600">#{{ $branch->id }}</td>
                                    <td class="px-3 py-2 font-medium text-gray-800">{{ $branch->name }}</td>
                                    <td class="px-3 py-2 text-gray-600">{{ $branch->address }}</td>
                                    <td class="px-3 py-2 text-gray-500">{{ $branch->lat }}</td>
                                    <td class="px-3 py-2 text-gray-500">{{ $branch->lng }}</td>
                                    <td class="px-3 py-2 text-gray-500">{{ $branch->radius }}</td>
                                    <td class="px-3 py-2 text-center">
                                        <a href="{{ route('companies.branches.users.index', [$company, $branch]) }}"
                                           class="px-2 py-1 rounded-full text-xs bg-sky-100 text-sky-700 mr-2">
                                            Employees
                                        </a>
                                        {{-- Schedules de la sucursal --}}
                                        <a href="{{ route('companies.branches.schedules.index', [$company, $branch]) }}"
                                           class="px-2 py-1 rounded-full text-xs bg-emerald-100 text-emerald-700 mr-2">
                                            Schedules
                                        </a>
                                        <a href="{{ route('companies.branches.edit', [$company, $branch]) }}"
                                           class="px-2 py-1 rounded-full text-xs bg-indigo-100 text-indigo-700 mr-2">
                                            Edit
                                        </a>

                                        <form action="{{ route('companies.branches.destroy', [$company, $branch]) }}"
                                              method="POST"
                                              class="inline-block"
                                              onsubmit="return confirm('¿Eliminar esta sucursal?');">
                                            @csrf
                                            @method('DELETE')
                                            <button class="px-2 py-1 rounded-full text-xs bg-red-100 text-red-700">
                                                Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach

                            @if($branches->isEmpty())
                                <tr>
                                    <td colspan="7" class="px-3 py-6 text-center text-gray-400">
                                        Aún no hay sucursales registradas para esta empresa.
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>

            </div>

        </div>
    </div>
</x-app-layout>

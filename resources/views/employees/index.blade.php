<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Employees of {{ $branch->name }} – {{ $company->name }}
            </h2>
            <p class="text-sm text-gray-500 mt-1">
                Gestión de usuarios asignados a esta sucursal.
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
                            Empleados
                        </h3>
                        <a href="{{ route('companies.branches.index', $company) }}"
                           class="text-xs text-indigo-600 hover:underline">
                            ← Volver a Sucursales
                        </a>
                    </div>

                    <a href="{{ route('companies.branches.users.create', [$company, $branch]) }}"
                       class="inline-flex items-center px-4 py-2 rounded-lg text-sm font-medium
                              bg-indigo-600 text-white shadow hover:bg-indigo-700">
                        + New Employee
                    </a>
                </div>

                <div class="p-4 overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="bg-gray-50 text-xs uppercase text-gray-500">
                                <th class="px-3 py-2 text-left">ID</th>
                                <th class="px-3 py-2 text-left">Name</th>
                                <th class="px-3 py-2 text-left">Email</th>
                                <th class="px-3 py-2 text-left">Role</th>
                                <th class="px-3 py-2 text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($employees as $user)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-3 py-2 text-gray-600">#{{ $user->id }}</td>
                                    <td class="px-3 py-2 font-medium text-gray-800">{{ $user->name }}</td>
                                    <td class="px-3 py-2 text-gray-600">{{ $user->email }}</td>
                                    <td class="px-3 py-2 text-gray-600">
                                        <!-- {{ $user->role_id }} {{-- luego lo mapeamos a texto --}} -->
                                        {{ $user->role_name }}

                                    </td>
                                    <td class="px-3 py-2 text-center">
                                        <a href="{{ route('companies.branches.users.edit', [$company, $branch, $user]) }}"
                                           class="px-2 py-1 rounded-full text-xs bg-indigo-100 text-indigo-700 mr-2">
                                            Edit
                                        </a>

                                        <form action="{{ route('companies.branches.users.destroy', [$company, $branch, $user]) }}"
                                              method="POST"
                                              class="inline-block"
                                              onsubmit="return confirm('¿Eliminar este empleado?');">
                                            @csrf
                                            @method('DELETE')
                                            <button class="px-2 py-1 rounded-full text-xs bg-red-100 text-red-700">
                                                Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach

                            @if($employees->isEmpty())
                                <tr>
                                    <td colspan="5" class="px-3 py-6 text-center text-gray-400">
                                        No hay empleados registrados en esta sucursal.
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

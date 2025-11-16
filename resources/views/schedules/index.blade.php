<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Schedules – {{ $branch->name }} – {{ $company->name }}
            </h2>
            <p class="text-sm text-gray-500 mt-1">
                Turnos de trabajo asignados a esta sucursal.
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
                            Schedules
                        </h3>
                        <a href="{{ route('companies.branches.index', $company) }}"
                           class="text-xs text-indigo-600 hover:underline">
                            ← Volver a Sucursales
                        </a>
                    </div>

                    <a href="{{ route('companies.branches.schedules.create', [$company, $branch]) }}"
                       class="inline-flex items-center px-4 py-2 rounded-lg text-sm font-medium
                              bg-indigo-600 text-white shadow hover:bg-indigo-700">
                        + New Schedule
                    </a>
                </div>

                <div class="p-4 overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="bg-gray-50 text-xs uppercase text-gray-500">
                                <th class="px-3 py-2 text-left">Date</th>
                                <th class="px-3 py-2 text-left">Employee</th>
                                <th class="px-3 py-2 text-left">Start</th>
                                <th class="px-3 py-2 text-left">End</th>
                                <th class="px-3 py-2 text-left">Status</th>
                                <th class="px-3 py-2 text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($schedules as $schedule)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-3 py-2 text-gray-700">
                                        {{ \Carbon\Carbon::parse($schedule->work_date)->format('Y-m-d') }}
                                    </td>
                                    <td class="px-3 py-2 text-gray-700">
                                        {{ $schedule->user->name ?? 'N/A' }}
                                    </td>
                                    <td class="px-3 py-2 text-gray-600">{{ $schedule->start_time }}</td>
                                    <td class="px-3 py-2 text-gray-600">{{ $schedule->end_time }}</td>
                                    <td class="px-3 py-2 text-gray-600">{{ ucfirst($schedule->status) }}</td>
                                    <td class="px-3 py-2 text-center">
                                        <a href="{{ route('companies.branches.schedules.edit', [$company, $branch, $schedule]) }}"
                                           class="px-2 py-1 rounded-full text-xs bg-indigo-100 text-indigo-700 mr-2">
                                            Edit
                                        </a>

                                        <form action="{{ route('companies.branches.schedules.destroy', [$company, $branch, $schedule]) }}"
                                              method="POST"
                                              class="inline-block"
                                              onsubmit="return confirm('¿Eliminar este schedule?');">
                                            @csrf
                                            @method('DELETE')
                                            <button class="px-2 py-1 rounded-full text-xs bg-red-100 text-red-700">
                                                Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-3 py-6 text-center text-gray-400">
                                        No hay schedules registrados para esta sucursal.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>

        </div>
    </div>
</x-app-layout>

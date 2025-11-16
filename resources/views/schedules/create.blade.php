<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                New Schedule – {{ $branch->name }}
            </h2>
            <p class="text-sm text-gray-500 mt-1">
                Asignar un turno a un empleado de esta sucursal.
            </p>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-xl border border-gray-100 p-6">

                <form method="POST"
                      action="{{ route('companies.branches.schedules.store', [$company, $branch]) }}"
                      class="space-y-6">
                    @csrf

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Empleado <span class="text-red-500">*</span>
                        </label>
                        <select name="user_id"
                                class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm">
                            <option value="" disabled selected>Seleccione empleado</option>
                            @foreach($employees as $employee)
                                <option value="{{ $employee->id }}"
                                    @selected(old('user_id') == $employee->id)>
                                    {{ $employee->name }} ({{ $employee->email }})
                                </option>
                            @endforeach
                        </select>
                        @error('user_id') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Fecha DESDE / HASTA + Horas --}}
                    <div class="grid grid-cols-1 sm:grid-cols-4 gap-4">

                        {{-- Fecha desde --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Fecha desde <span class="text-red-500">*</span>
                            </label>
                            <input type="date" name="date_start"
                                   value="{{ old('date_start') }}"
                                   class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm">
                            @error('date_start') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>

                        {{-- Fecha hasta --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Fecha hasta <span class="text-red-500">*</span>
                            </label>
                            <input type="date" name="date_end"
                                   value="{{ old('date_end') }}"
                                   class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm">
                            @error('date_end') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>

                        {{-- Hora inicio --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Hora inicio <span class="text-red-500">*</span>
                            </label>
                            <input type="time" name="start_time"
                                   value="{{ old('start_time') }}"
                                   class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm">
                            @error('start_time') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>

                        {{-- Hora fin --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Hora fin <span class="text-red-500">*</span>
                            </label>
                            <input type="time" name="end_time"
                                   value="{{ old('end_time') }}"
                                   class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm">
                            @error('end_time') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>

                    </div>

                    <p class="text-xs text-gray-500 mt-1">
                        Se generará un schedule por cada día entre la fecha desde y la fecha hasta (incluidos), con la misma hora de inicio y fin.
                    </p>


                    <div class="flex justify-end gap-3 pt-4">
                        <a href="{{ route('companies.branches.schedules.index', [$company, $branch]) }}"
                           class="px-4 py-2 rounded-lg bg-gray-200 hover:bg-gray-300 text-gray-700 text-sm">
                            Cancelar
                        </a>
                        <button type="submit"
                                class="px-4 py-2 rounded-lg bg-indigo-600 text-white hover:bg-indigo-700 text-sm shadow">
                            Guardar Schedule
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</x-app-layout>

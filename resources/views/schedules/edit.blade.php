<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Edit Schedule – {{ $branch->name }} ({{ $company->name }})
            </h2>
            <p class="text-sm text-gray-500 mt-1">
                Modifique el turno asignado a este empleado.
            </p>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-xl border border-gray-100 p-6">

                {{-- Flash message --}}
                @if(session('success'))
                    <div class="mb-4 rounded-md bg-green-50 border border-green-200 px-4 py-2 text-sm text-green-700">
                        {{ session('success') }}
                    </div>
                @endif

                <form method="POST"
                      action="{{ route('companies.branches.schedules.update', [$company, $branch, $schedule]) }}"
                      class="space-y-6">
                    @csrf
                    @method('PUT')

                    {{-- Empleado --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Empleado <span class="text-red-500">*</span>
                        </label>
                        <select name="user_id"
                                class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm">
                            @foreach($employees as $employee)
                                <option value="{{ $employee->id }}"
                                    @selected(old('user_id', $schedule->user_id) == $employee->id)>
                                    {{ $employee->name }} ({{ $employee->email }})
                                </option>
                            @endforeach
                        </select>
                        @error('user_id') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Fecha + Horas --}}
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">

                        {{-- Fecha --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Fecha <span class="text-red-500">*</span>
                            </label>
                            <input type="date" name="work_date"
                                   value="{{ old('work_date', $schedule->work_date) }}"
                                   class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm">
                            @error('work_date') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>

                        {{-- Hora inicio --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Hora inicio <span class="text-red-500">*</span>
                            </label>
                            <input type="time" name="start_time"
                                   value="{{ old('start_time', $schedule->start_time) }}"
                                   class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm">
                            @error('start_time') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>

                        {{-- Hora fin --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Hora fin <span class="text-red-500">*</span>
                            </label>
                            <input type="time" name="end_time"
                                   value="{{ old('end_time', $schedule->end_time) }}"
                                   class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm">
                            @error('end_time') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>

                    </div>

                    {{-- Status --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Estado del turno
                        </label>
                        <select name="status"
                                class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm">
                            <option value="planned"  @selected(old('status', $schedule->status) == 'planned')>Planned</option>
                            <option value="completed" @selected(old('status', $schedule->status) == 'completed')>Completed</option>
                            <option value="cancelled" @selected(old('status', $schedule->status) == 'cancelled')>Cancelled</option>
                        </select>
                        @error('status') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Botones --}}
                    <div class="flex justify-end gap-3 pt-4">

                        <a href="{{ route('companies.branches.schedules.index', [$company, $branch]) }}"
                           class="px-4 py-2 rounded-lg bg-gray-200 hover:bg-gray-300 text-gray-700 text-sm">
                            Cancelar
                        </a>

                        <button type="submit"
                                class="px-4 py-2 rounded-lg bg-indigo-600 text-white hover:bg-indigo-700 text-sm shadow">
                            Actualizar Schedule
                        </button>

                    </div>

                </form>

            </div>
        </div>
    </div>
</x-app-layout>

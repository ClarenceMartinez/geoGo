<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                New Employee – {{ $branch->name }}
            </h2>
            <p class="text-sm text-gray-500 mt-1">
                Crear un nuevo empleado para esta sucursal.
            </p>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow-sm sm:rounded-xl border border-gray-100 p-6">

                <form method="POST"
                      action="{{ route('companies.branches.users.store', [$company, $branch]) }}"
                      class="space-y-6">
                    @csrf

                    {{-- Name --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Nombre completo <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="name" value="{{ old('name') }}"
                               class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm">
                        @error('name') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Email --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Email <span class="text-red-500">*</span>
                        </label>
                        <input type="email" name="email" value="{{ old('email') }}"
                               class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm">
                        @error('email') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Password --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Password <span class="text-red-500">*</span>
                        </label>
                        <input type="password" name="password"
                               class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm">
                        @error('password') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Role --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Rol del usuario <span class="text-red-500">*</span>
                        </label>

                        <select name="role_id"
                                class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm">
                            <option value="" disabled selected>Seleccione un rol</option>
                            <option value="3">Manager</option>
                            <option value="4">Empleado</option>
                        </select>

                        @error('role_id') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Buttons --}}
                    <div class="flex justify-end gap-3 pt-4">
                        <a href="{{ route('companies.branches.users.index', [$company, $branch]) }}"
                           class="px-4 py-2 rounded-lg bg-gray-200 hover:bg-gray-300 text-gray-700 text-sm">
                            Cancelar
                        </a>

                        <button type="submit"
                                class="px-4 py-2 rounded-lg bg-indigo-600 text-white hover:bg-indigo-700 text-sm shadow">
                            Guardar Empleado
                        </button>
                    </div>

                </form>

            </div>

        </div>
    </div>

</x-app-layout>

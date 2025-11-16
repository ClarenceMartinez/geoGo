<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Edit Company') }}
            </h2>
            <p class="text-sm text-gray-500 mt-1">
                Editar información de la empresa seleccionada.
            </p>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow-sm sm:rounded-xl border border-gray-100 p-6">

                <form action="{{ route('companies.update', $company) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    {{-- Name --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Nombre de la empresa <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="name" value="{{ old('name', $company->name) }}"
                               class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm">
                        @error('name')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Owner --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Representante / Owner
                        </label>
                        <input type="text" name="owner_name"
                               value="{{ old('owner_name', $company->owner_name) }}"
                               class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm">
                        @error('owner_name')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Billing Email --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Email de facturación
                        </label>
                        <input type="email" name="billing_email"
                               value="{{ old('billing_email', $company->billing_email) }}"
                               class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm">
                        @error('billing_email')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>



                    <hr class="my-4">

                    {{-- Datos del Admin Empresa --}}
                    <div>
                        <h3 class="text-sm font-semibold text-gray-700 mb-3">Admin de la empresa</h3>

                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Nombre del Admin
                                </label>
                                <input type="text" name="admin_name"
                                       value="{{ old('admin_name', optional($admin)->name) }}"
                                       class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm">
                                @error('admin_name') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Email del Admin
                                </label>
                                <input type="email" name="admin_email"
                                       value="{{ old('admin_email', optional($admin)->email) }}"
                                       class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm">
                                @error('admin_email') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Password (opcional)
                                </label>
                                <input type="password" name="admin_password"
                                       class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm"
                                       placeholder="Dejar vacío para no cambiar">
                                @error('admin_password') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>





                    {{-- Buttons --}}
                    <div class="flex justify-end gap-3 pt-4">
                        <a href="{{ route('companies.index') }}"
                           class="px-4 py-2 rounded-lg bg-gray-200 hover:bg-gray-300 text-gray-700 text-sm">
                            Cancelar
                        </a>

                        <button type="submit"
                                class="px-4 py-2 rounded-lg bg-indigo-600 text-white hover:bg-indigo-700 text-sm shadow">
                            Actualizar
                        </button>
                    </div>

                </form>

            </div>

        </div>
    </div>
</x-app-layout>

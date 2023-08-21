<x-admin-layout>
    <x-slot name="header">
        <div class="flex items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ 'Usuarios' }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="max-w-6xl mx-auto">
                <x-button data-modal-target="authentication-modal" data-modal-toggle="authentication-modal">
                    Agregar Usuario
                </x-button>  
            </div>
            
            <!-- Main modal -->
            <div id="authentication-modal" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
                <div class="relative w-full max-w-md max-h-full">
                    <!-- Modal content -->
                    <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                        <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="authentication-modal">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                            </svg>
                            <span class="sr-only">Cancelar</span>
                        </button>
                        <div class="px-6 py-6 lg:px-8">
                            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                                Agregar Usuario
                            </h2>
                            <form class="space-y-6" method="POST" action="{{ route('register') }}">
                                @csrf
                                <div class="block mb-2">
                                    <x-label for="nombre" value="{{ __('Name') }}" />
                                    <x-input id="nombre" class="block mt-1 w-full" type="text" name="nombre" :value="old('nombre')" required autofocus autocomplete="nombre" />
                                </div>

                                <div class="block mb-2">
                                    <x-label for="apPaterno" value="{{ __('Apellido Paterno') }}" />
                                    <x-input id="apPaterno" class="block mt-1 w-full" type="text" name="apPaterno" :value="old('apPaterno')" required autofocus autocomplete="apPaterno" />
                                </div>
    
                                <div class="block mb-2">
                                    <x-label for="apMaterno" value="{{ __('Apellido Materno') }}" />
                                    <x-input id="apMaterno" class="block mt-1 w-full" type="text" name="apMaterno" :value="old('apMaterno')" required autofocus autocomplete="apMaterno" />
                                </div>
    
                                <div class="block mb-2">
                                    <x-label for="email" value="{{ __('Email') }}" />
                                    <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
                                </div>
    
                                <div class="block mb-2">
                                    <x-label for="telefono" value="{{ __('Teléfono') }}" />
                                    <x-input id="telefono" class="block mt-1 w-full" type="text" name="telefono" minlength="10" maxlength="10" :value="old('telefono')" required autocomplete="telefono" />
                                </div>
    
                                <div class="block mb-2">
                                    <label for="tipoUsuario" class="text-sm font-medium text-gray-900 dark:text-white">Tipo de Usuario</label>
                                    <select id="tipoUsuario" name="tipoUsuario" class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                        <option value="Usuario">Usuario</option>
                                        <option value="Administrador">Administrador</option>
                                    </select>
                                </div>

                                <p class="text-sm text-red-600">Nota: La contraseña del usuario es "<strong>123456789</strong>", recomiende al usuario cambiar su contraseña por seguridad.</p>
                    
                                <div class="flex items-center justify-end mt-4">
                                    <x-button class="ml-4">
                                        {{ 'Registrar Usuario' }}
                                    </x-button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div> 
            
            <br>

            <!-- Tabla de usuarios -->
            @if ($usuarios->count())
            
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                <table class="w-full text-sm text-center text-gray-500">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                Nombre
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Apellido Paterno
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Apellido Materno
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Teléfono
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Correo Electrónico
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Tipo de Usuario
                            </th>
                            <th scope="col" class="px-6 py-3">Eliminar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($usuarios as $index => $usuario)
                            <tr class="bg-white border-b dark:bg-gray-900 dark:border-gray-700">
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{$usuario->nombre}}
                                </th>
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{$usuario->apPaterno}}
                                </th>
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{$usuario->apMaterno}}
                                </th>
                                <td class="px-6 py-4">
                                    {{$usuario->telefono}}
                                </td>
                                <td class="px-6 py-4">
                                    {{$usuario->email}}
                                </td>
                                <td class="px-6 py-4">
                                    {{$usuario->tipoUsuario}}
                                </td>
                                @if ($usuario->id != Auth::user()->id)
                                <td class="px-6 py-4">
                                    <a data-modal-target="popup-modal-{{ $index }}" data-modal-toggle="popup-modal-{{ $index }}" class="font-medium text-red-600 hover:underline">Eliminar</a>
                                </td>
                                @else
                                <td class="px-6 py-4"></td>
                                @endif
                            </tr>

                            <!-- Modal para eliminar un usuario -->
                            <div id="popup-modal-{{ $index }}" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                <div class="relative w-full max-w-md max-h-full">
                                    <div class="relative bg-white rounded-lg shadow">
                                        <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="popup-modal-{{ $index }}">
                                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                            </svg>
                                            <span class="sr-only">Cancelar</span>
                                        </button>
                                        <form method="POST" action="{{ route('administrador.usuario-delete', $usuario->id) }}">
                                            @csrf
                                            @method('DELETE')
                                            <div class="p-6 text-center">
                                                <svg class="mx-auto mb-4 text-gray-400 w-12 h-12" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                                </svg>
                                                <h3 class="mb-5 text-lg font-normal text-gray-500">¿Estás seguro que quieres eliminar este usuario?</h3>
                                                <x-button type="submit">Si, estoy seguro</x-button>
                                                <x-secondary-button data-modal-hide="popup-modal-{{ $index }}" type="button">No, cancelar</x-secondary-button>
                                            </div>
                                        </form>                                        
                                    </div>
                                </div>
                            </div>

                        @endforeach
                    </tbody>
                </table>
            </div>

            @endif

        </div>
    </div>
</x-admin-layout>
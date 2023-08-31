<x-admin-layout>
    <x-slot name="header">
        <div class="flex items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ 'Cultivos' }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                
            <div class="max-w-6xl mx-auto flex flex-wrap">
                @if ($provedores->count())
                <x-button data-modal-target="authentication-modal" data-modal-toggle="authentication-modal">
                    Agregar Cultivo
                </x-button>&nbsp;&nbsp;&nbsp;&nbsp;
                <a href="{{ route('administrador.provedor') }}"><x-button>
                    Proveedores
                </x-button></a>
                @else
                <a href="{{ route('administrador.provedor') }}"><x-button>
                    Proveedores
                </x-button></a>
                @endif 
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
                                Agregar Cultivo
                            </h2>
                            <form class="space-y-6" method="POST" action="{{ route('administrador.cultivo-create') }}">
                                @csrf
                                <div class="block mb-2">
                                    <label for="provedor_id" class="text-sm font-medium text-gray-900">Provedor</label>
                                    <select id="provedor_id" name="provedor_id" class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5">
                                        @foreach ($provedores as $provedor)
                                        <option value="{{ $provedor->id }}">{{ $provedor->nombre }}</option>
                                        @endforeach
                                    </select>
                                    <x-input-error for="provedor_id" class="mt-2" />
                                </div>

                                <div class="block mb-2">
                                    <x-label for="nombre" value="{{ __('Name') }}" />
                                    <x-input id="nombre" class="block mt-1 w-full" type="text" name="nombre" :value="old('nombre')" required autofocus autocomplete="nombre" />
                                    <x-input-error for="nombre" class="mt-2" />
                                </div>

                                <div class="block mb-2">
                                    <x-label for="nombre_tecnico" value="{{ __('Nombre Técnico (opcional)') }}" />
                                    <x-input id="nombre_tecnico" class="block mt-1 w-full" type="text" name="nombre_tecnico" :value="old('nombre_tecnico')" autofocus autocomplete="nombre_tecnico" />
                                    <x-input-error for="nombre_tecnico" class="mt-2" />
                                </div>
    
                                <div class="block mb-2">
                                    <x-label for="cantidad" value="{{ __('Cantidad (gramos)') }}" />
                                    <x-input id="cantidad" class="block mt-1 w-full" type="text" name="cantidad" :value="old('cantidad')" required autofocus autocomplete="cantidad" />
                                    <x-input-error for="cantidad" class="mt-2" />
                                </div>
                                
                                <div class="block mb-2">
                                    <div class="relative max-w-sm">
                                        <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">
                                        <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                                        </svg>
                                        </div>
                                        <input datepicker id="fecha_ingreso" name="fecha_ingreso" type="text" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full pl-10 p-2.5" placeholder="Fecha de Ingreso">
                                        <x-input-error for="fecha_ingreso" class="mt-2" />
                                    </div>
                                </div>
                    
                                <div class="flex items-center justify-end mt-4">
                                    <x-button class="ml-4">
                                        {{ 'Registrar Cultivo' }}
                                    </x-button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div> 
            
            <br>

            <!-- Tabla de usuarios -->
            @if ($cultivos->count())
            
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                <table class="w-full text-sm text-center text-gray-500">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                Nombre
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Nombre Técnico
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Proveedor
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Cantidad (gramos)
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Fecha de Ingreso
                            </th>
                            <th scope="col" class="px-6 py-3">Editar</th>
                            <th scope="col" class="px-6 py-3">Eliminar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($cultivos as $index => $cultivo)
                            <tr class="bg-white border-b">
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                    {{$cultivo->nombre}}
                                </th>
                                @if ($cultivo->nombre_tecnico !== null)
                                <td class="px-6 py-4">
                                    {{$cultivo->nombre_tecnico}}
                                </td>
                                @else
                                <td class="px-6 py-4">
                                    No Registado
                                </td>
                                @endif
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                    {{$cultivo->provedor->nombre}}
                                </th>
                                <th scope="row" class="px-6 py-4">
                                    {{$cultivo->cantidad}}
                                </th>
                                <td class="px-6 py-4">
                                    {{ \Carbon\Carbon::parse($cultivo->fecha_ingreso)->isoFormat('dddd, D [de] MMMM [de] YYYY', 'Do MMMM YYYY') }}
                                </td>
                                <td class="px-6 py-4">
                                    <a data-modal-target="edit-modal-{{ $index }}" data-modal-toggle="edit-modal-{{ $index }}" class="font-medium text-blue-600 hover:underline">Editar</a>
                                </td>
                                <td class="px-6 py-4">
                                    <a data-modal-target="popup-modal-{{ $index }}" data-modal-toggle="popup-modal-{{ $index }}" class="font-medium text-red-600 hover:underline">Eliminar</a>
                                </td>
                            </tr>

                            <!-- Modal para eliminar un cultivo -->
                            <div id="popup-modal-{{ $index }}" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                <div class="relative w-full max-w-md max-h-full">
                                    <div class="relative bg-white rounded-lg shadow">
                                        <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="popup-modal-{{ $index }}">
                                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                            </svg>
                                            <span class="sr-only">Cancelar</span>
                                        </button>
                                        <form method="POST" action="{{ route('administrador.cultivo-delete', $cultivo->id) }}">
                                            @csrf
                                            @method('DELETE')
                                            <div class="p-6 text-center">
                                                <svg class="mx-auto mb-4 text-gray-400 w-12 h-12" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                                </svg>
                                                <h3 class="mb-5 text-lg font-normal text-gray-500">¿Estás seguro que quieres eliminar este cultivo?</h3>
                                                <x-button type="submit">Si, estoy seguro</x-button>
                                                <x-secondary-button data-modal-hide="popup-modal-{{ $index }}" type="button">No, cancelar</x-secondary-button>
                                            </div>
                                        </form>                                        
                                    </div>
                                </div>
                            </div>

                            <!-- Modal para editar un cultivo -->
                            <div id="edit-modal-{{ $index }}" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                <div class="relative w-full max-w-md max-h-full">
                                    <div class="relative bg-white rounded-lg shadow">
                                        <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="edit-modal-{{ $index }}">
                                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                            </svg>
                                            <span class="sr-only">Cancelar</span>
                                        </button>
                                        <form method="POST" action="{{ route('administrador.cultivo-update', $cultivo->id) }}">
                                            @csrf
                                            @method('PATCH')
                                            <div class="px-6 py-6 lg:px-8">
                                                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                                                    Editar Cultivo
                                                </h2><br>
                                                <div class="block mb-2">
                                                    <label for="provedor_id" class="text-sm font-medium text-gray-900">Provedor</label>
                                                    <select id="provedor_id" name="provedor_id" class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5">
                                                        @foreach ($provedores as $provedor)
                                                        <option value="{{ $provedor->id }}" @if ($provedor->id === $cultivo->provedor_id) selected @endif>{{ $provedor->nombre }}</option>
                                                        @endforeach
                                                    </select>
                                                    <x-input-error for="provedor_id" class="mt-2" />
                                                </div>
                
                                                <div class="block mb-2">
                                                    <x-label for="nombre" value="{{ __('Name') }}" />
                                                    <x-input id="nombre" class="block mt-1 w-full" type="text" name="nombre" :value="$cultivo->nombre" required autofocus autocomplete="nombre" />
                                                    <x-input-error for="nombre" class="mt-2" />
                                                </div>
                
                                                <div class="block mb-2">
                                                    <x-label for="nombre_tecnico" value="{{ __('Nombre Técnico (opcional)') }}" />
                                                    <x-input id="nombre_tecnico" class="block mt-1 w-full" type="text" name="nombre_tecnico" :value="$cultivo->nombre_tecnico" autofocus autocomplete="nombre_tecnico" />
                                                    <x-input-error for="nombre_tecnico" class="mt-2" />
                                                </div>
                    
                                                <div class="block mb-2">
                                                    <x-label for="cantidad" value="{{ __('Cantidad (gramos)') }}" />
                                                    <x-input id="cantidad" class="block mt-1 w-full" type="text" name="cantidad" :value="$cultivo->cantidad" required autofocus autocomplete="cantidad" />
                                                    <x-input-error for="cantidad" class="mt-2" />
                                                </div>
                                                
                                                <div class="block mb-2">
                                                    <div class="relative max-w-sm">
                                                        <x-label for="fecha_ingreso" value="{{ __('Fecha de Ingreso') }}" />
                                                        <x-input id="fecha_ingreso" class="block mt-1 w-full" type="text" name="fecha_ingreso" :value="$cultivo->fecha_ingreso" required autofocus autocomplete="fecha_ingreso" />
                                                        <x-input-error for="fecha_ingreso" class="mt-2" />
                                                    </div>
                                                </div>

                                                <div class="flex items-center justify-end mt-4">
                                                    <x-button class="ml-4">
                                                        {{ 'Actualizar Cultivo' }}
                                                    </x-button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                        @endforeach
                    </tbody>
                </table>
            </div>

            @else

            <br><br><br>
            <div class="flex w-full overflow-hidden bg-white rounded-lg shadow-md">
                <div class="flex items-center justify-center w-12 bg-red-500">
                    <svg class="w-6 h-6 text-white fill-current" viewBox="0 0 40 40" xmlns="http://www.w3.org/2000/svg">
                        <path d="M20 3.33331C10.8 3.33331 3.33337 10.8 3.33337 20C3.33337 29.2 10.8 36.6666 20 36.6666C29.2 36.6666 36.6667 29.2 36.6667 20C36.6667 10.8 29.2 3.33331 20 3.33331ZM21.6667 28.3333H18.3334V25H21.6667V28.3333ZM21.6667 21.6666H18.3334V11.6666H21.6667V21.6666Z" />
                    </svg>
                </div>
                <div class="px-4 py-2 -mx-3">
                    <div class="mx-3">
                        <span class="font-semibold text-red-500">Ups!!! Parece que aún no hay registros :(</span>
                    </div>
                </div>
            </div>

            @endif
            
        </div>
    </div>
</x-admin-layout>
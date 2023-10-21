<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center">
            @foreach ($cultivos as $index => $cultivo)
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ $cultivo->nombre }} &nbsp;&nbsp;
                </h2>
                @if($cultivo->nombre_tecnico !== null)
                <h2 class="text-xl text-gray-800 leading-tight">
                    ({{ $cultivo->nombre_tecnico }}) &nbsp;&nbsp;
                </h2>
                @endif
                @if (DB::table('users')->where('tipoUsuario', 'Administrador')->where('id', auth()->user()->id)->exists())
                <span data-modal-target="edit-modal-{{ $index }}" data-modal-toggle="edit-modal-{{ $index }}" class="bg-blue-100 text-blue-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded-full">Editar Semilla &nbsp;<i class="fa-solid fa-pen"></i></span>
                <span data-modal-target="popup-modal-{{ $index }}" data-modal-toggle="popup-modal-{{ $index }}" class="bg-red-100 text-red-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded-full">Eliminar Semilla &nbsp;<i class="fa-solid fa-trash"></i></span>
                @endif

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
                            <form method="POST" action="{{ route('inventario.semilla-delete', $cultivo->id) }}">
                                @csrf
                                @method('DELETE')
                                <div class="p-6 text-center">
                                    <svg class="mx-auto mb-4 text-gray-400 w-12 h-12" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                    </svg>
                                    <h3 class="mb-5 text-lg font-normal text-gray-500">¿Estás seguro que quieres eliminar esta semilla?</h3>
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
                            <form method="POST" action="{{ route('inventario.semilla-update', $cultivo->id) }}">
                                @csrf
                                @method('PATCH')
                                <div class="px-6 py-6 lg:px-8">
                                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                                        Editar Semilla
                                    </h2><br>
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

                                    <div class="flex items-center justify-end mt-4">
                                        <x-button class="ml-4">
                                            {{ 'Actualizar Semilla' }}
                                        </x-button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-9xl mx-auto sm:px-6 lg:px-8">
            <div class="max-w-6xl mx-auto flex flex-wrap">
                <x-button data-modal-target="authentication-modal" data-modal-toggle="authentication-modal">
                    Agregar Registro&nbsp;&nbsp;<i class="fa-solid fa-file-circle-check"></i>
                </x-button>
            </div>

            <!-- Modal para Agregar un nuevo registro -->
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
                                Agregar Nuevo Registro
                            </h2>
                            @foreach ($cultivos as $index => $cultivo)
                            <form class="space-y-6" method="POST" action="{{ route('inventario.registro-update', $cultivo->id) }}">
                                @csrf
                                @method('PATCH')
                                <div class="block mb-2">
                                    <label for="provedor_id" class="text-sm font-medium text-gray-900">Proveedor</label>
                                    <select id="provedor_id" name="provedor_id" class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5">
                                        @foreach ($provedores as $provedor)
                                        <option value="{{ $provedor->id }}">{{ $provedor->nombre }}</option>
                                        @endforeach
                                    </select>
                                    <x-input-error for="provedor_id" class="mt-2" />
                                </div>

                                <div class="block mb-2">
                                    <x-label for="encargado" value="{{ __('¿Quién recibió?') }}" />
                                    <x-input id="encargado" class="block mt-1 w-full" type="text" name="encargado" :value="old('encargado')" required autofocus autocomplete="encargado" />
                                    <x-input-error for="encargado" class="mt-2" />
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
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
    
            <!-- Tabla de registros de semillas -->
            @if ($resultados->count())
            <br>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Primera columna para la tabla existente -->
                <div class="relative overflow-x-auto sm:rounded-lg">

                    <h2 class="font-semibold text-xl text-gray-800 leading-tight text-center">
                        {{ __('Registros de Ingreso') }} &nbsp;<i class="fa-solid fa-file-circle-check"></i>
                    </h2><br>

                    <table class="w-full text-sm text-center text-gray-500">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    Fecha de Ingreso
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Proveedor
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Cantidad (gramos)
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    ¿Quién recibió?
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Agregar Información
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($resultados as $index => $cultivo)
                                <tr class="bg-white border-b">
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                        {{ $cultivo->fecha_ingreso }}
                                    </th>
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                        {{ $cultivo->provedor->nombre }}
                                    </th>
                                    <th scope="row" class="px-6 py-4">
                                        {{ $cultivo->cantidad }}
                                    </th>
                                    <th scope="row" class="px-6 py-4">
                                        {{ $cultivo->encargado }}
                                    </th>
                                    <td class="px-6 py-4">
                                        <a data-modal-target="create-modal-{{ $index }}" data-modal-toggle="create-modal-{{ $index }}"><i class="fa-solid fa-arrow-right-to-bracket fa-xl" style="color: #099f13;"></i></a>
                                    </td>
                                </tr>

                                <!-- Modal para agregar y ver los registros -->
                                <div id="create-modal-{{ $index }}" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                    <div class="relative w-full max-w-md max-h-full">
                                        <div class="relative bg-white rounded-lg shadow">
                                            <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="create-modal-{{ $index }}">
                                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                                </svg>
                                                <span class="sr-only">Cancelar</span>
                                            </button>
                                            <div class="px-6 py-6 lg:px-8">
                                                <!-- Formulario -->
                                                <form method="POST" class="space-y-6" action="{{ route('inventario.registro-create', $cultivo->id) }}">
                                                    @csrf
                                                    <div class="px-6 py-6 lg:px-8">
                                                        <input id="provedor_id" name="provedor_id" type="hidden" value="{{ $cultivo->provedor->id }}">

                                                        <div class="block mb-2">
                                                            <div class="relative max-w-sm">
                                                                <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">
                                                                <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                                                    <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                                                                </svg>
                                                                </div>
                                                                <input datepicker id="fecha_salida" name="fecha_salida" type="text" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full pl-10 p-2.5" placeholder="Fecha de Salida">
                                                                <x-input-error for="fecha_salida" class="mt-2" />
                                                            </div>
                                                        </div>

                                                        <div class="block mb-2">
                                                            <x-label for="cantidad" value="{{ __('Cantidad (gramos)') }}" />
                                                            <x-input id="cantidad" class="block mt-1 w-full" type="number" name="cantidad" autofocus autocomplete="cantidad" />
                                                            <x-input-error for="cantidad" class="mt-2" />
                                                        </div>
                        
                                                        <div class="block mb-2">
                                                            <x-label for="destino" value="{{ __('Destino') }}" />
                                                            <x-input id="destino" class="block mt-1 w-full" type="text" name="destino" autofocus autocomplete="destino" />
                                                            <x-input-error for="destino" class="mt-2" />
                                                        </div>
                            
                                                        <div class="block mb-2">
                                                            <x-label for="encargado" value="{{ __('Encargado') }}" />
                                                            <x-input id="encargado" class="block mt-1 w-full" type="text" name="encargado" autofocus autocomplete="encargado" />
                                                            <x-input-error for="encargado" class="mt-2" />
                                                        </div>

                                                        <div class="block mb-2">
                                                            <x-label for="responsable" value="{{ __('Responsable') }}" />
                                                            <x-input id="responsable" class="block mt-1 w-full" type="text" name="responsable" autofocus autocomplete="responsable" />
                                                            <x-input-error for="responsable" class="mt-2" />
                                                        </div>

                                                        <div class="flex items-center justify-end mt-4">
                                                            <x-button class="ml-4">
                                                                <i class="fa-solid fa-plus"></i>
                                                            </x-button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif

            @if ($registros->count())
                <!-- Segunda columna para la tabla de la modal -->
                <div class="relative overflow-x-auto sm:rounded-lg">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight text-center">
                        {{ __('Registros de Salida') }} &nbsp;<i class="fa-solid fa-file-export"></i>
                    </h2><br>

                    <table id="cosechasTable" class="w-full text-sm text-center text-gray-500">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    Fecha de Salida
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Cantidad (gramos)
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Destino de Semilla
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Encargado
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Responsable
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($registros as $index => $registro)
                                <tr class="bg-white border-b">
                                    <th scope="row" class="px-6 py-4">
                                        {{ $registro->fecha_salida }}
                                    </th>
                                    <td class="px-6 py-4">
                                        {{ $registro->cantidad }}
                                    </td>
                                    <th class="px-6 py-4">
                                        {{ $registro->destino }}
                                    </th>
                                    <td class="px-6 py-4">
                                        {{ $registro->encargado }}
                                    </td>
                                    <td class="px-6 py-4" scope="row">
                                        {{ $registro->responsable }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="relative overflow-x-auto sm:rounded-lg">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight text-center">
                        {{ __('Registros de Salida') }} &nbsp;<i class="fa-solid fa-file-export"></i>
                    </h2><br>

                    <table id="cosechasTable" class="w-full text-sm text-center text-gray-500">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    Fecha de Salida
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Cantidad (gramos)
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Destino de semilla
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Encargado
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Responsable
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="bg-white border-b">
                                <td colspan="5" class="px-6 py-4 text-center">Todavía no hay registros.</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>
            @endif
    
        </div>
    </div>
</x-app-layout>
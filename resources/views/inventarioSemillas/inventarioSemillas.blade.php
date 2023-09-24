<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ 'Inventario de Semillas' }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="max-w-6xl mx-auto flex flex-wrap">
                @if ($provedores->count())
                <x-button data-modal-target="authentication-modal" data-modal-toggle="authentication-modal">
                    Agregar Semilla&nbsp;&nbsp;<i class="fa-solid fa-plus"></i>
                </x-button>&nbsp;&nbsp;&nbsp;&nbsp;
                <a href="{{ route('inventario.provedor') }}"><x-button>
                    Proveedores&nbsp;&nbsp;<i class="fa-solid fa-truck-field"></i>
                </x-button></a>
                @else
                <a href="{{ route('inventario.provedor') }}"><x-button>
                    Proveedores&nbsp;&nbsp;<i class="fa-solid fa-truck-field"></i>
                </x-button></a>
                @endif 
            </div><br>

            <!-- Modal para Agregar un registro de Semilla -->
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
                                Agregar Semilla
                            </h2>
                            <form class="space-y-6" method="POST" action="{{ route('inventario.semilla-create') }}">
                                @csrf
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

            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 md:grid-cols-5">
            
                @if($cultivos->count())
                    @foreach ($cultivos as $index => $cultivo)
                    <div class="max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow text-center">
                        <i class="fa-solid fa-seedling fa-lg" style="color: #19d72f;"></i>
                        <a href="{{ route('inventario.registros', $cultivo->id) }}">
                            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{$cultivo->nombre}}</h2><br>
                        </a>
                        <a href="{{ route('inventario.registros', $cultivo->id) }}" class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-green-700 rounded-lg hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300">
                            Detalles
                            <svg class="w-3.5 h-3.5 ml-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
                            </svg>
                        </a>
                    </div>
                    @endforeach
                @endif

            </div>
        </div>
    </div>
</x-app-layout>
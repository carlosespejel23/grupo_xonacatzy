<x-admin-layout>
    <x-slot name="header">
        <div class="flex items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ 'Productos' }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="max-w-6xl mx-auto flex flex-wrap">
                <x-button data-modal-target="authentication-modal" data-modal-toggle="authentication-modal">
                    Agregar Producto&nbsp;&nbsp;<i class="fa-solid fa-plus"></i>
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
                                Agregar Producto
                            </h2>
                            <form class="space-y-6" method="POST" action="{{ route('administrador.producto-create') }}">
                                @csrf
                                <div class="block mb-2">
                                    <x-label for="nombre" value="{{ __('Name') }}" />
                                    <x-input id="nombre" class="block mt-1 w-full" type="text" name="nombre" :value="old('nombre')" required autofocus autocomplete="nombre" />
                                    <x-input-error for="nombre" class="mt-2" />
                                </div>
    
                                <div class="block mb-2">
                                    <x-label for="precio" value="{{ __('Precio') }}" />
                                    <x-input id="precio" class="block mt-1 w-full" type="number" name="precio" :value="old('precio')" required autofocus autocomplete="precio" />
                                    <x-input-error for="precio" class="mt-2" />
                                </div>
                    
                                <div class="flex items-center justify-end mt-4">
                                    <x-button class="ml-4">
                                        {{ 'Registrar Producto' }}
                                    </x-button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div> 
            
            <br>

            <!-- Tabla de usuarios -->
            @if ($productos->count())
            
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                <table class="w-full text-sm text-center text-gray-500">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                Nombre
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Estadísticas
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Precio
                            </th>
                            <th scope="col" class="px-6 py-3">Editar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($productos as $index => $producto)
                            <tr class="bg-white border-b">
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                    {{$producto->nombre}}
                                </th>
                                <td class="px-6 py-4">
                                    <a href="{{ route('administrador.estadisticas-productos', $producto->id) }}" class="font-medium text-purple-600 hover:underline"><i class="fa-solid fa-chart-line fa-xl"></i></a>
                                </td>
                                @if ($producto->precio !== null)
                                <td class="px-6 py-4">
                                    $ {{$producto->precio}}
                                </td>
                                @else
                                <td class="px-6 py-4">
                                    No Registado
                                </td>
                                @endif
                                <td class="px-6 py-4">
                                    <a data-modal-target="edit-modal-{{ $index }}" data-modal-toggle="edit-modal-{{ $index }}" class="font-medium text-blue-600 hover:underline">Editar</a>
                                </td>
                            </tr>

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
                                        <form method="POST" action="{{ route('administrador.producto-update', $producto->id) }}">
                                            @csrf
                                            @method('PATCH')
                                            <div class="px-6 py-6 lg:px-8">
                                                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                                                    Editar Producto
                                                </h2><br>
                                                <div class="block mb-2">
                                                    <x-label for="nombre" value="{{ __('Name') }}" />
                                                    <x-input id="nombre" class="block mt-1 w-full" type="text" name="nombre" :value="$producto->nombre" required autofocus autocomplete="nombre" />
                                                    <x-input-error for="nombre" class="mt-2" />
                                                </div>
                    
                                                <div class="block mb-2">
                                                    <x-label for="precio" value="{{ __('Precio') }}" />
                                                    <x-input id="precio" class="block mt-1 w-full" type="text" name="precio" :value="$producto->precio" required autofocus autocomplete="precio" disabled />
                                                    <x-input-error for="precio" class="mt-2" />
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
                        <span class="font-semibold text-red-500">Ups!!! :(</span>
                        <p class="text-sm text-gray-600">Aun no tienes productos.</p>
                    </div>
                </div>
            </div>

            @endif

        </div>
    </div>
</x-admin-layout>
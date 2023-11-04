<x-admin-layout>
    <x-slot name="header">
        <div class="flex items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ 'Eliminar Información' }}
            </h2>&nbsp;&nbsp;&nbsp;
            <a href="#reportes-seccion">
                <span class="bg-green-100 text-green-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded">Reportes de Actividades Diarias &nbsp;<i class="fa-solid fa-file"></i></span>&nbsp;
            </a>
            <a href="#ventas-seccion">
                <span class="bg-yellow-100 text-yellow-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded">Día de Ventas &nbsp;<i class="fa-solid fa-hand-holding-dollar"></i></span>&nbsp;
            </a>
            <a href="#inventario-seccion">
                <span class="bg-blue-100 text-blue-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded">Inventario de Semillas &nbsp;<i class="fa-solid fa-seedling"></i></span>&nbsp;&nbsp;&nbsp;
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Contenido de la sección de Reportes de Actividades Diarias -->
            <section id="reportes-seccion">
                
                <!-- Descripcion de la seccion "Cosechas y Empaques" -->
                <center>
                    <h3 class="text-lg font-medium text-gray-900">
                        {{ __('Reportes de Actividades Diarias') }}
                    </h3>
                    <div class="mt-3 max-w-2xl text-sm text-gray-600">
                        <p>
                            {{ __('La información que contienen "Cosechas y Empaques" se elimina por día o por un rango de días seleccionado, lo que lleva a una eliminación masiva de datos. Asimismo, se elimina de forma automática información sobre los combinados y tareas diarias.') }}
                        </p>
                    </div><br>
                    <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
                        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                            <div class="px-6 py-6 lg:px-8">
                                <div date-rangepicker class="flex items-center">
                                    <div class="relative">
                                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                                        </svg>
                                    </div>
                                    <input name="fecha1" type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5" placeholder="Fecha Inicial">
                                    </div>
                                    <span class="mx-4 text-gray-500">a</span>
                                    <div class="relative">
                                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                                        </svg>
                                    </div>
                                    <input name="fecha2" type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5" placeholder="Fecha Final">
                                    </div>&nbsp;&nbsp;

                                    <x-button data-modal-target="actividades-modal" data-modal-toggle="actividades-modal" class="ml-4">
                                        {{ 'ELiminar' }}
                                    </x-button>
                                </div>

                                @if ($errors->any())
                                    <br><div class="alert alert-danger">
                                        <ul>
                                            Los campos de fecha son obligatorios.
                                        </ul>
                                    </div>
                                @endif

                                <!-- Modal para eliminar rango de actividades diarias -->
                                <div id="actividades-modal" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                    <div class="relative w-full max-w-md max-h-full">
                                        <div class="relative bg-white rounded-lg shadow">
                                            <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="actividades-modal">
                                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                                </svg>
                                                <span class="sr-only">Cancelar</span>
                                            </button>
                                            <form id="formularioActividades" method="POST" action="{{ route('administrador.actividades-delete') }}">
                                                @csrf
                                                @method('DELETE')
                                                <input type="hidden" name="fecha1_hidden" value="" id="fecha1_hidden">
                                                <input type="hidden" name="fecha2_hidden" value="" id="fecha2_hidden">

                                                <script>
                                                    const formularioActividades = document.getElementById('formularioActividades');

                                                    formularioActividades.addEventListener('submit', (event) => {
                                                        // Obtener las fechas desde los campos del formulario
                                                        const fechaInput1 = document.querySelector('input[name="fecha1"]');
                                                        const fechaInput2 = document.querySelector('input[name="fecha2"]');

                                                        // Actualizar los campos ocultos con los valores actuales
                                                        document.querySelector('input[name="fecha1_hidden"]').value = fechaInput1.value;
                                                        document.querySelector('input[name="fecha2_hidden"]').value = fechaInput2.value;
                                                    });
                                                </script>

                                                <div class="p-6 text-center">
                                                    <svg class="mx-auto mb-4 text-gray-400 w-12 h-12" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                                    </svg>
                                                    <h3 class="mb-5 text-lg font-normal text-gray-500">¿Estás seguro que quieres eliminar estos datos?</h3>
                                                    <x-button type="submit">Si, estoy seguro</x-button>
                                                    <x-secondary-button data-modal-hide="actividades-modal" type="button">No, cancelar</x-secondary-button>
                                                </div>
                                            </form>                                        
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </center><br>

            </section>

            <br><br><center><i class="fa-solid fa-arrow-down-long fa-2xl"></i></center><br><br>

            <!-- Contenido de la sección de Día de Ventas -->
            <section id="ventas-seccion">

                <!-- Descripcion de la seccion "Ventas, Productos y Mercados" -->
                <center>
                    <h3 class="text-lg font-medium text-gray-900">
                        {{ __('Ventas, Productos y Mercados') }}
                    </h3>
                    <div class="mt-3 max-w-2xl text-sm text-gray-600">
                        <p>
                            {{ __('Para poder eliminar algún registro de "Productos y Mercados", primero debes eliminar los registros del "Día de Ventas". 
                            La información que contiene "Día de Ventas" se elimina por día o por un rango de días seleccionado, lo que conlleva a una eliminación masiva de datos. 
                            Asimismo, se elimina de forma automática información sobre las ventas de cultivos, productos y gastos del día. Ten en cuenta que la eliminación puede 
                            afectar a la interpretación de las estadísticas en el rango de fechas seleccionado.') }}
                        </p>
                    </div>
                </center><br>

                <!-- Division de la pantalla en 3 columnas para la relacion "Ventas y Mercados"-->
                <div class="max-w-7xl mx-auto grid grid-cols-1 sm:grid-cols-3 md:grid-cols-3 lg:grid-cols-3 gap-4">

                    <!-- Columna 1 "Ventas" -->
                    <div class="col-span-1">
                        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                            <br>
                            <h2 class="font-semibold text-xl text-gray-800 leading-tight text-center">
                                {{ __('Ventas') }} &nbsp;<i class="fa-solid fa-hand-holding-dollar"></i>
                            </h2>
                            <div class="px-6 py-6 lg:px-8">
                                <div date-rangepicker class="flex items-center">
                                    <div class="relative">
                                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                                        </svg>
                                    </div>
                                    <input name="fecha1_ventas" type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5" placeholder="Fecha Inicial">
                                    </div>
                                    <span class="mx-4 text-gray-500">a</span>
                                    <div class="relative">
                                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                                        </svg>
                                    </div>
                                    <input name="fecha2_ventas" type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5" placeholder="Fecha Final">
                                    </div>
                                </div><br>

                                <center><x-button data-modal-target="ventas-modal" data-modal-toggle="ventas-modal" class="ml-4">
                                    {{ 'ELiminar' }}
                                </x-button></center>

                                <!-- Modal para eliminar rango de actividades diarias -->
                                <div id="ventas-modal" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                    <div class="relative w-full max-w-md max-h-full">
                                        <div class="relative bg-white rounded-lg shadow">
                                            <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="ventas-modal">
                                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                                </svg>
                                                <span class="sr-only">Cancelar</span>
                                            </button>
                                            <form id="formularioVentas" method="POST" action="{{ route('administrador.ventas-delete') }}">
                                                @csrf
                                                @method('DELETE')
                                                <input type="hidden" name="fecha1_hidden_ventas" value="" id="fecha1_hidden_ventas">
                                                <input type="hidden" name="fecha2_hidden_ventas" value="" id="fecha2_hidden_ventas">

                                                <script>
                                                    const formularioVentas = document.getElementById('formularioVentas');

                                                    formularioVentas.addEventListener('submit', (event) => {
                                                        // Obtener las fechas desde los campos del formulario
                                                        const fechaInput1_ventas = document.querySelector('input[name="fecha1_ventas"]');
                                                        const fechaInput2_ventas = document.querySelector('input[name="fecha2_ventas"]');

                                                        // Actualizar los campos ocultos con los valores actuales
                                                        document.querySelector('input[name="fecha1_hidden_ventas"]').value = fechaInput1_ventas.value;
                                                        document.querySelector('input[name="fecha2_hidden_ventas"]').value = fechaInput2_ventas.value;
                                                    });
                                                </script>

                                                <div class="p-6 text-center">
                                                    <svg class="mx-auto mb-4 text-gray-400 w-12 h-12" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                                    </svg>
                                                    <h3 class="mb-5 text-lg font-normal text-gray-500">¿Estás seguro que quieres eliminar estos datos de venta?</h3>
                                                    <x-button type="submit">Si, estoy seguro</x-button>
                                                    <x-secondary-button data-modal-hide="ventas-modal" type="button">No, cancelar</x-secondary-button>
                                                </div>
                                            </form>                                        
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Columna 2 "Productos" -->
                    <div class="col-span-1">
                        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                            <br>
                            <h2 class="font-semibold text-xl text-gray-800 leading-tight text-center">
                                {{ __('Productos') }} &nbsp;<i class="fa-solid fa-boxes-stacked"></i>
                            </h2>
                            <div class="px-6 py-6 lg:px-8">
                                <!-- Tabla para mostrar los productos -->
                                @if ($productos->count())
                                
                                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                                    <table class="w-full text-sm text-center text-gray-500">
                                        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                            <tr>
                                                <th scope="col" class="px-6 py-2">
                                                    Nombre
                                                </th>
                                                <th scope="col" class="px-6 py-2">Eliminar</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($productos as $index => $producto)
                                                <tr class="bg-white border-b">
                                                    <th scope="row" class="px-6 py-2 font-medium text-gray-900 whitespace-nowrap">
                                                        {{$producto->nombre}}
                                                    </th>
                                                    <td class="px-6 py-2">
                                                        <a data-modal-target="productos-modal-{{ $index }}" data-modal-toggle="productos-modal-{{ $index }}" class="font-medium text-red-600 hover:underline">Eliminar</a>
                                                    </td>
                                                </tr>

                                                <!-- Modal para eliminar un producto -->
                                                <div id="productos-modal-{{ $index }}" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                                    <div class="relative w-full max-w-md max-h-full">
                                                        <div class="relative bg-white rounded-lg shadow">
                                                            <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="productos-modal-{{ $index }}">
                                                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                                                </svg>
                                                                <span class="sr-only">Cancelar</span>
                                                            </button>
                                                            <form method="POST" action="{{ route('administrador.producto-delete', $producto->id) }}">
                                                                @csrf
                                                                @method('DELETE')
                                                                <div class="p-6 text-center">
                                                                    <svg class="mx-auto mb-4 text-gray-400 w-12 h-12" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                                                    </svg>
                                                                    <h3 class="mb-5 text-lg font-normal text-gray-500">¿Estás seguro que quieres eliminar este producto?</h3>
                                                                    <x-button type="submit">Si, estoy seguro</x-button>
                                                                    <x-secondary-button data-modal-hide="productos-modal-{{ $index }}" type="button">No, cancelar</x-secondary-button>
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

                                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                                    <table class="w-full text-sm text-center text-gray-500">
                                        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                            <tr>
                                                <th scope="col" class="px-6 py-2">
                                                    Nombre
                                                </th>
                                                <th scope="col" class="px-6 py-2">Eliminar</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="bg-white border-b">
                                                <td colspan="2" class="px-6 py-2 text-center">Todavía no hay registros de productos</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                                @endif

                            </div>
                        </div>
                    </div>

                    <!-- Columna 3 "Mercados" -->
                    <div class="col-span-1">
                        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                            <br>
                            <h2 class="font-semibold text-xl text-gray-800 leading-tight text-center">
                                {{ __('Mercados') }} &nbsp;<i class="fa-solid fa-store"></i>
                            </h2>
                            <div class="px-6 py-6 lg:px-8">
                                <!-- Tabla para mostrar los mercados -->
                                @if ($mercados->count())
                                
                                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                                    <table class="w-full text-sm text-center text-gray-500">
                                        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                            <tr>
                                                <th scope="col" class="px-6 py-2">
                                                    Nombre
                                                </th>
                                                <th scope="col" class="px-6 py-2">Eliminar</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($mercados as $index => $mercado)
                                                <tr class="bg-white border-b">
                                                    <th scope="row" class="px-6 py-2 font-medium text-gray-900 whitespace-nowrap">
                                                        {{$mercado->nombre}}
                                                    </th>
                                                    <td class="px-6 py-2">
                                                        <a data-modal-target="mercados-modal-{{ $index }}" data-modal-toggle="mercados-modal-{{ $index }}" class="font-medium text-red-600 hover:underline">Eliminar</a>
                                                    </td>
                                                </tr>

                                                <!-- Modal para eliminar un mercado -->
                                                <div id="mercados-modal-{{ $index }}" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                                    <div class="relative w-full max-w-md max-h-full">
                                                        <div class="relative bg-white rounded-lg shadow">
                                                            <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="mercados-modal-{{ $index }}">
                                                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                                                </svg>
                                                                <span class="sr-only">Cancelar</span>
                                                            </button>
                                                            <form method="POST" action="{{ route('administrador.mercado-delete', $mercado->id) }}">
                                                                @csrf
                                                                @method('DELETE')
                                                                <div class="p-6 text-center">
                                                                    <svg class="mx-auto mb-4 text-gray-400 w-12 h-12" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                                                    </svg>
                                                                    <h3 class="mb-5 text-lg font-normal text-gray-500">¿Estás seguro que quieres eliminar este mercado?</h3>
                                                                    <x-button type="submit">Si, estoy seguro</x-button>
                                                                    <x-secondary-button data-modal-hide="mercados-modal-{{ $index }}" type="button">No, cancelar</x-secondary-button>
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
                                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                                    <table class="w-full text-sm text-center text-gray-500">
                                        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                            <tr>
                                                <th scope="col" class="px-6 py-2">
                                                    Nombre
                                                </th>
                                                <th scope="col" class="px-6 py-2">Eliminar</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="bg-white border-b">
                                                <td colspan="2" class="px-6 py-2 text-center">Todavía no hay registros de mercados</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                </div>

            </section>
            
            <br><br><center><i class="fa-solid fa-arrow-down-long fa-2xl"></i></center><br><br>

            <!-- Contenido de la sección de Inventario de Semillas -->
            <section id="inventario-seccion">

                <!-- Descripcion de la seccion "Proveedores y Cultivos" -->
                <center>
                    <h3 class="text-lg font-medium text-gray-900">
                        {{ __('Proveedores y Cultivos') }}
                    </h3>
                    <div class="mt-3 max-w-2xl text-sm text-gray-600">
                        <p>
                            {{ __('Para poder eliminar algún registro de "Proveedores" primero debes eliminar los "Cultivos". 
                            En la información que contiene "Cultivos" puede eliminar los registros de ingreso y salida, o tambien puede optar por eliminar el cultivo con todo y registros. 
                            Es importante saber que hay que eliminar todos los registros relacionados con el cultivo en las demas secciones (reportes y ventas) para poder eliminar dicho cultivo') }}
                        </p>
                    </div>
                </center><br>

                <!-- Division de la pantalla en 2 columnas para la relacion "Provedores y Cultivos"-->
                <div class="max-w-7xl mx-auto grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-2 gap-4">

                    <!-- Columna 1 "Cultivos" -->
                    <div class="col-span-1">
                        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                            <br>
                            <h2 class="font-semibold text-xl text-gray-800 leading-tight text-center">
                                {{ __('Cultivos') }} &nbsp;<i class="fa-solid fa-seedling"></i>
                            </h2>
                            <div class="px-6 py-6 lg:px-8">
                                <!-- Tabla de cultivos -->
                                @if ($cultivos->count())
                                
                                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                                    <table class="w-full text-sm text-center text-gray-500">
                                        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                            <tr>
                                                <th scope="col" class="px-6 py-2">
                                                    Nombre
                                                </th>
                                                <th scope="col" class="px-6 py-2">
                                                    Vaciar Registros
                                                    <!-- Ayuda al usuario a saber que esta columna -->
                                                    <button data-popover-target="popover-description" data-popover-placement="bottom-end" type="button"><svg class="w-4 h-4 ml-2 text-gray-400 hover:text-gray-500" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"></path></svg><span class="sr-only">Mostrar Información</span></button>
                                                    <div data-popover id="popover-description" role="tooltip" class="absolute z-10 invisible inline-block text-sm text-gray-600 transition-opacity duration-300 bg-white border border-gray-200 rounded-lg shadow-sm opacity-0 w-72 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-400">
                                                        <div class="p-3 space-y-2">
                                                            <p>Elimina los registros historiales de Ingreso y Salida de la semilla, excepto los actuales.</p>
                                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                                                    </svg></a>
                                                        </div>
                                                        <div data-popper-arrow></div>
                                                    </div>
                                                </th>
                                                <th scope="col" class="px-6 py-2">
                                                    Eliminar Cultivo
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($cultivos as $index => $cultivo)
                                                <tr class="bg-white border-b dark:bg-gray-900 dark:border-gray-700">
                                                    <th scope="row" class="px-6 py-2 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                        {{$cultivo->nombre}}
                                                    </th> 
                                                    <td class="px-6 py-2">
                                                        <a data-modal-target="registro-modal-{{ $index }}" data-modal-toggle="registro-modal-{{ $index }}" class="font-medium text-red-600 hover:underline">Eliminar</a>
                                                    </td>                       
                                                    <td class="px-6 py-2">
                                                        <a data-modal-target="cultivo-modal-{{ $index }}" data-modal-toggle="cultivo-modal-{{ $index }}" class="font-medium text-red-600 hover:underline">Eliminar</a>
                                                    </td>
                                                </tr>

                                                <!-- Modal para eliminar los registros de ese cultivo -->
                                                <div id="registro-modal-{{ $index }}" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                                    <div class="relative w-full max-w-md max-h-full">
                                                        <div class="relative bg-white rounded-lg shadow">
                                                            <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="registro-modal-{{ $index }}">
                                                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                                                </svg>
                                                                <span class="sr-only">Cancelar</span>
                                                            </button>
                                                            <form method="POST" action="{{ route('administrador.registros-delete', $cultivo->id) }}">
                                                                @csrf
                                                                @method('DELETE')
                                                                <div class="p-6 text-center">
                                                                    <svg class="mx-auto mb-4 text-gray-400 w-12 h-12" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                                                    </svg>
                                                                    <h3 class="mb-5 text-lg font-normal text-gray-500">¿Estás seguro que quieres eliminar los registros de este cultivo?</h3>
                                                                    <x-button type="submit">Si, estoy seguro</x-button>
                                                                    <x-secondary-button data-modal-hide="registro-modal-{{ $index }}" type="button">No, cancelar</x-secondary-button>
                                                                </div>
                                                            </form>                                        
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Modal para eliminar un cutivo -->
                                                <div id="cultivo-modal-{{ $index }}" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                                    <div class="relative w-full max-w-md max-h-full">
                                                        <div class="relative bg-white rounded-lg shadow">
                                                            <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="cultivo-modal-{{ $index }}">
                                                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                                                </svg>
                                                                <span class="sr-only">Cancelar</span>
                                                            </button>
                                                            <form method="POST" action="{{ route('administrador.semilla-delete', $cultivo->id) }}">
                                                                @csrf
                                                                @method('DELETE')
                                                                <div class="p-6 text-center">
                                                                    <svg class="mx-auto mb-4 text-gray-400 w-12 h-12" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                                                    </svg>
                                                                    <h3 class="mb-5 text-lg font-normal text-gray-500">¿Estás seguro que quieres eliminar este cultivo?</h3>
                                                                    <x-button type="submit">Si, estoy seguro</x-button>
                                                                    <x-secondary-button data-modal-hide="cultivo-modal-{{ $index }}" type="button">No, cancelar</x-secondary-button>
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
                                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                                    <table class="w-full text-sm text-center text-gray-500">
                                        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                            <tr>
                                                <th scope="col" class="px-6 py-2">
                                                    Nombre
                                                </th>
                                                <th scope="col" class="px-6 py-2">
                                                    Vaciar Registros
                                                    <!-- Ayuda al usuario a saber que esta columna -->
                                                    <button data-popover-target="popover-description" data-popover-placement="bottom-end" type="button"><svg class="w-4 h-4 ml-2 text-gray-400 hover:text-gray-500" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"></path></svg><span class="sr-only">Mostrar Información</span></button>
                                                </th>
                                                <th scope="col" class="px-6 py-2">
                                                    Eliminar Cultivo
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="bg-white border-b">
                                                <td colspan="3" class="px-6 py-2 text-center">Todavía no hay registros de cultivos</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                @endif

                            </div>
                        </div>
                    </div>

                    <!-- Columna 2 "Proveedores" -->
                    <div class="col-span-1">
                        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                            <br>
                            <h2 class="font-semibold text-xl text-gray-800 leading-tight text-center">
                                {{ __('Proveedores') }} &nbsp;<i class="fa-solid fa-truck-field"></i>
                            </h2>
                            <div class="px-6 py-6 lg:px-8">
                                <!-- Tabla de proveedores -->
                                @if ($provedores->count())
                                
                                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                                    <table class="w-full text-sm text-center text-gray-500">
                                        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                            <tr>
                                                <th scope="col" class="px-6 py-2">
                                                    Nombre
                                                </th>
                                                <th scope="col" class="px-6 py-2">Eliminar</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($provedores as $index => $provedor)
                                                <tr class="bg-white border-b dark:bg-gray-900 dark:border-gray-700">
                                                    <th scope="row" class="px-6 py-2 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                        {{$provedor->nombre}}
                                                    </th>                        
                                                    <td class="px-6 py-2">
                                                        <a data-modal-target="proveedor-modal-{{ $index }}" data-modal-toggle="proveedor-modal-{{ $index }}" class="font-medium text-red-600 hover:underline">Eliminar</a>
                                                    </td>
                                                </tr>

                                                <!-- Modal para eliminar un proveedor -->
                                                <div id="proveedor-modal-{{ $index }}" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                                    <div class="relative w-full max-w-md max-h-full">
                                                        <div class="relative bg-white rounded-lg shadow">
                                                            <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="proveedor-modal-{{ $index }}">
                                                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                                                </svg>
                                                                <span class="sr-only">Cancelar</span>
                                                            </button>
                                                            <form method="POST" action="{{ route('administrador.provedor-delete', $provedor->id) }}">
                                                                @csrf
                                                                @method('DELETE')
                                                                <div class="p-6 text-center">
                                                                    <svg class="mx-auto mb-4 text-gray-400 w-12 h-12" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                                                    </svg>
                                                                    <h3 class="mb-5 text-lg font-normal text-gray-500">¿Estás seguro que quieres eliminar este provedor?</h3>
                                                                    <x-button type="submit">Si, estoy seguro</x-button>
                                                                    <x-secondary-button data-modal-hide="proveedor-modal-{{ $index }}" type="button">No, cancelar</x-secondary-button>
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
                                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                                    <table class="w-full text-sm text-center text-gray-500">
                                        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                            <tr>
                                                <th scope="col" class="px-6 py-2">
                                                    Nombre
                                                </th>
                                                <th scope="col" class="px-6 py-2">Eliminar</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="bg-white border-b">
                                                <td colspan="3" class="px-6 py-2 text-center">Todavía no hay registros de proveedores</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                @endif

                            </div>
                        </div>
                    </div>
                    
                </div>
                
            </section>

        </div>
    </div>
</x-admin-layout>
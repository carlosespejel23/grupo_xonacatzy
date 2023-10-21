<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ 'Día de Ventas' }}
            </h2>&nbsp;&nbsp;&nbsp;
            <span data-modal-target="authentication-modal" data-modal-toggle="authentication-modal" class="bg-green-100 text-green-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded">Mercados &nbsp;<i class="fa-solid fa-store"></i></span>&nbsp;
            <a href="{{ route('administrador.productos') }}"><span class="bg-yellow-100 text-yellow-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded">Productos &nbsp;<i class="fa-solid fa-boxes-stacked"></i></span></a>

            <!-- Modal para agregar un Mercado -->
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
                                Agregar Nuevo Mercado
                            </h2>
                            <form class="space-y-6" method="POST" action="{{ route('diaVentas.mercado-create') }}">
                                @csrf
                                <div class="block mb-2">
                                    <x-label for="nombre" value="{{ __('Nombre del Mercado') }}" />
                                    <x-input id="nombre" class="block mt-1 w-full" type="text" name="nombre" :value="old('nombre')" required autofocus autocomplete="nombre" />
                                    <x-input-error for="nombre" class="mt-2" />
                                </div>

                                <div class="flex items-center justify-end mt-4">
                                    <x-button class="ml-4">
                                        {{ 'Registrar Mercado' }}
                                    </x-button>
                                </div>
                            </form><br>

                            <!-- Tabla para mostrar los mercados -->
                            @if ($mercados->count())
                            
                            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                                <table class="w-full text-sm text-center text-gray-500">
                                    <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                        <tr>
                                            <th scope="col" class="px-6 py-3">
                                                Nombre del Mercado
                                            </th>
                                            <th scope="col" class="px-6 py-3"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($mercados as $index => $mercado)
                                            <tr class="bg-white border-b">
                                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                                    {{$mercado->nombre}}
                                                </th>
                                                <td class="px-6 py-4">
                                                    <a data-modal-target="popup-modal-{{ $index }}" data-modal-toggle="popup-modal-{{ $index }}" class="font-medium text-red-600 hover:underline"><i class="fa-solid fa-trash"></i></a>
                                                </td>
                                            </tr>

                                            <!-- Modal para eliminar un mercado -->
                                            <div id="popup-modal-{{ $index }}" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                                <div class="relative w-full max-w-md max-h-full">
                                                    <div class="relative bg-white rounded-lg shadow">
                                                        <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="popup-modal-{{ $index }}">
                                                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                                            </svg>
                                                            <span class="sr-only">Cancelar</span>
                                                        </button>
                                                        <form method="POST" action="{{ route('diaVentas.mercado-delete', $mercado->id) }}">
                                                            @csrf
                                                            @method('DELETE')
                                                            <div class="p-6 text-center">
                                                                <svg class="mx-auto mb-4 text-gray-400 w-12 h-12" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                                                </svg>
                                                                <h3 class="mb-5 text-lg font-normal text-gray-500">¿Estás seguro que quieres eliminar este mercado?</h3>
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
                                        <p class="text-sm text-gray-600">Aun no tienes mercados.</p>
                                    </div>
                                </div>
                            </div>

                            @endif

                        </div>    
                    </div>
                </div>
            </div>

        </div>
    </x-slot>

    <div class="py-12">

        <div class="max-w-lg mx-auto bg-green-500 p-4 rounded-lg shadow-lg">
            <center>
                <div class="flex flex-col space-y-4 items-center justify-center">
                    <!-- Input para la fecha de venta y selección de mercado -->
                    <div class="flex items-center space-x-4">
                        <div class="relative max-w-xs">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                                </svg>
                            </div>
                            <input datepicker id="fecha" name="fecha" type="text" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full pl-10 p-2.5" placeholder="Fecha de Venta">
                        </div>
                        <select id="mercado_id" name="mercado_id" class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 p-2.5">
                            @foreach ($mercados as $mercado)
                            <option value="{{ $mercado->id }}">{{ $mercado->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </center>
        </div><br>

        <!-- Division de la pantalla en 3 columnas -->
        <div class="max-w-7xl mx-auto grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-4">

            <!-- Columna 1 -->
            <div class="col-span-1">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight text-center">
                    {{ __('Registro de Ventas') }} &nbsp;<i class="fa-solid fa-file-invoice-dollar"></i>
                </h2><br>
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="px-6 py-6 lg:px-8">

                        <!-- Inicio del primer formulario de registrar ventas -->
                        <h4 class="font-semibold text-sm text-gray-800 leading-tight text-center">
                            {{ __('Cultivos y/o Semillas') }} 
                        </h4>
                        <form id="formularioVentas" class="space-y-6" method="POST" action="{{ route('diaVentas.ventas_create') }}">
                            @csrf
                            <input type="hidden" name="fecha_hidden" value="" id="fecha_hidden">
                            <input type="hidden" name="mercado_id_hidden" value="" id="mercado_id_hidden">

                            <script>
                                const formularioVentas = document.getElementById('formularioVentas');

                                formularioVentas.addEventListener('submit', (event) => {
                                    // Obtener la fecha y el ID del mercado desde los campos del formulario
                                    const fechaInput = document.querySelector('input[name="fecha"]');
                                    const mercadoIdInput = document.querySelector('select[name="mercado_id"]');

                                    // Actualizar los campos ocultos con los valores actuales
                                    document.querySelector('input[name="fecha_hidden"]').value = fechaInput.value;
                                    document.querySelector('input[name="mercado_id_hidden"]').value = mercadoIdInput.value;
                                });
                            </script>

                            <div class="block mb-2">
                                <div id="cultivos_section">
                                    <div class="flex items-center space-x-4">
                                        <x-input id="cantidad" class="block mt-1 w-1/4" type="number" name="cantidad[]" min="0" autofocus autocomplete="cantidad" placeholder="Cant."/>
                                        <select id="cultivo_id" name="cultivo_id[]" class="block mt-1 w-1/2 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 p-2.5">
                                            @foreach ($cultivos as $cultivo)
                                            <option value="{{ $cultivo->id }}">{{ $cultivo->nombre }}</option>
                                            @endforeach
                                        </select>
                                        <x-input id="monto" class="block mt-1 w-1/4" type="text" name="monto[]" autofocus autocomplete="monto" placeholder="$"/>
                                    </div>
                                </div>
                                <div class="flex items-center justify-end mt-4">
                                    <x-secondary-button type="button" id="agregar_cultivo">
                                        <i class="fa-solid fa-plus"></i>
                                    </x-secondary-button><br>
                                </div>
                            </div>
                            
                            <!-- Script JavaScript para agregar otros registros de cultivos -->
                            <script>
                                const agregarCultivoButton = document.getElementById('agregar_cultivo');
                                const numCultivosSection = document.getElementById('cultivos_section');
                                let contadorCultivos = 1;
                                
                                agregarCultivoButton.addEventListener('click', () => {
                                    contadorCultivos++;
                                    const newInput = document.createElement('div');
                                    newInput.innerHTML = `
                                    <div class="flex items-center space-x-4">
                                        <x-input id="cantidad_${contadorCultivos}" class="block mt-1 w-1/4" type="number" name="cantidad[${contadorCultivos}]" min="0" autofocus autocomplete="cantidad" placeholder="Cant."/>
                                        <select id="cultivo_id_${contadorCultivos}" name="cultivo_id[${contadorCultivos}]" class="block mt-1 w-1/2 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 p-2.5">
                                            @foreach ($cultivos as $cultivo)
                                            <option value="{{ $cultivo->id }}">{{ $cultivo->nombre }}</option>
                                            @endforeach
                                        </select>
                                        <x-input id="monto_${contadorCultivos}" class="block mt-1 w-1/4" type="text" name="monto[${contadorCultivos}]" autofocus autocomplete="monto" placeholder="$"/>
                                    </div>
                                    `;
                                    numCultivosSection.appendChild(newInput);
                                });
                                </script>

                            <h4 class="font-semibold text-sm text-gray-800 leading-tight text-center">
                                {{ __('Productos') }} 
                            </h4>
                            <div class="block mb-2">
                                <div id="productos_section">
                                    <!-- Aquí colocamos el primer grupo de entrada, que no se agrega dinámicamente -->
                                    <div class="flex items-center space-x-4">
                                        <x-input id="cantidad1" class="block mt-1 w-1/4" type="number" name="cantidad1[]" min="0" autofocus autocomplete="cantidad1" placeholder="Cant."/>
                                        <select id=" producto_id" name="producto_id[]" class="block mt-1 w-3/4 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 p-2.5">
                                            @foreach ($productos as $producto)
                                            <option value="{{ $producto->id }}">{{ $producto->nombre }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="flex items-center justify-end mt-4">
                                    <x-secondary-button type="button" id="agregar_producto">
                                        <i class="fa-solid fa-plus"></i>
                                    </x-secondary-button>
                                </div><br>
                            </div>

                            <!-- Script JavaScript para agregar otros registros de productos -->
                            <script>
                                const agregarProductoButton = document.getElementById('agregar_producto');
                                const numProductosSection = document.getElementById('productos_section');
                                let contadorProductos = 1;
                            
                                agregarProductoButton.addEventListener('click', () => {
                                    contadorProductos++;
                                    const newInput = document.createElement('div');
                                    newInput.innerHTML = `
                                    <div class="flex items-center space-x-4">
                                        <x-input id="cantidad1_${contadorProductos}" class="block mt-1 w-1/4" type="number" name="cantidad1[${contadorProductos}]" min="0" autofocus autocomplete="cantidad1" placeholder="#"/>
                                        <select id="producto_id_${contadorProductos}" name="producto_id[${contadorProductos}]" class="block mt-1 w-3/4 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 p-2.5">
                                            @foreach ($productos as $producto)
                                            <option value="{{ $producto->id }}">{{ $producto->nombre }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    `;
                                    numProductosSection.appendChild(newInput);
                                });
                            </script>

                            @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif

                            <div class="flex items-center justify-end mt-4">
                                <x-button class="ml-4">
                                    Registrar
                                </x-button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>

            <!-- Columna 2 -->
            <div class="col-span-1">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight text-center">
                    {{ __('Gastos del Día') }} &nbsp;<i class="fa-solid fa-money-bill-transfer"></i>
                </h2><br>
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="px-6 py-6 lg:px-8">
                        
                        <!-- Inicio del segundo formulario de registrar gastos extras -->
                        <form id="formularioGastos" class="space-y-6" method="POST" action="{{ route('diaVentas.gastos_create') }}">
                            @csrf
                            <input type="hidden" name="fecha_hidden1" value="" id="fecha_hidden1">

                            <script>
                                const formularioGastos = document.getElementById('formularioGastos');

                                formularioGastos.addEventListener('submit', (event) => {
                                    // Obtener la fecha desde los campos del formulario
                                    const fechaInput = document.querySelector('input[name="fecha"]');

                                    // Actualizar los campos ocultos con los valores actuales
                                    document.querySelector('input[name="fecha_hidden1"]').value = fechaInput.value;
                                });
                            </script>

                            <div class="block mb-2">
                                <div id="gastos_section">
                                    <!-- Aquí colocamos el primer grupo de entrada, que no se agrega dinámicamente -->
                                    <div class="flex items-center space-x-4">
                                        <x-input id="nombre" class="block mt-1 w-3/4" type="text" name="nombre[]" autofocus autocomplete="nombre" placeholder="Descripción"/>
                                        <x-input id="monto" class="block mt-1 w-1/4" type="text" name="monto[]" autofocus autocomplete="monto" placeholder="$"/>
                                    </div>
                                </div>
                                <div class="flex items-center justify-end mt-4">
                                    <x-secondary-button type="button" id="agregar_gasto">
                                        <i class="fa-solid fa-plus"></i>
                                    </x-secondary-button><br>
                                </div>
                            </div>
                            
                            <!-- Script JavaScript para agregar otros registros de cultivos -->
                            <script>
                                const agregarGastoButton = document.getElementById('agregar_gasto');
                                const numGastosSection = document.getElementById('gastos_section');
                                let contadorGastos = 1;
                            
                                agregarGastoButton.addEventListener('click', () => {
                                    contadorGastos++;
                                    const newInput = document.createElement('div');
                                    newInput.innerHTML = `
                                    <div class="flex items-center space-x-4">
                                        <x-input id="nombre_${contadorGastos}" class="block mt-1 w-3/4" type="text" name="nombre[${contadorGastos}]" autofocus autocomplete="nombre" placeholder="Descripción"/>
                                        <x-input id="monto_${contadorGastos}" class="block mt-1 w-1/4" type="text" name="monto[${contadorGastos}]" autofocus autocomplete="monto" placeholder="$"/>
                                    </div>
                                    `;
                                    numGastosSection.appendChild(newInput);
                                });
                            </script>

                            @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif

                            <div class="flex items-center justify-end mt-4">
                                <x-button class="ml-4">
                                    Registrar
                                </x-button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>

            <!-- Columna 3 -->
            <div class="col-span-1">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight text-center">
                    {{ __('Resumen Final') }} &nbsp;<i class="fa-solid fa-filter-circle-dollar"></i>
                </h2><br>
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="px-6 py-6 lg:px-8">

                        <!-- Busqueda de datos de registros de ventas y gastos del dia -->
                        <div class="flex items-center space-x-4">
                            <div class="max-w-6xl mx-auto">
                                <div class="flex items-center space-x-4">
                                    <div class="relative max-w-xs block mt-1 w-3/4">
                                        <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">
                                            <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                                            </svg>
                                        </div>
                                        <input datepicker id="fecha_ingreso" name="fecha_ingreso" type="text" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full pl-10 p-2.5" placeholder="Consultar Registros">
                                    </div>
                            
                                    <x-button id="consultaBtn" class="bg-green-500 text-white block mt-1 w-1/4">
                                        <i class="fa-solid fa-magnifying-glass"></i>
                                    </x-button>
                                </div>
                            </div>
                        </div><br>

                        <!-- Seccion para mostrar los registros de ventas -->
                        @if ($ventas_cultivos->count())
                            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                                <table id="ventasTable" class="w-full text-sm text-center text-gray-500">
                                    <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                        <tr>
                                            <th scope="col" class="px-6 py-2">
                                                Cantidad
                                            </th>
                                            <th scope="col" class="px-6 py-2">
                                                Cultivos y/o Productos
                                            </th>
                                            <th scope="col" class="px-6 py-2">
                                                Monto
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($ventas_cultivos as $venta_cultivo)
                                            <tr class="bg-white border-b">
                                                <th scope="row" class="px-6 py-2 font-medium text-gray-900 whitespace-nowrap">
                                                    {{$venta_cultivo->cantidad}}
                                                </th>
                                                <td class="px-6 py-2">
                                                    {{$venta_cultivo->cultivo}}
                                                </td>
                                                <td class="px-6 py-2">
                                                    ${{$venta_cultivo->monto}}
                                                </td>
                                            </tr>
                                        @endforeach
                                        @foreach ($ventas_productos as $venta_producto)
                                            <tr class="bg-white border-b">
                                                <th scope="row" class="px-6 py-2 font-medium text-gray-900 whitespace-nowrap">
                                                    {{$venta_producto->cantidad}}
                                                </th>
                                                <td class="px-6 py-2">
                                                    {{$venta_producto->producto}}
                                                </td>
                                                <td class="px-6 py-2">
                                                    ${{$venta_producto->total}}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr class="font-semibold text-gray-900">
                                            <th colspan="2" scope="row" class="px-6 py-3 text-base text-right">Venta Total : </th>
                                            <td class="px-6 py-3">${{ number_format($totalVentas, 2) }}</td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div><br>

                        @else
                            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                                <table  id="ventasTable" class="w-full text-sm text-center text-gray-500">
                                    <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                        <tr>
                                            <th scope="col" class="px-6 py-2">
                                                Cantidad
                                            </th>
                                            <th scope="col" class="px-6 py-2">
                                                Cultivos y/o Productos
                                            </th>
                                            <th scope="col" class="px-6 py-2">
                                                Monto
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="bg-white border-b">
                                            <td colspan="3" class="px-6 py-4 text-center">Todavía no hay registros el día de hoy.</td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr class="font-semibold text-gray-900">
                                            <th colspan="2" scope="row" class="px-6 py-3 text-base text-right">Venta Total : </th>
                                            <td class="px-6 py-3"> - </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div><br>
                        @endif

                        <h4 class="font-semibold text-sm text-gray-800 leading-tight text-center">
                            {{ __('Gastos del Día') }} 
                        </h4><br>

                        <!-- Seccion para mostrar los gastos -->
                        @if ($gastos_extras->count())
                            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                                <table id="gastosTable" class="w-full text-sm text-center text-gray-500">
                                    <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                        <tr>
                                            <th scope="col" class="px-6 py-2">
                                                Descripción
                                            </th>
                                            <th scope="col" class="px-6 py-2">
                                                Monto
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($gastos_extras as $gastos_extra)
                                            <tr class="bg-white border-b">
                                                <td class="px-6 py-2">
                                                    {{$gastos_extra->nombre}}
                                                </td>
                                                <td class="px-6 py-2">
                                                    ${{$gastos_extra->monto}}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr class="font-semibold text-gray-900">
                                            <th scope="row" class="px-6 py-3 text-base text-right">Gastos Totales : </th>
                                            <td class="px-6 py-3">${{ number_format($totalGastosExtra, 2) }}</td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div><br>
                        @else
                            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                                <table id="gastosTable" class="w-full text-sm text-center text-gray-500">
                                    <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                        <tr>
                                            <th scope="col" class="px-6 py-2">
                                                Descripción
                                            </th>
                                            <th scope="col" class="px-6 py-2">
                                                Monto
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="bg-white border-b">
                                            <td colspan="2" class="px-6 py-4 text-center">Todavía no hay registros el día de hoy.</td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr class="font-semibold text-gray-900">
                                            <th scope="row" class="px-6 py-3 text-base text-right">Gastos Totales : </th>
                                            <td class="px-6 py-3"> - </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div><br>
                        @endif

                    </div>
                </div>
            </div>
            
        </div>
    </div>
</x-app-layout>

<script>
    document.addEventListener('DOMContentLoaded', function() {
    
        // Obtén una referencia al input por su id
        const fechaInput = document.getElementById('fecha_ingreso');
    
        // Obtén una referencia al botón de consulta por su ID
        const consultaBtn = document.getElementById('consultaBtn');
    
        // Agrega un event listener para el evento click en el botón
        consultaBtn.addEventListener('click', function () {
            console.log('Clic en el botón de consulta');
    
            // Obtén la fecha actual del input
            let fecha = fechaInput.value;
    
            // Reemplaza las barras diagonales "/" por guiones "-"
            fecha = fecha.replace(/\//g, '-');
    
            console.log(fecha);
    
            // Realiza una solicitud AJAX al controlador
            fetch(`/dia-ventas/gastosTotal/${fecha}`)
                .then(response => response.json())
                .then(data => {
                    // Maneja la respuesta del controlador aquí
                    console.log(data); // Aquí puedes ver los datos devueltos por el controlador
                    // Llama a una función para actualizar la tabla con los nuevos datos
                    actualizarTabla1(data); //Cultivos y/o semillas
                    actualizarTabla2(data); //Gastos extra
                })
                .catch(error => {
                    console.error('Error al realizar la solicitud AJAX:', error);
                });
        });
    
        // Función para actualizar la tabla con los datos de cultivos y/o semillas
        function actualizarTabla1(data) {
            const tbody = document.querySelector('#ventasTable tbody'); // Obtiene el tbody de la tabla
            const tfoot = document.querySelector('#ventasTable tfoot'); // Obtiene el tfoot de la tabla
    
            // Borra el contenido actual del tbody y tfoot
            tbody.innerHTML = '';
            tfoot.innerHTML = '';
    
            if (data.length > 0) {
                // Si hay registros, llenar la tabla con los datos
                data[0].forEach(venta_cultivo => {
                    const fila = document.createElement('tr');
                    fila.classList.add('bg-white', 'border-b');
                    fila.innerHTML = `
                        <th scope="row" class="px-6 py-2 font-medium text-gray-900 whitespace-nowrap">
                            ${venta_cultivo.cantidad}
                        </th>
                        <td class="px-6 py-2">
                            ${venta_cultivo.cultivo}
                        </td>
                        <td class="px-6 py-2">
                            $${venta_cultivo.monto}
                        </td>
                    `;
                    tbody.appendChild(fila);
                });
                data[1].forEach(venta_producto => {
                    const fila = document.createElement('tr');
                    fila.classList.add('bg-white', 'border-b');
                    fila.innerHTML = `
                        <th scope="row" class="px-6 py-2 font-medium text-gray-900 whitespace-nowrap">
                            ${venta_producto.cantidad}
                        </th>
                        <td class="px-6 py-2">
                            ${venta_producto.producto}
                        </td>
                        <td class="px-6 py-2">
                            $${venta_producto.total}
                        </td>
                    `;
                    tbody.appendChild(fila);
                });
                const fila = document.createElement('tr');
                fila.classList.add('font-semibold', 'text-gray-900');
                fila.innerHTML = `
                    <th colspan="2" scope="row" class="px-6 py-3 text-base text-right">Venta Total : </th>
                    <td class="px-6 py-3">$${data[3].toFixed(2)}</td>
                `;
                tfoot.appendChild(fila);
            } else {
                // Si no hay registros, mostrar el mensaje en una fila
                const noRegistrosFila = document.createElement('tr');
                noRegistrosFila.classList.add('bg-white', 'border-b');
                noRegistrosFila.innerHTML = `
                    <td colspan="3" class="px-6 py-4 text-center">Todavía no hay registros para esta fecha.</td>
                `;
                tbody.appendChild(noRegistrosFila);
            }
        }

        // Función para actualizar la tabla con los datos de gastos extra
        function actualizarTabla2(data) {
            const tbody = document.querySelector('#gastosTable tbody'); // Obtiene el tbody de la tabla
            const tfoot = document.querySelector('#gastosTable tfoot'); // Obtiene el tfoot de la tabla
    
            // Borra el contenido actual del tbody y tfoot
            tbody.innerHTML = '';
            tfoot.innerHTML = '';
    
            if (data.length > 0) {
                // Si hay registros, llenar la tabla con los datos
                data[2].forEach(gastos_extra => {
                    const fila = document.createElement('tr');
                    fila.classList.add('bg-white', 'border-b');
                    fila.innerHTML = `
                        <td class="px-6 py-2">
                            ${gastos_extra.nombre}
                        </td>
                        <td class="px-6 py-2">
                            $${gastos_extra.monto}
                        </td>
                    `;
                    tbody.appendChild(fila);
                });
                const fila = document.createElement('tr');
                fila.classList.add('font-semibold', 'text-gray-900');
                fila.innerHTML = `
                    <th scope="row" class="px-6 py-3 text-base text-right">Gastos Totales : </th>
                    <td class="px-6 py-3">$${data[4].toFixed(2)}</td>
                `;
                tfoot.appendChild(fila);
            } else {
                // Si no hay registros, mostrar el mensaje en una fila
                const noRegistrosFila = document.createElement('tr');
                noRegistrosFila.classList.add('bg-white', 'border-b');
                noRegistrosFila.innerHTML = `
                    <td colspan="2" class="px-6 py-4 text-center">Todavía no hay registros para esta fecha.</td>
                `;
                tbody.appendChild(noRegistrosFila);
            }
        }
    
    });
</script>
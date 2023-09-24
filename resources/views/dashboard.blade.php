<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Dashboard') }}
            </h2>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    
            <ul class="flex flex-wrap text-sm font-medium text-center text-gray-500 dark:text-gray-400">
                <li class="mr-2">
                    <a href="{{ route('dashboard') }}" class="inline-block px-4 py-3 text-white {{ request()->is('dashboard*') ? 'bg-green-700' : '' }} rounded-lg" aria-current="page">Cosechas y Empaques</a>
                </li>
            </ul>
            
        </div>
    </x-slot>

    <div class="flex flex-wrap">
        <div class="w-full lg:w-6/12">
            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    
                    <div class="max-w-6xl mx-auto">
                        <div class="flex items-center space-x-4">
                            <x-button data-modal-target="authentication-modal" data-modal-toggle="authentication-modal">
                                Agregar Registro&nbsp;<i class="fa-solid fa-plus"></i>
                            </x-button>
                    
                            <div class="relative max-w-xs">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                                    </svg>
                                </div>
                                <input datepicker id="fecha_ingreso" name="fecha_ingreso" type="text" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full pl-10 p-2.5" placeholder="Consultar Registros">
                            </div>
                    
                            <x-button id="consultaBtn" class="bg-green-500 text-white">
                                <i class="fa-solid fa-magnifying-glass"></i>
                            </x-button>
                    
                            <x-button type="button" data-modal-target="top-left-modal" data-modal-toggle="top-left-modal">
                                <i class="fa-solid fa-list-check"></i>
                            </x-button>
                        </div>
                    </div>                    
                    <br>
        
                    <!-- Modal para agregar un registro -->
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
                                        Agregar Registro a Cosechas
                                    </h2>
                                    <form class="space-y-6" method="POST" action="{{ route('cosecha-create') }}">
                                        @csrf
                                    
                                        <div class="block mb-2">
                                            <label for=" cultivo_id" class="text-sm font-medium text-gray-900">Cultivo</label>
                                            <select id=" cultivo_id" name=" cultivo_id" class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5">
                                                @foreach ($cultivos as $cultivo)
                                                <option value="{{ $cultivo->id }}">{{ $cultivo->nombre }}</option>
                                                @endforeach
                                            </select>
                                            <x-input-error for="provedor_id" class="mt-2" />
                                        </div>
                                    
                                        <div class="block mb-2">
                                            <x-label for="num_botes" value="{{ __('Número de Botes')}}" />
                                            <x-input id="num_botes" class="block mt-1 w-full" type="text" name="num_botes" value="0" min="0" required autofocus autocomplete="num_botes" />
                                            <input id="range_botes" name="range_botes" type="range" min="0" max="0.99" value="0" step="0.25" class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer">
                                            <span id="range_botes_value" class="text-sm mt-1">0</span>
                                            <x-input-error for="num_botes" class="mt-2" />
                                        </div>
                                        
                                        <script>
                                            const noBotesInput = document.getElementById('num_botes');
                                            const rangeBotesInput = document.getElementById('range_botes');
                                        
                                            rangeBotesInput.addEventListener('input', function () {
                                                const noBotesValue = parseInt(noBotesInput.value) || 0;
                                                const rangeBotesValue = parseFloat(this.value) || 0;
                                        
                                                // Asegurarse de que solo se sumen valores de 0 a 3/4 cuando el rango es 1
                                                let totalBotes = noBotesValue;
                                                if (rangeBotesValue < 1) {
                                                    totalBotes += rangeBotesValue;
                                                } else {
                                                    totalBotes += 0.75; // Sumar 3/4 en lugar del valor completo de 1
                                                }
                                        
                                                // Redondear el valor antes de establecerlo en el input
                                                noBotesInput.value = totalBotes.toFixed(2);
                                            });
                                        
                                            const rangeBotesValue = document.getElementById('range_botes_value');
                                        
                                            rangeBotesInput.addEventListener('input', function () {
                                                const value = parseFloat(this.value);
                                                const numerator = Math.floor(value * 4);
                                                const denominator = 4;
                                                const fraction = numerator === denominator ? '1' : `${numerator}/${denominator}`;
                                                rangeBotesValue.textContent = fraction;
                                            });
                                        </script>
                                                                        
                                    
                                        <div class="block mb-2">
                                            <x-label for="invernadero" value="{{ __('Número de Invernadero (Opcional)') }}" />
                                            <x-input id="invernadero" class="block mt-1 w-full" type="number" name="invernadero" :value="old('invernadero')" min="0" autofocus autocomplete="invernadero" />
                                            <x-input-error for="invernadero" class="mt-2" />
                                        </div>
                                    
                                        <div class="block mb-2">
                                            <div id="num_camas_section">
                                                <div class="block mb-2">
                                                    <x-label for="num_cama[]" value="{{ __('Número de Cama') }}" />
                                                    <x-input id="num_cama" class="block mt-1 w-full" type="number" name="num_cama[]" min="0" value="0" required autofocus autocomplete="num_cama" />
                                                    <x-input-error for="num_cama" class="mt-2" />
                                                </div>
                                            </div>
                                    
                                            <x-button type="button" id="agregar_cama" class="text-sm font-medium text-gray-900">
                                                Agregar otra cama
                                            </x-button>
                                        </div>
                                    
                                        <!-- Script JavaScript para agregar camas -->
                                        <script>
                                            const agregarCamaButton = document.getElementById('agregar_cama');
                                            const numCamasSection = document.getElementById('num_camas_section');
                                            let contadorCamas = 1;
                                    
                                            agregarCamaButton.addEventListener('click', () => {
                                                contadorCamas++;
                                                const newInput = document.createElement('div');
                                                newInput.innerHTML = `
                                                <div class="block mb-2">
                                                    <x-label for="num_cama[${contadorCamas}]" value="Número de Cama (${contadorCamas})" />
                                                    <x-input id="num_cama_${contadorCamas}" class="block mt-1 w-full" type="number" name="num_cama[${contadorCamas}]" min="0" value="0" required autofocus autocomplete="num_cama" />
                                                    <x-input-error for="num_cama[${contadorCamas}]" class="mt-2" />
                                                </div>
                                                `;
                                                numCamasSection.appendChild(newInput);
                                            });
                                        </script>
                                    
                                        <div class="block mb-2">
                                            <x-label for="corte" value="{{ __('Número de Corte (Opcional)') }}" />
                                            <x-input id="corte" class="block mt-1 w-full" type="number" name="corte" :value="old('corte')" min="0" autofocus autocomplete="corte" />
                                            <x-input-error for="corte" class="mt-2" />
                                        </div>
                                        
                                        <div class="block mb-2">
                                            <div class="relative max-w-sm">
                                                <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">
                                                <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                                                </svg>
                                                </div>
                                                <input datepicker id="fecha" name="fecha" type="text" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full pl-10 p-2.5" placeholder="Fecha de Registro">
                                                <x-input-error for="fecha" class="mt-2" />
                                            </div>
                                        </div>
                                    
                                        <div class="flex items-center justify-end mt-4">
                                            <x-button class="ml-4">
                                                {{ 'Registrar' }}
                                            </x-button>
                                        </div>
                                    </form>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
        
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight text-center">
                        {{ __('Cosechas') }} &nbsp;<i class="fa-solid fa-seedling"></i>
                    </h2><br>

                    <!-- Tabla de cosechas -->
                    @if ($cosechas->count())
                    
                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                        <table id="cosechasTable" class="w-full text-sm text-center text-gray-500">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3">
                                        Cultivo
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        No. de Botes
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Invernadero
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Cama(s)
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Corte
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Encargado
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($cosechas as $index => $cosecha)
                                    <tr class="bg-white border-b">
                                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                            {{$cosecha->nombre}}
                                        </th>
                                        <th scope="row" class="px-6 py-4">
                                            {{$cosecha->num_botes}}
                                        </th>
                                        @if ($cosecha->invernadero !== null)
                                        <td class="px-6 py-4">
                                            {{$cosecha->invernadero}}
                                        </td>
                                        @else
                                        <td class="px-6 py-4">
                                            --
                                        </td>
                                        @endif
                                        <th class="px-6 py-4">
                                            {{$cosecha->num_cama}}
                                        </th>
                                        @if ($cosecha->corte !== null)
                                        <td class="px-6 py-4">
                                            {{$cosecha->corte}}
                                        </td>
                                        @else
                                        <td class="px-6 py-4">
                                            --
                                        </td>
                                        @endif
                                        <td class="px-6 py-4" scope="row">
                                            {{$cosecha->encargado}}
                                        </td>
                                    </tr>
        
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                        <table id="cosechasTable" class="w-full text-sm text-center text-gray-500">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3">
                                        Cultivo
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        No. de Botes
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Invernadero
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Cama(s)
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Corte
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Encargado
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="bg-white border-b">
                                    <td colspan="6" class="px-6 py-4 text-center">Todavía no hay registros el día de hoy.</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    @endif
        
                </div>
            </div>
        </div>
        <div class="w-full lg:w-6/12">
            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    
                    <div class="max-w-6xl mx-auto">
                        <div class="flex items-center space-x-4">
                            <button data-modal-target="combinado-modal" data-modal-toggle="combinado-modal" class="text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2 mr-2 mb-2 focus:outline-none">
                                Agregar Combinado
                            </button>
                        </div>
                    </div>                                        
                    <br>

                    <!-- Modal para agregar un combinado -->
                    <div id="combinado-modal" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
                        <div class="relative w-full max-w-md max-h-full">
                            <!-- Modal content -->
                            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="combinado-modal">
                                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                    </svg>
                                    <span class="sr-only">Cancelar</span>
                                </button>
                                <div class="px-6 py-6 lg:px-8">
                                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                                        Agregar Combinado
                                    </h2>
                                    <form class="space-y-6" method="POST" action="{{ route('combinados-create') }}">
                                        @csrf
                                        <div class="block mb-2">
                                            <label for=" cultivo_id" class="text-sm font-medium text-gray-900">Escoger Cultivo</label>
                                            <select id=" cultivo_id" name=" cultivo_id" class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5">
                                                @foreach ($cultivos as $cultivo)
                                                <option value="{{ $cultivo->id }}">{{ $cultivo->nombre }}</option>
                                                @endforeach
                                            </select>
                                            <x-input-error for="cultivo_id" class="mt-2" />
                                        </div>
        
                                        <div class="block mb-2">
                                            <x-label for="num_bolsas" value="{{ __('Número de Bolsas') }}" />
                                            <x-input id="num_bolsas" class="block mt-1 w-full" type="number" name="num_bolsas" :value="old('num_bolsas')" autofocus autocomplete="num_bolsas" />
                                            <x-input-error for="num_bolsas" class="mt-2" />
                                        </div>
            
                                        <div class="block mb-2">
                                            <x-label for="gramos" value="{{ __('Gramos') }}" />
                                            <x-input id="gramos" class="block mt-1 w-full" type="number" name="gramos" :value="old('gramos')" required autofocus autocomplete="gramos" />
                                            <x-input-error for="gramos" class="mt-2" />
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

                    <!-- Modal para mostrar las actividades diarias-->
                    <div id="top-left-modal" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
                        <div class="relative w-full max-w-md max-h-full">
                            <!-- Modal content -->
                            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                <!-- Modal header -->
                                <div class="flex items-center justify-between p-5 border-b rounded-t dark:border-gray-600">
                                    <i class="fa-solid fa-list-check fa-lg"></i>
                                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="top-left-modal">
                                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                        </svg>
                                        <span class="sr-only">Close modal</span>
                                    </button>
                                </div>
                                <!-- Modal body -->
                                <div class="p-6 space-y-6">
                                    <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
                                        <h2 class="font-semibold text-xl text-gray-800 leading-tight text-center">
                                            Actividades Diarias
                                        </h2>
                                        <form id="formularioTareas" class="space-y-6" method="POST" action="{{ route('tareas-diarias-create') }}">
                                            @csrf
                                            <div class="flex items-center space-x-4">
                                                <x-input id="nombre" class="block mt-1 w-full" type="text" name="nombre" :value="old('nombre')" autofocus autocomplete="nombre" />
                                                <x-input-error for="nombre" class="mt-2" />
                                                <x-button class="ml-4">
                                                    <i class="fa-solid fa-plus"></i>
                                                </x-button>
                                            </div>
                                        </form><br>
                                
                                        <ol id="listaTareas" class="relative border-l border-gray-200 dark:border-gray-700">
                                        @if ($tareas->count())
                                            @foreach ($tareas as $index => $tarea)
                                                <li class="ml-6">
                                                    <span class="absolute flex items-center justify-center w-6 h-6 bg-green-100 rounded-full -left-3 ring-8 ring-white">
                                                        <svg class="w-2.5 h-2.5 text-green-800 aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                                            <i class="fa-solid fa-check fa-sm"></i>&nbsp;
                                                        </svg>
                                                    </span>
                                                    <h3 class="mb-1 text-md font-semibold text-gray-900">{{$tarea->nombre}}</h3>
                                                    <time class="block mb-2 text-sm font-normal leading-none text-gray-400">&nbsp;</time>
                                                </li>
                                            @endforeach
                                
                                        @else
                                            <li class="ml-6">
                                                <span class="absolute flex items-center justify-center w-6 h-6 bg-red-100 rounded-full -left-3 ring-8 ring-white">
                                                    <svg class="w-2.5 h-2.5 text-red-800 aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                                        <i class="fa-solid fa-face-frown fa-sm"></i>&nbsp;
                                                    </svg>
                                                </span>
                                                <h3 class="mb-1 text-md font-semibold text-red-800">Todavía no hay actividades registradas.</h3>
                                            </li>
                                        @endif
                                        </ol>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <h2 class="font-semibold text-xl text-gray-800 leading-tight text-center">
                        {{ __('Empaques') }} &nbsp;<i class="fa-solid fa-box-open"></i>
                    </h2><br>

                    <!-- Tabla de empaques -->
                    @if ($empaques->count())
                    
                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                        <table id="empaquesTable" class="w-full text-sm text-center text-gray-500">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3">
                                        Número de Bolsas
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Gramos
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        °C Inicial
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        °C Final
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        H2O
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Editar
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($empaques as $index => $empaque)
                                    <tr class="bg-white border-b">
                                        @if ($empaque->num_bolsas !== null)
                                            <td class="px-6 py-4">
                                                {{$empaque->num_bolsas}}
                                            </td>
                                            @else
                                            <td class="px-6 py-4">
                                                --
                                            </td>
                                        @endif
                                        @if ($empaque->gramos !== null)
                                            <td class="px-6 py-4">
                                                {{$empaque->gramos}}
                                            </td>
                                            @else
                                            <td class="px-6 py-4">
                                                --
                                            </td>
                                        @endif
                                            @if ($empaque->temp_inicial !== null)
                                            <td class="px-6 py-4">
                                                {{$empaque->temp_inicial}}
                                            </td>
                                            @else
                                            <td class="px-6 py-4">
                                                --
                                            </td>
                                        @endif
                                        @if ($empaque->temp_final !== null)
                                            <td class="px-6 py-4">
                                                {{$empaque->temp_final}}
                                            </td>
                                            @else
                                            <td class="px-6 py-4">
                                                --
                                            </td>
                                        @endif
                                        @if ($empaque->H2O !== null)
                                            <td class="px-6 py-4">
                                                {{$empaque->H2O}}
                                            </td>
                                            @else
                                            <td class="px-6 py-4">
                                                --
                                            </td>
                                        @endif
                                        <td class="px-6 py-4" scope="row">
                                            <a data-modal-target="edit-modal-{{ $index }}" data-modal-toggle="edit-modal-{{ $index }}" class="text-sm font-medium text-gray-900">
                                                <i class="fa-solid fa-pen"></i>
                                            </a>
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
                                                <form method="POST" action="{{ route('empaques-update', $empaque->id) }}">
                                                    @csrf
                                                    @method('PATCH')
                                                    <div class="px-6 py-6 lg:px-8">
                                                        <h2 class="font-semibold text-xl text-gray-800 leading-tight text-center">
                                                            {{$empaque->nombre}}
                                                        </h2><br>
                                                        <div class="block mb-2">
                                                            <x-label for="num_bolsas" value="{{ __('Número de Bolsas') }}" />
                                                            <x-input id="num_bolsas" class="block mt-1 w-full" type="text" name="num_bolsas" :value="$empaque->num_bolsas" autofocus autocomplete="num_bolsas" />
                                                            <x-input-error for="num_bolsas" class="mt-2" />
                                                        </div>
                        
                                                        <div class="block mb-2">
                                                            <x-label for="gramos" value="{{ __('Gramos') }}" />
                                                            <x-input id="gramos" class="block mt-1 w-full" type="text" name="gramos" :value="$empaque->gramos" autofocus autocomplete="gramos" />
                                                            <x-input-error for="gramos" class="mt-2" />
                                                        </div>
                            
                                                        <div class="block mb-2">
                                                            <x-label for="temp_inicial" value="{{ __('°C Inicial') }}" />
                                                            <x-input id="temp_inicial" class="block mt-1 w-full" type="text" name="temp_inicial" :value="$empaque->temp_inicial" autofocus autocomplete="temp_inicial" />
                                                            <x-input-error for="temp_inicial" class="mt-2" />
                                                        </div>

                                                        <div class="block mb-2">
                                                            <x-label for="temp_final" value="{{ __('°C Final') }}" />
                                                            <x-input id="temp_final" class="block mt-1 w-full" type="text" name="temp_final" :value="$empaque->temp_final" autofocus autocomplete="temp_final" />
                                                            <x-input-error for="temp_final" class="mt-2" />
                                                        </div>

                                                        <div class="block mb-2">
                                                            <x-label for="H2O" value="{{ __('H2O') }}" />
                                                            <x-input id="H2O" class="block mt-1 w-full" type="text" name="H2O" :value="$empaque->H2O" autofocus autocomplete="H2O" />
                                                            <x-input-error for="H2O" class="mt-2" />
                                                        </div>

                                                        <div class="flex items-center justify-end mt-4">
                                                            <x-button class="ml-4">
                                                                {{ 'Actualizar Empaque' }}
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
                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                        <table id="empaquesTable" class="w-full text-sm text-center text-gray-500">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3">
                                        Número de Bolsas
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Gramos
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        °C Inicial
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        °C Final
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        H2O
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="bg-white border-b">
                                    <td colspan="5" class="px-6 py-4 text-center">Todavía no hay registros el día de hoy.</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    @endif

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
        fetch(`/dashboard/${fecha}`)
            .then(response => response.json())
            .then(data => {
                // Maneja la respuesta del controlador aquí
                console.log(data); // Aquí puedes ver los datos devueltos por el controlador
                // Llama a una función para actualizar la tabla con los nuevos datos
                actualizarTabla(data.cosechas);
                actualizarLista(data.tareas_diarias);
                actualizarTablaEmpaques(data.empaques);
            })
            .catch(error => {
                console.error('Error al realizar la solicitud AJAX:', error);
            });
    });

    // Función para actualizar la tabla con los datos
    function actualizarTabla(data) {
        const tbody = document.querySelector('#cosechasTable tbody'); // Obtiene el tbody de la tabla

        // Borra el contenido actual del tbody
        tbody.innerHTML = '';

        if (data.length > 0) {
            // Si hay registros, llenar la tabla con los datos
            data.forEach(cosecha => {
                const fila = document.createElement('tr');
                fila.classList.add('bg-white', 'border-b');
                fila.innerHTML = `
                    <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">${cosecha.nombre}</td>
                    <td scope="row" class="px-6 py-4">${cosecha.num_botes}</td>
                    <td class="px-6 py-4">${cosecha.invernadero !== null ? cosecha.invernadero : '--'}</td>
                    <td class="px-6 py-4">${cosecha.num_cama}</td>
                    <td class="px-6 py-4">${cosecha.corte !== null ? cosecha.corte : '--'}</td>
                    <td scope="row" class="px-6 py-4">${cosecha.encargado}</td>
                `;
                tbody.appendChild(fila);
            });
        } else {
            // Si no hay registros, mostrar el mensaje en una fila
            const noRegistrosFila = document.createElement('tr');
            noRegistrosFila.classList.add('bg-white', 'border-b');
            noRegistrosFila.innerHTML = `
                <td colspan="6" class="px-6 py-4 text-center">Todavía no hay registros para esta fecha.</td>
            `;
            tbody.appendChild(noRegistrosFila);
        }
    }

    //Funcion para actualizar la lista de actividades diarias
    function actualizarLista(data) {
        const lista = document.getElementById('listaTareas'); // Obtén el elemento ol con el ID listaTareas
        const formulario = document.getElementById('formularioTareas'); // Obtén el formulario con el ID formularioTareas

        // Borra el contenido actual
        lista.innerHTML = '';

        if (data.length > 0) {
            // Si hay registros, llenar la lista con los datos
            data.forEach(tarea => {
                const li = document.createElement('li');
                li.classList.add('ml-6');
                li.innerHTML = `
                    <span class="absolute flex items-center justify-center w-6 h-6 bg-green-100 rounded-full -left-3 ring-8 ring-white">
                        <svg class="w-2.5 h-2.5 text-green-800 aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <i class="fa-solid fa-check fa-sm"></i>&nbsp;
                        </svg>
                    </span>
                    <h3 class="mb-1 text-md font-semibold text-gray-900">${tarea.nombre}</h3>
                    <time class="block mb-2 text-sm font-normal leading-none text-gray-400">&nbsp;</time>
                `;
                lista.appendChild(li);
            });
            // Ocultar el formulario
            formulario.style.display = 'none';
        } else {
            // Si no hay registros, mostrar un mensaje
            const li = document.createElement('li');
            li.classList.add('ml-6');
            li.innerHTML = `
                <span class="absolute flex items-center justify-center w-6 h-6 bg-red-100 rounded-full -left-3 ring-8 ring-white">
                    <svg class="w-2.5 h-2.5 text-red-800 aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <i class="fa-solid fa-exclamation-circle fa-sm"></i>&nbsp;
                    </svg>
                </span>
                <h3 class="mb-1 text-md font-semibold text-red-800">No hay actividades registradas.</h3>
            `;
            lista.appendChild(li);
            // Ocultar el formulario
            formulario.style.display = 'none';
        }
    }

    // Función para actualizar la tabla "Empaques" con los datos
    function actualizarTablaEmpaques(data) {
        const tbody = document.querySelector('#empaquesTable tbody'); // Obtiene el tbody de la tabla

        // Borra el contenido actual del tbody
        tbody.innerHTML = '';

        if (data.length > 0) {
            // Si hay registros, llenar la tabla con los datos
            data.forEach(empaque => {
                const fila = document.createElement('tr');
                fila.classList.add('bg-white', 'border-b');
                fila.innerHTML = `
                    <td scope="row" class="px-6 py-4">${empaque.num_bolsas !== null ? empaque.num_bolsas : '--'}</td>
                    <td scope="row" class="px-6 py-4">${empaque.gramos !== null ? empaque.gramos : '--'}</td>
                    <td class="px-6 py-4">${empaque.temp_inicial !== null ? empaque.temp_inicial : '--'}</td>
                    <td class="px-6 py-4">${empaque.temp_final !== null ? empaque.temp_final : '--'}</td>
                    <td class="px-6 py-4">${empaque.H2O !== null ? empaque.H2O : '--'}</td>
                `;
                tbody.appendChild(fila);
            });
        } else {
            // Si no hay registros, mostrar el mensaje en una fila
            const noRegistrosFila = document.createElement('tr');
            noRegistrosFila.classList.add('bg-white', 'border-b');
            noRegistrosFila.innerHTML = `
                <td colspan="6" class="px-6 py-4 text-center">Todavía no hay registros para esta fecha.</td>
            `;
            tbody.appendChild(noRegistrosFila);
        }
    }

});
</script>
<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center">
            @foreach ($cultivos as $index => $cultivo)
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ 'Estadísticas de venta de ' }}{{ $cultivo->nombre }}&nbsp;&nbsp;
                </h2>
                @if($cultivo->nombre_tecnico !== null)
                <h2 class="text-xl text-gray-800 leading-tight">
                    ({{ $cultivo->nombre_tecnico }}) &nbsp;&nbsp;
                </h2>
                @endif
            @endforeach
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                
                @if(!empty($ventas) && !empty($rangosFechas))
                    <!-- Grafico -->
                    <div class="max-w-7xl w-full bg-white rounded-lg shadow dark:bg-gray-800">
                        <div class="flex justify-between p-4 md:p-6 pb-0 md:pb-0">
                        <div>
                            <h5 class="leading-none text-3xl font-bold text-gray-900 dark:text-white pb-2">${{ $ventasSemanales }}</h5>
                            <p class="text-base font-normal text-gray-500 dark:text-gray-400">Ventas de esta semana</p>
                        </div>
                        </div>
                        <div id="labels-chart" class="px-2.5"></div>
                        <div class="grid grid-cols-1 items-center border-gray-200 border-t dark:border-gray-700 justify-between mt-5 p-4 md:p-6 pt-0 md:pt-0">
                        <div class="flex justify-between items-center pt-5">
                            <!-- Button -->
                            <button
                            id="dropdownDefaultButton"
                            data-dropdown-toggle="lastDaysdropdown"
                            data-dropdown-placement="bottom"
                            class="text-sm font-medium text-gray-500 dark:text-gray-400 hover:text-gray-900 text-center inline-flex items-center dark:hover:text-white"
                            type="button">
                            Últimos dos meses
                            <svg class="w-2.5 m-2.5 ml-1.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                            </svg>
                            </button>
                            <!-- Dropdown menu -->
                            <div id="lastDaysdropdown" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700">
                                <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownDefaultButton">
                                    <li>
                                        <button id="consulta1"><a class="block px-4 py-2">Últimos 12 meses</a></button>
                                    </li>
                                </ul>
                            </div>
                            
                            <!-- Rangos de fechas para consulta -->
                            <div date-rangepicker class="flex items-center">
                                <div class="relative">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                                    </svg>
                                </div>
                                <input name="fechaInicial" id="fechaInicial" type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full pl-10 p-2.5" placeholder="Seleccionar Fecha Inicial">
                                </div>
                                <span class="mx-4 text-gray-500">a</span>
                                <div class="relative">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                                    </svg>
                                </div>
                                <input name="fechaFinal" id="fechaFinal" type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full pl-10 p-2.5" placeholder="Seleccionar Fecha Final">
                                </div>&nbsp;&nbsp;&nbsp;
                                <x-button id="consulta2" class="bg-green-500 text-white">
                                    <i class="fa-solid fa-magnifying-glass"></i>
                                </x-button>
                            </div>

                        </div>
                        </div>
                    </div>
                @else

                    <div class="flex w-full overflow-hidden bg-white rounded-lg shadow-md">
                        <div class="flex items-center justify-center w-12 bg-red-500">
                            <svg class="w-6 h-6 text-white fill-current" viewBox="0 0 40 40" xmlns="http://www.w3.org/2000/svg">
                                <path d="M20 3.33331C10.8 3.33331 3.33337 10.8 3.33337 20C3.33337 29.2 10.8 36.6666 20 36.6666C29.2 36.6666 36.6667 29.2 36.6667 20C36.6667 10.8 29.2 3.33331 20 3.33331ZM21.6667 28.3333H18.3334V25H21.6667V28.3333ZM21.6667 21.6666H18.3334V11.6666H21.6667V21.6666Z" />
                            </svg>
                        </div>
                    
                        <div class="px-4 py-2 -mx-3">
                            <div class="mx-3">
                                <span class="font-semibold text-red-500">Ups!!! :(</span>
                                <p class="text-sm text-gray-600">No puedo mostrar las estadísticas porque no hay ninguna venta registrada a este cultivo</p>
                            </div>
                        </div>
                    </div>

                @endif
                
                <script>
                    // JSON de los datos mandados a blade
                    var mercados = @json($mercados);
                    var ventas = @json($ventas);
                    var rangosFechas = @json($rangosFechas);
                
                    // Crea una variable para el gráfico
                    let chart  = document.getElementById('labels-chart');
                    // Obtén una referencia al input de las fechas
                    const fechaInicial = document.getElementById('fechaInicial');
                    const fechaFinal = document.getElementById('fechaFinal');

                    // Función para destruir el gráfico existente
                    function destruirGrafico() {
                        if (chart) {
                            chart.destroy();
                        }
                    }

                    // Función para generar colores pastel aleatorios
                    function generarColorPastelAleatorio() {
                        // Genera valores aleatorios para los componentes RGB
                        var r = Math.floor(Math.random() * 156 + 100); // R entre 100 y 255
                        var g = Math.floor(Math.random() * 156 + 100); // G entre 100 y 255
                        var b = Math.floor(Math.random() * 156 + 100); // B entre 100 y 255

                        // Convierte los componentes RGB a un color hexadecimal
                        var color = "#" + r.toString(16) + g.toString(16) + b.toString(16);

                        return color;
                    }

                    // Crea un array para almacenar los datos de la serie
                    var mercadosData = [];

                    // Itera sobre los mercados y agrega datos a seriesData
                    mercados.forEach(function (mercado, index) {
                        var colorPastel = generarColorPastelAleatorio();
                        var datosVentas = ventas[index]; // Obtén los datos de ventas específicos para este mercado
                        mercadosData.push({
                            name: mercado.nombre,
                            data: datosVentas,
                            color: colorPastel,
                        });
                    });
                    
                    inicializarGrafico(mercadosData, rangosFechas);
                
                    // Obtén una referencia al botón de consulta por su ID
                    const consulta1 = document.getElementById('consulta1'); //Consulta de los últimos 12 meses
                    const consulta2 = document.getElementById('consulta2'); //Consulta de un rango de fecha especifico

                    // Obtén los IDs de los cultivos en un array de JavaScript
                    var id = @json($cultivos->pluck('id')->toArray());
                
                    // Agrega un evento click a los botones de la consulta1
                    consulta1.addEventListener('click', function () {
                        actualizarGrafico(`/inventario-semillas/estadistica/semilla/meses/${id}`);
                    });

                    // Agrega un evento click a los botones de la consulta2
                    consulta2.addEventListener('click', function () {
                        // Obtén la fecha actual del input
                        let fechaInicial_value = fechaInicial.value;
                        let fechaFinal_value = fechaFinal.value;
                        // Reemplaza las barras diagonales "/" por guiones "-"
                        fechaInicio = fechaInicial_value.replace(/\//g, '-');
                        fechaFin = fechaFinal_value.replace(/\//g, '-');

                        actualizarGrafico(`/inventario-semillas/estadistica/semilla/${id}/fecha1/${fechaInicio}/fecha2/${fechaFin}`);
                    });

                    function inicializarGrafico(mercadosData, fechasData) {
                        // Crea el nuevo gráfico con los datos
                        const options = {
                            // set the labels option to true to show the labels on the X and Y axis
                            xaxis: {
                                show: true,
                                categories: fechasData,
                                labels: {
                                    show: true,
                                    style: {
                                        fontFamily: "Inter, sans-serif",
                                        cssClass: 'text-xs font-normal fill-gray-500 dark:fill-gray-400'
                                    }
                                },
                                axisBorder: {
                                    show: false,
                                },
                                axisTicks: {
                                    show: false,
                                },
                            },
                            yaxis: {
                                show: true,
                                labels: {
                                    show: true,
                                    style: {
                                        fontFamily: "Inter, sans-serif",
                                        cssClass: 'text-xs font-normal fill-gray-500 dark:fill-gray-400'
                                    },
                                    formatter: function (value) {
                                        return '$' + value;
                                    }
                                }
                            },
                            series: mercadosData,
                            chart: {
                                sparkline: {
                                    enabled: false
                                },
                                height: "100%",
                                width: "100%",
                                type: "area",
                                fontFamily: "Inter, sans-serif",
                                dropShadow: {
                                    enabled: false,
                                },
                                toolbar: {
                                    show: false,
                                },
                            },
                            tooltip: {
                                enabled: true,
                                x: {
                                    show: false,
                                },
                            },
                            fill: {
                                type: "gradient",
                                gradient: {
                                    opacityFrom: 0.55,
                                    opacityTo: 0,
                                    shade: "#1C64F2",
                                    gradientToColors: ["#1C64F2"],
                                },
                            },
                            dataLabels: {
                                enabled: false,
                            },
                            stroke: {
                                width: 6,
                            },
                            legend: {
                                show: true
                            },
                            grid: {
                                show: true,
                            },
                        };

                        if (document.getElementById("labels-chart") && typeof ApexCharts !== 'undefined') {
                            chart = new ApexCharts(document.getElementById("labels-chart"), options);
                            chart.render();
                        }
                    }

                    function actualizarGrafico(url) {
                        destruirGrafico();
                        chart.innerHTML = '';

                        // Realiza una solicitud AJAX para obtener los nuevos datos
                        fetch(url)
                            .then(response => response.json())
                            .then(data => {
                                // Maneja la respuesta del controlador aquí
                                console.log(data); // Aquí puedes ver los datos devueltos por el controlador

                                rangosFechas = data[2];
                                ventas = data[3];

                                // Actualiza los datos en mercadosData con los nuevos datos
                                let mercadosData = [];

                                mercados.forEach(function (mercado, index) {
                                    var colorPastel = generarColorPastelAleatorio();
                                    var datosVentas = ventas[index]; // Nuevos datos obtenidos de la solicitud
                                    mercadosData.push({
                                        name: mercado.nombre,
                                        data: datosVentas,
                                        color: colorPastel,
                                    });
                                });

                                // Inicializa el gráfico con los nuevos datos
                                inicializarGrafico(mercadosData, rangosFechas);
                            })
                            .catch(error => {
                                console.error('Error al realizar la solicitud AJAX:', error);
                            });
                    }
                </script>                
  

            </div>
        </div>
    </div>
</x-app-layout>
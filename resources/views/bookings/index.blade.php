@extends('layout.app')

@section('content')
    <section id="reservas" class="pt-20 px-6">
        <h1 class="text-[45px] text-center font-bungee uppercase text-[#B99E2A]">
            Reservas
        </h1>
        
        <!-- Botones para cambiar semana -->
        <div class="text-center mb-8 flex items-center justify-between">
            <button id="prevWeek1" class="bg-red-500 text-white px-4 py-2 rounded mr-2">
                Semana Anterior
            </button>
            <button id="nextWeek1" class="bg-red-500 text-white px-4 py-2 rounded">
                Semana Siguiente
            </button>
        </div>

        <!-- Sección para cada campo -->
        <div id="court1" class="mb-8 min-w-full overflow-x-auto">
        </div>

        <div class="text-center mb-8 flex items-center justify-between">
            <button id="prevWeek2" class="bg-red-500 text-white px-4 py-2 rounded mr-2">
                Semana Anterior
            </button>
            <button id="nextWeek2" class="bg-red-500 text-white px-4 py-2 rounded">
                Semana Siguiente
            </button>
        </div>

        <div id="court2" class="mb-8 min-w-full overflow-x-auto" >
        </div>

        <div class="text-center mb-8 flex items-center justify-between">
            <button id="prevWeek3" class="bg-red-500 text-white px-4 py-2 rounded mr-2">
                Semana Anterior
            </button>
            <button id="nextWeek3" class="bg-red-500 text-white px-4 py-2 rounded">
                Semana Siguiente
            </button>
        </div>

        <div id="court3" class="mb-8 min-w-full overflow-x-auto">
           
        </div>

        <div class="text-center mb-8 flex items-center justify-between">
            <button id="prevWeek4" class="bg-red-500 text-white px-4 py-2 rounded mr-2">
                Semana Anterior
            </button>
            <button id="nextWeek4" class="bg-red-500 text-white px-4 py-2 rounded">
                Semana Siguiente
            </button>
        </div>

        <div id="court4" class="min-w-full overflow-x-auto">
           
        </div>
    </section>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const courts = [1, 2, 3, 4]; // Los 4 campos
            let currentStartDate = new Date().toISOString().split('T')[0];

            // Función para obtener las reservas
            function fetchReservations(startDate, courtId) {
                fetch(`/reservas/${courtId}/${startDate}`)
                    .then(response => response.json())
                    .then(data => {
                        let html = `<h2 class="text-center text-lg font-semibold text-black/90">Campo ${courtId}</h2><table class="table-auto w-full border-collapse"><thead><tr><th>Hora</th>`;
                        
                        const weekDays = Object.keys(data.data[0]).filter(key => key !== 'hour');
                        weekDays.forEach(day => {
                            const formattedDay = new Date(day).toLocaleDateString('es-ES', { weekday: 'long', day: 'numeric', month: 'short' });
                            html += `<th class="border px-4 py-2 bg-[#B99E2A] text-white mayus ">${formattedDay}</th>`;
                        });

                        html += `</tr></thead><tbody>`;

                        data.data.forEach(item => {
                            html += `<tr><td class="border px-4 py-2 font-bold bg-blue-600/90 text-white text-center text-sm"  style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">${item.hour}</td>`;
                            weekDays.forEach(day => {
                                html += `<td class="border px-4 py-2 text-center capitalize text-sm ${getColorClass(item[day])}">${item[day]}</td>`;
                            });
                            html += `</tr>`;
                        });

                        html += `</tbody></table>`;

                        // Limpiar el contenido anterior antes de agregar las nuevas reservas
                        document.getElementById(`court${courtId}`).innerHTML = html;
                    })
                    .catch(error => console.error('Error:', error));
            }

            function changeWeek(courtId, direction) {
                if (direction === 'previous') {
                    currentStartDate = getDateOneWeekEarlier(currentStartDate);
                } else if (direction === 'next') {
                    currentStartDate = getDateOneWeekLater(currentStartDate);
                }
                fetchReservations(currentStartDate, courtId);
            }

            function getDateOneWeekEarlier(date) {
                const dateObj = new Date(date);
                dateObj.setDate(dateObj.getDate() - 7);
                return dateObj.toISOString().split('T')[0];
            }

            function getDateOneWeekLater(date) {
                const dateObj = new Date(date);
                dateObj.setDate(dateObj.getDate() + 7);
                return dateObj.toISOString().split('T')[0];
            }

            function getColorClass(value) {
                const colors = {
                    disponible: "bg-white text-black font-bold",
                    reservado: "bg-[#39AA29]",
                    "en espera": "bg-yellow-500 text-white font-bold",
                    completado: "bg-red-600",
                };
                return colors[value] || "bg-gray-600";
            }

            courts.forEach(courtId => {
                fetchReservations(currentStartDate, courtId);

                document.getElementById(`prevWeek${courtId}`).addEventListener('click', function () {
                    changeWeek(courtId, 'previous');
                });

                document.getElementById(`nextWeek${courtId}`).addEventListener('click', function () {
                    changeWeek(courtId, 'next');
                });
            });
        });
    </script>
@endsection

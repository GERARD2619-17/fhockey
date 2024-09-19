@extends('adminlte::page')

@section('title', 'Panel de Juego')

@section('content_header')
    <h1>Panel de Juego</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header text-center">
            <h3>{{ $partido->equipo_local->nombre }} vs {{ $partido->equipo_visitante->nombre }}</h3>
        </div>
        <div class="card-body">
            <div class="row text-center mb-4">
                <!-- Equipo Local -->
                <div class="col-md-4">
                    <h4>{{ $partido->equipo_local->nombre }}</h4>
                    <img src="{{ asset('storage/' . $partido->equipo_local->fotografia) }}" alt="Logo de {{ $partido->equipo_local->nombre }}" class="img-fluid" style="max-width: 100px; max-height: 100px;">
                    <p>Goles: <span id="golesLocal">{{ $partido->goles_local }}</span></p>
                    <p>Penales: <span id="penalesLocal">{{ $partido->penales_local ?? 0 }}</span></p>
                    <p>Tarjetas Amarillas: <span id="tarjetasAmarillasLocal">{{ $partido->tarjetas_amarillas_local }}</span></p>
                    <p>Tarjetas Rojas: <span id="tarjetasRojasLocal">{{ $partido->tarjetas_rojas_local }}</span></p>
                    <p>Tarjetas Verdes: <span id="tarjetasVerdesLocal">{{ $partido->tarjetas_verdes_local }}</span></p>
                    <button class="btn btn-success" onclick="window.gameController.agregarGol('local')">Añadir Gol Local</button>
                    <button class="btn btn-primary" onclick="window.gameController.asignarPenal('local')">Asignar Penal Local</button>
                    <button class="btn btn-warning" onclick="window.gameController.agregarTarjeta('local', 'amarilla')">Añadir Tarjeta Amarilla</button>
                    <button class="btn btn-danger" onclick="window.gameController.agregarTarjeta('local', 'roja')">Añadir Tarjeta Roja</button>
                    <button class="btn btn-success" onclick="window.gameController.agregarTarjeta('local', 'verde')">Añadir Tarjeta Verde</button>
                </div>

                <!-- Cronómetro -->
                <div class="col-md-4">
                    <h4>Cronómetro</h4>
                    <p id="cronometro">00:00</p>
                    <label for="tiempoDescansoLabel">Tiempo de Descanso:</label>
                    <p id="tiempoDescansoLabel">-</p>
                    
                    <div>
                        <label for="tiempo_seleccionado">Duración del partido (en minutos):</label>
                        <select name="tiempo_seleccionado" id="tiempo_seleccionado">
                            <option value="60">60 minutos</option>
                            <option value="90">90 minutos</option>
                            <option value="120">120 minutos</option>
                        </select>
                    </div>
                    <button id="iniciarTiempo" class="btn btn-success">Iniciar Tiempo</button>
                    <p id="estadoPartido" class="mt-3">Estado: No Iniciado</p>
                    <p id="labelDescanso" class="mt-3" style="display:none;">Tiempo de descanso: <span id="descansoTiempo">00:00</span></p>
                    <button id="actualizarEstadoBtn" class="btn btn-info mt-2" onclick="actualizarEstado()">Actualizar Estado</button>
                </div>

                <!-- Equipo Visitante -->
                <div class="col-md-4">
                    <h4>{{ $partido->equipo_visitante->nombre }}</h4>
                    <img src="{{ asset('storage/' . $partido->equipo_visitante->fotografia) }}" alt="Logo de {{ $partido->equipo_visitante->nombre }}" class="img-fluid" style="max-width: 100px; max-height: 100px;">
                    <p>Goles: <span id="golesVisitante">{{ $partido->goles_visitante }}</span></p>
                    <p>Penales: <span id="penalesVisitante">{{ $partido->penales_visitante ?? 0 }}</span></p>
                    <p>Tarjetas Amarillas: <span id="tarjetasAmarillasVisitante">{{ $partido->tarjetas_amarillas_visitante }}</span></p>
                    <p>Tarjetas Rojas: <span id="tarjetasRojasVisitante">{{ $partido->tarjetas_rojas_visitante }}</span></p>
                    <p>Tarjetas Verdes: <span id="tarjetasVerdesVisitante">{{ $partido->tarjetas_verdes_visitante }}</span></p>
                    <button class="btn btn-primary mb-2" onclick="window.gameController.agregarGol('visitante')">Añadir Gol Visitante</button>
                    <button class="btn btn-primary" onclick="window.gameController.asignarPenal('visitante')">Asignar Penal Visitante</button>
                    <button class="btn btn-warning" onclick="window.gameController.agregarTarjeta('visitante', 'amarilla')">Añadir Tarjeta Amarilla</button>
                    <button class="btn btn-danger" onclick="window.gameController.agregarTarjeta('visitante', 'roja')">Añadir Tarjeta Roja</button>
                    <button class="btn btn-success" onclick="window.gameController.agregarTarjeta('visitante', 'verde')">Añadir Tarjeta Verde</button>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    {{-- Añade aquí hojas de estilo adicionales si es necesario --}}
@stop

@section('js')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
(function() {
    let timer;
    let seconds = {{ $partido->tiempo_transcurrido }};
    let running = false;

    window.gameController = {
        agregarGol: function(equipo) {
            $.ajax({
                url: '{{ route('partidos.actualizarMarcador', $partido->id) }}',
                method: 'POST',
                data: {
                    equipo: equipo,
                    _token: '{{ csrf_token() }}'
                },
                success: function(data) {
                    $(`#goles${equipo.charAt(0).toUpperCase() + equipo.slice(1)}`).text(data[`goles_${equipo}`]);
                },
                error: function(xhr, status, error) {
                    console.error("Error al actualizar goles:", status, error);
                    console.log(xhr.responseText);
                }
            });
        },

        agregarTarjeta: function(equipo, tipo) {
            $.ajax({
                url: '{{ route('partidos.actualizarTarjetas', $partido->id) }}',
                method: 'POST',
                data: {
                    equipo: equipo,
                    tipo: tipo,
                    _token: '{{ csrf_token() }}'
                },
                success: function(data) {
                    $(`#tarjetas${tipo.charAt(0).toUpperCase() + tipo.slice(1)}s${equipo.charAt(0).toUpperCase() + equipo.slice(1)}`).text(data[`tarjetas_${tipo}s_${equipo}`]);
                },
                error: function(xhr, status, error) {
                    console.error("Error al actualizar tarjetas:", status, error);
                    console.log(xhr.responseText);
                }
            });
        },

        asignarPenal: function(equipo) {
            $.ajax({
                url: '{{ route('partidos.asignarPenal', $partido->id) }}',
                method: 'POST',
                data: {
                    equipo: equipo,
                    _token: '{{ csrf_token() }}'
                },
                success: function(data) {
                    $(`#penales${equipo.charAt(0).toUpperCase() + equipo.slice(1)}`).text(data[`penales_${equipo}`]);
                },
                error: function(xhr, status, error) {
                    console.error("Error al asignar penal:", status, error);
                    console.log(xhr.responseText);
                }
            });
        },

        startTimer: function() {
            if (!running) {
                timer = setInterval(function() {
                    seconds++;
                    updateDisplayTime();
                    if (seconds % 10 === 0) { // Actualizar en el servidor cada 10 segundos
                        updateServerTime();
                    }
                }, 1000);
                $('#iniciarTiempo').prop('disabled', true);
                $('#actualizarEstadoBtn').prop('disabled', false);
                running = true;
            }
        },

        pauseTimer: function() {
            if (running) {
                clearInterval(timer);
                $('#iniciarTiempo').prop('disabled', false);
                $('#actualizarEstadoBtn').prop('disabled', true);
                running = false;
                updateServerTime(); // Actualizar el servidor al pausar
            }
        },

        resetTimer: function() {
            clearInterval(timer);
            seconds = 0;
            updateDisplayTime();
            $('#iniciarTiempo').prop('disabled', false);
            $('#actualizarEstadoBtn').prop('disabled', true);
            running = false;
            updateServerTime();
        },

        setCustomTime: function() {
            let minutes = parseInt($('#tiempo_seleccionado').val());
            if (!isNaN(minutes) && minutes > 0) {
                seconds = minutes * 60;
                updateDisplayTime();
                updateServerTime();
            }
        }
    };

    function updateDisplayTime() {
        let minutes = Math.floor(seconds / 60);
        let remainingSeconds = seconds % 60;
        $('#cronometro').text(
            minutes.toString().padStart(2, '0') + ':' + 
            remainingSeconds.toString().padStart(2, '0')
        );
    }

    function updateServerTime() {
        $.ajax({
            url: '{{ route('partidos.actualizarTiempo', $partido->id) }}',
            method: 'POST',
            data: {
                tiempo: seconds,
                _token: '{{ csrf_token() }}'
            },
            error: function(xhr, status, error) {
                console.error("Error al actualizar tiempo en el servidor:", status, error);
            }
        });
    }

    function actualizarEstado() {
        $.ajax({
            url: '{{ route('partidos.actualizarEstado', $partido->id) }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(data) {
                $('#estadoPartido').text('Estado: ' + data.estado);
                if (data.estado === 'Finalizado') {
                    window.gameController.pauseTimer();
                }
            },
            error: function(xhr, status, error) {
                console.error("Error al actualizar estado:", status, error);
            }
        });
    }

    // Event listeners
    $('#iniciarTiempo').on('click', window.gameController.startTimer);
    $('#actualizarEstadoBtn').on('click', actualizarEstado);
    $('#tiempo_seleccionado').on('change', window.gameController.setCustomTime);

    // Inicializar el tiempo mostrado
    updateDisplayTime();
})();
</script>
@stop
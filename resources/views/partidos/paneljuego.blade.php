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
                    <p id="estadoPartido">Estado: {{ $partido->estado }}</p>
                    <p id="labelDescanso" style="display:none;">Tiempo de descanso: <span id="descansoTiempo">00:00</span></p>
                    
                    <div>
                        <label for="tiempo_seleccionado">Duración del partido:</label>
                        <select name="tiempo_seleccionado" id="tiempo_seleccionado">
                            <option value="20">20 minutos (2x10)</option>
                            <option value="90">90 minutos (2x45)</option>
                        </select>
                    </div>
                    <button id="iniciarTiempo" class="btn btn-success" onclick="window.gameController.iniciarTiempo()">Iniciar Tiempo</button>
                    <button id="pausarTiempo" class="btn btn-warning" onclick="window.gameController.pausarTiempo()">Pausar</button>
                    <button id="reiniciarTiempo" class="btn btn-danger" onclick="window.gameController.reiniciarTiempo()">Reiniciar</button>
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
                    <button class="btn btn-success" onclick="window.gameController.agregarGol('visitante')">Añadir Gol Visitante</button>
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
        let segundos = {{ $partido->tiempo_transcurrido }};
        let enEjecucion = false;
        let periodoActual = '{{ $partido->estado }}';
        let timerDescanso;
        let segundosDescanso = 0;
        let tiempoTotalJuego = 0;
        let tiempoMitad = 0;
        let tiempoDescanso = 0;

        window.gameController = {
            iniciarTiempo: function() {
                if (!enEjecucion) {
                    // Configurar tiempos según la selección
                    const tiempoSeleccionado = parseInt($('#tiempo_seleccionado').val());
                    if (tiempoSeleccionado === 20) {
                        tiempoTotalJuego = 1200; // 20 minutos en segundos
                        tiempoMitad = 600; // 10 minutos en segundos
                        tiempoDescanso = 120; // 2 minutos en segundos
                    } else if (tiempoSeleccionado === 90) {
                        tiempoTotalJuego = 5400; // 90 minutos en segundos
                        tiempoMitad = 2700; // 45 minutos en segundos
                        tiempoDescanso = 900; // 15 minutos en segundos
                    }

                    // Iniciar el primer tiempo si el partido no ha comenzado
                    if (periodoActual === 'no_iniciado') {
                        periodoActual = 'primer_tiempo';
                        actualizarEstadoJuego(periodoActual);
                    }
                    iniciarCronometroJuego();
                }
            },

            pausarTiempo: function() {
                if (enEjecucion) {
                    clearInterval(timer);
                    enEjecucion = false;
                    $('#iniciarTiempo').prop('disabled', false).text('Reanudar');
                    actualizarTiempoServidor();
                }
            },

            reiniciarTiempo: function() {
                clearInterval(timer);
                clearInterval(timerDescanso);
                segundos = 0;
                segundosDescanso = 0;
                enEjecucion = false;
                periodoActual = 'no_iniciado';
                actualizarTiempoMostrado();
                actualizarEstadoJuego(periodoActual);
                $('#iniciarTiempo').prop('disabled', false).text('Iniciar Tiempo');
                $('#labelDescanso').hide();
                actualizarTiempoServidor();
            },

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
            }
        };

        function iniciarCronometroJuego() {
            enEjecucion = true;
            $('#iniciarTiempo').prop('disabled', true);
            timer = setInterval(function() {
                segundos++;
                actualizarTiempoMostrado();
                if (segundos % 10 === 0) {
                    actualizarTiempoServidor();
                }
                
                if (segundos === tiempoMitad && periodoActual === 'primer_tiempo') {
                    manejarMedioTiempo();
                } else if (segundos === tiempoTotalJuego) {
                    manejarFinJuego();
                }
            }, 1000);
        }

        function manejarMedioTiempo() {
            clearInterval(timer);
            periodoActual = 'descanso';
            actualizarEstadoJuego(periodoActual);
            iniciarCronometroDescanso();
        }

        function iniciarCronometroDescanso() {
            $('#labelDescanso').show();
            timerDescanso = setInterval(function() {
                segundosDescanso++;
                actualizarTiempoDescanso();
                if (segundosDescanso === tiempoDescanso) {
                    manejarSegundoTiempo();
                }
            }, 1000);
        }

        function manejarSegundoTiempo() {
            clearInterval(timerDescanso);
            $('#labelDescanso').hide();
            segundosDescanso = 0;
            periodoActual = 'segundo_tiempo';
            actualizarEstadoJuego(periodoActual);
            iniciarCronometroJuego();
        }

        function manejarFinJuego() {
            clearInterval(timer);
            enEjecucion = false;
            periodoActual = 'finalizado';
            actualizarEstadoJuego(periodoActual);
            $('#iniciarTiempo').prop('disabled', true);
        }

        function actualizarTiempoMostrado() {
            let minutos = Math.floor(segundos / 60);
            let segundosRestantes = segundos % 60;
            $('#cronometro').text(('0' + minutos).slice(-2) + ':' + ('0' + segundosRestantes).slice(-2));
        }

        function actualizarTiempoDescanso() {
            let minutos = Math.floor(segundosDescanso / 60);
            let segundosRestantes = segundosDescanso % 60;
            $('#descansoTiempo').text(
                minutos.toString().padStart(2, '0') + ':' + 
                segundosRestantes.toString().padStart(2, '0')
            );
        }

        function actualizarEstadoJuego(estado) {
                $.ajax({
                    url: '/partidos/2/actualizar-estado',  // URL correcta
                    method: 'PATCH',  // Cambiar POST a PATCH si corresponde
                    data: {
                        // Aquí van los datos que envías
                    },
                    success: function(response) {
                        console.log('Estado del partido actualizado correctamente');
                    },
                    error: function(xhr, status, error) {
                        console.error('Error al actualizar estado del partido:', error);
                    }
                });
        }

        function actualizarTiempoServidor() {
            $.ajax({
                url: '{{ route('partidos.actualizarTiempo', $partido->id) }}',
                method: 'POST',
                data: {
                    tiempo_transcurrido: segundos,
                    estado: periodoActual,
                    _token: '{{ csrf_token() }}'
                },
                success: function(data) {
                    console.log("Tiempo actualizado en el servidor");
                },
                error: function(xhr, status, error) {
                    console.error("Error al actualizar tiempo:", status, error);
                }
            });
        }
    })();
</script>
@stop
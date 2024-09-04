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
                <div class="col-md-4">
                    <h4>{{ $partido->equipo_local->nombre }}</h4>
                    <img src="{{ asset('storage/' . $partido->equipo_local->fotografia) }}" alt="Logo de {{ $partido->equipo_local->nombre }}" class="img-fluid" style="max-width: 100px; max-height: 100px;">
                    <p>Goles: <span id="golesLocal">{{ $partido->goles_local }}</span></p>
                    <p>Tarjetas Amarillas: <span id="tarjetasAmarillasLocal">{{ $partido->tarjetas_amarillas_local }}</span></p>
                    <p>Tarjetas Rojas: <span id="tarjetasRojasLocal">{{ $partido->tarjetas_rojas_local }}</span></p>
                    <p>Tarjetas Verdes: <span id="tarjetasVerdesLocal">{{ $partido->tarjetas_verdes_local }}</span></p>
                    <button class="btn btn-primary" onclick="agregarGol('local', {{ $partido->id }})">Agregar Gol Local</button>
                    <button class="btn btn-warning" onclick="agregarTarjeta('amarilla', 'local')">Añadir Tarjeta Amarilla Local</button>
                    <button class="btn btn-danger" onclick="agregarTarjeta('roja', 'local')">Añadir Tarjeta Roja Local</button>
                    <button class="btn btn-success" onclick="agregarTarjeta('verde', 'local')">Añadir Tarjeta Verde Local</button>
                </div>
                <div class="col-md-4">
                    <h4>Cronómetro</h4>
                    <p id="cronometro">00:00</p>
                    <label for="tiempoDescansoLabel">Tiempo de Descanso:</label>
                    <p id="tiempoDescansoLabel">-</p>
                    <div class="form-group">
                        <label for="tiempoJuego">Tiempo de Juego (minutos):</label>
                        <input type="number" id="tiempoJuego" class="form-control" value="10" min="1">
                    </div>
                    <div class="form-group">
                        <label for="numTiempos">Número de Tiempos:</label>
                        <select id="numTiempos" class="form-control">
                            <option value="2">2 Tiempos</option>
                            <option value="4">4 Tiempos</option>
                        </select>
                    </div>
                    <button id="iniciarTiempo" class="btn btn-success">Iniciar Tiempo</button>
                    <p id="estadoPartido" class="mt-3">Estado: No Iniciado</p>
                    <p id="labelDescanso" class="mt-3" style="display:none;">Tiempo de descanso: 00:00</p>
                </div>
                <div class="col-md-4">
                    <h4>{{ $partido->equipo_visitante->nombre }}</h4>
                    <img src="{{ asset('storage/' . $partido->equipo_visitante->fotografia) }}" alt="Logo de {{ $partido->equipo_visitante->nombre }}" class="img-fluid" style="max-width: 100px; max-height: 100px;">
                    <p>Goles: <span id="golesVisitante">{{ $partido->goles_visitante }}</span></p>
                    <p>Tarjetas Amarillas: <span id="tarjetasAmarillasVisitante">{{ $partido->tarjetas_amarillas_visitante }}</span></p>
                    <p>Tarjetas Rojas: <span id="tarjetasRojasVisitante">{{ $partido->tarjetas_rojas_visitante }}</span></p>
                    <p>Tarjetas Verdes: <span id="tarjetasVerdesVisitante">{{ $partido->tarjetas_verdes_visitante }}</span></p>
                    <button class="btn btn-primary" onclick="agregarGol('visitante', {{ $partido->id }})">Agregar Gol Visitante</button>
                    <button class="btn btn-warning" onclick="agregarTarjeta('amarilla', 'visitante')">Añadir Tarjeta Amarilla Visitante</button>
                    <button class="btn btn-danger" onclick="agregarTarjeta('roja', 'visitante')">Añadir Tarjeta Roja Visitante</button>
                    <button class="btn btn-success" onclick="agregarTarjeta('verde', 'visitante')">Añadir Tarjeta Verde Visitante</button>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            let estadoPartido = 'No Iniciado';
            let cronometroInterval;
            let tiempoDescansoLabel = document.getElementById('labelDescanso');
            let descansoIniciado = false;

            document.getElementById('iniciarTiempo').addEventListener('click', function () {
                let tiempoJuego = parseInt(document.getElementById('tiempoJuego').value) * 60;
                let numTiempos = parseInt(document.getElementById('numTiempos').value);
                iniciarCronometro(tiempoJuego, numTiempos);
            });

            function iniciarCronometro(tiempoJuego, numTiempos) {
                if (estadoPartido === 'No Iniciado') {
                    estadoPartido = 'Primer Tiempo';
                    document.getElementById('estadoPartido').innerText = 'Estado: Primer Tiempo';
                    iniciarTiempo(tiempoJuego);
                } else if (estadoPartido.includes('Tiempo')) {
                    clearInterval(cronometroInterval);
                    if (estadoPartido.includes('Descanso')) {
                        if (estadoPartido === 'Descanso 2') {
                            estadoPartido = 'Segundo Tiempo';
                            document.getElementById('estadoPartido').innerText = 'Estado: Segundo Tiempo';
                            iniciarTiempo(tiempoJuego);
                        }
                    } else {
                        iniciarDescanso();
                    }
                }
            }

            function iniciarTiempo(tiempoJuego) {
                cronometroInterval = setInterval(() => {
                    if (tiempoJuego <= 0) {
                        clearInterval(cronometroInterval);
                        iniciarDescanso();
                    } else {
                        tiempoJuego--;
                        document.getElementById('cronometro').innerText = formatoTiempo(tiempoJuego);
                    }
                }, 1000);
            }

            function iniciarDescanso() {
                if (!descansoIniciado) {
                    estadoPartido = 'Descanso';
                    document.getElementById('estadoPartido').innerText = 'Estado: Descanso';
                    tiempoDescansoLabel.style.display = 'block';
                    descansoIniciado = true;
                    let descansoTiempo = 120; // 2 minutos de descanso
                    cronometroInterval = setInterval(() => {
                        if (descansoTiempo <= 0) {
                            clearInterval(cronometroInterval);
                            tiempoDescansoLabel.style.display = 'none';
                            estadoPartido = 'Descanso 2';
                            document.getElementById('estadoPartido').innerText = 'Estado: Descanso 2';
                        } else {
                            descansoTiempo--;
                            tiempoDescansoLabel.innerText = `Tiempo de descanso: ${formatoTiempo(descansoTiempo)}`;
                        }
                    }, 1000);
                }
            }

            function formatoTiempo(segundos) {
                let minutos = Math.floor(segundos / 60);
                let segundosRestantes = segundos % 60;
                return `${minutos.toString().padStart(2, '0')}:${segundosRestantes.toString().padStart(2, '0')}`;
            }

            function agregarGol(equipoId, partidoId) {
            fetch(`/partidos/${partidoId}/actualizar-goles`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    equipo: equipoId
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload(); // Recarga la página para reflejar los cambios
                } else {
                    alert('Error al actualizar los goles.');
                }
            })
            .catch(error => console.error('Error:', error));
        }

            function agregarTarjeta(tipo, equipo) {
                actualizarPartido(equipo, tipo);
            }

            function actualizarPartido(equipo, tipo) {
                let token = '{{ csrf_token() }}';
                let url = '{{ route("partidos.actualizar", $partido->id) }}';
                let data = { equipo: equipo, tipo: tipo };

                fetch(url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token,
                    },
                    body: JSON.stringify(data),
                })
                .then(response => response.json())
                .then(data => {
                    if (equipo === 'local') {
                        if (tipo === 'goles') {
                            document.getElementById('golesLocal').innerText = data.goles_local;
                        } else if (tipo === 'amarilla') {
                            document.getElementById('tarjetasAmarillasLocal').innerText = data.tarjetas_amarillas_local;
                        } else if (tipo === 'roja') {
                            document.getElementById('tarjetasRojasLocal').innerText = data.tarjetas_rojas_local;
                        } else if (tipo === 'verde') {
                            document.getElementById('tarjetasVerdesLocal').innerText = data.tarjetas_verdes_local;
                        }
                    } else {
                        if (tipo === 'goles') {
                            document.getElementById('golesVisitante').innerText = data.goles_visitante;
                        } else if (tipo === 'amarilla') {
                            document.getElementById('tarjetasAmarillasVisitante').innerText = data.tarjetas_amarillas_visitante;
                        } else if (tipo === 'roja') {
                            document.getElementById('tarjetasRojasVisitante').innerText = data.tarjetas_rojas_visitante;
                        } else if (tipo === 'verde') {
                            document.getElementById('tarjetasVerdesVisitante').innerText = data.tarjetas_verdes_visitante;
                        }
                    }
                })
                .catch(error => console.error('Error al actualizar el partido:', error));
            }
        </script>
    @endpush
@stop
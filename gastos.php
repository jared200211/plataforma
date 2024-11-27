<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de gastos</title>
    <link rel="stylesheet" href="./css/estilos.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Incluir jQuery (puedes usar CDN) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">






</head>

<body>


   

        <form id="form-gastos">
            <div class="form-group">
                <label for="concepto">Concepto:</label>
                <input type="text" id="concepto" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="monto">Monto:</label>
                <input type="number" step="0.01" id="monto" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="fecha">Fecha:</label>
                <input type="date" id="fecha" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="categoria">Categoría:</label>
                <select id="categoria" class="form-control" required>
                    <option value="Gasolina">Gasolina</option>
                    <option value="Productos de Limpieza">Productos de Limpieza</option>
                    <option value="Viaticos">Viaticos</option>
                    <option value="Otros">Otros</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Registrar Gasto</button>
        </form>
        <div id="mensaje" style="display:none;" class="alert alert-success mt-3">Gasto registrado exitosamente.</div>


        <div class="container mt-3">
            <h3 class="text-center">Filtrar Gastos por Fecha</h3>
            <div class="row mb-4">
                <div class="col-md-4">
                    <label for="fecha_inicio" class="form-label">Fecha Inicio</label>
                    <input type="date" class="form-control" id="fecha_inicio">
                </div>
                <div class="col-md-4">
                    <label for="fecha_fin" class="form-label">Fecha Fin</label>
                    <input type="date" class="form-control" id="fecha_fin">
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <button class="btn btn-primary w-100" id="filtrarFechas">Filtrar</button>
                    <button class="btn btn-secondary w-100 ms-2" id="limpiarFiltro">Limpiar</button>
                </div>
            </div>
        </div>

        <div class="container">
            <h4>Total Gastado: $<span id="total-gasto">0.00</span></h4>
        </div>

        <div class="container mt-4">
            <canvas id="graficoGastos" width="400" height="200"></canvas>
        </div>



        <!-- Tabla de Gastos -->
        <div class="container mt-5">
            <h3 class="text-center">Listado de Gastos</h3>
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Concepto</th>
                            <th>Monto</th>
                            <th>Fecha</th>
                            <th>Categoría</th>
                        </tr>
                    </thead>
                    <tbody id="tabla-gastos">
                        <!-- Aquí se llenará con AJAX -->
                    </tbody>
                </table>
            </div>
        </div>

    




    <script>
    document.getElementById('filtrarFechas').addEventListener('click', () => {
        const fechaInicio = document.getElementById('fecha_inicio').value;
        const fechaFin = document.getElementById('fecha_fin').value;

        if (fechaInicio && fechaFin) {
            // Enviar datos al servidor para filtrar
            fetch('filtrar_gastos.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: fecha_inicio=${encodeURIComponent(fechaInicio)}&fecha_fin=${encodeURIComponent(fechaFin)}
                })
                .then(response => response.json())
                .then(data => {
                    mostrarGastos(data.gastos);
                    document.getElementById('total-gasto').textContent = data.total_gasto.toFixed(2);
                })
                .catch(error => console.error('Error:', error));
        } else {
            alert('Por favor selecciona ambas fechas');
        }
    });

    document.getElementById('limpiarFiltro').addEventListener('click', () => {
        // Limpiar los campos de fecha
        document.getElementById('fecha_inicio').value = '';
        document.getElementById('fecha_fin').value = '';

        // Cargar todos los gastos
        cargarGastos();
    });

    function cargarGastos() {
        fetch('listar_gastos.php')
            .then(response => response.json())
            .then(gastos => {
                mostrarGastos(gastos);
                calcularTotal(gastos);
            });
    }

    function mostrarGastos(gastos) {
        const tablaGastos = document.getElementById('tabla-gastos');
        tablaGastos.innerHTML = '';
        gastos.forEach((gasto, index) => {
            tablaGastos.innerHTML += `
            <tr>
                <td>${index + 1}</td>
                <td>${gasto.concepto}</td>
                <td>$${parseFloat(gasto.monto).toFixed(2)}</td>
                <td>${gasto.fecha}</td>
                <td>${gasto.categoria}</td>
            </tr>
        `;
        });
    }

    function calcularTotal(gastos) {
        const totalGasto = gastos.reduce((sum, gasto) => sum + parseFloat(gasto.monto), 0);
        document.getElementById('total-gasto').textContent = totalGasto.toFixed(2);
    }

    // Cargar gastos al inicio
    cargarGastos();
    </script>


    <script>
    let grafico; // Variable global para almacenar el gráfico

    // Función para crear o actualizar el gráfico
    function actualizarGrafico(fechaInicio = null, fechaFin = null) {
        const params = new URLSearchParams();
        if (fechaInicio && fechaFin) {
            params.append('fecha_inicio', fechaInicio);
            params.append('fecha_fin', fechaFin);
        }

        fetch('gastos_por_categoria.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: params.toString()
            })
            .then(response => response.json())
            .then(data => {
                const categorias = data.map(item => item.categoria);
                const montos = data.map(item => parseFloat(item.total));

                // Si el gráfico ya existe, lo destruye antes de crear uno nuevo
                if (grafico) {
                    grafico.destroy();
                }

                // Crear un nuevo gráfico de barras
                const ctx = document.getElementById('graficoGastos').getContext('2d');
                grafico = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: categorias,
                        datasets: [{
                            label: 'Gastos por Categoría',
                            data: montos,
                            backgroundColor: [
                                'rgba(75, 192, 192, 0.2)',
                                'rgba(255, 99, 132, 0.2)',
                                'rgba(54, 162, 235, 0.2)',
                                'rgba(255, 206, 86, 0.2)',
                                'rgba(153, 102, 255, 0.2)',
                                'rgba(255, 159, 64, 0.2)'
                            ],
                            borderColor: [
                                'rgba(75, 192, 192, 1)',
                                'rgba(255, 99, 132, 1)',
                                'rgba(54, 162, 235, 1)',
                                'rgba(255, 206, 86, 1)',
                                'rgba(153, 102, 255, 1)',
                                'rgba(255, 159, 64, 1)'
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            })
            .catch(error => console.error('Error al actualizar gráfico:', error));
    }

    // Filtrar gastos y actualizar el gráfico
    document.getElementById('filtrarFechas').addEventListener('click', () => {
        const fechaInicio = document.getElementById('fecha_inicio').value;
        const fechaFin = document.getElementById('fecha_fin').value;

        if (fechaInicio && fechaFin) {
            actualizarGrafico(fechaInicio, fechaFin);
        } else {
            alert('Por favor selecciona ambas fechas');
        }
    });

    // Limpiar filtro y actualizar el gráfico
    document.getElementById('limpiarFiltro').addEventListener('click', () => {
        document.getElementById('fecha_inicio').value = '';
        document.getElementById('fecha_fin').value = '';
        actualizarGrafico();
    });

    // Llamar a la función para cargar el gráfico al inicio
    document.addEventListener("DOMContentLoaded", function() {
        actualizarGrafico();
    });

    // Función para insertar un gasto y actualizar el gráfico automáticamente
    document.getElementById("form-gastos").addEventListener("submit", function(e) {
        e.preventDefault();

        const concepto = document.getElementById("concepto").value;
        const monto = document.getElementById("monto").value;
        const fecha = document.getElementById("fecha").value;
        const categoria = document.getElementById("categoria").value;

        const xhr = new XMLHttpRequest();
        xhr.open("POST", "insertar_gasto.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onload = function() {
            if (this.status === 200) {
                document.getElementById("mensaje").style.display = "block";
                document.getElementById("form-gastos").reset();
                setTimeout(() => {
                    document.getElementById("mensaje").style.display = "none";
                }, 2000);

                // Actualizar el gráfico después de insertar un gasto
                actualizarGrafico();
            } else {
                console.error('Error al insertar gasto:', this.responseText);
            }
        };

        xhr.send(concepto=${concepto}&monto=${monto}&fecha=${fecha}&categoria=${categoria});
    });
    </script>




</body>

</html>
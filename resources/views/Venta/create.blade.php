@extends('layouts.create')

@section('page-title', 'Nueva Venta')
@section('back-url', route('venta.index')) {{-- Ajusta la ruta a tu index real --}}

@push('css')
    <style>
        .table-detalles th { background-color: #f8f9fa; font-size: 0.85rem; text-transform: uppercase; }
        .table-detalles td { vertical-align: middle; }
        .btn-add-item { background-color: #007bff; color: white; border: none; }
        .btn-add-item:hover { background-color: #0056b3; color: white; }
        
        /* Estilos para el Modal de Búsqueda */
        #modalArticulos .modal-lg { max-width: 900px; }
        .search-box { background-color: #f1f3f5; padding: 15px; border-radius: 5px; margin-bottom: 15px; }
        .qty-input { width: 70px; text-align: center; display: inline-block; margin-right: 5px; }
    </style>
@endpush

@php
date_default_timezone_set('America/Lima');
@endphp

@section('form-content')
    <form action="{{ route('venta.store') }}" method="POST" id="formVenta">
        @csrf 
        
        {{-- ========================================== --}}
        {{-- CABECERA DE LA VENTA                       --}}
        {{-- ========================================== --}}
        <div class="row g-3 mb-4">
            <div class="col-12 col-md-6">
                <label for="Nombre_Cliente" class="form-label">Cliente</label>
                <input type="text" class="form-control @error('Nombre_Cliente') is-invalid @enderror" id="Nombre_Cliente" name="Nombre_Cliente" value="{{ old('Nombre_Cliente') }}" placeholder="Nombre del cliente">
                @error('Nombre_Cliente') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-12 col-md-6">
                <label for="fk_personal_Vendedor">Vendedor</label>
                <select class="form-control @error('fk_personal_Vendedor') is-invalid @enderror" id="fk_personal_Vendedor" name="fk_personal_Vendedor">
                    <option value="">Seleccione un empleado</option>
                    @foreach($personas as $persona)
                        <option value="{{ $persona->id }}" {{ $persona->id==old('fk_personal_Vendedor') ? 'selected' : '' }}>{{ $persona->Codigo_Documento }} - {{ $persona->Nombre_1 }} {{ $persona->Apellido_1 }}</option>
                    @endforeach
                </select>
                @error('fk_personal_Vendedor') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
        </div>

        <div class="row g-3 mb-4">
            <div class="col-12 col-md-4">
                <label for="Fecha_Emision" class="form-label">Fecha Emisión</label>
                <input type="date" class="form-control @error('Fecha_Emision') is-invalid @enderror" id="Fecha_Emision" name="Fecha_Emision" value="{{ old('Fecha_Emision') ?? date('Y-m-d') }}">
                @error('Fecha_Emision') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-12 col-md-4">
                <label for="Fecha_Entrega" class="form-label">Fecha Entrega</label>
                <input type="date" class="form-control @error('Fecha_Entrega') is-invalid @enderror" id="Fecha_Entrega" name="Fecha_Entrega" value="{{ old('Fecha_Entrega') }}">
                @error('Fecha_Entrega') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-12 col-md-4">
                <label for="Fecha_Cobro" class="form-label">Fecha Cobro</label>
                <input type="date" class="form-control @error('Fecha_Cobro') is-invalid @enderror" id="Fecha_Cobro" name="Fecha_Cobro" value="{{ old('Fecha_Cobro') }}">
                @error('Fecha_Cobro') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
        </div>

        <hr class="my-4">

        {{-- ========================================== --}}
        {{-- SECCIÓN DE DETALLES (BOTÓN Y TABLA)        --}}
        {{-- ========================================== --}}
        <div class="mb-3 d-flex gap-2">
            <button type="button" class="btn btn-add-item rounded-1" data-bs-toggle="modal" data-bs-target="#modalArticulos">
                <i class="fas fa-plus"></i> Agregar Item
            </button>
            <button type="button" class="btn btn-danger rounded-1" onclick="limpiarTabla()">
                <i class="fas fa-trash-alt"></i> Limpiar Detalles
            </button>
        </div>

        <div class="table-responsive mb-4">
            <table class="table table-bordered table-hover table-detalles text-center w-100" id="tablaDetalles">
                <thead>
                    <tr>
                        <th style="width: 50px;">#</th>
                        <th class="text-start">Artículo</th>
                        <th class="text-start">Descripción</th>
                        <th style="width: 100px;">Cantidad</th>
                        <th style="width: 120px;">P.U.</th>
                        <th style="width: 120px;">P.T.</th>
                        <th style="width: 80px;">Acciones</th>
                    </tr>
                </thead>
                <tbody id="cuerpoDetalles">
                    {{-- Los items se agregarán aquí mediante JavaScript --}}
                    <tr id="filaVacia">
                        <td colspan="7" class="text-muted py-4">No hay ítems agregados. Haga clic en "Agregar Item".</td>
                    </tr>
                </tbody>
            </table>
        </div>

        {{-- ========================================== --}}
        {{-- SECCIÓN DE TOTALES Y FINANZAS              --}}
        {{-- ========================================== --}}
        <div class="row g-3 mb-4 justify-content-end">
            <div class="col-12 col-md-8 row g-3">
                <div class="col-6 col-md-3">
                    <label for="Cuotas" class="form-label">Cuotas</label>
                    <input type="number" class="form-control @error('Cuotas') is-invalid @enderror" id="Cuotas" name="Cuotas" value="{{ old('Cuotas', 1) }}" min="1">
                    @error('Cuotas') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-6 col-md-3">
                    <label for="MontoCancelado" class="form-label">Monto Cancelado</label>
                    <input type="number" step="0.01" class="form-control @error('MontoCancelado') is-invalid @enderror" id="MontoCancelado" name="MontoCancelado" value="{{ old('MontoCancelado', 0) }}">
                    @error('MontoCancelado') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-6 col-md-3">
                    <label for="Subtotal" class="form-label text-secondary fw-bold">Subtotal</label>
                    <input type="number" step="0.01" class="form-control text-end bg-light" id="Subtotal" name="Subtotal" value="{{ old('Subtotal', 0) }}" readonly>
                </div>
                <div class="col-6 col-md-3">
                    <label for="Total" class="form-label text-success fw-bold">Total (+IGV)</label>
                    <input type="number" step="0.01" class="form-control text-end fw-bold bg-light" id="Total" name="Total" value="{{ old('Total', 0) }}" readonly>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 text-end">
                <button type="submit" class="btn btn-success rounded-1 mt-2 px-4">
                    <i class="fas fa-save me-1"></i> Guardar Venta
                </button>
            </div>
        </div>
    </form>

    {{-- ========================================== --}}
    {{-- MODAL DE BÚSQUEDA DE ARTÍCULOS             --}}
    {{-- ========================================== --}}
    <div class="modal fade" id="modalArticulos" tabindex="-1" aria-labelledby="modalArticulosLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalArticulosLabel">Buscar Item</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    
                    {{-- Buscador en tiempo real --}}
                    <div class="search-box d-flex gap-2 align-items-center">
                        <input type="text" id="buscadorArticulos" class="form-control" placeholder="Escriba el Modelo, Descripción o Código...">
                        <button type="button" class="btn btn-success px-4" onclick="enfocarBuscador()">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover table-sm text-center w-100" id="tablaModalArticulos">
                            <thead>
                                <tr>
                                    <th class="text-start">Modelo</th>
                                    <th class="text-start">Descripción</th>
                                    <th>Stock</th>
                                    <th>Precio</th>
                                    <th>Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- Aquí iteramos sobre TODOS los artículos enviados desde el controlador --}}
                                @foreach($articulos as $art)
                                    <tr class="articulo-row">
                                        <td class="text-start modelo-col">{{ $art->Modelo }}</td>
                                        <td class="text-start desc-col" style="font-size: 0.85rem;">{{ $art->Descripcion }}</td>
                                        
                                        {{-- Agregamos un ID al TD del stock para actualizarlo por JS --}}
                                        <td id="td_stock_{{ $art->id }}" class="{{ $art->Stock <= 0 ? 'text-danger fw-bold' : '' }}">{{ $art->Stock }}</td>
                                        
                                        <td class="fw-bold">S/ {{ number_format($art->PrecioVenta, 2) }}</td>
                                        <td>
                                            <div class="d-flex justify-content-center align-items-center">
                                                {{-- Input de cantidad: deshabilitado si stock es 0 --}}
                                                <input type="number" id="cant_modal_{{ $art->id }}" class="form-control form-control-sm qty-input" value="{{ $art->Stock > 0 ? 1 : 0 }}" min="1" max="{{ $art->Stock }}" {{ $art->Stock <= 0 ? 'disabled' : '' }}>
                                                
                                                {{-- Botón de agregar: deshabilitado si stock es 0 --}}
                                                <button type="button" id="btn_add_{{ $art->id }}" class="btn btn-success btn-sm" 
                                                    onclick="agregarItem({{ $art->id }}, '{{ $art->Modelo }}', '{{ addslashes($art->Descripcion) }}', {{ $art->PrecioVenta }})"
                                                    {{ $art->Stock <= 0 ? 'disabled' : '' }}>
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </div>
                                            
                                            {{-- GUARDAR EL STOCK ORIGINAL --}}
                                            <input type="hidden" id="stock_original_{{ $art->id }}" value="{{ $art->Stock }}">
                                            
                                            {{-- Datos ocultos disponibles --}}
                                            <input type="hidden" id="costo_{{ $art->id }}" value="{{ $art->Costo }}">
                                            <input type="hidden" id="peso_{{ $art->id }}" value="{{ $art->Peso }}">
                                            <input type="hidden" id="largo_{{ $art->id }}" value="{{ $art->Largo }}">
                                            <input type="hidden" id="alto_{{ $art->id }}" value="{{ $art->Alto }}">
                                            <input type="hidden" id="ancho_{{ $art->id }}" value="{{ $art->Ancho }}">
                                            <input type="hidden" id="unidad_{{ $art->id }}" value="{{ $art->fk_id_unidad }}">
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <script>
        let contadorItems = 0;

        // 1. LÓGICA DEL BUSCADOR EN TIEMPO REAL (Client-Side)
        document.getElementById('buscadorArticulos').addEventListener('keyup', function() {
            let filtro = this.value.toLowerCase();
            let filas = document.querySelectorAll('.articulo-row');

            filas.forEach(function(fila) {
                let modelo = fila.querySelector('.modelo-col').textContent.toLowerCase();
                let desc = fila.querySelector('.desc-col').textContent.toLowerCase();
                
                if (modelo.includes(filtro) || desc.includes(filtro)) {
                    fila.style.display = '';
                } else {
                    fila.style.display = 'none';
                }
            });
        });

        function enfocarBuscador() {
            document.getElementById('buscadorArticulos').focus();
        }

        // Al abrir el modal, enfocar automáticamente en el buscador
        document.getElementById('modalArticulos').addEventListener('shown.bs.modal', function () {
            document.getElementById('buscadorArticulos').focus();
        });

        // 2. LÓGICA PARA AGREGAR ÍTEM A LA VENTA
        function agregarItem(id, modelo, descripcion, precio) {
            let cantidadInput = document.getElementById('cant_modal_' + id);
            let cantidad = parseFloat(cantidadInput.value);
            let stockOriginal = parseFloat(document.getElementById('stock_original_' + id).value);

            if (isNaN(cantidad) || cantidad <= 0) {
                alert('Ingrese una cantidad válida mayor a 0');
                return;
            }

            // Calcular cuánto hay actualmente en la tabla para este artículo
            let cantidadEnTabla = 0;
            let filaExistente = document.getElementById('row_item_' + id);
            if (filaExistente) {
                cantidadEnTabla = parseFloat(filaExistente.querySelector('.input-cantidad').value) || 0;
            }

            // Validar que la nueva cantidad no supere el stock
            if ((cantidad + cantidadEnTabla) > stockOriginal) {
                alert('No hay suficiente stock. Stock disponible: ' + (stockOriginal - cantidadEnTabla));
                return;
            }

            // Ocultar mensaje de tabla vacía
            let filaVacia = document.getElementById('filaVacia');
            if (filaVacia) filaVacia.style.display = 'none';

            // Comprobar si el item ya está en la tabla para solo sumar cantidad
            if (filaExistente) {
                let inputCant = filaExistente.querySelector('.input-cantidad');
                inputCant.value = parseFloat(inputCant.value) + cantidad;
                recalcularFila(id, precio);
            } else {
                contadorItems++;
                let totalItem = cantidad * precio;
                
                let tr = document.createElement('tr');
                tr.id = 'row_item_' + id;
                tr.innerHTML = `
                    <td>${contadorItems}</td>
                    <td class="text-start fw-bold">
                        ${modelo}
                        <input type="hidden" name="articulos_id[]" value="${id}">
                    </td>
                    <td class="text-start" style="font-size: 0.85rem;">${descripcion}</td>
                    <td>
                        <input type="number" name="cantidades[]" class="form-control form-control-sm text-center input-cantidad" value="${cantidad}" min="1" onchange="recalcularFila(${id}, ${precio})" onkeyup="recalcularFila(${id}, ${precio})">
                    </td>
                    <td>
                        <input type="number" name="precios[]" class="form-control form-control-sm text-end input-precio" value="${precio.toFixed(2)}" step="0.01" onchange="recalcularFila(${id})" onkeyup="recalcularFila(${id})">
                    </td>
                    <td class="text-end fw-bold pt-item" id="pt_item_${id}">${totalItem.toFixed(2)}</td>
                    <td>
                        <button type="button" class="btn btn-danger btn-sm" onclick="eliminarFila(${id})">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                `;
                document.getElementById('cuerpoDetalles').appendChild(tr);
            }

            // Devolver el input del modal a 1 (si queda stock)
            cantidadInput.value = 1;
            
            // Recalcular totales y actualizar visualmente el stock del modal
            calcularTotalesGlobales();
            actualizarStockModal(id);
        }

        // NUEVA FUNCIÓN: Actualiza el stock visual en el modal basado en lo que hay en la tabla
        function actualizarStockModal(id) {
            let stockOriginal = parseFloat(document.getElementById('stock_original_' + id).value);
            let cantidadEnTabla = 0;
            let filaExistente = document.getElementById('row_item_' + id);

            if (filaExistente) {
                cantidadEnTabla = parseFloat(filaExistente.querySelector('.input-cantidad').value) || 0;
            }

            let stockRestante = stockOriginal - cantidadEnTabla;
            let tdStock = document.getElementById('td_stock_' + id);
            let inputModal = document.getElementById('cant_modal_' + id);
            let btnAdd = document.getElementById('btn_add_' + id);

            // Actualizar el texto en la tabla del modal
            tdStock.innerText = stockRestante;

            // Bloquear/Desbloquear según el stock restante
            if (stockRestante <= 0) {
                tdStock.classList.add('text-danger', 'fw-bold');
                inputModal.value = 0;
                inputModal.disabled = true;
                btnAdd.disabled = true;
            } else {
                tdStock.classList.remove('text-danger', 'fw-bold');
                inputModal.disabled = false;
                btnAdd.disabled = false;
                inputModal.max = stockRestante;
                
                // Si el valor actual del input es mayor al stock restante, ajustarlo
                if (parseFloat(inputModal.value) > stockRestante || parseFloat(inputModal.value) === 0) {
                    inputModal.value = 1;
                }
            }
        }

        // 3. RECALCULAR FILA Y TOTALES
        function recalcularFila(id, precioBase = null) {
            let fila = document.getElementById('row_item_' + id);
            let inputCant = fila.querySelector('.input-cantidad');
            let inputPrecio = fila.querySelector('.input-precio');
            
            let cant = parseFloat(inputCant.value) || 0;
            let precio = precioBase || parseFloat(inputPrecio.value) || 0;
            let stockOriginal = parseFloat(document.getElementById('stock_original_' + id).value);

            // Evitar que editen la cantidad directamente en la tabla superando el stock
            if (cant > stockOriginal) {
                alert('La cantidad supera el stock disponible (' + stockOriginal + ').');
                cant = stockOriginal;
                inputCant.value = cant;
            }

            let totalFila = cant * precio;
            document.getElementById('pt_item_' + id).innerText = totalFila.toFixed(2);
            
            calcularTotalesGlobales();
            actualizarStockModal(id); // Actualiza el modal en tiempo real si cambian la cantidad manual
        }

        function calcularTotalesGlobales() {
            let subtotales = document.querySelectorAll('.pt-item');
            let suma_subtotal = 0;
            
            // 1. Calcular el Subtotal (Suma de Cantidad x Precio de cada fila)
            subtotales.forEach(function(celda) {
                suma_subtotal += parseFloat(celda.innerText) || 0;
            });

            // 2. Calcular el Total (+ 18% de IGV/IVA)
            let igv = suma_subtotal * 0.18;
            let total = suma_subtotal + igv;

            // 3. Asignar los valores a los inputs
            document.getElementById('Subtotal').value = suma_subtotal.toFixed(2);
            document.getElementById('Total').value = total.toFixed(2);
            
            // El Monto Cancelado por defecto suele ser el Total a pagar
            document.getElementById('MontoCancelado').value = total.toFixed(2);
        }

        // 4. ELIMINAR FILA Y LIMPIAR TABLA
        function eliminarFila(id) {
            document.getElementById('row_item_' + id).remove();
            calcularTotalesGlobales();
            actualizarStockModal(id); // Restaura el stock en el modal al eliminar
            
            let filas = document.querySelectorAll('#cuerpoDetalles tr[id^="row_item_"]');
            if (filas.length === 0) {
                document.getElementById('filaVacia').style.display = '';
                contadorItems = 0;
            }
        }

        function limpiarTabla() {
            if(confirm('¿Está seguro de limpiar todos los detalles?')) {
                let filas = document.querySelectorAll('#cuerpoDetalles tr[id^="row_item_"]');
                let idsActualizar = [];
                
                // Extraemos los IDs de las filas antes de borrarlas
                filas.forEach(fila => {
                    let id = fila.id.replace('row_item_', '');
                    idsActualizar.push(id);
                    fila.remove();
                });

                document.getElementById('filaVacia').style.display = '';
                contadorItems = 0;
                calcularTotalesGlobales();

                // Restaurar el stock de todos los items eliminados
                idsActualizar.forEach(id => actualizarStockModal(id));
            }
        }
    </script>
@endsection
@extends('principal.maestralmacen')

@section('contenido')


<style>
    .bg-amarillo-suave {
        background-color: #fff3cd !important;
    }

    .bg-verde-suave {
        background-color: #d1e7dd !important;
    }
</style>

<div class="contenedor-contenido">
    <ol class="breadcrumb mb-5" style="display: flex; justify-content: center; align-items: center;">
        <h3 style="color: #ffffff; margin: 0;"><i class="bi bi-card-list"></i>&nbsp;Bitácora de retornables</h3>

    </ol>

    <div class="card-body">
        <table id="Tablabitacoraretornable" class="table table-hover bg-white table-bordered text-center w-100 TableCustom">

        </table>
    </div>

</div>




<div class="modal fade" id="miModal_BITACORA" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form method="post" enctype="multipart/form-data" id="formularioBITACORA" style="background-color: #ffffff;">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Salida de almacén de materiales y/o equipos</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    {!! csrf_field() !!}

                    <input type="hidden" id="ID_BITACORAS_ALMACEN" name="ID_BITACORAS_ALMACEN" value="0">

                    <div class="col-12 mt-3">
                        <div class="row">
                            <div class="col-9">
                                <label class="form-label">Solicitante </label>
                                <input type="text" class="form-control" id="SOLICITANTE_SALIDA" name="SOLICITANTE_SALIDA" readonly>
                            </div>

                            <div class="col-3">
                                <label class="form-label">Fecha de entrega *</label>
                                <div class="input-group">
                                    <input type="text" class="form-control mydatepicker" placeholder="aaaa-mm-dd" id="FECHA_ALMACEN_SOLICITUD" name="FECHA_ALMACEN_SOLICITUD" required>
                                    <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 mt-3">
                        <div class="row">
                            <div class="col-9 mt-2">
                                <label class="form-label">Descripción del Artículo </label>
                                <input type="text" class="form-control" id="DESCRIPCION" name="DESCRIPCION" readonly>
                            </div>
                            <div class="col-3 mt-2">
                                <label class="form-label">Cantidad solicitada </label>
                                <input type="text" class="form-control" id="CANTIDAD" name="CANTIDAD" readonly>
                            </div>
                            <div class="col-8 mt-3">
                                <label class="form-label">Artículo entregado </label>
                                <select class="form-select " id="INVENTARIO" name="INVENTARIO" style="pointer-events:none; background-color:#e9ecef;">
                                    <option value="">Seleccione un artículo</option>
                                    @foreach($inventario as $item)
                                    <option value="{{ $item->ID_FORMULARIO_INVENTARIO }}">
                                        {{ $item->DESCRIPCION_EQUIPO }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-2 mt-3">
                                <label class="form-label">Cantidad entregada</label>
                                <input type="text" class="form-control" id="CANTIDAD_SALIDA" name="CANTIDAD_SALIDA" readonly>
                            </div>
                            <div class="col-2 mt-2">
                                <label class="form-label">U.M. </label>
                                <input type="text" class="form-control" id="UNIDAD_SALIDA" name="UNIDAD_SALIDA" readonly>
                            </div>

                        </div>
                    </div>
                    <div class="col-12 mt-3">
                        <div class="row">
                            <div class="col-4">
                                <label class="form-label">Funcionamiento </label>
                                <select class="form-control" id="FUNCIONAMIENTO_BITACORA" name="FUNCIONAMIENTO_BITACORA" required>
                                    <option value="" selected disabled>Seleccione una opción</option>
                                    <option value="1">Buen estado</option>
                                    <option value="2">Mal estado</option>
                                </select>
                            </div>
                            <div class="col-8">
                                <label class="form-label">Motivo </label>
                                <input type="text" class="form-control" id="OBSERVACIONES_REC" name="OBSERVACIONES_REC" readonly>
                            </div>
                            <div class="col-6 mt-3">
                                <label class="form-label">Recibido por</label>
                                <select class="form-control" id="RECIBIDO_POR" name="RECIBIDO_POR" required>
                                    <option value="">Seleccione una opción</option>

                                    @foreach ($usuarios as $u)
                                    <option value="{{ $u->ID_USUARIO }}">
                                        {{ $u->EMPLEADO_NOMBRE }} {{ $u->EMPLEADO_APELLIDOPATERNO }} {{ $u->EMPLEADO_APELLIDOMATERNO }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-6 mt-3 ">
                                <label class="form-label">Entregado por </label>
                                <input type="text" class="form-control" id="ENTREGADO_POR" name="ENTREGADO_POR" readonly>
                            </div>
                            <div class="col-6 mt-3 text-center">
                                <label class="form-label">Firma (Recibido por)</label>
                                <div style="border: 1px dashed #ffffffff; border-radius: 5px; padding: 10px; text-align:center;">
                                    <canvas id="firmaCanvas" width="400" height="200" style="border:1px solid #ccc; cursor: crosshair;">
                                        Tu navegador no soporta canvas.
                                    </canvas>
                                    <br>
                                    <button type="button" class="btn btn-danger btn-sm mt-2" id="btnLimpiarFirma">
                                        Borrar firma
                                    </button>
                                </div>
                                <input type="hidden" id="FIRMA_RECIBIDO_POR" name="FIRMA_RECIBIDO_POR">
                            </div>
                            <div class="col-6 mt-3 text-center">
                                <label class="form-label">Firma (Entregado por)</label>
                                <div style="border: 1px dashed #ffffffff; border-radius: 5px; padding: 10px; text-align:center;">
                                    <canvas id="firmaCanvas2" width="400" height="200" style="border:1px solid #ccc; cursor: crosshair;">
                                        Tu navegador no soporta canvas.
                                    </canvas>
                                    <br>
                                    <button type="button" class="btn btn-danger btn-sm mt-2" id="btnLimpiarFirma2">
                                        Borrar firma
                                    </button>
                                </div>
                                <input type="hidden" id="FIRMA_ENTREGADO_POR" name="FIRMA_ENTREGADO_POR">
                            </div>
                            <div class="col-12 mt-2">
                                <label class="form-label">Observación </label>
                                <textarea class="form-control" id="OBSERVACIONES_BITACORA" name="OBSERVACIONES_BITACORA" rows="3"></textarea>
                            </div>


                            <div class="col-12 mt-4 text-center">
                                <label class="form-label fw-bold">Evidencias del artículo</label>
                                <br>

                                <input type="file"
                                    id="inputCamara"
                                    accept="image/*"
                                    capture="environment"
                                    multiple
                                    hidden>

                                <input type="file"
                                    id="inputGaleria"
                                    accept="image/*"
                                    multiple
                                    hidden>

                                <button type="button"
                                    class="btn btn-success me-2"
                                    onclick="document.getElementById('inputCamara').click()">
                                    Tomar foto
                                </button>

                                <button type="button"
                                    class="btn btn-primary"
                                    onclick="document.getElementById('inputGaleria').click()">
                                    Cargar imágenes
                                </button>
                            </div>

                            <div id="previewImagenesBitacora" class="row mt-3"></div>


                            <input type="file"
                                name="IMAGENES_BITACORA[]"

                                multiple
                                accept="image/*"
                                hidden>

                            <div id="contenedorImagenesHidden" style="display:none;"></div>


                            <div class="col-12 mt-3">
                                <div class="form-group">
                                    <label for="RETORNO_LABEL">
                                        El artículo ya retorno *
                                    </label>
                                    <select class="form-select"
                                        id="RETORNO_BITACORA_RETORNABLE"
                                        name="RETORNO_BITACORA_RETORNABLE" required>
                                        <option value="" selected disabled>Seleccione una opción</option>
                                        <option value="1">Sí</option>
                                        <option value="2">No</option>
                                    </select>
                                </div>
                            </div>
                    
                            <div class="col-12" id="RETORNO_EQUIPO" style="display: none;">

                                <div class="col-12 mt-3">
                                    <div class="row justify-content-center">
                                        <div class="col-3">
                                            <label class="form-label">Fecha de retorno *</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control mydatepicker" placeholder="aaaa-mm-dd" id="FECHA_RETORNO_BITACORA" name="FECHA_RETORNO_BITACORA" required>
                                                <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>



                                <div class="row">
                                    <div class="col-6 mt-3 text-center">
                                        <label class="form-label">Firma (Retornado por)</label>
                                        <div style="border: 1px dashed #ffffffff; border-radius: 5px; padding: 10px; text-align:center;">
                                            <canvas id="firmaCanvas3" width="400" height="200" style="border:1px solid #ccc; cursor: crosshair;">
                                                Tu navegador no soporta canvas.
                                            </canvas>
                                            <br>
                                            <button type="button" class="btn btn-danger btn-sm mt-2" id="btnLimpiarFirma3">
                                                Borrar firma
                                            </button>
                                        </div>
                                        <input type="hidden" id="FIRMA_RETORNADO_POR" name="FIRMA_RETORNADO_POR">
                                    </div>
                                    <div class="col-6 mt-3 text-center">
                                        <label class="form-label">Firma (Recibido por)</label>
                                        <div style="border: 1px dashed #ffffffff; border-radius: 5px; padding: 10px; text-align:center;">
                                            <canvas id="firmaCanvas4" width="400" height="200" style="border:1px solid #ccc; cursor: crosshair;">
                                                Tu navegador no soporta canvas.
                                            </canvas>
                                            <br>
                                            <button type="button" class="btn btn-danger btn-sm mt-2" id="btnLimpiarFirma4">
                                                Borrar firma
                                            </button>
                                        </div>

                                        <input type="hidden" id="FIRMA_ACEPTADO_POR" name="FIRMA_ACEPTADO_POR">
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-success" id="guardaBITACORA" style="display: block;">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>


<script>
    window.tipoinventario = @json($tipoinventario);
    window.inventario = @json($inventario);
</script>


<script>
    //////////////////////////// FIRMA 1 //////////////

    (function() {

        const canvas = document.getElementById("firmaCanvas");
        const ctx = canvas.getContext("2d");

        let dibujando = false;
        let movimiento = false;
        let pos = {
            x: 0,
            y: 0
        };
        let posAnterior = {
            x: 0,
            y: 0
        };

        function obtenerPosCanvas(evt) {
            let rect = canvas.getBoundingClientRect();
            return {
                x: evt.clientX - rect.left,
                y: evt.clientY - rect.top
            };
        }

        function dibujarPunto(x, y) {
            ctx.beginPath();
            ctx.arc(x, y, 2.5, 0, Math.PI * 2);
            ctx.fillStyle = "#000";
            ctx.fill();
            ctx.closePath();

            document.getElementById("FIRMA_RECIBIDO_POR").value = canvas.toDataURL("image/png");
        }

        canvas.addEventListener("mousedown", function(e) {
            dibujando = true;
            movimiento = false;
            posAnterior = obtenerPosCanvas(e);
        });

        canvas.addEventListener("mouseup", function() {
            if (dibujando && !movimiento) {
                dibujarPunto(posAnterior.x, posAnterior.y);
            }
            dibujando = false;
        });

        canvas.addEventListener("mousemove", function(e) {
            if (dibujando) movimiento = true;
            pos = obtenerPosCanvas(e);
        });

        canvas.addEventListener("touchstart", function(e) {
            e.preventDefault();
            dibujando = true;
            movimiento = false;

            let t = e.touches[0];
            posAnterior = obtenerPosCanvas(t);
        });

        canvas.addEventListener("touchend", function(e) {
            e.preventDefault();

            if (dibujando && !movimiento) {
                dibujarPunto(posAnterior.x, posAnterior.y);
            }

            dibujando = false;
        });

        canvas.addEventListener("touchmove", function(e) {
            e.preventDefault();
            movimiento = true;

            let t = e.touches[0];
            pos = obtenerPosCanvas(t);
        });

        function render() {
            if (dibujando && movimiento) {
                ctx.strokeStyle = "#000";
                ctx.lineWidth = 2;

                ctx.beginPath();
                ctx.moveTo(posAnterior.x, posAnterior.y);
                ctx.lineTo(pos.x, pos.y);
                ctx.stroke();
                ctx.closePath();

                posAnterior = pos;

                document.getElementById("FIRMA_RECIBIDO_POR").value =
                    canvas.toDataURL("image/png");
            }

            requestAnimationFrame(render);
        }

        render();

        document.getElementById("btnLimpiarFirma").addEventListener("click", function() {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            document.getElementById("FIRMA_RECIBIDO_POR").value = "";
        });

    })();

    //////////////////////////// FIRMA 2 //////////////

    (function() {

        const canvas = document.getElementById("firmaCanvas2");
        const ctx = canvas.getContext("2d");

        let dibujando = false;
        let movimiento = false;
        let pos = {
            x: 0,
            y: 0
        };
        let posAnterior = {
            x: 0,
            y: 0
        };

        function obtenerPosCanvas(evt) {
            let rect = canvas.getBoundingClientRect();
            return {
                x: evt.clientX - rect.left,
                y: evt.clientY - rect.top
            };
        }

        function dibujarPunto(x, y) {
            ctx.beginPath();
            ctx.arc(x, y, 2.5, 0, Math.PI * 2);
            ctx.fillStyle = "#000";
            ctx.fill();
            ctx.closePath();

            document.getElementById("FIRMA_ENTREGADO_POR").value = canvas.toDataURL("image/png");
        }

        canvas.addEventListener("mousedown", function(e) {
            dibujando = true;
            movimiento = false;
            posAnterior = obtenerPosCanvas(e);
        });

        canvas.addEventListener("mouseup", function() {
            if (dibujando && !movimiento) {
                dibujarPunto(posAnterior.x, posAnterior.y);
            }
            dibujando = false;
        });

        canvas.addEventListener("mousemove", function(e) {
            if (dibujando) movimiento = true;
            pos = obtenerPosCanvas(e);
        });

        canvas.addEventListener("touchstart", function(e) {
            e.preventDefault();
            dibujando = true;
            movimiento = false;

            let t = e.touches[0];
            posAnterior = obtenerPosCanvas(t);
        });

        canvas.addEventListener("touchend", function(e) {
            e.preventDefault();

            if (dibujando && !movimiento) {
                dibujarPunto(posAnterior.x, posAnterior.y);
            }

            dibujando = false;
        });

        canvas.addEventListener("touchmove", function(e) {
            e.preventDefault();
            movimiento = true;

            let t = e.touches[0];
            pos = obtenerPosCanvas(t);
        });

        function render() {
            if (dibujando && movimiento) {
                ctx.strokeStyle = "#000";
                ctx.lineWidth = 2;

                ctx.beginPath();
                ctx.moveTo(posAnterior.x, posAnterior.y);
                ctx.lineTo(pos.x, pos.y);
                ctx.stroke();
                ctx.closePath();

                posAnterior = pos;

                document.getElementById("FIRMA_ENTREGADO_POR").value =
                    canvas.toDataURL("image/png");
            }

            requestAnimationFrame(render);
        }

        render();

        document.getElementById("btnLimpiarFirma2").addEventListener("click", function() {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            document.getElementById("FIRMA_ENTREGADO_POR").value = "";
        });

    })();

    //////////////////////////// FIRMA 3 //////////////

    (function() {

        const canvas = document.getElementById("firmaCanvas3");
        const ctx = canvas.getContext("2d");

        let dibujando = false;
        let movimiento = false;
        let pos = {
            x: 0,
            y: 0
        };
        let posAnterior = {
            x: 0,
            y: 0
        };

        function obtenerPosCanvas(evt) {
            let rect = canvas.getBoundingClientRect();
            return {
                x: evt.clientX - rect.left,
                y: evt.clientY - rect.top
            };
        }

        function dibujarPunto(x, y) {
            ctx.beginPath();
            ctx.arc(x, y, 2.5, 0, Math.PI * 2);
            ctx.fillStyle = "#000";
            ctx.fill();
            ctx.closePath();

            document.getElementById("FIRMA_RETORNADO_POR").value = canvas.toDataURL("image/png");
        }

        canvas.addEventListener("mousedown", function(e) {
            dibujando = true;
            movimiento = false;
            posAnterior = obtenerPosCanvas(e);
        });

        canvas.addEventListener("mouseup", function() {
            if (dibujando && !movimiento) {
                dibujarPunto(posAnterior.x, posAnterior.y);
            }
            dibujando = false;
        });

        canvas.addEventListener("mousemove", function(e) {
            if (dibujando) movimiento = true;
            pos = obtenerPosCanvas(e);
        });

        canvas.addEventListener("touchstart", function(e) {
            e.preventDefault();
            dibujando = true;
            movimiento = false;

            let t = e.touches[0];
            posAnterior = obtenerPosCanvas(t);
        });

        canvas.addEventListener("touchend", function(e) {
            e.preventDefault();

            if (dibujando && !movimiento) {
                dibujarPunto(posAnterior.x, posAnterior.y);
            }

            dibujando = false;
        });

        canvas.addEventListener("touchmove", function(e) {
            e.preventDefault();
            movimiento = true;

            let t = e.touches[0];
            pos = obtenerPosCanvas(t);
        });

        function render() {
            if (dibujando && movimiento) {
                ctx.strokeStyle = "#000";
                ctx.lineWidth = 2;

                ctx.beginPath();
                ctx.moveTo(posAnterior.x, posAnterior.y);
                ctx.lineTo(pos.x, pos.y);
                ctx.stroke();
                ctx.closePath();

                posAnterior = pos;

                document.getElementById("FIRMA_RETORNADO_POR").value =
                    canvas.toDataURL("image/png");
            }

            requestAnimationFrame(render);
        }

        render();

        document.getElementById("btnLimpiarFirma3").addEventListener("click", function() {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            document.getElementById("FIRMA_RETORNADO_POR").value = "";
        });

    })();


    //////////////////////////// FIRMA 3 //////////////

    (function() {

        const canvas = document.getElementById("firmaCanvas4");
        const ctx = canvas.getContext("2d");

        let dibujando = false;
        let movimiento = false;
        let pos = {
            x: 0,
            y: 0
        };
        let posAnterior = {
            x: 0,
            y: 0
        };

        function obtenerPosCanvas(evt) {
            let rect = canvas.getBoundingClientRect();
            return {
                x: evt.clientX - rect.left,
                y: evt.clientY - rect.top
            };
        }

        function dibujarPunto(x, y) {
            ctx.beginPath();
            ctx.arc(x, y, 2.5, 0, Math.PI * 2);
            ctx.fillStyle = "#000";
            ctx.fill();
            ctx.closePath();

            document.getElementById("FIRMA_ACEPTADO_POR").value = canvas.toDataURL("image/png");
        }

        canvas.addEventListener("mousedown", function(e) {
            dibujando = true;
            movimiento = false;
            posAnterior = obtenerPosCanvas(e);
        });

        canvas.addEventListener("mouseup", function() {
            if (dibujando && !movimiento) {
                dibujarPunto(posAnterior.x, posAnterior.y);
            }
            dibujando = false;
        });

        canvas.addEventListener("mousemove", function(e) {
            if (dibujando) movimiento = true;
            pos = obtenerPosCanvas(e);
        });

        canvas.addEventListener("touchstart", function(e) {
            e.preventDefault();
            dibujando = true;
            movimiento = false;

            let t = e.touches[0];
            posAnterior = obtenerPosCanvas(t);
        });

        canvas.addEventListener("touchend", function(e) {
            e.preventDefault();

            if (dibujando && !movimiento) {
                dibujarPunto(posAnterior.x, posAnterior.y);
            }

            dibujando = false;
        });

        canvas.addEventListener("touchmove", function(e) {
            e.preventDefault();
            movimiento = true;

            let t = e.touches[0];
            pos = obtenerPosCanvas(t);
        });

        function render() {
            if (dibujando && movimiento) {
                ctx.strokeStyle = "#000";
                ctx.lineWidth = 2;

                ctx.beginPath();
                ctx.moveTo(posAnterior.x, posAnterior.y);
                ctx.lineTo(pos.x, pos.y);
                ctx.stroke();
                ctx.closePath();

                posAnterior = pos;

                document.getElementById("FIRMA_ACEPTADO_POR").value =
                    canvas.toDataURL("image/png");
            }

            requestAnimationFrame(render);
        }

        render();

        document.getElementById("btnLimpiarFirma4").addEventListener("click", function() {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            document.getElementById("FIRMA_ACEPTADO_POR").value = "";
        });

    })();
</script>

@endsection
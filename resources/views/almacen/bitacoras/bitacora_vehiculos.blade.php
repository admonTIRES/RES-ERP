@extends('principal.maestralmacen')

@section('contenido')


<style>
    .bg-amarillo-suave {
        background-color: #fff3cd !important;
    }

    .bg-verde-suave {
        background-color: #d1e7dd !important;
    }

    #canvasCombustibleSalida {
        touch-action: none;
    }

    #canvasCombustibleLlegada {
        touch-action: none;
    }
</style>

<div class="contenedor-contenido">
    <ol class="breadcrumb mb-5" style="display: flex; justify-content: center; align-items: center;">
        <h3 style="color: #ffffff; margin: 0;"><i class="bi bi-card-list"></i>&nbsp;Bitácora de vehículos</h3>
    </ol>

    <div class="card-body">
        <table id="Tablabitacoravehiculos" class="table table-hover bg-white table-bordered text-center w-100 TableCustom">
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
                        <table class="table table-bordered align-middle text-center">
                            <thead class="table-secondary">
                                <tr>
                                    <th style="width: 40%;">Tipo de verificación</th>
                                    <th style="width: 15%;">Sí/No</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="text-center">Seguimiento</td>
                                    <td class="text-center">
                                        <select class="form-select" name="SEGUIMIENTO_VEHICULOS" id="SEGUIMIENTO_VEHICULOS" required>
                                            <option value="">Seleccione una opción</option>
                                            <option value="1">Sí</option>
                                            <option value="2">No</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-center">Inspección del Usuario</td>
                                    <td class="text-center">
                                        <select class="form-select" name="INSPECCION_USUARIO_VEHICULOS" id="INSPECCION_USUARIO_VEHICULOS" required>
                                            <option value="">Seleccione una opción</option>
                                            <option value="1">Sí</option>
                                            <option value="2">No</option>
                                        </select>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="col-12 mt-3">
                        <div class="row">
                            <div class="col-9 mt-2">
                                <label class="form-label">Descripción del vehículo </label>
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
                            <div class="col-2 mt-3">
                                <label class="form-label">U.M.</label>
                                <input type="text" class="form-control" id="UNIDAD_SALIDA" name="UNIDAD_SALIDA" readonly>
                            </div>

                        </div>
                    </div>

                    <div class="col-12 mt-3">
                        <div class="row">
                            <div class="col-4 mt-2">
                                <label class="form-label">Marca *</label>
                                <input type="text" class="form-control" id="MARCA_VEHICULO" name="MARCA_VEHICULO" readonly>
                            </div>
                            <div class="col-4 mt-2">
                                <label class="form-label">Último mantenimiento </label>
                                <div class="input-group">
                                    <input type="text" class="form-control mydatepicker" placeholder="aaaa-mm-dd" id="MANTENIMIENTO_VEHICULO" name="MANTENIMIENTO_VEHICULO">
                                    <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                                </div>
                            </div>
                            <div class="col-4 mt-2">
                                <label class="form-label">Modelo *</label>
                                <input type="text" class="form-control" id="MODELO_VEHICULO" name="MODELO_VEHICULO" readonly>
                            </div>
                            <div class="col-4 mt-2">
                                <label class="form-label">Color *</label>
                                <input type="text" class="form-control" id="COLOR_VEHICULO" name="COLOR_VEHICULO" readonly>
                            </div>
                            <div class="col-4 mt-2">
                                <label class="form-label">Placas *</label>
                                <input type="text" class="form-control" id="PLACAS_VEHICULO" name="PLACAS_VEHICULO" readonly>
                            </div>
                            <div class="col-4 mt-2">
                                <label class="form-label">No. de inventario *</label>
                                <input type="text" class="form-control" id="NOINVENTARIO_VEHICULO" name="NOINVENTARIO_VEHICULO" readonly>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 mt-3">
                        <div class="row">



                            <div class="col-3">
                                <div class="form-group">
                                    <label>Entidad póliza *</label>
                                    <input type="text" class="form-control" id="ENTIDAD_POLIZA" name="ENTIDAD_POLIZA" required>
                                </div>
                            </div>
                            <div class="col-3 ">
                                <div class="form-group">
                                    <label>Número de póliza *</label>
                                    <input type="text" class="form-control" id="NUMERO_POLIZA" name="NUMERO_POLIZA" required>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label>Inicio de Vigencia *</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control mydatepicker" placeholder="aaaa-mm-dd" id="INICIOVIGENCIA_POLIZA" name="INICIOVIGENCIA_POLIZA" required>
                                        <span class="input-group-text"><i class="icon-calender"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label>Fin de Vigencia *</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control mydatepicker" placeholder="aaaa-mm-dd" id="FINVIGENCIA_POLIZA" name="FINVIGENCIA_POLIZA" required>
                                        <span class="input-group-text"><i class="icon-calender"></i></span>
                                    </div>
                                </div>
                            </div>


                            <div class="col-6  mt-3">
                                <label class="form-label">No. de licencia</label>
                                <input type="text" class="form-control" id="NOLICENCIA_VEHICULO" name="NOLICENCIA_VEHICULO">
                            </div>
                            <div class="col-6 mt-3">
                                <label class="form-label">Fecha de vencimiento </label>
                                <div class="input-group">
                                    <input type="text" class="form-control mydatepicker" placeholder="aaaa-mm-dd" id="FECHAVENCIMIENTO_VEHICULO" name="FECHAVENCIMIENTO_VEHICULO">
                                    <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                                </div>
                            </div>
                            <div class="col-12 mt-3">
                                <label class="form-label">Área/Proceso/Proyecto </label>
                                <input type="text" class="form-control" id="OBSERVACIONES_REC" name="OBSERVACIONES_REC" readonly>
                            </div>
                            <div class="col-12 mt-3">
                                <div class="table-responsive">
                                    <table class="table table-bordered align-middle">
                                        <thead class="table-secondary text-center">
                                            <tr>
                                                <th>Documento</th>
                                                <th>Sí</th>
                                                <th>No</th>
                                                <th>Observaciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Tarjeta de Circulación</td>
                                                <td class="text-center">
                                                    <input type="radio"
                                                        id="TARJETA_CIRCULACION_SI_VEHICULOS"
                                                        name="TARJETA_CIRCULACION_VEHICULOS"
                                                        value="SI">
                                                </td>
                                                <td class="text-center">
                                                    <input type="radio"
                                                        id="TARJETA_CIRCULACION_NO_VEHICULOS"
                                                        name="TARJETA_CIRCULACION_VEHICULOS"
                                                        value="NO">
                                                </td>
                                                <td>
                                                    <input type="text"
                                                        class="form-control"
                                                        name="OBS_TARJETA_CIRCULACION_VEHICULOS">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Tenencia Vigente</td>
                                                <td class="text-center">
                                                    <input type="radio"
                                                        id="TENENCIA_VIGENTE_SI_VEHICULOS"
                                                        name="TENENCIA_VIGENTE_VEHICULOS"
                                                        value="SI">
                                                </td>
                                                <td class="text-center">
                                                    <input type="radio"
                                                        id="TENENCIA_VIGENTE_NO_VEHICULOS"
                                                        name="TENENCIA_VIGENTE_VEHICULOS"
                                                        value="NO">
                                                </td>
                                                <td>
                                                    <input type="text"
                                                        class="form-control"
                                                        name="OBS_TENENCIA_VIGENTE_VEHICULOS">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Póliza de Seguro Vigente</td>
                                                <td class="text-center">
                                                    <input type="radio"
                                                        id="POLIZA_SEGURO_VIGENTE_SI_VEHICULOS"
                                                        name="POLIZA_SEGURO_VIGENTE_VEHICULOS"
                                                        value="SI">
                                                </td>
                                                <td class="text-center">
                                                    <input type="radio"
                                                        id="POLIZA_SEGURO_VIGENTE_NO_VEHICULOS"
                                                        name="POLIZA_SEGURO_VIGENTE_VEHICULOS"
                                                        value="NO">
                                                </td>
                                                <td>
                                                    <input type="text"
                                                        class="form-control"
                                                        name="OBS_POLIZA_SEGURO_VIGENTE_VEHICULOS">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Instructivo / Manual</td>
                                                <td class="text-center">
                                                    <input type="radio"
                                                        id="INSTRUCTIVO_MANUAL_SI_VEHICULOS"
                                                        name="INSTRUCTIVO_MANUAL_VEHICULOS"
                                                        value="SI">
                                                </td>
                                                <td class="text-center">
                                                    <input type="radio"
                                                        id="INSTRUCTIVO_MANUAL_NO_VEHICULOS"
                                                        name="INSTRUCTIVO_MANUAL_VEHICULOS"
                                                        value="NO">
                                                </td>
                                                <td>
                                                    <input type="text"
                                                        class="form-control"
                                                        name="OBS_INSTRUCTIVO_MANUAL_VEHICULOS">
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="col-12 mt-3">
                                <div class="table-responsive">
                                    <table class="table table-bordered align-middle">
                                        <thead>
                                            <tr class="table-secondary text-center">
                                                <th colspan="6">Accesorios y partes</th>
                                            </tr>
                                            <tr class="text-center">
                                                <th>Descripción</th>
                                                <th>Sí</th>
                                                <th>No</th>
                                                <th>Descripción</th>
                                                <th>Sí</th>
                                                <th>No</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Encendido / Motor</td>
                                                <td class="text-center"><input type="radio" id="ENCENDIDO_MOTOR_SI_VEHICULOS" name="ENCENDIDO_MOTOR_VEHICULOS" value="SI"></td>
                                                <td class="text-center"><input type="radio" id="ENCENDIDO_MOTOR_NO_VEHICULOS" name="ENCENDIDO_MOTOR_VEHICULOS" value="NO"></td>

                                                <td>Accesorios para Cambio de Llanta (Gato / Llave)</td>
                                                <td class="text-center"><input type="radio" id="ACCESORIOS_CAMBIO_LLANTA_SI_VEHICULOS" name="ACCESORIOS_CAMBIO_LLANTA_VEHICULOS" value="SI"></td>
                                                <td class="text-center"><input type="radio" id="ACCESORIOS_CAMBIO_LLANTA_NO_VEHICULOS" name="ACCESORIOS_CAMBIO_LLANTA_VEHICULOS" value="NO"></td>
                                            </tr>
                                            <tr>
                                                <td>Nivel de Aceite</td>
                                                <td class="text-center"><input type="radio" id="NIVEL_ACEITE_SI_VEHICULOS" name="NIVEL_ACEITE_VEHICULOS" value="SI"></td>
                                                <td class="text-center"><input type="radio" id="NIVEL_ACEITE_NO_VEHICULOS" name="NIVEL_ACEITE_VEHICULOS" value="NO"></td>

                                                <td>Reflejantes / Triángulo de Seguridad / Conos</td>
                                                <td class="text-center"><input type="radio" id="REFLEJANTES_SEGURIDAD_SI_VEHICULOS" name="REFLEJANTES_SEGURIDAD_VEHICULOS" value="SI"></td>
                                                <td class="text-center"><input type="radio" id="REFLEJANTES_SEGURIDAD_NO_VEHICULOS" name="REFLEJANTES_SEGURIDAD_VEHICULOS" value="NO"></td>
                                            </tr>
                                            <tr>
                                                <td>Frenos</td>
                                                <td class="text-center"><input type="radio" id="FRENOS_SI_VEHICULOS" name="FRENOS_VEHICULOS" value="SI"></td>
                                                <td class="text-center"><input type="radio" id="FRENOS_NO_VEHICULOS" name="FRENOS_VEHICULOS" value="NO"></td>

                                                <td>Cable pasa corriente</td>
                                                <td class="text-center"><input type="radio" id="CABLE_PASA_CORRIENTE_SI_VEHICULOS" name="CABLE_PASA_CORRIENTE_VEHICULOS" value="SI"></td>
                                                <td class="text-center"><input type="radio" id="CABLE_PASA_CORRIENTE_NO_VEHICULOS" name="CABLE_PASA_CORRIENTE_VEHICULOS" value="NO"></td>
                                            </tr>
                                            <tr>
                                                <td>Sistema Eléctrico</td>
                                                <td class="text-center"><input type="radio" id="SISTEMA_ELECTRICO_SI_VEHICULOS" name="SISTEMA_ELECTRICO_VEHICULOS" value="SI"></td>
                                                <td class="text-center"><input type="radio" id="SISTEMA_ELECTRICO_NO_VEHICULOS" name="SISTEMA_ELECTRICO_VEHICULOS" value="NO"></td>

                                                <td>Gel antibacterial / Spray desinfectante</td>
                                                <td class="text-center"><input type="radio" id="GEL_ANTIBACTERIAL_SI_VEHICULOS" name="GEL_ANTIBACTERIAL_VEHICULOS" value="SI"></td>
                                                <td class="text-center"><input type="radio" id="GEL_ANTIBACTERIAL_NO_VEHICULOS" name="GEL_ANTIBACTERIAL_VEHICULOS" value="NO"></td>
                                            </tr>
                                            <tr>
                                                <td>Faros</td>
                                                <td class="text-center"><input type="radio" id="FAROS_SI_VEHICULOS" name="FAROS_VEHICULOS" value="SI"></td>
                                                <td class="text-center"><input type="radio" id="FAROS_NO_VEHICULOS" name="FAROS_VEHICULOS" value="NO"></td>

                                                <td>Espejos</td>
                                                <td class="text-center"><input type="radio" id="ESPEJOS_SI_VEHICULOS" name="ESPEJOS_VEHICULOS" value="SI"></td>
                                                <td class="text-center"><input type="radio" id="ESPEJOS_NO_VEHICULOS" name="ESPEJOS_VEHICULOS" value="NO"></td>
                                            </tr>
                                            <tr>
                                                <td>Intermitentes</td>
                                                <td class="text-center"><input type="radio" id="INTERMITENTES_SI_VEHICULOS" name="INTERMITENTES_VEHICULOS" value="SI"></td>
                                                <td class="text-center"><input type="radio" id="INTERMITENTES_NO_VEHICULOS" name="INTERMITENTES_VEHICULOS" value="NO"></td>

                                                <td>Cristales / Ventanas</td>
                                                <td class="text-center"><input type="radio" id="CRISTALES_VENTANAS_SI_VEHICULOS" name="CRISTALES_VENTANAS_VEHICULOS" value="SI"></td>
                                                <td class="text-center"><input type="radio" id="CRISTALES_VENTANAS_NO_VEHICULOS" name="CRISTALES_VENTANAS_VEHICULOS" value="NO"></td>
                                            </tr>
                                            <tr>
                                                <td>Funcionamiento de Limpiadores</td>
                                                <td class="text-center"><input type="radio" id="FUNCIONAMIENTO_LIMPIADORES_SI_VEHICULOS" name="FUNCIONAMIENTO_LIMPIADORES_VEHICULOS" value="SI"></td>
                                                <td class="text-center"><input type="radio" id="FUNCIONAMIENTO_LIMPIADORES_NO_VEHICULOS" name="FUNCIONAMIENTO_LIMPIADORES_VEHICULOS" value="NO"></td>

                                                <td>Manchas en Vestiduras</td>
                                                <td class="text-center"><input type="radio" id="MANCHAS_VESTIDURAS_SI_VEHICULOS" name="MANCHAS_VESTIDURAS_VEHICULOS" value="SI"></td>
                                                <td class="text-center"><input type="radio" id="MANCHAS_VESTIDURAS_NO_VEHICULOS" name="MANCHAS_VESTIDURAS_VEHICULOS" value="NO"></td>
                                            </tr>
                                            <tr>
                                                <td>Disponibilidad de Agua para Limpiadores</td>
                                                <td class="text-center"><input type="radio" id="AGUA_LIMPIADORES_SI_VEHICULOS" name="AGUA_LIMPIADORES_VEHICULOS" value="SI"></td>
                                                <td class="text-center"><input type="radio" id="AGUA_LIMPIADORES_NO_VEHICULOS" name="AGUA_LIMPIADORES_VEHICULOS" value="NO"></td>

                                                <td>Asientos</td>
                                                <td class="text-center"><input type="radio" id="ASIENTOS_SI_VEHICULOS" name="ASIENTOS_VEHICULOS" value="SI"></td>
                                                <td class="text-center"><input type="radio" id="ASIENTOS_NO_VEHICULOS" name="ASIENTOS_VEHICULOS" value="NO"></td>
                                            </tr>
                                            <tr>
                                                <td>Molduras Delanteras</td>
                                                <td class="text-center"><input type="radio" id="MOLDURAS_DELANTERAS_SI_VEHICULOS" name="MOLDURAS_DELANTERAS_VEHICULOS" value="SI"></td>
                                                <td class="text-center"><input type="radio" id="MOLDURAS_DELANTERAS_NO_VEHICULOS" name="MOLDURAS_DELANTERAS_VEHICULOS" value="NO"></td>

                                                <td>Cinturones de Seguridad</td>
                                                <td class="text-center"><input type="radio" id="CINTURONES_SEGURIDAD_SI_VEHICULOS" name="CINTURONES_SEGURIDAD_VEHICULOS" value="SI"></td>
                                                <td class="text-center"><input type="radio" id="CINTURONES_SEGURIDAD_NO_VEHICULOS" name="CINTURONES_SEGURIDAD_VEHICULOS" value="NO"></td>
                                            </tr>
                                            <tr>
                                                <td>Molduras Traseras</td>
                                                <td class="text-center"><input type="radio" id="MOLDURAS_TRASERAS_SI_VEHICULOS" name="MOLDURAS_TRASERAS_VEHICULOS" value="SI"></td>
                                                <td class="text-center"><input type="radio" id="MOLDURAS_TRASERAS_NO_VEHICULOS" name="MOLDURAS_TRASERAS_VEHICULOS" value="NO"></td>

                                                <td>Calcomanías (Imanes) con Logo de la Empresa</td>
                                                <td class="text-center"><input type="radio" id="CALCOMANIAS_LOGO_SI_VEHICULOS" name="CALCOMANIAS_LOGO_VEHICULOS" value="SI"></td>
                                                <td class="text-center"><input type="radio" id="CALCOMANIAS_LOGO_NO_VEHICULOS" name="CALCOMANIAS_LOGO_VEHICULOS" value="NO"></td>
                                            </tr>
                                            <tr>
                                                <td>Llantas</td>
                                                <td class="text-center"><input type="radio" id="LLANTAS_SI_VEHICULOS" name="LLANTAS_VEHICULOS" value="SI"></td>
                                                <td class="text-center"><input type="radio" id="LLANTAS_NO_VEHICULOS" name="LLANTAS_VEHICULOS" value="NO"></td>

                                                <td>Pase Vehicular a Instalaciones del Cliente</td>
                                                <td class="text-center"><input type="radio" id="PASE_VEHICULAR_SI_VEHICULOS" name="PASE_VEHICULAR_VEHICULOS" value="SI"></td>
                                                <td class="text-center"><input type="radio" id="PASE_VEHICULAR_NO_VEHICULOS" name="PASE_VEHICULAR_VEHICULOS" value="NO"></td>
                                            </tr>
                                            <tr>
                                                <td>Llanta de Refacción</td>
                                                <td class="text-center"><input type="radio" id="LLANTA_REFACCION_SI_VEHICULOS" name="LLANTA_REFACCION_VEHICULOS" value="SI"></td>
                                                <td class="text-center"><input type="radio" id="LLANTA_REFACCION_NO_VEHICULOS" name="LLANTA_REFACCION_VEHICULOS" value="NO"></td>
                                                <td>Birlo de seguridad </td>
                                                <td class="text-center"><input type="radio" id="BRILLO_SEGURIDAD_SI_VEHICULOS" name="BRILLO_SEGURIDAD_VEHICULOS" value="SI"></td>
                                                <td class="text-center"><input type="radio" id="BRILLO_SEGURIDAD_NO_VEHICULOS" name="BRILLO_SEGURIDAD_VEHICULOS" value="NO"></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="col-12 mt-2" id="DATOS_VEHICULOS">
                                <div class="row">
                                    <div class="col-12 text-center mt-2">
                                        <h5>Marca de llantas </h5>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label>Frente derecha *</label>
                                            <input type="text" class="form-control" id="FRENTE_DERECHA" name="FRENTE_DERECHA" required readonly>
                                            <label>Si</label>
                                            <input class="form-check-input" type="radio" id="FRENTE_DERECHA_SI" name="FRENTE_DERECHA_RADIO" value="1" required>
                                            <label>No</label>
                                            <input class="form-check-input" type="radio" id="FRENTE_DERECHA_NO" name="FRENTE_DERECHA_RADIO" value="0">
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label>Frente izquierda *</label>
                                            <input type="text" class="form-control" id="FRENTE_IZQUIERDA" name="FRENTE_IZQUIERDA" required readonly>
                                            <label>Si</label>
                                            <input class="form-check-input" type="radio" id="FRENTE_IZQUIERDA_SI" name="FRENTE_IZQUIERDA_RADIO" value="1" required>
                                            <label>No</label>
                                            <input class="form-check-input" type="radio" id="FRENTE_IZQUIERDA_NO" name="FRENTE_IZQUIERDA_RADIO" value="0">
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label>Trasera derecha *</label>
                                            <input type="text" class="form-control" id="TRASERA_DERECHA" name="TRASERA_DERECHA" required readonly>
                                            <label>Si</label>
                                            <input class="form-check-input" type="radio" id="TRASERA_DERECHA_SI" name="TRASERA_DERECHA_RADIO" value="1" required>
                                            <label>No</label>
                                            <input class="form-check-input" type="radio" id="TRASERA_DERECHA_NO" name="TRASERA_DERECHA_RADIO" value="0">
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label>Trasera izquierda *</label>
                                            <input type="text" class="form-control" id="TRASERA_IZQUIERDA" name="TRASERA_IZQUIERDA" required readonly>
                                            <label>Si</label>
                                            <input class="form-check-input" type="radio" id="TRASERA_IZQUIERDA_SI" name="TRASERA_IZQUIERDA_RADIO" value="1" required>
                                            <label>No</label>
                                            <input class="form-check-input" type="radio" id="TRASERA_IZQUIERDA_NO" name="TRASERA_IZQUIERDA_RADIO" value="0">
                                        </div>
                                    </div>
                                </div>
                            </div>



                            <div class="col-12 mt-4">
                                <div class="table-responsive">
                                    <table class="table table-bordered text-center align-middle">
                                        <thead class="table-secondary">
                                            <tr>
                                                <th colspan="3">Kilometraje de salida</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                            <tr>
                                                <td colspan="3" style="text-align:center;">
                                                    <input type="text" class="form-control mb-2"
                                                        name="KILOMETRAJE_SALIDA_VEHICULOS"
                                                        id="KILOMETRAJE_SALIDA_VEHICULOS"
                                                        placeholder="Kilometraje salida"
                                                        required>

                                                    <p style="font-size:14px; margin-bottom:4px;">
                                                        <strong>Marque el nivel actual de combustible</strong>
                                                    </p>

                                                    <div style="display:flex; justify-content:center;">

                                                        <canvas id="canvasCombustibleSalida"
                                                            width="360"
                                                            height="160"
                                                            style="border:1px solid #ccc; cursor:crosshair;">
                                                        </canvas>

                                                    </div>

                                                    <div style="margin-top:6px;">
                                                        <button type="button" id="btnLimpiarCombustibleSalida">
                                                            Limpiar
                                                        </button>
                                                    </div>

                                                    <input type="hidden"
                                                        name="COMBUSTIBLE_SALIDA_VEHICULOS"
                                                        id="COMBUSTIBLE_SALIDA_VEHICULOS">

                                                </td>
                                            </tr>

                                            </tr>

                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div style="text-align:center;">

                                <p style="font-size:14px; margin-bottom:8px;">
                                    Marque con una <strong>"X"</strong> si existen golpes, rayones o alguna anomalía de importancia,
                                    y encierre la <strong>"X"</strong> en un círculo si la anomalía se detecta al regreso de la unidad.
                                </p>

                                <style>
                                    .modo-btn {
                                        padding: 6px 12px;
                                        margin-right: 5px;
                                        border: 1px solid #999;
                                        background: #f8f9fa;
                                        cursor: pointer;
                                    }

                                    .modo-btn.activo {
                                        background: #0d6efd;
                                        color: #fff;
                                        border-color: #0d6efd;
                                    }
                                </style>

                                <div id="modoActual"
                                    style="
                                        margin-bottom:8px;
                                        font-weight:bold;
                                        font-size:15px;
                                        color:#0d6efd;">
                                    Modo actual: Marcar X
                                </div>

                                <canvas id="canvasCarro" width="850" height="350" style="border:1px solid #ccc;"></canvas>





                                <div style="margin-top:10px;">
                                    <button type="button" id="btnX" class="modo-btn activo">Marcar X</button>
                                    <button type="button" id="btnCirculo" class="modo-btn">Encerrar</button>
                                    <button type="button" id="btnBorrarUltimo" class="modo-btn">Borrar último</button>
                                    <button type="button" id="btnLimpiar" class="modo-btn">Limpiar todo</button>
                                </div>

                                <input type="hidden" name="DANIOS_UNIDAD_JSON" id="DANIOS_UNIDAD_JSON">
                            </div>


                            <div class="col-12 mt-4 text-center">
                                <label class="form-label fw-bold">Evidencias del vehículo</label>
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


                            <div class="col-12 mt-2">
                                <label class="form-label">Observaciones generales</label>
                                <textarea class="form-control" id="OBSERVACIONES_BITACORA" name="OBSERVACIONES_BITACORA" rows="3"></textarea>
                            </div>

                            <div class="col-6 mt-2">
                                <label class="form-label">Número de Personas que viajan en la unidad *</label>
                                <input type="text" class="form-control" id="NOPERSONAS_VEHICULOS" name="NOPERSONAS_VEHICULOS" required>
                            </div>

                            <div class="col-6 mt-2">
                                <label class="form-label">Salida de la unidad / horario aprox *</label>
                                <input type="time" id="HORASALIDA_VEHICULOS" name="HORASALIDA_VEHICULOS" class="form-control" required>
                            </div>

                            <div class="col-12 mt-3">
                                <div class="form-group">
                                    <label for="BOTIQUIN_PRIMEROS_AUXILIOS_VEHICULOS">
                                        Cuenta con botiquín de primeros auxilios
                                    </label>
                                    <select class="form-select"
                                        id="BOTIQUIN_PRIMEROS_AUXILIOS_VEHICULOS"
                                        name="BOTIQUIN_PRIMEROS_AUXILIOS_VEHICULOS"
                                        required>
                                        <option value="" disabled selected>Seleccione una opción</option>
                                        <option value="1">Sí</option>
                                        <option value="2">No</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-12 mt-4" id="TABLA_BOTIQUIN_VEHICULOS" style="display:none;">
                                <div class="table-responsive">
                                    <table class="table table-bordered align-middle">
                                        <thead class="table-secondary text-center">
                                            <tr>
                                                <th>Descripción del material a entregar</th>
                                                <th style="width: 15%;">Cantidad Entregada</th>
                                                <th style="width: 25%;">Observaciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Maletín para automóvil (medidas: 26 x 35 x 11 cm) color rojo</td>
                                                <td class="text-center">1</td>
                                                <td><input type="text" class="form-control" name="OBS_MALETIN_VEHICULOS" id="OBS_MALETIN_VEHICULOS"></td>
                                            </tr>
                                            <tr>
                                                <td>Sam Splint férula enrollada (36.0” x 4.5”)</td>
                                                <td class="text-center">1</td>
                                                <td><input type="text" class="form-control" name="OBS_FERULA_VEHICULOS" id="OBS_FERULA_VEHICULOS"></td>
                                            </tr>
                                            <tr>
                                                <td>Face Shield para RCP con estuche nylon: pastico cloruro de polivinilo (PVC)
                                                </td>
                                                <td class="text-center">1</td>
                                                <td><input type="text" class="form-control" name="OBS_FACE_SHIELD_VEHICULOS" id="OBS_FACE_SHIELD_VEHICULOS"></td>
                                            </tr>
                                            <tr>
                                                <td>Tijeras redondas de acero inoxidable con mango de plástico</td>
                                                <td class="text-center">1</td>
                                                <td><input type="text" class="form-control" name="OBS_TIJERAS_VEHICULOS" id="OBS_TIJERAS_VEHICULOS"></td>
                                            </tr>
                                            <tr>
                                                <td>Gasas (10 x 10 cm)</td>
                                                <td class="text-center">2</td>
                                                <td><input type="text" class="form-control" name="OBS_GASAS_10_VEHICULOS" id="OBS_GASAS_10_VEHICULOS"></td>
                                            </tr>
                                            <tr>
                                                <td>Gasas (5 x 5 cm)</td>
                                                <td class="text-center">2</td>
                                                <td><input type="text" class="form-control" name="OBS_GASAS_5_VEHICULOS" id="OBS_GASAS_5_VEHICULOS"></td>
                                            </tr>
                                            <tr>
                                                <td>Par de guantes de látex (1 talla Mediana, 1 talla Grande)</td>
                                                <td class="text-center">2</td>
                                                <td><input type="text" class="form-control" name="OBS_GUANTES_VEHICULOS" id="OBS_GUANTES_VEHICULOS"></td>
                                            </tr>
                                            <tr>
                                                <td>Micropore Farme Piel (1.25 cm x 5 cm)</td>
                                                <td class="text-center">1</td>
                                                <td><input type="text" class="form-control" name="OBS_MICROPORE_1_VEHICULOS" id="OBS_MICROPORE_1_VEHICULOS"></td>
                                            </tr>
                                            <tr>
                                                <td>Micropore Farme Piel (2.25 cm x 5 cm)</td>
                                                <td class="text-center">1</td>
                                                <td><input type="text" class="form-control" name="OBS_MICROPORE_2_VEHICULOS" id="OBS_MICROPORE_2_VEHICULOS"></td>
                                            </tr>
                                            <tr>
                                                <td>Venda elástica (5 cm x 5 cm)</td>
                                                <td class="text-center">1</td>
                                                <td><input type="text" class="form-control" name="OBS_VENDA_5_VEHICULOS" id="OBS_VENDA_5_VEHICULOS"></td>
                                            </tr>
                                            <tr>
                                                <td>Venda elástica (10 cm x 5 cm)</td>
                                                <td class="text-center">1</td>
                                                <td><input type="text" class="form-control" name="OBS_VENDA_10_VEHICULOS" id="OBS_VENDA_10_VEHICULOS"></td>
                                            </tr>
                                            <tr>
                                                <td>Solución salina (50 ml / 0.9%)</td>
                                                <td class="text-center">1</td>
                                                <td><input type="text" class="form-control" name="OBS_SOLUCION_SALINA_VEHICULOS" id="OBS_SOLUCION_SALINA_VEHICULOS"></td>
                                            </tr>
                                            <tr>
                                                <td>Venda triangular</td>
                                                <td class="text-center">1</td>
                                                <td><input type="text" class="form-control" name="OBS_VENDA_TRIANGULAR_VEHICULOS" id="OBS_VENDA_TRIANGULAR_VEHICULOS"></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <small class="fw-bold">
                                        *Estos artículos se consideran consumibles, los cuales pueden no ser devueltos a RES,
                                        con la justificación de su uso.
                                    </small>
                                </div>
                            </div>

                            <div class="col-12 mt-3">
                                <div class="form-group">
                                    <label for="KIT_SEGURIDAD_VEHICULOS">
                                        Cuenta con kit de seguridad
                                    </label>
                                    <select class="form-select"
                                        id="KIT_SEGURIDAD_VEHICULOS"
                                        name="KIT_SEGURIDAD_VEHICULOS" required>
                                        <option value="" selected disabled>Seleccione una opción</option>
                                        <option value="1">Sí</option>
                                        <option value="2">No</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-12 mt-4" id="TABLA_KIT_SEGURIDAD_VEHICULOS" style="display:none;">
                                <div class="table-responsive">
                                    <table class="table table-bordered align-middle">
                                        <thead class="table-secondary text-center">
                                            <tr>
                                                <th>Descripción del material entregado</th>
                                                <th style="width: 15%;">Cantidad Entregada</th>
                                                <th style="width: 30%;">Observaciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Maletín para herramientas</td>
                                                <td class="text-center">1</td>
                                                <td><input type="text" class="form-control" name="OBS_MALETIN_HERRAMIENTAS_VEHICULOS" id="OBS_MALETIN_HERRAMIENTAS_VEHICULOS"></td>
                                            </tr>
                                            <tr>
                                                <td>Desarmador de cruz</td>
                                                <td class="text-center">1</td>
                                                <td><input type="text" class="form-control" name="OBS_DESARMADOR_CRUZ_VEHICULOS" id="OBS_DESARMADOR_CRUZ_VEHICULOS"></td>
                                            </tr>
                                            <tr>
                                                <td>Desarmador plano</td>
                                                <td class="text-center">1</td>
                                                <td><input type="text" class="form-control" name="OBS_DESARMADOR_PLANO_VEHICULOS" id="OBS_DESARMADOR_PLANO_VEHICULOS"></td>
                                            </tr>
                                            <tr>
                                                <td>Pinzas multiusos</td>
                                                <td class="text-center">1</td>
                                                <td><input type="text" class="form-control" name="OBS_PINZAS_MULTIUSOS_VEHICULOS" id="OBS_PINZAS_MULTIUSOS_VEHICULOS"></td>
                                            </tr>
                                            <tr>
                                                <td>Cuerdas bungee</td>
                                                <td class="text-center">4</td>
                                                <td><input type="text" class="form-control" name="OBS_CUERDAS_BUNGEE_VEHICULOS" id="OBS_CUERDAS_BUNGEE_VEHICULOS"></td>
                                            </tr>
                                            <tr>
                                                <td>Lona de Polietileno</td>
                                                <td class="text-center">1</td>
                                                <td><input type="text" class="form-control" name="OBS_LONA_POLIETILENO_VEHICULOS" id="OBS_LONA_POLIETILENO_VEHICULOS"></td>
                                            </tr>
                                            <tr>
                                                <td>Guantes de punto de neopreno *</td>
                                                <td class="text-center">1</td>
                                                <td><input type="text" class="form-control" name="OBS_GUANTES_NEOPRENO_VEHICULOS" id="OBS_GUANTES_NEOPRENO_VEHICULOS"></td>
                                            </tr>
                                            <tr>
                                                <td>Calibrador de presión de llantas</td>
                                                <td class="text-center">1</td>
                                                <td><input type="text" class="form-control" name="OBS_CALIBRADOR_LLANTAS_VEHICULOS" id="OBS_CALIBRADOR_LLANTAS_VEHICULOS"></td>
                                            </tr>
                                            <tr>
                                                <td>Extintor 1kg tipo PQS (polvo químico seco)</td>
                                                <td class="text-center">1</td>
                                                <td><input type="text" class="form-control" name="OBS_EXTINTOR_PQS_VEHICULOS" id="OBS_EXTINTOR_PQS_VEHICULOS"></td>
                                            </tr>
                                            <tr>
                                                <td>Linterna recargable</td>
                                                <td class="text-center">1</td>
                                                <td><input type="text" class="form-control" name="OBS_LINTERNA_RECARGABLE_VEHICULOS" id="OBS_LINTERNA_RECARGABLE_VEHICULOS"></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <small class="fw-bold">
                                        *Estos artículos se consideran consumibles, los cuales pueden no ser devueltos a RES,
                                        con la justificación de su uso.
                                    </small>
                                </div>
                            </div>

                            <div class="col-6 mt-3">
                                <label class="form-label">Recibido por</label>
                                <select class="form-control" id="RECIBIDO_POR" name="RECIBIDO_POR" required>
                                    <option value="">Seleccione una opción</option>
                                    <optgroup label="Colaboradores">
                                        @foreach ($colaboradores as $recibido)
                                        <option value="{{ $recibido->CURP }}">
                                            {{ $recibido->NOMBRE_COLABORADOR }} {{ $recibido->PRIMER_APELLIDO }} {{ $recibido->SEGUNDO_APELLIDO }}
                                        </option>
                                        @endforeach
                                    </optgroup>
                                    <optgroup label="Proveedores">
                                        @foreach ($proveedores as $recibido)
                                        <option value="{{ $recibido->RFC_ALTA }}">
                                            {{ $recibido->NOMBRE_DIRECTORIO }}
                                        </option>
                                        @endforeach
                                    </optgroup>
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

                            <div class="col-12 mt-3">
                                <div class="form-group">
                                    <label for="RETORNO_LABEL_VEHICULOS">
                                        El vehículo ya retorno
                                    </label>
                                    <select class="form-select"
                                        id="RETORNO_VEHICULOS"
                                        name="RETORNO_VEHICULOS" required>
                                        <option value="" selected disabled>Seleccione una opción</option>
                                        <option value="1">Sí</option>
                                        <option value="2">No</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-12 mt-4" id="DIV_KILOMETRAJE_LLEGADA" style="display: none;">
                                <div class="table-responsive">
                                    <table class="table table-bordered text-center align-middle">
                                        <thead class="table-secondary">
                                            <tr>
                                                <th colspan="3">Kilometraje de llegada</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td colspan="3" style="text-align:center;">

                                                    <input type="text" class="form-control mb-2"
                                                        name="KILOMETRAJE_LLEGADA_VEHICULOS"
                                                        id="KILOMETRAJE_LLEGADA_VEHICULOS"
                                                        placeholder="Kilometraje llegada"
                                                        required>

                                                    <p style="font-size:14px; margin-bottom:4px;">
                                                        <strong>Marque el nivel actual de combustible</strong>
                                                    </p>

                                                    <div style="display:flex; justify-content:center;">
                                                        <canvas id="canvasCombustibleLlegada"
                                                            width="360"
                                                            height="160"
                                                            style="border:1px solid #ccc; cursor:crosshair;">
                                                        </canvas>
                                                    </div>

                                                    <div style="margin-top:6px;">
                                                        <button type="button" id="btnLimpiarCombustibleLlegada">
                                                            Limpiar
                                                        </button>
                                                    </div>

                                                    <input type="hidden"
                                                        name="COMBUSTIBLE_LLEGADA_VEHICULOS"
                                                        id="COMBUSTIBLE_LLEGADA_VEHICULOS">
                                                </td>


                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-12 mt-2">
                                    <label class="form-label">Regreso de la unidad / horario aprox *</label>
                                    <input type="time" id="HORAREGRESO_VEHICULOS" name="HORAREGRESO_VEHICULOS" class="form-control" required>
                                </div>
                            </div>

                            <div class="col-12" id="FIRMA_REGRESO_VEHICULO" style="display: none;">
                                <div class="row">
                                    <div class="col-6 mt-3">
                                        <label class="form-label">Retornado por</label>
                                        <select class="form-control" id="VERIFICA_POR" name="VERIFICA_POR" required>
                                            <option value="">Seleccione una opción</option>
                                            <optgroup label="Colaboradores">
                                                @foreach ($colaboradores as $recibido)
                                                <option value="{{ $recibido->CURP }}">
                                                    {{ $recibido->NOMBRE_COLABORADOR }} {{ $recibido->PRIMER_APELLIDO }} {{ $recibido->SEGUNDO_APELLIDO }}
                                                </option>
                                                @endforeach
                                            </optgroup>
                                            <optgroup label="Proveedores">
                                                @foreach ($proveedores as $recibido)
                                                <option value="{{ $recibido->RFC_ALTA }}">
                                                    {{ $recibido->NOMBRE_DIRECTORIO }}
                                                </option>
                                                @endforeach
                                            </optgroup>
                                        </select>
                                    </div>
                                    <div class="col-6 mt-3 ">
                                        <label class="form-label">Recibido por </label>
                                        <input type="text" class="form-control" id="VALIDADO_POR" name="VALIDADO_POR">
                                    </div>
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
                                        <input type="hidden" id="FIRMA_VERIFICADO_POR" name="FIRMA_VERIFICADO_POR">
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
                                        <input type="hidden" id="FIRMA_VALIDADO_POR" name="FIRMA_VALIDADO_POR">
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

            document.getElementById("FIRMA_VERIFICADO_POR").value = canvas.toDataURL("image/png");
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

                document.getElementById("FIRMA_VERIFICADO_POR").value =
                    canvas.toDataURL("image/png");
            }

            requestAnimationFrame(render);
        }

        render();

        document.getElementById("btnLimpiarFirma3").addEventListener("click", function() {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            document.getElementById("FIRMA_VERIFICADO_POR").value = "";
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

            document.getElementById("FIRMA_VALIDADO_POR").value = canvas.toDataURL("image/png");
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

                document.getElementById("FIRMA_VALIDADO_POR").value =
                    canvas.toDataURL("image/png");
            }

            requestAnimationFrame(render);
        }

        render();

        document.getElementById("btnLimpiarFirma4").addEventListener("click", function() {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            document.getElementById("FIRMA_VALIDADO_POR").value = "";
        });

    })();
</script>



@endsection
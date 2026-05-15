@extends('principal.maestra')

@section('contenido')


<!-- Estilos CSS a añadir al proyecto -->
<style>
    .brechas-container {
        background-color: #f8f9fa;
        border-radius: 8px;
        padding: 15px 20px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
        margin-bottom: 20px;
    }

    .brecha-item {
        display: flex;
        flex-direction: column;
        margin-bottom: 15px;
        border-radius: 6px;
        background-color: white;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        overflow: hidden;
        border: 1px solid #e9ecef;
    }

    .brecha-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 12px 15px;
        background-color: #f8f9fa;
        border-bottom: 1px solid #e9ecef;
    }

    .brecha-header .mensaje-brecha {
        font-size: 14px;
        font-weight: 500;
        color: #495057;
        flex-grow: 1;
    }

    .brecha-header .porcentaje-brecha {
        font-weight: 600;
        padding: 4px 10px;
        min-width: 60px;
        text-align: center;
        border-radius: 20px;
        color: white;
        font-size: 13px;
        margin-left: 10px;
    }

    .brecha-content {
        padding: 12px 15px;
        display: flex;
        justify-content: flex-end;
    }

    .btn-plan {
        background-color: transparent;
        border: 1px dashed #adb5bd;
        color: #6c757d;
        font-size: 13px;
        padding: 5px 12px;
        border-radius: 4px;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .btn-plan:hover {
        background-color: #f1f3f5;
        border-color: #6c757d;
    }

    .porcentaje-bajo {
        background-color: #28a745;
    }

    .porcentaje-medio {
        background-color: #fd7e14;
    }

    .porcentaje-alto {
        background-color: #dc3545;
    }

    .brechas-cabecera {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 1px solid #e9ecef;
    }

    .brechas-cabecera h5 {
        margin-bottom: 0;
        font-weight: 600;
        color: #343a40;
    }

    .contador-brechas {
        background-color: #3b7ddd;
        color: white;
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 14px;
        font-weight: 500;
    }

    .sin-brechas {
        text-align: center;
        padding: 25px;
        color: #6c757d;
        font-style: italic;
        background-color: white;
        border-radius: 6px;
    }
</style>

<div class="contenedor-contenido">
    <ol class="breadcrumb mb-5">
        <h3 style="color: #ffffff; margin: 0;">&nbsp;Brecha de competencias</h3>
        <!-- <button type="button" class="btn btn-light waves-effect waves-light " id="NUEVO_ANUNCIO" style="margin-left: auto;">
            Nuevo &nbsp;<i class="bi bi-plus-circle"></i>
        </button> -->
    </ol>

    <div class="card-body">
        <table id="Tablabrecha" class="table table-hover bg-white table-bordered text-center w-100 TableCustom">
        </table>
    </div>
</div>









<div class="modal modal-fullscreen fade" id="miModal_BRECHA" tabindex="-1" aria-labelledby="miModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form method="post" enctype="multipart/form-data" id="formularioBRECHA" style="background-color: #ffffff;">
                <div class="modal-header">
                    <h5 class="modal-title" id="miModalLabel"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    {!! csrf_field() !!}
                    <div class="row">

                        <div class="col-12">
                            <div class="row">

                                <div class="col-4 mb-3">
                                    <label class="form-label">CURP </label>
                                    <input type="text" class="form-control" id="CURP" name="CURP" readonly>
                                </div>
                                <div class="col-4 mb-3">
                                    <label class="form-label">Nombre del colaborador</label>
                                    <input type="text" class="form-control" id="NOMBRE_BRECHA" name="NOMBRE_BRECHA" readonly>
                                </div>
                                <div class="col-4 mb-3">
                                    <label class="form-label">Porcentaje faltante </label>
                                    <input type="text" class="form-control" id="PORCENTAJE_FALTANTE" name="PORCENTAJE_FALTANTE" readonly>
                                </div>

                            </div>
                            <div class="mt-3 brechas-container">
                                <div class="brechas-cabecera">
                                    <h5>Brechas detectadas</h5>
                                    <span id="contadorBrechas" class="contador-brechas"></span>
                                </div>
                                <div id="listaBrechas"></div>
                            </div>

                        </div>
                    </div>

                    <div class="modal-footer mx-5">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>

                    </div>
            </form>
        </div>
    </div>
</div>





@endsection
@extends('principal.maestracompras')

@section('contenido')






<div class="contenedor-contenido">
    <ol class="breadcrumb mb-5" style="display: flex; justify-content: center; align-items: center;">
        <h3 style="color: #ffffff; margin: 0;">&nbsp;Vo.Bo de bienes y/o servicios usuarios</h3>
    </ol>

    <div class="card-body">
        <table id="TablaVoBoGRusuarios" class="table table-hover bg-white table-bordered text-center w-100 TableCustom"></table>
    </div>
</div>





<div class="modal fade" id="modalVoBo" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <form id="formVoBo">
                @csrf
                <input type="hidden" name="ID_GR" id="ID_GR_VOBO">

                <div class="modal-header bg-white text-dark">
                    <h5 class="modal-title">Dar Vo.Bo a los Productos</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="row mb-3">


                        <div class="col-md-12">
                            <label class="form-label">Fecha Vo.Bo</label>
                            <div class="input-group">
                                <input type="text" class="form-control mydatepicker" placeholder="aaaa-mm-dd" id="FECHA_VOUSUARIO" name="FECHA_VOUSUARIO" required>
                                <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                            </div>
                        </div>

                    </div>

                    <div id="contenedorProductosVoBo"></div>


                    <div class="col-md-12">
                        <label>Dar a Vo.Bo </label>
                        <div id="estado-container" class="p-2 rounded">
                            <select class="form-control" id="VO_BO_USUARIO" name="VO_BO_USUARIO" required>
                                <option value="" selected disabled>Seleccione una opción</option>
                                <option value="Aprobada">Aprobada</option>
                                <option value="Rechazada">Rechazada</option>
                            </select>
                        </div>
                    </div>


                </div>


                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-success" id="btnGuardarVoBoGR">Guardar Vo.Bo</button>
                </div>


            </form>
        </div>
    </div>
</div>










<script>
    window.tipoinventario = @json($tipoinventario);
    window.inventario = @json($inventario);
</script>














@endsection
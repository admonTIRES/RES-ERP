

@extends('principal.maestra')


@section('contenido')



<div class="contenedor-contenido">
    <ol class="breadcrumb mb-5">
        <h3 style="color: #ffffff; margin: 0;">&nbsp;Pendiente por contratar</h3>
    </ol>

    <div class="card-body">
        <table id="Tablapendientecontratacion" class="table table-hover bg-white table-bordered text-center w-100 TableCustom">

        </table>
    </div>

</div>




<div class="modal modal-fullscreen fade" id="miModal_PENDIENTE" tabindex="-1" aria-labelledby="miModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
          <div class="modal-content">
        <form method="post" enctype="multipart/form-data" id="formularioPENDIENTE" style="background-color: #ffffff;">
            <div class="modal-header">
                <h5 class="modal-title" id="miModalLabel">Pendiente por contratar</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
                <div class="modal-body">
                    {!! csrf_field() !!}
                        <div class="row">


                            <div class="row mb-3">
                                <div class="col-4">
                                    <div class="form-group">
                                    <label>Nombre(s)</label>
                                    <input type="text" class="form-control" id="NOMBRE_PC" name="NOMBRE_PC" required>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">                            
                                    <label>Primer Apellido </label>
                                    <input type="text" class="form-control" id="PRIMER_APELLIDO_PC" name="PRIMER_APELLIDO_PC" required>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">                            
                                    <label>Segundo Apellido </label>
                                    <input type="text" class="form-control" id="SEGUNDO_APELLIDO_PC" name="SEGUNDO_APELLIDO_PC" required>
                                    </div>
                                </div>
                            </div>   
                                
                            <div class="row mb-3">
                                <div class="col-12 text-center">
                                    <label>Fecha de nacimiento</label>

                                </div>
                            </div>   
                                
        

                            <div class="row mb-3">
                                    <div class="col-4">
                                        <label>Día</label>
                                        <select class="form-select"  id="dia" name="DIA_FECHA_PC" required>
                                            <option value="" selected disabled>Día</option>
                                        <!-- Genera los días del 1 al 31 -->
                                        <script>
                                        for (let i = 1; i <= 31; i++) {
                                            document.write('<option value="' + i + '">' + i + '</option>');
                                            }
                                            </script>
                                    </select>
                                </div>
                                <div class="col-4">   
                                    <label class="text-center">Mes</label>
                                    <select class="form-select"  id="mes" name="MES_FECHA_PC" required>
                                        <option value="" selected disabled>Mes</option>
                                        <option value="1">Enero</option>
                                        <option value="2">Febrero</option>
                                        <option value="3">Marzo</option>
                                        <option value="4">Abril</option>
                                        <option value="5">Mayo</option>
                                        <option value="6">Junio</option>
                                        <option value="7">Julio</option>
                                        <option value="8">Agosto</option>
                                        <option value="9">Septiembre</option>
                                        <option value="10">Octubre</option>
                                        <option value="11">Noviembre</option>
                                        <option value="12">Diciembre</option>
                                    </select>
                                </div>

                                <div class="col-4">
                                    <label>Año</label>
                                        <input type="text" class="form-control" id="ANIO_FECHA_PC" name="ANIO_FECHA_PC" required>
                                    </select>
                                </div>

                            </div>

                            
                            <br>
                           
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                            </div>
                    </div>

                </div>
         </form>
        </div>
    </div>
</div>



@endsection


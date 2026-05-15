@extends('principal.maestracompras')

@section('contenido')



<div class="contenedor-contenido">
    <ol class="breadcrumb mt-5" style="display: flex; justify-content: center; align-items: center;">
        <h3 style="color: #ffffff; margin: 0;">
            <i class="bi bi-file-earmark-fill"></i>&nbsp;&nbsp;Lista de contratos
        </h3>
    </ol>

    <div class="card-body">
        <table id="Tablalistacontratosproveedores" class="table table-hover bg-white table-bordered text-center w-100 TableCustom">
        </table>
    </div>
</div>













@endsection
@extends('principal.maestraproveedores')

@section('contenido')




<div class="contenedor-contenido">
    <ol class="breadcrumb mb-5" style="display: flex; justify-content: center; align-items: center;">
        <h3 style="color: #ffffff; margin: 0;"><i class="bi bi-file-earmark-fill"></i>&nbsp;Contratos</h3>
    </ol>

    <div class="card-body">
        <table id="Tablaproveedorescontrato" class="table table-hover bg-white table-bordered text-center w-100 TableCustom">
            <i id="loadingIcon1" class="bi bi-arrow-repeat position-absolute spin" style="top: 10px; left: 10px; font-size: 24px; display: none;"></i>
        </table>
    </div>



</div>






@endsection
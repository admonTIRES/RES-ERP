@extends('principal.maestraproveedores')

@section('contenido')




<div class="contenedor-contenido">
    <ol class="breadcrumb mb-5" style="display: flex; justify-content: center; align-items: center;">
        <h3 style="color: #ffffff; margin: 0;"><i class="bi bi-file-earmark-fill"></i>&nbsp;Orden de compra (PO)</h3>
    </ol>

    <div class="card-body">
        <table id="Tablapoproveedor" class="table table-hover bg-white table-bordered text-center w-100 TableCustom">
            <i id="loadingIcon1" class="bi bi-arrow-repeat position-absolute spin" style="top: 10px; left: 10px; font-size: 24px; display: none;"></i>
        </table>
    </div>


    <ol class="breadcrumb mt-5" style="display: flex; justify-content: center; align-items: center;">
        <h3 style="color: #ffffff; margin: 0;"><i class="bi bi-file-earmark-fill"></i>&nbsp;Recepción de bienes y/o servicios (GR)</h3>
    </ol>

    <div class="card-body">
        <table id="Tablagrproveedor" class="table table-hover bg-white table-bordered text-center w-100 TableCustom">
            <i id="loadingIcon2" class="bi bi-arrow-repeat position-absolute spin" style="top: 10px; left: 10px; font-size: 24px; display: none;"></i>
        </table>
    </div>



</div>






@endsection
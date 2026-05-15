@extends('principal.maestracompras')

@section('contenido')

<style>
    .card-body {
        height: 250px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }

    .card-title {
        text-align: center;
    }

    .btn {
        margin-top: auto;
    }
</style>


<div class="container mt-5">
    <div class="row justify-content-center">

        <div class="col-md-4 mb-4">
            <div class="card h-100 text-center">
                <div class="card-body d-flex flex-column justify-content-center align-items-center">
                    <h5 class="card-title mb-4">Catálogo funciones/áreas del contacto</h5>
                    <a class="btn btn-primary mt-3" href="{{ url('/catalogofunciones') }}">Ver Catálogo</a>
                </div>
            </div>
        </div>


        <div class="col-md-4 mb-4">
            <div class="card h-100 text-center">
                <div class="card-body d-flex flex-column justify-content-center align-items-center">
                    <h5 class="card-title mb-4">Catálogo título del contacto</h5>
                    <a class="btn btn-primary mt-3" href="{{ url('/catalogotitulos') }}">Ver Catálogo</a>
                </div>
            </div>
        </div>


        <div class="col-md-4 mb-4">
            <div class="card h-100 text-center">
                <div class="card-body d-flex flex-column justify-content-center align-items-center">
                    <h5 class="card-title mb-4">Catálogo documentos de soporte </h5>
                    <a class="btn btn-primary mt-3" href="{{ url('/catalogodocumentosoporte') }}">Ver Catálogo</a>
                </div>
            </div>
        </div>


        <div class="col-md-4 mb-4">
            <div class="card h-100 text-center">
                <div class="card-body d-flex flex-column justify-content-center align-items-center">
                    <h5 class="card-title mb-4">Catálogo Verificación de información del proveedor</h5>
                    <a class="btn btn-primary mt-3" href="{{ url('/catalogoverificacionproveedor') }}">Ver Catálogo</a>
                </div>
            </div>
        </div>




    </div>
</div>



@endsection
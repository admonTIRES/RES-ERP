@extends('principal.maestraventas')

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
                    <h5 class="card-title mb-4">Catálogo medio de contacto</h5>
                    <a class="btn btn-primary mt-3" href="{{ url('/catalogomediocontacto') }}">Ver Catálogo</a>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card h-100 text-center">
                <div class="card-body d-flex flex-column justify-content-center align-items-center">
                    <h5 class="card-title mb-4">Catálogo Giro de la empresa</h5>
                    <a class="btn btn-primary mt-3" href="{{ url('/catalogogiroempresa') }}">Ver Catálogo</a>
                </div>
            </div>
        </div>



        <div class="col-md-4 mb-4">
            <div class="card h-100 text-center">
                <div class="card-body d-flex flex-column justify-content-center align-items-center">
                    <h5 class="card-title mb-4">Catálogo necesidad del servicio</h5>
                    <a class="btn btn-primary mt-3" href="{{ url('/catalogonecesidadservicio') }}">Ver Catálogo</a>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card h-100 text-center">
                <div class="card-body d-flex flex-column justify-content-center align-items-center">
                    <h5 class="card-title mb-4">Catálogo línea de negocios</h5>
                    <a class="btn btn-primary mt-3" href="{{ url('/catalogolineanegocio') }}">Ver Catálogo</a>
                </div>
            </div>
        </div>


        <div class="col-md-4 mb-4">
            <div class="card h-100 text-center">
                <div class="card-body d-flex flex-column justify-content-center align-items-center">
                    <h5 class="card-title mb-4">Catálogo tipo de servicio</h5>
                    <a class="btn btn-primary mt-3" href="{{ url('/catalogotiposervicio') }}">Ver Catálogo</a>
                </div>
            </div>
        </div>


        <div class="col-md-4 mb-4">
            <div class="card h-100 text-center">
                <div class="card-body d-flex flex-column justify-content-center align-items-center">
                    <h5 class="card-title mb-4">Catálogo título del contacto</h5>
                    <a class="btn btn-primary mt-3" href="{{ url('/catalogoclientestitulos') }}">Ver Catálogo</a>
                </div>
            </div>
        </div>

        {{--

<div class="col-md-4 mb-4">
    <div class="card h-100 text-center">
        <div class="card-body d-flex flex-column justify-content-center align-items-center">
            <h5 class="card-title mb-4">Catálogo competencias gerenciales</h5>
            <a class="btn btn-primary mt-3" href="{{ url('/competenciasgerenciales') }}">Ver Catálogo</a>
    </div>
</div>
</div>
--}}










</div>
</div>



@endsection
@extends('principal.maestra')

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
                    <h5 class="card-title mb-4">Catálogo asesores</h5>
                    <a class="btn btn-primary mt-3" href="{{ url('/asesores') }}">Ver Catálogo</a>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card h-100 text-center">
                <div class="card-body d-flex flex-column justify-content-center align-items-center">
                    <h5 class="card-title mb-4">Catálogo categorías</h5>
                    <a class="btn btn-primary mt-3" href="{{ url('/categorias') }}">Ver Catálogo</a>
                </div>
            </div>
        </div>



        <div class="col-md-4 mb-4">
            <div class="card h-100 text-center">
                <div class="card-body d-flex flex-column justify-content-center align-items-center">
                    <h5 class="card-title mb-4">Catálogo vacantes</h5>
                    <a class="btn btn-primary mt-3" href="{{ url('/catalogodevacantes') }}">Ver Catálogo</a>
                </div>
            </div>
        </div>


        <div class="col-md-4 mb-4">
            <div class="card h-100 text-center">
                <div class="card-body d-flex flex-column justify-content-center align-items-center">
                    <h5 class="card-title mb-4">Catálogo género</h5>
                    <a class="btn btn-primary mt-3" href="{{ url('/genero') }}">Ver Catálogo</a>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card h-100 text-center">
                <div class="card-body d-flex flex-column justify-content-center align-items-center">
                    <h5 class="card-title mb-4">Catálogo áreas de interés</h5>
                    <a class="btn btn-primary mt-3" href="{{ url('/areainteres') }}">Ver Catálogo</a>
                </div>
            </div>
        </div>


        <div class="col-md-4 mb-4">
            <div class="card h-100 text-center">
                <div class="card-body d-flex flex-column justify-content-center align-items-center">
                    <h5 class="card-title mb-4">Catálogo pruebas de conocimientos</h5>
                    <a class="btn btn-primary mt-3" href="{{ url('/pruebasconocimientos') }}">Ver Catálogo</a>
                </div>
            </div>
        </div>


        <div class="col-md-4 mb-4">
            <div class="card h-100 text-center">
                <div class="card-body d-flex flex-column justify-content-center align-items-center">
                    <h5 class="card-title mb-4">Catálogo anuncios</h5>
                    <a class="btn btn-primary mt-3" href="{{ url('/anuncios') }}">Ver Catálogo</a>
                </div>
            </div>
        </div>







    </div>
</div>



@endsection
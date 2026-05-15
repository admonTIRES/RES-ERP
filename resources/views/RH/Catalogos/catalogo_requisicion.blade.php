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
                    <h5 class="card-title mb-4">Catálogo tipo de vacante</h5>
                    <a class="btn btn-primary mt-3" href="{{ url('/tipovacante') }}">Ver Catálogo</a>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card h-100 text-center">
                <div class="card-body d-flex flex-column justify-content-center align-items-center">
                    <h5 class="card-title mb-4">Catálogo motivo de la vacante</h5>
                    <a class="btn btn-primary mt-3" href="{{ url('/motivovacante') }}">Ver Catálogo</a>
                </div>
            </div>
        </div>



    

      





    </div>
</div>



@endsection

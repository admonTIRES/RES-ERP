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
                    <h5 class="card-title mb-4">Catálogo general de los cursos</h5>
                    <a class="btn btn-primary mt-3" href="{{ url('/capacitacioncursos') }}">Ver Catálogo</a>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card h-100 text-center">
                <div class="card-body d-flex flex-column justify-content-center align-items-center">
                    <h5 class="card-title mb-4">Tipo de curso</h5>
                    <a class="btn btn-primary mt-3" href="{{ url('/capacitaciontipocurso') }}">Ver Catálogo</a>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card h-100 text-center">
                <div class="card-body d-flex flex-column justify-content-center align-items-center">
                    <h5 class="card-title mb-4">Área de conocimiento</h5>
                    <a class="btn btn-primary mt-3" href="{{ url('/capacitacionareaconocimiento') }}">Ver Catálogo</a>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card h-100 text-center">
                <div class="card-body d-flex flex-column justify-content-center align-items-center">
                    <h5 class="card-title mb-4">Modalidad</h5>
                    <a class="btn btn-primary mt-3" href="{{ url('/capacitacionmodalidad') }}">Ver Catálogo</a>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card h-100 text-center">
                <div class="card-body d-flex flex-column justify-content-center align-items-center">
                    <h5 class="card-title mb-4">Formato</h5>
                    <a class="btn btn-primary mt-3" href="{{ url('/capacitacionformato') }}">Ver Catálogo</a>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card h-100 text-center">
                <div class="card-body d-flex flex-column justify-content-center align-items-center">
                    <h5 class="card-title mb-4">País o región</h5>
                    <a class="btn btn-primary mt-3" href="{{ url('/capacitacionpaisoregion') }}">Ver Catálogo</a>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card h-100 text-center">
                <div class="card-body d-flex flex-column justify-content-center align-items-center">
                    <h5 class="card-title mb-4">Idioma</h5>
                    <a class="btn btn-primary mt-3" href="{{ url('/capacitacionidioma') }}">Ver Catálogo</a>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card h-100 text-center">
                <div class="card-body d-flex flex-column justify-content-center align-items-center">
                    <h5 class="card-title mb-4">Normativa o marco de referencia</h5>
                    <a class="btn btn-primary mt-3" href="{{ url('/capacitacionnormatividad') }}">Ver Catálogo</a>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card h-100 text-center">
                <div class="card-body d-flex flex-column justify-content-center align-items-center">
                    <h5 class="card-title mb-4">Reconocimiento</h5>
                    <a class="btn btn-primary mt-3" href="{{ url('/capacitacionreconocimiento') }}">Ver Catálogo</a>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card h-100 text-center">
                <div class="card-body d-flex flex-column justify-content-center align-items-center">
                    <h5 class="card-title mb-4">Competencias que desarrolla</h5>
                    <a class="btn btn-primary mt-3" href="{{ url('/capacitacioncompetencia') }}">Ver Catálogo</a>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card h-100 text-center">
                <div class="card-body d-flex flex-column justify-content-center align-items-center">
                    <h5 class="card-title mb-4">Tipo de proveedor</h5>
                    <a class="btn btn-primary mt-3" href="{{ url('/capacitaciontipoproveedor') }}">Ver Catálogo</a>
                </div>
            </div>
        </div>


        <div class="col-md-4 mb-4">
            <div class="card h-100 text-center">
                <div class="card-body d-flex flex-column justify-content-center align-items-center">
                    <h5 class="card-title mb-4">Método de evaluación</h5>
                    <a class="btn btn-primary mt-3" href="{{ url('/capacitacionmetodoevaluacion') }}">Ver Catálogo</a>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card h-100 text-center">
                <div class="card-body d-flex flex-column justify-content-center align-items-center">
                    <h5 class="card-title mb-4">Evidencias generadas</h5>
                    <a class="btn btn-primary mt-3" href="{{ url('/capacitacionevidenciasgeneradas') }}">Ver Catálogo</a>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card h-100 text-center">
                <div class="card-body d-flex flex-column justify-content-center align-items-center">
                    <h5 class="card-title mb-4">Ubicación</h5>
                    <a class="btn btn-primary mt-3" href="{{ url('/capacitacionubicacion') }}">Ver Catálogo</a>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card h-100 text-center">
                <div class="card-body d-flex flex-column justify-content-center align-items-center">
                    <h5 class="card-title mb-4">Material didáctico</h5>
                    <a class="btn btn-primary mt-3" href="{{ url('/capacitacionmaterialdidactico') }}">Ver Catálogo</a>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card h-100 text-center">
                <div class="card-body d-flex flex-column justify-content-center align-items-center">
                    <h5 class="card-title mb-4">Impacto esperado</h5>
                    <a class="btn btn-primary mt-3" href="{{ url('/capacitacionimpactoesperado') }}">Ver Catálogo</a>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card h-100 text-center">
                <div class="card-body d-flex flex-column justify-content-center align-items-center">
                    <h5 class="card-title mb-4">Documento emitido por el proveedor</h5>
                    <a class="btn btn-primary mt-3" href="{{ url('/capacitaciondocumentosemitidos') }}">Ver Catálogo</a>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card h-100 text-center">
                <div class="card-body d-flex flex-column justify-content-center align-items-center">
                    <h5 class="card-title mb-4">Moneda</h5>
                    <a class="btn btn-primary mt-3" href="{{ url('/capacitacionmoneda') }}">Ver Catálogo</a>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card h-100 text-center">
                <div class="card-body d-flex flex-column justify-content-center align-items-center">
                    <h5 class="card-title mb-4">Líneas de negocios</h5>
                    <a class="btn btn-primary mt-3" href="{{ url('/capacitaciolineasnegocios') }}">Ver Catálogo</a>
                </div>
            </div>
        </div>

    </div>
</div>



@endsection
@extends('principal.maestra')

@section('contenido')




<div class="contenedor-contenido">
    <ol class="breadcrumb mb-5">
        <h3 style="color: #ffffff; margin: 0;">&nbsp; Cursos capacitación</h3>
        <button type="button" class="btn btn-light waves-effect waves-light" data-bs-toggle="modal" id="NUEVO_CURSO" style="margin-left: auto;">
            Nuevo &nbsp;<i class="bi bi-plus-circle"></i>
        </button>
    </ol>
    <div class="card-body">
        <table id="Tablacapcursos" class="table table-hover bg-white table-bordered text-center w-100 TableCustom">
        </table>
    </div>
</div>


<div class="modal modal-fullscreen fade" id="miModal_curso" tabindex="-1" aria-labelledby="miModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <form method="post" enctype="multipart/form-data" id="formulariocurso" style="background-color: #ffffff;">
                <div class="modal-header">
                    <h5 class="modal-title" id="miModalLabel">Nuevo curso</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    {!! csrf_field() !!}

                    <div class="row">


                        <div class="row mb-3">
                            <div class="col-12 text-center">
                                <div style="display: inline-flex; align-items: center; gap: 10px;">
                                    <h4 style="margin: 0;">1. Identificación general del curso </h4>
                                </div>
                            </div>
                        </div>


                        <div class="col-6 mt-3">
                            <div class="form-group">
                                <label>Seleccione el tipo de ID *</label>
                                <select class="form-select" name="TIPO_ID" id="TIPO_ID" required>
                                    <option value="" disabled selected>Seleccione una opción</option>
                                    <option value="1">H-TE-XXX (Habilidades Técnicas)</option>
                                    <option value="2">H-HU-XXX (Habilidades humanas)</option>
                                    <option value="3">H-SA-XXX (Health) H</option>
                                    <option value="4">H-SE-XXX (Safety) S</option>
                                    <option value="5">H-MA-XXX (Environment) E</option>
                                    <option value="6">H-CA-XXX (Quality) Q</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-6 mt-3">
                            <div class="form-group">
                                <label>Número de ID</label>
                                <input type="text" class="form-control" id="NUMERO_ID" name="NUMERO_ID" readonly required>
                            </div>
                        </div>




                        <div class="col-6 mt-3">
                            <div class="form-group">
                                <label>Nombre oficial del curso *</label>
                                <input type="text" class="form-control" id="NOMBE_OFICIAL_CURSO" name="NOMBE_OFICIAL_CURSO" required>
                            </div>
                        </div>

                        <div class="col-6 mt-3">
                            <div class="form-group">
                                <label>Nombre corto / comercial *</label>
                                <input type="text" class="form-control" id="NOMBE_COMERCIAL_CURSO" name="NOMBE_COMERCIAL_CURSO" required>
                            </div>
                        </div>

                        <div class="col-6 mt-3">
                            <div class="form-group">
                                <label>Descripción general *</label>
                                <textarea class="form-control" id="DESCRIPCION_CURSO" name="DESCRIPCION_CURSO" required rows="3"> </textarea>
                            </div>
                        </div>

                        <div class="col-6 mt-3">
                            <div class="form-group">
                                <label>Objetivo(s) de aprendizaje *</label>
                                <textarea class="form-control" id="OBJETIVOS_CURSO" name="OBJETIVOS_CURSO" required rows="3"> </textarea>
                            </div>
                        </div>

                        <div class="col-4 mt-3">
                            <div class="form-group">
                                <label>Tipo de curso </label>
                                <select class="form-select" id="TIPO_CURSO" name="TIPO_CURSO[]" multiple>
                                    <option value=""></option>
                                    @foreach ($tipocurso as $catalogo)
                                    <option value="{{ $catalogo->ID_TIPO_CURSO }}">{{ $catalogo->TIPO_CURSO }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-4 mt-3">
                            <div class="form-group">
                                <label>Área de conocimiento </label>
                                <select class="form-select" id="AREA_CONOCIMIENTO" name="AREA_CONOCIMIENTO[]" multiple>
                                    <option value=""></option>
                                    @foreach ($areaconocimiento as $catalogo)
                                    <option value="{{ $catalogo->ID_AREA_CONOCIMIENTO }}">{{ $catalogo->NOMBRE_AREA_CONOCIMIENTO }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-4 mt-3">
                            <div class="form-group">
                                <label>Niveles </label>
                                <select class="form-select" id="NIVELES_CURSO" name="NIVELES_CURSO[]" multiple>
                                    <option value="" disabled selected>Seleccione una opción</option>
                                    <option value="1">Básico </option>
                                    <option value="2">Intermedio</option>
                                    <option value="3">Avanzado</option>
                                    <option value="4">Especializado</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mt-5">
                            <div class="col-12 text-center">
                                <div style="display: inline-flex; align-items: center; gap: 10px;">
                                    <h4 style="margin: 0;">2. Modalidad y formato </h4>
                                </div>
                            </div>
                        </div>

                        <div class="col-6 mt-3">
                            <div class="form-group">
                                <label>Modalidad </label>
                                <select class="form-select" id="MODALIDAD_CURSO" name="MODALIDAD_CURSO[]" multiple>
                                    <option value=""></option>
                                    @foreach ($modalidad as $catalogo)
                                    <option value="{{ $catalogo->ID_MODALIDAD }}">{{ $catalogo->NOMBRE_MODALIDAD }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-6 mt-3">
                            <div class="form-group">
                                <label>Formato </label>
                                <select class="form-select" id="FORMATO_CURSO" name="FORMATO_CURSO[]" multiple>
                                    <option value=""></option>
                                    @foreach ($formato as $catalogo)
                                    <option value="{{ $catalogo->ID_FORMATO }}">{{ $catalogo->NOMBRE_FORMATO }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-4 mt-3">
                            <div class="form-group">
                                <label>Duración total del curso *</label>
                                <input type="text" class="form-control" id="DURACION_CURSO" name="DURACION_CURSO" required>
                            </div>
                        </div>

                        <div class="col-4 mt-3">
                            <div class="form-group">
                                <label>Horas teóricas *</label>
                                <input type="text" class="form-control" id="HORAS_TEORICAS" name="HORAS_TEORICAS" required>
                            </div>
                        </div>

                        <div class="col-4 mt-3">
                            <div class="form-group">
                                <label>Horas prácticas *</label>
                                <input type="text" class="form-control" id="HORAS_PRACTICAS" name="HORAS_PRACTICAS" required>
                            </div>
                        </div>

                        <div class="col-6 mt-3">
                            <div class="form-group">
                                <label>Número de sesiones / días *</label>
                                <input type="text" class="form-control" id="NUMERO_SESIONES" name="NUMERO_SESIONES" required>
                            </div>
                        </div>

                        <div class="col-6 mt-3">
                            <div class="form-group">
                                <label>Duración por sesión / día*</label>
                                <input type="text" class="form-control" id="DURACION_SESIONES" name="DURACION_SESIONES" required>
                            </div>
                        </div>

                        <div class="row mt-5">
                            <div class="col-12 text-center">
                                <div style="display: inline-flex; align-items: center; gap: 10px;">
                                    <h4 style="margin: 0;">3. Alcance geográfico y normativo (nacional / internacional) </h4>
                                </div>
                            </div>
                        </div>

                        <div class="col-6 mt-3">
                            <div class="form-group">
                                <label>País o región de aplicación </label>
                                <select class="form-select" id="PAISREGION_CURSO" name="PAISREGION_CURSO[]" multiple>
                                    <option value=""></option>
                                    @foreach ($paisregion as $catalogo)
                                    <option value="{{ $catalogo->ID_PAIS_REGION }}">{{ $catalogo->NOMBRE_PAIS_REGION }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-6 mt-3">
                            <div class="form-group">
                                <label>Idioma(s) del curso </label>
                                <select class="form-select" id="IDIOMAS_CURSO" name="IDIOMAS_CURSO[]" multiple>
                                    <option value=""></option>
                                    @foreach ($idioma as $catalogo)
                                    <option value="{{ $catalogo->ID_IDIOMAS }}">{{ $catalogo->NOMBRE_IDIOMA }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-6 mt-3">
                            <div class="form-group">
                                <label>Normativa o marco de referencia </label>
                                <select class="form-select" id="NORMATIVA_CURSO" name="NORMATIVA_CURSO[]" multiple>
                                    <option value=""></option>
                                    @foreach ($normatividad as $catalogo)
                                    <option value="{{ $catalogo->ID_NORMATIVIDAD_MARCO }}">{{ $catalogo->NOMBRE_NORMATIVIDAD }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-6 mt-3">
                            <div class="form-group">
                                <label>Reconocimiento </label>
                                <select class="form-select" id="RECONOCIMIENTO_CURSO" name="RECONOCIMIENTO_CURSO[]" multiple>
                                    <option value=""></option>
                                    @foreach ($reconocimiento as $catalogo)
                                    <option value="{{ $catalogo->ID_RECONOCIMIENTO }}">{{ $catalogo->NOMBRE_RECONOCIMIENTO }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row mt-5">
                            <div class="col-12 text-center">
                                <div style="display: inline-flex; align-items: center; gap: 10px;">
                                    <h4 style="margin: 0;">4. Requisitos y perfil del participante</h4>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-group">
                                <label> Perfil recomendado del participante</label>
                                <button type="button" class="btn btn-danger ml-2 rounded-pill" id="botonagregarperfilrecomendado">
                                    <i class="bi bi-plus-circle-fill"></i>
                                </button>
                            </div>
                        </div>

                        <div class="col-12 mt-3">
                            <div class="perfilrecomendado">
                            </div>
                        </div>


                        <div class="row mt-5">
                            <div class="col-12 text-center">
                                <div style="display: inline-flex; align-items: center; gap: 10px;">
                                    <h6 style="margin: 0;">Requisitos previo</h6>
                                </div>
                            </div>
                        </div>


                        <div class="col-4 mt-3">
                            <div class="form-group">
                                <label>Escolaridad *</label>
                                <input type="text" class="form-control" id="ESCOLARIDAD_CURSO" name="ESCOLARIDAD_CURSO" required>
                            </div>
                        </div>

                        <div class="col-4 mt-3">
                            <div class="form-group">
                                <label>Experiencia *</label>
                                <input type="text" class="form-control" id="EXPERIENCIA_CURSO" name="EXPERIENCIA_CURSO" required>
                            </div>
                        </div>

                        <div class="col-4 mt-3">
                            <div class="form-group">
                                <label>Cursos previos *</label>
                                <select class="form-select" id="CURSOS_PREVIOS" name="CURSOS_PREVIOS" required>
                                    <option value="" disabled selected>Seleccione una opción</option>
                                    <option value="1">Sí</option>
                                    <option value="2">No</option>
                                </select>
                            </div>
                        </div>


                        <div class="col-12 mt-3" id="NOMBRE_CURSOS" style="display: none;">
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Agregar cursos</label>
                                    <button type="button" class="btn btn-danger ml-2 rounded-pill" id="botonagregarcursos">
                                        <i class="bi bi-plus-circle-fill"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="col-12 mt-3">
                                <div class="cursosprevios">
                                </div>
                            </div>
                        </div>


                        <div class="col-6 mt-3">
                            <div class="form-group">
                                <label>Puestos o roles a los que aplica </label>
                                <select class="form-select" id="CATEGORIAS_CURSO" name="CATEGORIAS_CURSO[]" multiple>
                                    <option value=""></option>
                                    @foreach ($categorias as $catalogo)
                                    <option value="{{ $catalogo->ID_CATALOGO_CATEGORIA }}">{{ $catalogo->NOMBRE_CATEGORIA }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-6 mt-3">
                            <div class="form-group">
                                <label>Competencias que desarrolla </label>
                                <select class="form-select" id="COMPETENCIAS_CURSO" name="COMPETENCIAS_CURSO[]" multiple>
                                    <option value=""></option>
                                    @foreach ($competencia as $catalogo)
                                    <option value="{{ $catalogo->ID_COMPETENCIA_DESARROLLA }}">{{ $catalogo->NOMBRE_COMPETENCIAS }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-6 mt-3">
                            <div class="form-group">
                                <label>Riesgos o procesos relacionados (si aplica) </label>
                                <textarea class="form-control" id="RIESGOSRELACIONADOS_CURSO" name="RIESGOSRELACIONADOS_CURSO" rows="2"> </textarea>
                            </div>
                        </div>

                        <div class="col-6 mt-3">
                            <div class="form-group">
                                <label>¿Si aplica para la prestación de servicios de la empresa?</label>
                                <select class="form-select" id="PRESTACIONSERVICIOS_CURSO" name="PRESTACIONSERVICIOS_CURSO" required>
                                    <option value="" disabled selected>Seleccione una opción</option>
                                    <option value="1">Sí</option>
                                    <option value="2">No</option>
                                </select>
                            </div>
                        </div>


                        <div class="col-12 mt-3" id="PRESTACION_SERVICIOS" style="display: none;">
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Agregar servicio</label>
                                    <button type="button" class="btn btn-danger ml-2 rounded-pill" id="botonagregarservicios">
                                        <i class="bi bi-plus-circle-fill"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="col-12 mt-3">
                                <div class="prestacionservicios">
                                </div>
                            </div>
                        </div>


                        <div class="row mt-5">
                            <div class="col-12 text-center">
                                <div style="display: inline-flex; align-items: center; gap: 10px;">
                                    <h4 style="margin: 0;">5. Instructor(es) y proveedor </h4>
                                </div>
                            </div>
                        </div>

                        <div class="col-4 mt-3">
                            <div class="form-group">
                                <label>Tipo de proveedor </label>
                                <select class="form-select" id="TIPO_PROVEEDOR" name="TIPO_PROVEEDOR[]" multiple>
                                    <option value=""></option>
                                    @foreach ($tipoproveedor as $catalogo)
                                    <option value="{{ $catalogo->ID_TIPO_PROVEEDOR }}">{{ $catalogo->TIPO_PROVEEDOR }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-4 mt-3">
                            <div class="form-group">
                                <label>Nombre del instructor </label>
                                <input type="text" class="form-control" id="NOMBRE_INSTRUCTOR" name="NOMBRE_INSTRUCTOR">
                            </div>
                        </div>

                        <div class="col-4 mt-3">
                            <div class="form-group">
                                <label>Certificaciones del instructor </label>
                                <select class="form-select" id="CERTIFICACIONES_INSTRUCTOR" name="CERTIFICACIONES_INSTRUCTOR" required>
                                    <option value="" disabled selected>Seleccione una opción</option>
                                    <option value="1">Sí</option>
                                    <option value="2">No</option>
                                </select>
                            </div>
                        </div>


                        <div class="col-12 mt-3" id="CERTIFICACIONESINSTRUCTOR" style="display: none;">
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Agregar certificación</label>
                                    <button type="button" class="btn btn-danger ml-2 rounded-pill" id="botonagregarcertificacioninstructor">
                                        <i class="bi bi-plus-circle-fill"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="col-12 mt-3">
                                <div class="certificacionesinstructor">
                                </div>
                            </div>
                        </div>



                        <div class="col-4 mt-3">
                            <div class="form-group">
                                <label>Nombre de Proveedor o institución potencia </label>
                                <input type="text" class="form-control" id="NOMBRE_PROVEEDOR" name="NOMBRE_PROVEEDOR">
                            </div>
                        </div>

                        <div class="col-4 mt-3">
                            <div class="form-group">
                                <label>Ubicación del proveedor (ciudad y país) </label>
                                <input type="text" class="form-control" id="UBICACION_PROVEEDOR" name="UBICACION_PROVEEDOR">
                            </div>
                        </div>

                        <div class="col-4 mt-3">
                            <div class="form-group">
                                <label>Contacto / contrato asociado </label>
                                <input type="text" class="form-control" id="CONTACTO_CONTRATO_PROVEEDOR" name="CONTACTO_CONTRATO_PROVEEDOR">
                            </div>
                        </div>

                        <div class="row mt-5">
                            <div class="col-12 text-center">
                                <div style="display: inline-flex; align-items: center; gap: 10px;">
                                    <h4 style="margin: 0;">6. Evaluación, evidencia y certificación </h4>
                                </div>
                            </div>
                        </div>

                        <div class="col-4 mt-3">
                            <div class="form-group">
                                <label>Método de evaluación </label>
                                <select class="form-select" id="METODO_EVALUACION" name="METODO_EVALUACION[]" multiple>
                                    <option value=""></option>
                                    @foreach ($metodoevaluacion as $catalogo)
                                    <option value="{{ $catalogo->ID_METODO_EVALUACION }}">{{ $catalogo->METODO_EVALUACION }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-4 mt-3">
                            <div class="form-group">
                                <label>Criterios de aprobación </label>
                                <input type="text" class="form-control" id="CRITERIOS_APROBACION" name="CRITERIOS_APROBACION">
                            </div>
                        </div>

                        <div class="col-2 mt-3">
                            <div class="form-group">
                                <label>Calificación mínima </label>
                                <input type="text" class="form-control" id="CALIFICACION_MINIMA" name="CALIFICACION_MINIMA">
                            </div>
                        </div>

                        <div class="col-2 mt-3">
                            <div class="form-group">
                                <label>Calificación máxima </label>
                                <input type="text" class="form-control" id="CALIFICACION_MAXIMA" name="CALIFICACION_MAXIMA">
                            </div>
                        </div>



                        <div class="col-6 mt-3">
                            <div class="form-group">
                                <label>Evidencias generadas </label>
                                <select class="form-select" id="EVIDENCIAS_GENERADAS" name="EVIDENCIAS_GENERADAS[]" multiple>
                                    <option value=""></option>
                                    @foreach ($evidenciageneradas as $catalogo)
                                    <option value="{{ $catalogo->ID_EVIDENCIA_GENERADAS }}">{{ $catalogo->NOMBRE_EVIDENCIA }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-6 mt-3">
                            <div class="form-group">
                                <label>Documento emitido por el proveedor </label>
                                <select class="form-select" id="DOCUMENTOS_EMITIDOS" name="DOCUMENTOS_EMITIDOS[]" multiple>
                                    <option value=""></option>
                                    @foreach ($docemitido as $catalogo)
                                    <option value="{{ $catalogo->ID_DOCUMENTOS_EMITIDOS }}">{{ $catalogo->NOMBRE_DOCUMENTO }}</option>
                                    @endforeach
                                </select>
                                </select>
                            </div>
                        </div>

                        <div class="col-6 mt-3">
                            <div class="form-group">
                                <label>Vigencia del curso *</label>
                                <select class="form-select" id="VIGENCIA_CURSO" name="VIGENCIA_CURSO" required>
                                    <option value="" disabled selected>Seleccione una opción</option>
                                    <option value="1">Sin vigencia</option>
                                    <option value="2">Renovación cada X años </option>
                                    <option value="3">Reentrenamiento cada X años </option>
                                </select>
                            </div>
                        </div>

                        <div class="col-6 mt-3" id="CADA_ANIO" style="display: none;">
                            <div class="form-group">
                                <label>Cada cuanto *</label>
                                <input type="text" class="form-control" id="CADA_CUANTO_TIEMPO" name="CADA_CUANTO_TIEMPO" required>
                            </div>
                        </div>

                        <div class="row mt-5">
                            <div class="col-12 text-center">
                                <div style="display: inline-flex; align-items: center; gap: 10px;">
                                    <h4 style="margin: 0;">7. Costos y planeación financiera </h4>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-5">
                            <div class="col-12 text-center">
                                <div style="display: inline-flex; align-items: center; gap: 10px;">
                                    <h6 style="margin: 0;">Costo del curso </h6>
                                </div>
                            </div>
                        </div>

                        <div class="col-4 mt-3">
                            <div class="form-group">
                                <label>Tipo de costo</label>
                                <select class="form-select" id="TIPO_COSTO" name="TIPO_COSTO" required>
                                    <option value="" disabled selected>Seleccione una opción</option>
                                    <option value="1">Interno</option>
                                    <option value="2">Externo</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-4 mt-3">
                            <div class="form-group">
                                <label>Valor del curso</label>
                                <input type="text" class="form-control" id="COSTO_CURSO" name="COSTO_CURSO">
                            </div>
                        </div>


                        <div class="col-4 mt-3">
                            <div class="form-group">
                                <label>Moneda </label>
                                <select class="form-select" id="MONEDA_CURSO" name="MONEDA_CURSO">
                                    <option value="" disabled selected>Seleccione una opción</option>
                                    @foreach ($moneda as $catalogo)
                                    <option value="{{ $catalogo->ID_MONEDA }}">{{ $catalogo->TIPO_MONEDA }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>


                        <div class="col-6 mt-3">
                            <div class="form-group">
                                <label>Tasa de cambio </label>
                                <input type="text" class="form-control" id="TASA_CAMBIO" name="TASA_CAMBIO">
                            </div>
                        </div>

                        <div class="col-6 mt-3">
                            <div class="form-group">
                                <label>Valor en MXN </label>
                                <input type="text" class="form-control" id="VALOR_MXN" name="VALOR_MXN" readonly>
                            </div>
                        </div>


                        <div class="row mt-5">
                            <div class="col-12 text-center">
                                <div style="display: inline-flex; align-items: center; gap: 10px;">
                                    <h6 style="margin: 0;">Costos asociados </h6>
                                </div>
                            </div>
                        </div>

                        <div class="col-3 mt-3">
                            <div class="form-group">
                                <label>Viáticos – costo aproximado </label>
                                <input type="text" class="form-control" id="VIATICOS_CURSO" name="VIATICOS_CURSO">
                            </div>
                        </div>

                        <div class="col-3 mt-3">
                            <div class="form-group">
                                <label>Material – costo aproximado </label>
                                <input type="text" class="form-control" id="MATERIALES_CURSO" name="MATERIALES_CURSO">
                            </div>
                        </div>

                        <div class="col-3 mt-3">
                            <div class="form-group">
                                <label>Otros – costo aproximado </label>
                                <input type="text" class="form-control" id="LICENCIAS_CURSO" name="LICENCIAS_CURSO">
                            </div>
                        </div>

                        <div class="col-3 mt-3">
                            <div class="form-group">
                                <label>Costo por participante </label>
                                <input type="text" class="form-control" id="COSTO_PARTICIPANTE" name="COSTO_PARTICIPANTE">
                            </div>
                        </div>

                        <div class="row mt-5">
                            <div class="col-12 text-center">
                                <div style="display: inline-flex; align-items: center; gap: 10px;">
                                    <h4 style="margin: 0;">8. Gestión operativa del curso </h4>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-5">
                            <div class="col-12 text-center">
                                <div style="display: inline-flex; align-items: center; gap: 10px;">
                                    <h6 style="margin: 0;">Frecuencia </h6>
                                </div>
                            </div>
                        </div>

                        <div class="col-6 mt-3">
                            <div class="form-group">
                                <label>Bajo demanda </label>
                                <input type="text" class="form-control" id="BAJO_DEMANDA" name="BAJO_DEMANDA">
                            </div>
                        </div>

                        <div class="col-6 mt-3">
                            <div class="form-group">
                                <label>Programado y cada cuanto </label>
                                <input type="text" class="form-control" id="PROGRAMADO_CADACUANTO" name="PROGRAMADO_CADACUANTO">
                            </div>
                        </div>

                        <div class="col-6 mt-3">
                            <div class="form-group">
                                <label>Capacidad mínima por curso</label>
                                <input type="text" class="form-control" id="CAPACIDAD_MINIMA" name="CAPACIDAD_MINIMA">
                            </div>
                        </div>

                        <div class="col-6 mt-3">
                            <div class="form-group">
                                <label>Capacidad máxima por curso</label>
                                <input type="text" class="form-control" id="CAPACIDAD_MAXIMA" name="CAPACIDAD_MAXIMA">
                            </div>
                        </div>

                        <div class="col-6 mt-3">
                            <div class="form-group">
                                <label>Ubicación </label>
                                <select class="form-select" id="UBICACION_CURSO" name="UBICACION_CURSO[]" multiple>
                                    <option value=""></option>
                                    @foreach ($ubicacion as $catalogo)
                                    <option value="{{ $catalogo->ID_UBICACION }}">{{ $catalogo->NOMBRE_UBICACION }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-6 mt-3">
                            <div class="form-group">
                                <label>Material didáctico </label>
                                <select class="form-select" id="MATERIAL_DIDACTICO" name="MATERIAL_DIDACTICO[]" multiple>
                                    <option value=""></option>
                                    @foreach ($materialesdidactico as $catalogo)
                                    <option value="{{ $catalogo->ID_MATERIAL_DIDACTICO }}">{{ $catalogo->MATERIAL_DIDACTICO }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-6 mt-3">
                            <div class="form-group">
                                <label>Versión del curso</label>
                                <input type="text" class="form-control" id="VERSION_CURSO" name="VERSION_CURSO">
                            </div>
                        </div>

                        <div class="col-6 mt-3">
                            <div class="form-group">
                                <label>Estatus *</label>
                                <select class="form-select" id="ESTATUS_CURSO" name="ESTATUS_CURSO">
                                    <option value="" disabled selected>Seleccione una opción</option>
                                    <option value="1">Activo</option>
                                    <option value="2">Inactivo</option>
                                    <option value="3">En revisión</option>
                                    <option value="4">Obsoleto</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mt-5">
                            <div class="col-12 text-center">
                                <div style="display: inline-flex; align-items: center; gap: 10px;">
                                    <h4 style="margin: 0;">9. Indicadores y mejora continua</h4>
                                </div>
                            </div>
                        </div>


                        <div class="col-6 mt-3">
                            <div class="form-group">
                                <label>Evaluación de curso</label>
                                <textarea class="form-control" id="EVALUACION_CURSO" name="EVALUACION_CURSO" rows="3"></textarea>
                            </div>
                        </div>

                        <div class="col-6 mt-3">
                            <div class="form-group">
                                <label>Evaluación de instructor</label>
                                <textarea class="form-control" id="EVALUACION_INSTRUCTOR" name="EVALUACION_INSTRUCTOR" rows="3"></textarea>
                            </div>
                        </div>

                        <div class="col-12 mt-3">
                            <div class="form-group">
                                <label>Impacto esperado </label>
                                <select class="form-select" id="IMPACTO_ESPERADO" name="IMPACTO_ESPERADO[]" multiple>
                                    <option value=""></option>
                                    @foreach ($impactoesperado as $catalogo)
                                    <option value="{{ $catalogo->ID_IMPACTO_ESPERADO }}">{{ $catalogo->IMPACTO_ESPERADO }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>



                        <div class="col-12 mt-4">
                            <div class="form-group">
                                <label> Lecciones aprendidas</label>
                                <button type="button" class="btn btn-danger ml-2 rounded-pill" id="botonagregarlecciones">
                                    <i class="bi bi-plus-circle-fill"></i>
                                </button>
                            </div>
                        </div>

                        <div class="col-12 mt-3">
                            <div class="leccionesaprendidas">
                            </div>
                        </div>


                        <div class="col-12">
                            <div class="form-group">
                                <label> Observaciones</label>
                                <button type="button" class="btn btn-danger ml-2 rounded-pill" id="botonagregarobservaciones">
                                    <i class="bi bi-plus-circle-fill"></i>
                                </button>
                            </div>
                        </div>

                        <div class="col-12 mt-3">
                            <div class="observacionescurso">
                            </div>
                        </div>






                        <!-- 
                        <div class="col-6 mt-3">
                            <div class="form-group">
                                <label>Lecciones aprendidas</label>
                                <textarea class="form-control" id="LECCIONES_APRENDIDAS" name="LECCIONES_APRENDIDAS" rows="3"></textarea>
                            </div>
                        </div> -->

                        <!-- <div class="col-6 mt-3">
                            <div class="form-group">
                                <label>Observaciones</label>
                                <textarea class="form-control" id="OBSERVACIONES_CURSO" name="OBSERVACIONES_CURSO" rows="3"></textarea>
                            </div>
                        </div> -->


                    </div>
                </div>
                <div class="modal-footer mt-5">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-success" id="guardarcursos"><i class="bi bi-floppy-fill" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Guardar curso"></i> Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>



<script>
    window.lineas = @json($lineas);
</script>




@endsection
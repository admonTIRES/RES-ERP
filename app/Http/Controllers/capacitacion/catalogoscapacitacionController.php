<?php

namespace App\Http\Controllers\capacitacion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Artisan;
use Exception;

use DB;


//Modelos

use App\Models\capacitacion\tipocursoModel;
use App\Models\capacitacion\areaconocimientoModel;
use App\Models\capacitacion\modalidadModel;
use App\Models\capacitacion\formatoModel;
use App\Models\capacitacion\paisregionModel;
use App\Models\capacitacion\idiomaModel;
use App\Models\capacitacion\normatividadModel;
use App\Models\capacitacion\reconocimientoModel;
use App\Models\capacitacion\competenciaModel;
use App\Models\capacitacion\tipoproveedorModel;
use App\Models\capacitacion\metodoevaluacionModel;
use App\Models\capacitacion\evidenciageneradaModel;
use App\Models\capacitacion\ubicacionModel;
use App\Models\capacitacion\materialdidacticoModel;
use App\Models\capacitacion\impactoesparadoModel;
use App\Models\capacitacion\documentosemitidosModel;
use App\Models\capacitacion\monedaModel;
use App\Models\capacitacion\lineanegocioModel;



class catalogoscapacitacionController extends Controller
{



    /// TABLA TIPO DE CURSO
    public function Tablacaptipocurso()
    {
        try {
            $tabla = tipocursoModel::get();

            foreach ($tabla as $value) {
                if ($value->ACTIVO == 0) {
                    $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
                    $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_TIPO_CURSO . '"><span class="slider round"></span></label>';
                    $value->BTN_EDITAR = '<button type="button" class="btn btn-secondary btn-custom rounded-pill EDITAR" disabled><i class="bi bi-ban"></i></button>';
                } else {
                    $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_TIPO_CURSO . '" checked><span class="slider round"></span></label>';
                    $value->BTN_EDITAR = '<button type="button" class="btn btn-warning btn-custom rounded-pill EDITAR"><i class="bi bi-pencil-square"></i></button>';
                    $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
                }
            }
            return response()->json([
                'data' => $tabla,
                'msj' => 'Información consultada correctamente'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'msj' => 'Error ' . $e->getMessage(),
                'data' => 0
            ]);
        }
    }

    /// TABLA AREA DE CONOCIMIENTO
    public function Tablacapareaconocimiento()
    {
        try {
            $tabla = areaconocimientoModel::get();

            foreach ($tabla as $value) {
                if ($value->ACTIVO == 0) {
                    $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
                    $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_AREA_CONOCIMIENTO . '"><span class="slider round"></span></label>';
                    $value->BTN_EDITAR = '<button type="button" class="btn btn-secondary btn-custom rounded-pill EDITAR" disabled><i class="bi bi-ban"></i></button>';
                } else {
                    $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_AREA_CONOCIMIENTO . '" checked><span class="slider round"></span></label>';
                    $value->BTN_EDITAR = '<button type="button" class="btn btn-warning btn-custom rounded-pill EDITAR"><i class="bi bi-pencil-square"></i></button>';
                    $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
                }
            }
            return response()->json([
                'data' => $tabla,
                'msj' => 'Información consultada correctamente'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'msj' => 'Error ' . $e->getMessage(),
                'data' => 0
            ]);
        }
    }

    /// TABLA MODALIDAD
    public function Tablacapmodalidad()
    {
        try {
            $tabla = modalidadModel::get();

            foreach ($tabla as $value) {
                if ($value->ACTIVO == 0) {
                    $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
                    $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_MODALIDAD . '"><span class="slider round"></span></label>';
                    $value->BTN_EDITAR = '<button type="button" class="btn btn-secondary btn-custom rounded-pill EDITAR" disabled><i class="bi bi-ban"></i></button>';
                } else {
                    $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_MODALIDAD . '" checked><span class="slider round"></span></label>';
                    $value->BTN_EDITAR = '<button type="button" class="btn btn-warning btn-custom rounded-pill EDITAR"><i class="bi bi-pencil-square"></i></button>';
                    $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
                }
            }
            return response()->json([
                'data' => $tabla,
                'msj' => 'Información consultada correctamente'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'msj' => 'Error ' . $e->getMessage(),
                'data' => 0
            ]);
        }
    }

    /// TABLA FORMATO
    public function Tablacapformato()
    {
        try {
            $tabla = formatoModel::get();

            foreach ($tabla as $value) {
                if ($value->ACTIVO == 0) {
                    $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
                    $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_FORMATO . '"><span class="slider round"></span></label>';
                    $value->BTN_EDITAR = '<button type="button" class="btn btn-secondary btn-custom rounded-pill EDITAR" disabled><i class="bi bi-ban"></i></button>';
                } else {
                    $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_FORMATO . '" checked><span class="slider round"></span></label>';
                    $value->BTN_EDITAR = '<button type="button" class="btn btn-warning btn-custom rounded-pill EDITAR"><i class="bi bi-pencil-square"></i></button>';
                    $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
                }
            }
            return response()->json([
                'data' => $tabla,
                'msj' => 'Información consultada correctamente'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'msj' => 'Error ' . $e->getMessage(),
                'data' => 0
            ]);
        }
    }

    /// TABLA PAIS O REGION 
    public function Tablacappaisoregion()
    {
        try {
            $tabla = paisregionModel::get();

            foreach ($tabla as $value) {
                if ($value->ACTIVO == 0) {
                    $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
                    $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_PAIS_REGION . '"><span class="slider round"></span></label>';
                    $value->BTN_EDITAR = '<button type="button" class="btn btn-secondary btn-custom rounded-pill EDITAR" disabled><i class="bi bi-ban"></i></button>';
                } else {
                    $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_PAIS_REGION . '" checked><span class="slider round"></span></label>';
                    $value->BTN_EDITAR = '<button type="button" class="btn btn-warning btn-custom rounded-pill EDITAR"><i class="bi bi-pencil-square"></i></button>';
                    $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
                }
            }
            return response()->json([
                'data' => $tabla,
                'msj' => 'Información consultada correctamente'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'msj' => 'Error ' . $e->getMessage(),
                'data' => 0
            ]);
        }
    }

    /// TABLA  IDIOMA
    public function Tablacapidioma()
    {
        try {
            $tabla = idiomaModel::get();

            foreach ($tabla as $value) {
                if ($value->ACTIVO == 0) {
                    $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
                    $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_IDIOMAS . '"><span class="slider round"></span></label>';
                    $value->BTN_EDITAR = '<button type="button" class="btn btn-secondary btn-custom rounded-pill EDITAR" disabled><i class="bi bi-ban"></i></button>';
                } else {
                    $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_IDIOMAS . '" checked><span class="slider round"></span></label>';
                    $value->BTN_EDITAR = '<button type="button" class="btn btn-warning btn-custom rounded-pill EDITAR"><i class="bi bi-pencil-square"></i></button>';
                    $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
                }
            }
            return response()->json([
                'data' => $tabla,
                'msj' => 'Información consultada correctamente'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'msj' => 'Error ' . $e->getMessage(),
                'data' => 0
            ]);
        }
    }

    /// TABLA  NORMATIVIDAD O MARCO DE REFERENCIA 
    public function Tablacapnormatividad()
    {
        try {
            $tabla = normatividadModel::get();

            foreach ($tabla as $value) {
                if ($value->ACTIVO == 0) {
                    $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
                    $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_NORMATIVIDAD_MARCO . '"><span class="slider round"></span></label>';
                    $value->BTN_EDITAR = '<button type="button" class="btn btn-secondary btn-custom rounded-pill EDITAR" disabled><i class="bi bi-ban"></i></button>';
                } else {
                    $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_NORMATIVIDAD_MARCO . '" checked><span class="slider round"></span></label>';
                    $value->BTN_EDITAR = '<button type="button" class="btn btn-warning btn-custom rounded-pill EDITAR"><i class="bi bi-pencil-square"></i></button>';
                    $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
                }
            }
            return response()->json([
                'data' => $tabla,
                'msj' => 'Información consultada correctamente'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'msj' => 'Error ' . $e->getMessage(),
                'data' => 0
            ]);
        }
    }

    /// TABLA  RECONOCIMIENTO
    public function Tablacapreconocimiento()
    {
        try {
            $tabla = reconocimientoModel::get();

            foreach ($tabla as $value) {
                if ($value->ACTIVO == 0) {
                    $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
                    $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_RECONOCIMIENTO . '"><span class="slider round"></span></label>';
                    $value->BTN_EDITAR = '<button type="button" class="btn btn-secondary btn-custom rounded-pill EDITAR" disabled><i class="bi bi-ban"></i></button>';
                } else {
                    $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_RECONOCIMIENTO . '" checked><span class="slider round"></span></label>';
                    $value->BTN_EDITAR = '<button type="button" class="btn btn-warning btn-custom rounded-pill EDITAR"><i class="bi bi-pencil-square"></i></button>';
                    $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
                }
            }
            return response()->json([
                'data' => $tabla,
                'msj' => 'Información consultada correctamente'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'msj' => 'Error ' . $e->getMessage(),
                'data' => 0
            ]);
        }
    }

    /// TABLA  COMPETENCIA
    public function Tablacapcompetencias()
    {
        try {
            $tabla = competenciaModel::get();

            foreach ($tabla as $value) {
                if ($value->ACTIVO == 0) {
                    $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
                    $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_COMPETENCIA_DESARROLLA . '"><span class="slider round"></span></label>';
                    $value->BTN_EDITAR = '<button type="button" class="btn btn-secondary btn-custom rounded-pill EDITAR" disabled><i class="bi bi-ban"></i></button>';
                } else {
                    $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_COMPETENCIA_DESARROLLA . '" checked><span class="slider round"></span></label>';
                    $value->BTN_EDITAR = '<button type="button" class="btn btn-warning btn-custom rounded-pill EDITAR"><i class="bi bi-pencil-square"></i></button>';
                    $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
                }
            }
            return response()->json([
                'data' => $tabla,
                'msj' => 'Información consultada correctamente'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'msj' => 'Error ' . $e->getMessage(),
                'data' => 0
            ]);
        }
    }

    /// TABLA  TIPO PROVEEDOR
    public function Tablacaptipoproveedor()
    {
        try {
            $tabla = tipoproveedorModel::get();

            foreach ($tabla as $value) {
                if ($value->ACTIVO == 0) {
                    $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
                    $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_TIPO_PROVEEDOR . '"><span class="slider round"></span></label>';
                    $value->BTN_EDITAR = '<button type="button" class="btn btn-secondary btn-custom rounded-pill EDITAR" disabled><i class="bi bi-ban"></i></button>';
                } else {
                    $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_TIPO_PROVEEDOR . '" checked><span class="slider round"></span></label>';
                    $value->BTN_EDITAR = '<button type="button" class="btn btn-warning btn-custom rounded-pill EDITAR"><i class="bi bi-pencil-square"></i></button>';
                    $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
                }
            }
            return response()->json([
                'data' => $tabla,
                'msj' => 'Información consultada correctamente'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'msj' => 'Error ' . $e->getMessage(),
                'data' => 0
            ]);
        }
    }

    /// TABLA  METODO DE EVALUACION
    public function Tablacapmetodoevaluacion()
    {
        try {
            $tabla = metodoevaluacionModel::get();

            foreach ($tabla as $value) {
                if ($value->ACTIVO == 0) {
                    $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
                    $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_METODO_EVALUACION . '"><span class="slider round"></span></label>';
                    $value->BTN_EDITAR = '<button type="button" class="btn btn-secondary btn-custom rounded-pill EDITAR" disabled><i class="bi bi-ban"></i></button>';
                } else {
                    $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_METODO_EVALUACION . '" checked><span class="slider round"></span></label>';
                    $value->BTN_EDITAR = '<button type="button" class="btn btn-warning btn-custom rounded-pill EDITAR"><i class="bi bi-pencil-square"></i></button>';
                    $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
                }
            }
            return response()->json([
                'data' => $tabla,
                'msj' => 'Información consultada correctamente'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'msj' => 'Error ' . $e->getMessage(),
                'data' => 0
            ]);
        }
    }

    /// TABLA  EVIDENCIAS GENERADAS
    public function Tablacapevidenciasgeneradas()
    {
        try {
            $tabla = evidenciageneradaModel::get();

            foreach ($tabla as $value) {
                if ($value->ACTIVO == 0) {
                    $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
                    $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_EVIDENCIA_GENERADAS . '"><span class="slider round"></span></label>';
                    $value->BTN_EDITAR = '<button type="button" class="btn btn-secondary btn-custom rounded-pill EDITAR" disabled><i class="bi bi-ban"></i></button>';
                } else {
                    $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_EVIDENCIA_GENERADAS . '" checked><span class="slider round"></span></label>';
                    $value->BTN_EDITAR = '<button type="button" class="btn btn-warning btn-custom rounded-pill EDITAR"><i class="bi bi-pencil-square"></i></button>';
                    $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
                }
            }
            return response()->json([
                'data' => $tabla,
                'msj' => 'Información consultada correctamente'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'msj' => 'Error ' . $e->getMessage(),
                'data' => 0
            ]);
        }
    }

    /// TABLA UBICACION
    public function Tablacapubicacion()
    {
        try {
            $tabla = ubicacionModel::get();

            foreach ($tabla as $value) {
                if ($value->ACTIVO == 0) {
                    $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
                    $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_UBICACION . '"><span class="slider round"></span></label>';
                    $value->BTN_EDITAR = '<button type="button" class="btn btn-secondary btn-custom rounded-pill EDITAR" disabled><i class="bi bi-ban"></i></button>';
                } else {
                    $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_UBICACION . '" checked><span class="slider round"></span></label>';
                    $value->BTN_EDITAR = '<button type="button" class="btn btn-warning btn-custom rounded-pill EDITAR"><i class="bi bi-pencil-square"></i></button>';
                    $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
                }
            }
            return response()->json([
                'data' => $tabla,
                'msj' => 'Información consultada correctamente'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'msj' => 'Error ' . $e->getMessage(),
                'data' => 0
            ]);
        }
    }

    /// TABLA MATERIAL DIDACTICO 
    public function Tablacapmaterialdidactico()
    {
        try {
            $tabla = materialdidacticoModel::get();

            foreach ($tabla as $value) {
                if ($value->ACTIVO == 0) {
                    $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
                    $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_MATERIAL_DIDACTICO . '"><span class="slider round"></span></label>';
                    $value->BTN_EDITAR = '<button type="button" class="btn btn-secondary btn-custom rounded-pill EDITAR" disabled><i class="bi bi-ban"></i></button>';
                } else {
                    $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_MATERIAL_DIDACTICO . '" checked><span class="slider round"></span></label>';
                    $value->BTN_EDITAR = '<button type="button" class="btn btn-warning btn-custom rounded-pill EDITAR"><i class="bi bi-pencil-square"></i></button>';
                    $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
                }
            }
            return response()->json([
                'data' => $tabla,
                'msj' => 'Información consultada correctamente'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'msj' => 'Error ' . $e->getMessage(),
                'data' => 0
            ]);
        }
    }

    /// TABLA IMPACTO ESPERADO 
    public function Tablacapimpactoesperado()
    {
        try {
            $tabla = impactoesparadoModel::get();

            foreach ($tabla as $value) {
                if ($value->ACTIVO == 0) {
                    $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
                    $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_IMPACTO_ESPERADO . '"><span class="slider round"></span></label>';
                    $value->BTN_EDITAR = '<button type="button" class="btn btn-secondary btn-custom rounded-pill EDITAR" disabled><i class="bi bi-ban"></i></button>';
                } else {
                    $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_IMPACTO_ESPERADO . '" checked><span class="slider round"></span></label>';
                    $value->BTN_EDITAR = '<button type="button" class="btn btn-warning btn-custom rounded-pill EDITAR"><i class="bi bi-pencil-square"></i></button>';
                    $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
                }
            }
            return response()->json([
                'data' => $tabla,
                'msj' => 'Información consultada correctamente'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'msj' => 'Error ' . $e->getMessage(),
                'data' => 0
            ]);
        }
    }

    /// TABLA DOCUMENTOS EMITIDO 
    public function Tablacapemitidos()
    {
        try {
            $tabla = documentosemitidosModel::get();

            foreach ($tabla as $value) {
                if ($value->ACTIVO == 0) {
                    $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
                    $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_DOCUMENTOS_EMITIDOS . '"><span class="slider round"></span></label>';
                    $value->BTN_EDITAR = '<button type="button" class="btn btn-secondary btn-custom rounded-pill EDITAR" disabled><i class="bi bi-ban"></i></button>';
                } else {
                    $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_DOCUMENTOS_EMITIDOS . '" checked><span class="slider round"></span></label>';
                    $value->BTN_EDITAR = '<button type="button" class="btn btn-warning btn-custom rounded-pill EDITAR"><i class="bi bi-pencil-square"></i></button>';
                    $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
                }
            }
            return response()->json([
                'data' => $tabla,
                'msj' => 'Información consultada correctamente'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'msj' => 'Error ' . $e->getMessage(),
                'data' => 0
            ]);
        }
    }

    /// TABLA MONEDA 
    public function Tablacapmoneda()
    {
        try {
            $tabla = monedaModel::get();

            foreach ($tabla as $value) {
                if ($value->ACTIVO == 0) {
                    $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
                    $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_MONEDA . '"><span class="slider round"></span></label>';
                    $value->BTN_EDITAR = '<button type="button" class="btn btn-secondary btn-custom rounded-pill EDITAR" disabled><i class="bi bi-ban"></i></button>';
                } else {
                    $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_MONEDA . '" checked><span class="slider round"></span></label>';
                    $value->BTN_EDITAR = '<button type="button" class="btn btn-warning btn-custom rounded-pill EDITAR"><i class="bi bi-pencil-square"></i></button>';
                    $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
                }
            }
            return response()->json([
                'data' => $tabla,
                'msj' => 'Información consultada correctamente'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'msj' => 'Error ' . $e->getMessage(),
                'data' => 0
            ]);
        }
    }

    /// TABLA LINEA DE NEGOCIOS 
    public function Tablacaplineanegocios()
    {
        try {
            $tabla = lineanegocioModel::get();

            foreach ($tabla as $value) {
                if ($value->ACTIVO == 0) {
                    $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
                    $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_LINEA_NEGOCIO . '"><span class="slider round"></span></label>';
                    $value->BTN_EDITAR = '<button type="button" class="btn btn-secondary btn-custom rounded-pill EDITAR" disabled><i class="bi bi-ban"></i></button>';
                } else {
                    $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_LINEA_NEGOCIO . '" checked><span class="slider round"></span></label>';
                    $value->BTN_EDITAR = '<button type="button" class="btn btn-warning btn-custom rounded-pill EDITAR"><i class="bi bi-pencil-square"></i></button>';
                    $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
                }
            }
            return response()->json([
                'data' => $tabla,
                'msj' => 'Información consultada correctamente'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'msj' => 'Error ' . $e->getMessage(),
                'data' => 0
            ]);
        }
    }
    public function store(Request $request)
    {

        try {
            switch (intval($request->api)) {

            /// TIPO CURSO 
                case 1:
                    if ($request->ID_TIPO_CURSO == 0) {
                        DB::statement('ALTER TABLE capacitacion_tipocurso AUTO_INCREMENT=1;');
                        $capacitacion = tipocursoModel::create($request->all());
                    } else {
                        if (isset($request->ELIMINAR)) {
                            if ($request->ELIMINAR == 1) {
                                $capacitacion = tipocursoModel::where('ID_TIPO_CURSO', $request['ID_TIPO_CURSO'])->update(['ACTIVO' => 0]);
                                $response['code'] = 1;
                                $response['capacitaciones'] = 'Desactivada';
                            } else {
                                $capacitacion = tipocursoModel::where('ID_TIPO_CURSO', $request['ID_TIPO_CURSO'])->update(['ACTIVO' => 1]);
                                $response['code'] = 1;
                                $response['capacitaciones'] = 'Activada';
                            }
                        } else {
                            $capacitacion = tipocursoModel::find($request->ID_TIPO_CURSO);
                            $capacitacion->update($request->all());
                            $response['code'] = 1;
                            $response['capacitaciones'] = 'Actualizada';
                        }
                        return response()->json($response);
                    }
                    $response['code']  = 1;
                    $response['capacitaciones']  = $capacitacion;
                    return response()->json($response);
                    break;

                ///  AREA CONOCIMIENTO
                case 2:
                    if ($request->ID_AREA_CONOCIMIENTO == 0) {
                        DB::statement('ALTER TABLE capacitacion_areaconocimiento AUTO_INCREMENT=1;');
                        $capacitacion = areaconocimientoModel::create($request->all());
                    } else {
                        if (isset($request->ELIMINAR)) {
                            if ($request->ELIMINAR == 1) {
                                $capacitacion = areaconocimientoModel::where('ID_AREA_CONOCIMIENTO', $request['ID_AREA_CONOCIMIENTO'])->update(['ACTIVO' => 0]);
                                $response['code'] = 1;
                                $response['capacitaciones'] = 'Desactivada';
                            } else {
                                $capacitacion = areaconocimientoModel::where('ID_AREA_CONOCIMIENTO', $request['ID_AREA_CONOCIMIENTO'])->update(['ACTIVO' => 1]);
                                $response['code'] = 1;
                                $response['capacitaciones'] = 'Activada';
                            }
                        } else {
                            $capacitacion = areaconocimientoModel::find($request->ID_AREA_CONOCIMIENTO);
                            $capacitacion->update($request->all());
                            $response['code'] = 1;
                            $response['capacitaciones'] = 'Actualizada';
                        }
                        return response()->json($response);
                    }
                    $response['code']  = 1;
                    $response['capacitaciones']  = $capacitacion;
                    return response()->json($response);
                    break;

                /// MODALIDAD 
                case 3:
                    if ($request->ID_MODALIDAD == 0) {
                        DB::statement('ALTER TABLE capacitacion_modalidad AUTO_INCREMENT=1;');
                        $capacitacion = modalidadModel::create($request->all());
                    } else {
                        if (isset($request->ELIMINAR)) {
                            if ($request->ELIMINAR == 1) {
                                $capacitacion = modalidadModel::where('ID_MODALIDAD', $request['ID_MODALIDAD'])->update(['ACTIVO' => 0]);
                                $response['code'] = 1;
                                $response['capacitaciones'] = 'Desactivada';
                            } else {
                                $capacitacion = modalidadModel::where('ID_MODALIDAD', $request['ID_MODALIDAD'])->update(['ACTIVO' => 1]);
                                $response['code'] = 1;
                                $response['capacitaciones'] = 'Activada';
                            }
                        } else {
                            $capacitacion = modalidadModel::find($request->ID_MODALIDAD);
                            $capacitacion->update($request->all());
                            $response['code'] = 1;
                            $response['capacitaciones'] = 'Actualizada';
                        }
                        return response()->json($response);
                    }
                    $response['code']  = 1;
                    $response['capacitaciones']  = $capacitacion;
                    return response()->json($response);
                    break;

                /// FORMATO 
                case 4:
                    if ($request->ID_FORMATO == 0) {
                        DB::statement('ALTER TABLE capacitacion_formato AUTO_INCREMENT=1;');
                        $capacitacion = formatoModel::create($request->all());
                    } else {
                        if (isset($request->ELIMINAR)) {
                            if ($request->ELIMINAR == 1) {
                                $capacitacion = formatoModel::where('ID_FORMATO', $request['ID_FORMATO'])->update(['ACTIVO' => 0]);
                                $response['code'] = 1;
                                $response['capacitaciones'] = 'Desactivada';
                            } else {
                                $capacitacion = formatoModel::where('ID_FORMATO', $request['ID_FORMATO'])->update(['ACTIVO' => 1]);
                                $response['code'] = 1;
                                $response['capacitaciones'] = 'Activada';
                            }
                        } else {
                            $capacitacion = formatoModel::find($request->ID_FORMATO);
                            $capacitacion->update($request->all());
                            $response['code'] = 1;
                            $response['capacitaciones'] = 'Actualizada';
                        }
                        return response()->json($response);
                    }
                    $response['code']  = 1;
                    $response['capacitaciones']  = $capacitacion;
                    return response()->json($response);
                    break;

                /// PAIS O REGION  
                case 5:
                    if ($request->ID_PAIS_REGION == 0) {
                        DB::statement('ALTER TABLE capacitacion_paisregion AUTO_INCREMENT=1;');
                        $capacitacion = paisregionModel::create($request->all());
                    } else {
                        if (isset($request->ELIMINAR)) {
                            if ($request->ELIMINAR == 1) {
                                $capacitacion = paisregionModel::where('ID_PAIS_REGION', $request['ID_PAIS_REGION'])->update(['ACTIVO' => 0]);
                                $response['code'] = 1;
                                $response['capacitaciones'] = 'Desactivada';
                            } else {
                                $capacitacion = paisregionModel::where('ID_PAIS_REGION', $request['ID_PAIS_REGION'])->update(['ACTIVO' => 1]);
                                $response['code'] = 1;
                                $response['capacitaciones'] = 'Activada';
                            }
                        } else {
                            $capacitacion = paisregionModel::find($request->ID_PAIS_REGION);
                            $capacitacion->update($request->all());
                            $response['code'] = 1;
                            $response['capacitaciones'] = 'Actualizada';
                        }
                        return response()->json($response);
                    }
                    $response['code']  = 1;
                    $response['capacitaciones']  = $capacitacion;
                    return response()->json($response);
                    break;

                /// IDIOMA
                case 6:
                    if ($request->ID_IDIOMAS == 0) {
                        DB::statement('ALTER TABLE capacitacion_idiomas AUTO_INCREMENT=1;');
                        $capacitacion = idiomaModel::create($request->all());
                    } else {
                        if (isset($request->ELIMINAR)) {
                            if ($request->ELIMINAR == 1) {
                                $capacitacion = idiomaModel::where('ID_IDIOMAS', $request['ID_IDIOMAS'])->update(['ACTIVO' => 0]);
                                $response['code'] = 1;
                                $response['capacitaciones'] = 'Desactivada';
                            } else {
                                $capacitacion = idiomaModel::where('ID_IDIOMAS', $request['ID_IDIOMAS'])->update(['ACTIVO' => 1]);
                                $response['code'] = 1;
                                $response['capacitaciones'] = 'Activada';
                            }
                        } else {
                            $capacitacion = idiomaModel::find($request->ID_IDIOMAS);
                            $capacitacion->update($request->all());
                            $response['code'] = 1;
                            $response['capacitaciones'] = 'Actualizada';
                        }
                        return response()->json($response);
                    }
                    $response['code']  = 1;
                    $response['capacitaciones']  = $capacitacion;
                    return response()->json($response);
                    break;

                /// NORMATIVIDAD O MARCO DE REFERENCIA 
                case 7:
                    if ($request->ID_NORMATIVIDAD_MARCO == 0) {
                        DB::statement('ALTER TABLE capacitacion_normatividad AUTO_INCREMENT=1;');
                        $capacitacion = normatividadModel::create($request->all());
                    } else {
                        if (isset($request->ELIMINAR)) {
                            if ($request->ELIMINAR == 1) {
                                $capacitacion = normatividadModel::where('ID_NORMATIVIDAD_MARCO', $request['ID_NORMATIVIDAD_MARCO'])->update(['ACTIVO' => 0]);
                                $response['code'] = 1;
                                $response['capacitaciones'] = 'Desactivada';
                            } else {
                                $capacitacion = normatividadModel::where('ID_NORMATIVIDAD_MARCO', $request['ID_NORMATIVIDAD_MARCO'])->update(['ACTIVO' => 1]);
                                $response['code'] = 1;
                                $response['capacitaciones'] = 'Activada';
                            }
                        } else {
                            $capacitacion = normatividadModel::find($request->ID_NORMATIVIDAD_MARCO);
                            $capacitacion->update($request->all());
                            $response['code'] = 1;
                            $response['capacitaciones'] = 'Actualizada';
                        }
                        return response()->json($response);
                    }
                    $response['code']  = 1;
                    $response['capacitaciones']  = $capacitacion;
                    return response()->json($response);
                    break;

                /// RECONOCIMIENTO
                case 8:
                    if ($request->ID_RECONOCIMIENTO == 0) {
                        DB::statement('ALTER TABLE capacitacion_reconocimiento AUTO_INCREMENT=1;');
                        $capacitacion = reconocimientoModel::create($request->all());
                    } else {
                        if (isset($request->ELIMINAR)) {
                            if ($request->ELIMINAR == 1) {
                                $capacitacion = reconocimientoModel::where('ID_RECONOCIMIENTO', $request['ID_RECONOCIMIENTO'])->update(['ACTIVO' => 0]);
                                $response['code'] = 1;
                                $response['capacitaciones'] = 'Desactivada';
                            } else {
                                $capacitacion = reconocimientoModel::where('ID_RECONOCIMIENTO', $request['ID_RECONOCIMIENTO'])->update(['ACTIVO' => 1]);
                                $response['code'] = 1;
                                $response['capacitaciones'] = 'Activada';
                            }
                        } else {
                            $capacitacion = reconocimientoModel::find($request->ID_RECONOCIMIENTO);
                            $capacitacion->update($request->all());
                            $response['code'] = 1;
                            $response['capacitaciones'] = 'Actualizada';
                        }
                        return response()->json($response);
                    }
                    $response['code']  = 1;
                    $response['capacitaciones']  = $capacitacion;
                    return response()->json($response);
                    break;

                /// COMPETENCIA
                case 9:
                    if ($request->ID_COMPETENCIA_DESARROLLA == 0) {
                        DB::statement('ALTER TABLE capacitacion_competencia AUTO_INCREMENT=1;');
                        $capacitacion = competenciaModel::create($request->all());
                    } else {
                        if (isset($request->ELIMINAR)) {
                            if ($request->ELIMINAR == 1) {
                                $capacitacion = competenciaModel::where('ID_COMPETENCIA_DESARROLLA', $request['ID_COMPETENCIA_DESARROLLA'])->update(['ACTIVO' => 0]);
                                $response['code'] = 1;
                                $response['capacitaciones'] = 'Desactivada';
                            } else {
                                $capacitacion = competenciaModel::where('ID_COMPETENCIA_DESARROLLA', $request['ID_COMPETENCIA_DESARROLLA'])->update(['ACTIVO' => 1]);
                                $response['code'] = 1;
                                $response['capacitaciones'] = 'Activada';
                            }
                        } else {
                            $capacitacion = competenciaModel::find($request->ID_COMPETENCIA_DESARROLLA);
                            $capacitacion->update($request->all());
                            $response['code'] = 1;
                            $response['capacitaciones'] = 'Actualizada';
                        }
                        return response()->json($response);
                    }
                    $response['code']  = 1;
                    $response['capacitaciones']  = $capacitacion;
                    return response()->json($response);
                    break;

                /// TIPO PROVEEDOR
                case 10:
                    if ($request->ID_TIPO_PROVEEDOR == 0) {
                        DB::statement('ALTER TABLE capacitacion_tipoproveedor AUTO_INCREMENT=1;');
                        $capacitacion = tipoproveedorModel::create($request->all());
                    } else {
                        if (isset($request->ELIMINAR)) {
                            if ($request->ELIMINAR == 1) {
                                $capacitacion = tipoproveedorModel::where('ID_TIPO_PROVEEDOR', $request['ID_TIPO_PROVEEDOR'])->update(['ACTIVO' => 0]);
                                $response['code'] = 1;
                                $response['capacitaciones'] = 'Desactivada';
                            } else {
                                $capacitacion = tipoproveedorModel::where('ID_TIPO_PROVEEDOR', $request['ID_TIPO_PROVEEDOR'])->update(['ACTIVO' => 1]);
                                $response['code'] = 1;
                                $response['capacitaciones'] = 'Activada';
                            }
                        } else {
                            $capacitacion = tipoproveedorModel::find($request->ID_TIPO_PROVEEDOR);
                            $capacitacion->update($request->all());
                            $response['code'] = 1;
                            $response['capacitaciones'] = 'Actualizada';
                        }
                        return response()->json($response);
                    }
                    $response['code']  = 1;
                    $response['capacitaciones']  = $capacitacion;
                    return response()->json($response);
                    break;

                /// METODO DE EVALUACION
                case 11:
                    if ($request->ID_METODO_EVALUACION == 0) {
                        DB::statement('ALTER TABLE capacitacion_metodoevaluacion AUTO_INCREMENT=1;');
                        $capacitacion = metodoevaluacionModel::create($request->all());
                    } else {
                        if (isset($request->ELIMINAR)) {
                            if ($request->ELIMINAR == 1) {
                                $capacitacion = metodoevaluacionModel::where('ID_METODO_EVALUACION', $request['ID_METODO_EVALUACION'])->update(['ACTIVO' => 0]);
                                $response['code'] = 1;
                                $response['capacitaciones'] = 'Desactivada';
                            } else {
                                $capacitacion = metodoevaluacionModel::where('ID_METODO_EVALUACION', $request['ID_METODO_EVALUACION'])->update(['ACTIVO' => 1]);
                                $response['code'] = 1;
                                $response['capacitaciones'] = 'Activada';
                            }
                        } else {
                            $capacitacion = metodoevaluacionModel::find($request->ID_METODO_EVALUACION);
                            $capacitacion->update($request->all());
                            $response['code'] = 1;
                            $response['capacitaciones'] = 'Actualizada';
                        }
                        return response()->json($response);
                    }
                    $response['code']  = 1;
                    $response['capacitaciones']  = $capacitacion;
                    return response()->json($response);
                    break;

                ///  EVIDENCIAS GENERADAS 
                case 12:
                    if ($request->ID_EVIDENCIA_GENERADAS == 0) {
                        DB::statement('ALTER TABLE capacitacion_evidenciageneradas AUTO_INCREMENT=1;');
                        $capacitacion = evidenciageneradaModel::create($request->all());
                    } else {
                        if (isset($request->ELIMINAR)) {
                            if ($request->ELIMINAR == 1) {
                                $capacitacion = evidenciageneradaModel::where('ID_EVIDENCIA_GENERADAS', $request['ID_EVIDENCIA_GENERADAS'])->update(['ACTIVO' => 0]);
                                $response['code'] = 1;
                                $response['capacitaciones'] = 'Desactivada';
                            } else {
                                $capacitacion = evidenciageneradaModel::where('ID_EVIDENCIA_GENERADAS', $request['ID_EVIDENCIA_GENERADAS'])->update(['ACTIVO' => 1]);
                                $response['code'] = 1;
                                $response['capacitaciones'] = 'Activada';
                            }
                        } else {
                            $capacitacion = evidenciageneradaModel::find($request->ID_EVIDENCIA_GENERADAS);
                            $capacitacion->update($request->all());
                            $response['code'] = 1;
                            $response['capacitaciones'] = 'Actualizada';
                        }
                        return response()->json($response);
                    }
                    $response['code']  = 1;
                    $response['capacitaciones']  = $capacitacion;
                    return response()->json($response);
                    break;

                ///  UBICACION 
                case 13:
                    if ($request->ID_UBICACION == 0) {
                        DB::statement('ALTER TABLE capacitacion_ubicacion AUTO_INCREMENT=1;');
                        $capacitacion = ubicacionModel::create($request->all());
                    } else {
                        if (isset($request->ELIMINAR)) {
                            if ($request->ELIMINAR == 1) {
                                $capacitacion = ubicacionModel::where('ID_UBICACION', $request['ID_UBICACION'])->update(['ACTIVO' => 0]);
                                $response['code'] = 1;
                                $response['capacitaciones'] = 'Desactivada';
                            } else {
                                $capacitacion = ubicacionModel::where('ID_UBICACION', $request['ID_UBICACION'])->update(['ACTIVO' => 1]);
                                $response['code'] = 1;
                                $response['capacitaciones'] = 'Activada';
                            }
                        } else {
                            $capacitacion = ubicacionModel::find($request->ID_UBICACION);
                            $capacitacion->update($request->all());
                            $response['code'] = 1;
                            $response['capacitaciones'] = 'Actualizada';
                        }
                        return response()->json($response);
                    }
                    $response['code']  = 1;
                    $response['capacitaciones']  = $capacitacion;
                    return response()->json($response);
                    break;


                ///  MATERIAL DIDACTICO  
                case 14:
                    if ($request->ID_MATERIAL_DIDACTICO == 0) {
                        DB::statement('ALTER TABLE capacitacion_materialdidactivo AUTO_INCREMENT=1;');
                        $capacitacion = materialdidacticoModel::create($request->all());
                    } else {
                        if (isset($request->ELIMINAR)) {
                            if ($request->ELIMINAR == 1) {
                                $capacitacion = materialdidacticoModel::where('ID_MATERIAL_DIDACTICO', $request['ID_MATERIAL_DIDACTICO'])->update(['ACTIVO' => 0]);
                                $response['code'] = 1;
                                $response['capacitaciones'] = 'Desactivada';
                            } else {
                                $capacitacion = materialdidacticoModel::where('ID_MATERIAL_DIDACTICO', $request['ID_MATERIAL_DIDACTICO'])->update(['ACTIVO' => 1]);
                                $response['code'] = 1;
                                $response['capacitaciones'] = 'Activada';
                            }
                        } else {
                            $capacitacion = materialdidacticoModel::find($request->ID_MATERIAL_DIDACTICO);
                            $capacitacion->update($request->all());
                            $response['code'] = 1;
                            $response['capacitaciones'] = 'Actualizada';
                        }
                        return response()->json($response);
                    }
                    $response['code']  = 1;
                    $response['capacitaciones']  = $capacitacion;
                    return response()->json($response);
                    break;

                ///  IMPACTO ESPERADO  
                case 15:
                    if ($request->ID_IMPACTO_ESPERADO == 0) {
                        DB::statement('ALTER TABLE capacitacion_impactoesperado AUTO_INCREMENT=1;');
                        $capacitacion = impactoesparadoModel::create($request->all());
                    } else {
                        if (isset($request->ELIMINAR)) {
                            if ($request->ELIMINAR == 1) {
                                $capacitacion = impactoesparadoModel::where('ID_IMPACTO_ESPERADO', $request['ID_IMPACTO_ESPERADO'])->update(['ACTIVO' => 0]);
                                $response['code'] = 1;
                                $response['capacitaciones'] = 'Desactivada';
                            } else {
                                $capacitacion = impactoesparadoModel::where('ID_IMPACTO_ESPERADO', $request['ID_IMPACTO_ESPERADO'])->update(['ACTIVO' => 1]);
                                $response['code'] = 1;
                                $response['capacitaciones'] = 'Activada';
                            }
                        } else {
                            $capacitacion = impactoesparadoModel::find($request->ID_IMPACTO_ESPERADO);
                            $capacitacion->update($request->all());
                            $response['code'] = 1;
                            $response['capacitaciones'] = 'Actualizada';
                        }
                        return response()->json($response);
                    }
                    $response['code']  = 1;
                    $response['capacitaciones']  = $capacitacion;
                    return response()->json($response);
                    break;

                ///  DOCUMENTO EMITIDO  
                case 16:
                    if ($request->ID_DOCUMENTOS_EMITIDOS == 0) {
                        DB::statement('ALTER TABLE capacitacion_documentosemitidos AUTO_INCREMENT=1;');
                        $capacitacion = documentosemitidosModel::create($request->all());
                    } else {
                        if (isset($request->ELIMINAR)) {
                            if ($request->ELIMINAR == 1) {
                                $capacitacion = documentosemitidosModel::where('ID_DOCUMENTOS_EMITIDOS', $request['ID_DOCUMENTOS_EMITIDOS'])->update(['ACTIVO' => 0]);
                                $response['code'] = 1;
                                $response['capacitaciones'] = 'Desactivada';
                            } else {
                                $capacitacion = documentosemitidosModel::where('ID_DOCUMENTOS_EMITIDOS', $request['ID_DOCUMENTOS_EMITIDOS'])->update(['ACTIVO' => 1]);
                                $response['code'] = 1;
                                $response['capacitaciones'] = 'Activada';
                            }
                        } else {
                            $capacitacion = documentosemitidosModel::find($request->ID_DOCUMENTOS_EMITIDOS);
                            $capacitacion->update($request->all());
                            $response['code'] = 1;
                            $response['capacitaciones'] = 'Actualizada';
                        }
                        return response()->json($response);
                    }
                    $response['code']  = 1;
                    $response['capacitaciones']  = $capacitacion;
                    return response()->json($response);
                    break;

                ///  MONEDA   
                case 17:
                    if ($request->ID_MONEDA == 0) {
                        DB::statement('ALTER TABLE capacitacion_moneda AUTO_INCREMENT=1;');
                        $capacitacion = monedaModel::create($request->all());
                    } else {
                        if (isset($request->ELIMINAR)) {
                            if ($request->ELIMINAR == 1) {
                                $capacitacion = monedaModel::where('ID_MONEDA', $request['ID_MONEDA'])->update(['ACTIVO' => 0]);
                                $response['code'] = 1;
                                $response['capacitaciones'] = 'Desactivada';
                            } else {
                                $capacitacion = monedaModel::where('ID_MONEDA', $request['ID_MONEDA'])->update(['ACTIVO' => 1]);
                                $response['code'] = 1;
                                $response['capacitaciones'] = 'Activada';
                            }
                        } else {
                            $capacitacion = monedaModel::find($request->ID_MONEDA);
                            $capacitacion->update($request->all());
                            $response['code'] = 1;
                            $response['capacitaciones'] = 'Actualizada';
                        }
                        return response()->json($response);
                    }
                    $response['code']  = 1;
                    $response['capacitaciones']  = $capacitacion;
                    return response()->json($response);
                    break;

                ///  LINEAS DE NEGOCIOS   
                case 18:
                    if ($request->ID_LINEA_NEGOCIO == 0) {
                        DB::statement('ALTER TABLE capacitacion_lineanegocios AUTO_INCREMENT=1;');
                        $capacitacion = lineanegocioModel::create($request->all());
                    } else {
                        if (isset($request->ELIMINAR)) {
                            if ($request->ELIMINAR == 1) {
                                $capacitacion = lineanegocioModel::where('ID_LINEA_NEGOCIO', $request['ID_LINEA_NEGOCIO'])->update(['ACTIVO' => 0]);
                                $response['code'] = 1;
                                $response['capacitaciones'] = 'Desactivada';
                            } else {
                                $capacitacion = lineanegocioModel::where('ID_LINEA_NEGOCIO', $request['ID_LINEA_NEGOCIO'])->update(['ACTIVO' => 1]);
                                $response['code'] = 1;
                                $response['capacitaciones'] = 'Activada';
                            }
                        } else {
                            $capacitacion = lineanegocioModel::find($request->ID_LINEA_NEGOCIO);
                            $capacitacion->update($request->all());
                            $response['code'] = 1;
                            $response['capacitaciones'] = 'Actualizada';
                        }
                        return response()->json($response);
                    }
                    $response['code']  = 1;
                    $response['capacitaciones']  = $capacitacion;
                    return response()->json($response);
                    break;

                default:

                    $response['code']  = 1;
                    $response['msj']  = 'Api no encontrada';
                    return response()->json($response);
            }
        } catch (Exception $e) {

            return response()->json('Error al guardar las funciones');
        }
    }




}

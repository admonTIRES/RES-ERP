<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Response;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

//  USUARIOS
use App\Http\Controllers\usuario\usuarioController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\VerificationController;


// CONTROLADORES INFORMACION EMPRESA
use App\Http\Controllers\empresainformacion\empresainformacionController;

// CONTROLADORES DE ORGANIZACION 
use App\Http\Controllers\organizacion\areasController;
use App\Http\Controllers\organizacion\pptController;
use App\Http\Controllers\organizacion\dptController;
use App\Http\Controllers\excel\makeExcelController;
use App\Http\Controllers\organizacion\catalogosController;
use App\Http\Controllers\organizacion\catalogosasesoresController;
use App\Http\Controllers\organizacion\catalogosfuncionescargoController;
use App\Http\Controllers\organizacion\catalogosfuncionesgestionController;
use App\Http\Controllers\organizacion\catalogosrelacionesexternasController;
use App\Http\Controllers\organizacion\requerimientoPersonalController;
use App\Http\Controllers\organizacion\catalogocategoriaControlller;
use App\Http\Controllers\organizacion\catalogoexperienciaController;
use App\Http\Controllers\organizacion\catalogocompetenciabasicaController;
use App\Http\Controllers\organizacion\catalogotipovacanteController;
use App\Http\Controllers\organizacion\catalogoCompotenciasGerencialesController;
use App\Http\Controllers\organizacion\catalogomotivovacanteControlller;
use App\Http\Controllers\organizacion\catalogoanuncioController;
use App\Http\Controllers\organizacion\requerimientopersonalsolicitudController;

// CONTROLADORES DE RECLUTAMIENO 
use App\Http\Controllers\reclutamiento\catalogovacantesController;
use App\Http\Controllers\reclutamiento\PuestoController;
use App\Http\Controllers\reclutamiento\bancocvController;
use App\Http\Controllers\reclutamiento\vacantesactivasController;
use App\Http\Controllers\organizacion\catalogoareainteresController;
use App\Http\Controllers\organizacion\catalogogeneroControlller;
use App\Http\Controllers\reclutamiento\formCVController;
use App\Http\Controllers\reclutamiento\vacanteshistorialController;


// CONTROLADORES DE SELECCION
use App\Http\Controllers\seleccion\seleccionController;
use App\Http\Controllers\seleccion\catalogopruebasController;
use App\Http\Controllers\TestController;

// CONTROLADORES DE CONTRATACION 
use App\Http\Controllers\contratacion\contratacionController;
use App\Http\Controllers\contratacion\PowerPointController;
use App\Http\Controllers\contratacion\pendientecontratarController;
use App\Http\Controllers\contratacion\CvController;
use App\Http\Controllers\contratacion\pdfasingacionController;
use App\Http\Controllers\contratacion\actualizaciondocsController;
use App\Http\Controllers\contratacion\actualizaciondochistorialController;


// CONTROLADORES DE REC.EMPLEADOS
use App\Http\Controllers\recursosempleado\recempleadoController;
use App\Http\Controllers\recursosempleado\pdfrecempleadoController;
use App\Http\Controllers\recursosempleado\expedientecolabController;


// CONTROLADORES DE CAPACITACION 
use App\Http\Controllers\capacitacion\brechaController;
use App\Http\Controllers\capacitacion\catalogoscapacitacionController;
use App\Http\Controllers\capacitacion\catalogocursosController;

// CONTROLADORES DE DESVINCULACION
use App\Http\Controllers\desvinculacion\desvinculacionController;

// CONTROLADORES DE CLIENTES
use App\Http\Controllers\clientes\clientesController;

// CONTROLADORES DE SOLICITUDES
use App\Http\Controllers\solicitudes\solicitudesController;
use App\Http\Controllers\solicitudes\catalogomediocontactoController;
use App\Http\Controllers\solicitudes\catalogogiroempresaController;
use App\Http\Controllers\solicitudes\catalogonecesidadController;
use App\Http\Controllers\solicitudes\catalogolineanegociosController;
use App\Http\Controllers\solicitudes\catalogotiposervicioController;
use App\Http\Controllers\solicitudes\solicitudeshistorialController;

// CONTROLADORES DE OFERTAS 
use App\Http\Controllers\ofertas\ofertasController;
use App\Http\Controllers\ofertas\ofertashistorialController;

// CONTROLADORES DE CONFIRMACION 
use App\Http\Controllers\confirmacion\confirmacionController;
use App\Http\Controllers\confirmacion\catalagoverificacioninformacionController;
use App\Http\Controllers\confirmacion\confirmacionhistorialController;

// CONTROLADORES DE ORDEN DE TRABAJO
use App\Http\Controllers\ordentrabajo\otController;
use App\Http\Controllers\ordentrabajo\othistorialController ;
use App\Http\Controllers\ordentrabajo\pdfotController;



// CONTROLADORES DE MR
use App\Http\Controllers\requisicionmaterial\mrController;
use App\Http\Controllers\requisicionmaterial\bitacora2025Controller;

// CONTROLADORES DE PROVEEDORES
use App\Http\Controllers\proveedor\directorioController;
use App\Http\Controllers\proveedor\altaproveedorController;
use App\Http\Controllers\proveedor\altacuentaController;
use App\Http\Controllers\proveedor\altacontactoController;
use App\Http\Controllers\proveedor\altacerticacionController;
use App\Http\Controllers\proveedor\altareferenciasController;
use App\Http\Controllers\proveedor\altadocumentosController;
use App\Http\Controllers\proveedor\listaproveedorController;
use App\Http\Controllers\proveedor\proveedortempController;
use App\Http\Controllers\proveedor\catalagofuncionesproveedorController;
use App\Http\Controllers\proveedor\catalagotituloproveedorController;
use App\Http\Controllers\proveedor\catalagodocumentosproveedorController;
use App\Http\Controllers\proveedor\catalogoverificacionproveedorController;
use App\Http\Controllers\proveedor\listaproveedorcriticoController;
use App\Http\Controllers\proveedor\actualizaciondocumentosController;
use App\Http\Controllers\proveedor\ordencompraproveedorController;
use App\Http\Controllers\proveedor\facturaproveedorController;
use App\Http\Controllers\proveedor\listacontratosController;
use App\Http\Controllers\proveedor\listafacturasController;
use App\Http\Controllers\proveedor\contratoproveedorController;
use App\Http\Controllers\proveedor\relacionpagoController;




// CONTROLADORES DE PO 
use App\Http\Controllers\ordencompra\poController;
use App\Http\Controllers\ordencompra\pdfpoController;
use App\Http\Controllers\ordencompra\pohistorialController;

// CONTROLADORES DE MATRIZ COMPARATIVA
use App\Http\Controllers\matrizcomparativa\matrizController;

// GENERAR PDF
use App\Http\Controllers\pdf\pdfController;

// CONTROLADORES GR  
use App\Http\Controllers\requisicongr\grController;
use App\Http\Controllers\requisicongr\vobogrusuarioController;
use App\Http\Controllers\requisicongr\pdfgrController;
use App\Http\Controllers\requisicongr\grhistorialController;


// CONTROLADORES DE LA PAGINA WEB
use App\Http\Controllers\paginaweb\mensajespaginaController;

// CONTROLADORES DE INVENTARIO
use App\Http\Controllers\inventario\inventarioController;
use App\Http\Controllers\inventario\catalogotipoinventarioController;
use App\Http\Controllers\inventario\salidalmacenController;
use App\Http\Controllers\aprobacionsalidalmacen\aprobacionsalidalmacenController;
use App\Http\Controllers\listaaf\listaafController;
use App\Http\Controllers\listaafn\listaafnController;
use App\Http\Controllers\listacomercializacion\listacomercializacionController;
use App\Http\Controllers\listaitemcritico\listaitemcriticoController;
use App\Http\Controllers\listaalerta\listaalertaController;
use App\Http\Controllers\listaasignacion\listaasignacionController;
use App\Http\Controllers\listainfraestructura\listainfraestructuraController;
use App\Http\Controllers\inventario\catalogokitsController;


//// BITACORAS INVENTARIO
use App\Http\Controllers\bitacorasinventario\bitacoraconsumiblesController;
use App\Http\Controllers\bitacorasinventario\bitacoraretornableController;
use App\Http\Controllers\bitacorasinventario\bitacoravehiculosController;
use App\Http\Controllers\bitacorasinventario\bitacoraasignacionController;

/// NOTIFICACIONES 
use App\Http\Controllers\notificacion\notificacionController;

/// MANTENIMIENTO EQUIPOS
use App\Http\Controllers\listamantenimiento\listamantenimientoController;

/// MANTENIMIENTO INSTALACIONES

use App\Http\Controllers\listamantenimiento\listainstalacionController;


//==============================================  login  ============================================== 
Route::get('/', function () {
    if (Auth::check()) {
        if (Auth::user()->hasAnyRole(['Superusuario', 'Administrador'])) {
            return redirect('/modulos');
        }
        return response()->noContent(); 
    }
    return response()->noContent(); 
});



// Rutas públicas (excluidas del middleware global)

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::post('/verify-code', [AuthController::class, 'verifyCode']);
Route::get('/validarRolExterno', [AuthController::class, 'validarRolExterno']);
//==============================================  ENVIAR CORREO  ============================================== 

Route::post('/enviar-codigo', [VerificationController::class, 'enviarCodigo']);
Route::post('/verificar-codigo', [VerificationController::class, 'verificarCodigo']);
//==============================================  Módulos  ============================================== 



Route::get('/modulos', [catalogoanuncioController::class, 'index']);
Route::get('/tipo-cambio', [catalogoanuncioController::class, 'getTipoCambio']);
Route::get('/obtenerInfoEmpresa', [catalogoanuncioController::class, 'obtenerInfoEmpresa']);

//==============================================  USUARIO  ============================================== 


Route::get('/usuario', [usuarioController::class, 'index'])->middleware('role:Superusuario,Administrador');
Route::post('/usuarioSave', [usuarioController::class, 'store']);
Route::get('/Tablausuarios', [usuarioController::class, 'Tablausuarios']);
Route::get('/Tablaproveedores', [usuarioController::class, 'Tablaproveedores']);
Route::get('/usuarioDelete', [usuarioController::class, 'store']);
Route::get('/usuariofoto/{id}', [usuarioController::class, 'mostrarFotoUsuario'])->name('usuariofoto');
Route::post('/validarRFC', [usuarioController::class, 'validarRFC']);



//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////RRHH//////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//==============================================  INFORMACION EMRPESA  ============================================== 

Route::get('/informacionempresa', function () {return view('RH.informacionempresa.empresainformacion');});
Route::post('/InfoEmpresaSave', [empresainformacionController::class, 'store']);
Route::get('/Tablainformacionempresa', [empresainformacionController::class, 'Tablainformacionempresa']);
Route::get('/InfoEmpresaDelete', [empresainformacionController::class, 'store']);



//==============================================  ORGANIZACION  ============================================== 
Route::get('/tablero', function () {return view('RH.tablero.index');});

// ORGANIGRAMA
Route::get('/organigrama', [areasController::class, 'index']);
Route::post('/areasSave', [areasController::class, 'store']);
Route::get('/areasDelete', [areasController::class, 'store']);
Route::get('/TablaAreas', [areasController::class, 'TablaAreas']);
Route::get('/mostrararchivo/{id}', [areasController::class, 'mostrararchivo']);
Route::get('/TablaCargos/{area_id}', [areasController::class, 'TablaCargos']);
Route::get('/TablaEncargados/{area_id}', [areasController::class, 'TablaEncargados']);
Route::get('/listaEncagadosAreas/{area_id}', [areasController::class, 'listaEncagadosAreas']);
Route::get('/getDataOrganigrama/{area_id}/{esGeneral}', [areasController::class, 'getDataOrganigrama']);
Route::get('/mostrarFoto/{id}', [areasController::class, 'mostrarFoto']);


Route::post('/activarEncargado', [areasController::class, 'activarEncargado']);

// PPT
Route::get('/ppt', [pptController::class, 'index'])->middleware('role:Superusuario,Administrador,Analista HSEQ,Asistente de planeación y logística,Desarrollador de software,Intendente,Consultor-Instructor (Junior/Senior),externo');
Route::post('/pptSave', [pptController::class, 'store']);
Route::get('/TablaPPT', [pptController::class, 'TablaPPT']);
Route::get('/autorizarPPT/{id_formulario}', [pptController::class, 'autorizarPPT']);
Route::get('/revisarPPT/{id_formulario}', [pptController::class, 'revisarPPT']);
Route::get('/makeExcelPPT/{id_formulario}', [makeExcelController::class, 'makeExcelPPT']);
Route::get('pptDelete', [pptController::class, 'store']);

// DPT
Route::get('/dpt', [dptController::class, 'index']);
Route::post('/dptSave', [dptController::class, 'store']);
Route::get('/TablaDPT', [dptController::class, 'TablaDPT']);
Route::get('/dptDelete', [dptController::class, 'store']);
Route::get('/makeExcelDPT/{id_formulario}', [makeExcelController::class, 'makeExcelDPT']);
Route::get('/infoReportan/{ID}/{LIDER}', [dptController::class, 'infoReportan']);
Route::get('/consultarfuncionescargo/{areaId}', [dptController::class, 'consultarfuncionescargo']);

// REQUERIMIENTO PERSONAL 

Route::get('/requisiciondepersonalsolicitud', [requerimientopersonalsolicitudController::class, 'index']);
Route::post('/RequisiconPerSolicitudSave', [requerimientopersonalsolicitudController::class, 'store']);
Route::get('/Tablasolicitudrequerimientopersonal', [requerimientopersonalsolicitudController::class, 'Tablasolicitudrequerimientopersonal']);


// REQUERIMIENTO PERSONAL 
Route::get('/requisiciondepersonal', [requerimientoPersonalController::class, 'index'])->middleware('role:Superusuario,Administrador,externo');
Route::post('/RequerimientoSave', [requerimientoPersonalController::class, 'store']);
Route::get('/RequerimientoDelete', [requerimientoPersonalController::class, 'store']);
Route::get('/Tablarequerimiento', [requerimientoPersonalController::class, 'Tablarequerimiento']);
Route::get('/makeExcelRP/{id_formulario}', [makeExcelController::class, 'makeExcelRP']);
Route::get('/mostrardocumentorequisicion/{id}', [requerimientoPersonalController::class, 'mostrardocumentorequisicion']);


// CATÁLOGO DE JERARQUÍA
Route::get('/jerarquico', function () {return view('RH.Catalogos.catalogo_Jerárquico');});
Route::post('/jerarquiaSave', [catalogosController::class, 'store']);
Route::get('/jerarquiaDelete', [catalogosController::class, 'store']);
Route::get('/Tablajerarquia', [catalogosController::class, 'Tablajerarquia']);

// CATÁLOGO DE ASESORES
Route::get('/asesores', function () {return view('RH.Catalogos.catalogo_asesores');});
Route::post('/asesorSave', [catalogosasesoresController::class, 'store']);
Route::get('/asesorDelete', [catalogosasesoresController::class, 'store']);
Route::get('/Tablaasesores', [catalogosasesoresController::class, 'Tablaasesores']);

// CATÁLOGO DE FUNCIONES CARGO
Route::get('/funcionescargo', [catalogosfuncionescargoController::class, 'index']);
Route::post('/CargoSave', [catalogosfuncionescargoController::class, 'store']);
Route::get('/CargoDelete', [catalogosfuncionescargoController::class, 'store']);
Route::get('/Tablaafuncionescargo', [catalogosfuncionescargoController::class, 'Tablaafuncionescargo']);

// CATÁLOGO DE FUNCIONES GESTIONES
Route::get('/funcionesgestion', function () {return view('RH.Catalogos.catalogo_funcionesgestion');});
Route::post('/GestionSave', [catalogosfuncionesgestionController::class, 'store']);
Route::get('/GestionDelete', [catalogosfuncionesgestionController::class, 'store']);
Route::get('/Tablafuncionesgestion', [catalogosfuncionesgestionController::class, 'Tablafuncionesgestion']);

// CATÁLOGO DE RELACIONES EXTERNAS 
Route::get('/relacionesexternas', function () {return view('RH.Catalogos.catalogo_relacionesexternas');});
Route::post('/ExternaSave', [catalogosrelacionesexternasController::class, 'store']);
Route::get('/ExternaDelete', [catalogosrelacionesexternasController::class, 'store']);
Route::get('/Tablarelacionesexterna', [catalogosrelacionesexternasController::class, 'Tablarelacionesexterna']);

// CATÁLOGO DE CATEGORÍAS
Route::get('/categorias', [catalogocategoriaControlller::class, 'index']);
Route::post('/CategoriaSave', [catalogocategoriaControlller::class, 'store']);
Route::get('CategoriaDelete', [catalogocategoriaControlller::class, 'store']);
Route::get('/Tablacategoria', [catalogocategoriaControlller::class, 'Tablacategoria']);

// CATÁLOGO DE GÉNERO 
Route::get('/genero', function () {return view('RH.Catalogos.catalogo_genero');});
Route::post('/GeneroSave', [catalogogeneroControlller::class, 'store']);
Route::get('/GeneroDelete', [catalogogeneroControlller::class, 'store']);
Route::get('/Tablageneros', [catalogogeneroControlller::class, 'Tablageneros']);

// CATÁLOGO DE PUESTO QUE SE REQUIERE COMO EXPERIENCIA
Route::get('/puestoexperiencia', function () {return view('RH.Catalogos.catalogo_experiencia');});
Route::post('/PuestoSave', [catalogoexperienciaController::class, 'store']);
Route::get('/PuestoDelete', [catalogoexperienciaController::class, 'store']);
Route::get('/Tablaexperiencia', [catalogoexperienciaController::class, 'Tablaexperiencia']);

// CATÁLOGO COMPETENCIAS BÁSICAS O CARDINALES 
Route::get('/competenciasbasicas', function () {return view('RH.Catalogos.catalogo_competenciasbasicas');});
Route::post('/BasicoSave', [catalogocompetenciabasicaController::class, 'store']);
Route::get('/BasicoDelete', [catalogocompetenciabasicaController::class, 'store']);
Route::get('/Tablacompetenciabasica', [catalogocompetenciabasicaController::class, 'Tablacompetenciabasica']);

// CATÁLOGO COMPETENCIAS GERENCIALES 
Route::get('/competenciasgerenciales', function () {return view('RH.Catalogos.catalogo_competenciasGerenciales'); });
Route::post('/GerencialesSave', [catalogoCompotenciasGerencialesController::class, 'store']);
Route::get('/GerencialesDelete', [catalogoCompotenciasGerencialesController::class, 'store']);
Route::get('/TablaCompetenciasGerenciales', [catalogoCompotenciasGerencialesController::class, 'TablaCompetenciasGerenciales']);

// CATÁLOGO DE TIPO DE VACANTES
Route::get('/tipovacante', function () {return view('RH.Catalogos.catalogo_tipovacante');});
Route::post('/TipoSave', [catalogotipovacanteController::class, 'store']);
Route::get('/TipoDelete', [catalogotipovacanteController::class, 'store']);
Route::get('/Tablatipovacantes', [catalogotipovacanteController::class, 'Tablatipovacantes']);

// CATÁLOGO DE  MOTIVO DE VACANTES 
Route::get('/motivovacante', function () {return view('RH.Catalogos.catalogo_motivovacante');});
Route::post('/MotivoSave', [catalogomotivovacanteControlller::class, 'store']);
Route::get('/MotivoDelete', [catalogomotivovacanteControlller::class, 'store']);
Route::get('/Tablamotivovacante', [catalogomotivovacanteControlller::class, 'Tablamotivovacante']);



// CATÁLOGO DE ANUNCIO
Route::get('/anuncios', function () { return view('RH.Catalogos.catalogo_anucios');});
Route::post('/AnuncioSave', [catalogoanuncioController::class, 'store']);
Route::get('/Tablanuncios', [catalogoanuncioController::class, 'Tablanuncios']);
Route::get('/AnuncioDelete', [catalogoanuncioController::class, 'store']);
Route::get('/anunciofoto/{id}', [catalogoanuncioController::class, 'mostrarfotoanuncio'])->name('anunciofoto');

// CATALOGOS
Route::get('/catalogoppt', function () {return view('RH.Catalogos.catalogo_ppt');});
Route::get('/catalogodpt', function () {return view('RH.Catalogos.catalogo_dpt');});
Route::get('/catalogorequisicion', function () {return view('RH.Catalogos.catalogo_requisicion');});
Route::get('/catalogogenerales', function () {return view('RH.Catalogos.catalogo_generales');});





//==============================================  RECLUTAMIENTO  ============================================== 


Route::post('/BancoSave', [bancocvController::class, 'store']);
Route::post('/FormCVSave', [formCVController::class, 'store']);
Route::post('/actualizarinfocv', [formCVController::class, 'actualizarinfocv'])->name('actualizarinfocv');

//  TABLA PARA PODER LA INFORMACIÓN DEL FORMULARIO DE BANCO DE CV 
Route::get('/listavacantes', [bancocvController::class, 'index']);
Route::get('/BancoDelete', [bancocvController::class, 'store']);
Route::get('/Tablabancocv', [bancocvController::class, 'Tablabancocv']);


Route::get('/Tablacontratadobancocv', [bancocvController::class, 'Tablacontratadobancocv']);


Route::get('/mostrarCurpCv/{id}', [bancocvController::class, 'mostrarCurpCv']);
Route::get('/mostrarCv/{id}', [bancocvController::class, 'mostrarCv']);

// RUTA PARA VER LAS VACANTES EXTERNA EN LA APLICACIÓN
Route::post('/actualizarinfo', [PuestoController::class, 'getCvInfo'])->name('actualizarinfo');
Route::post('/ActualizarSave', [PuestoController::class, 'store']);
Route::post('/PostularseSave', [PuestoController::class, 'store1']);

// CATÁLOGO DE VACANTES
Route::get('/catalogodevacantes', [catalogovacantesController::class, 'index']);
Route::post('/VacantesSave', [catalogovacantesController::class, 'store']);
Route::get('/VacanteDelete', [catalogovacantesController::class, 'store']);
Route::get('/Tablavacantes', [catalogovacantesController::class, 'Tablavacantes']);

//  CATÁLOGO ÁREA DE INTERESES
Route::get('/areainteres', function () {return view('RH.Catalogos.catalogo_areainteres');});
Route::post('/interesSave', [catalogoareainteresController::class, 'store']);
Route::get('/interesDelete', [catalogoareainteresController::class, 'store']);
Route::get('/Tablaareainteres', [catalogoareainteresController::class, 'Tablaareainteres']);

// VISUALIZAR LA VACANTES Y PODER VER LOS QUE SE HAN POSTULADO Y PODER MANDAR A SELECCIÓN
Route::get('/postulaciones', [vacantesactivasController::class, 'index']);
Route::get('/Tablapostulaciones', [vacantesactivasController::class, 'Tablapostulaciones']);
Route::post('/VacantesactSave', [vacantesactivasController::class, 'store']);

// PODER VISUALIZAR LA INFORMACIÓN DE LOS POSTULANTES Y GUARDARLOS 
Route::get('/informacionpostulantes/{idVacante}', [vacantesactivasController::class, 'informacionpostulantes']);
Route::get('/obtener-cv/{curp}', [vacantesactivasController::class, 'mostrarCvPorCurp'])->name('mostrarCvPorCurp');
Route::post('/guardarPostulantes', [vacantesactivasController::class, 'guardarPostulantes']);

// PODER VISUALIZAR LA INFORMACIÓN DE LOS QUE SE VAN A  PRESELECCIONAR Y  MANDARLOS A SELECCIÓN
Route::post('/guardarPreseleccion', [vacantesactivasController::class, 'guardarPreseleccion']);
Route::get('/informacionpreseleccion/{idVacante}', [VacantesactivasController::class, 'informacionpreseleccion']);
Route::post('/actualizarDisponibilidad', [VacantesactivasController::class, 'actualizarDisponibilidad']);

// HISTORIAL DE VACANTES

Route::get('/postulacioneshistorial', [vacanteshistorialController::class, 'index']);
Route::get('/Tablapostulacioneshistorial', [vacanteshistorialController::class, 'Tablapostulacioneshistorial']);



//==============================================  SELECCION  ============================================== 

// VISUALIZAR HISTORIAL DE SELECCION


Route::get('/visualizarseleccion', [seleccionController::class, 'index2'])->middleware('role:Superusuario,Administrador,externo');
Route::get('/Tablaseleccion2Visualizar', [seleccionController::class, 'Tablaseleccion2Visualizar']);
Route::get('/consultarSeleccion2Visualizar/{vacantesId}', [seleccionController::class, 'consultarSeleccion2Visualizar']);


// SELECCION

Route::get('/seleccion', [seleccionController::class, 'index'])->middleware('role:Superusuario,Administrador,externo');
Route::get('/Tablaseleccion', [seleccionController::class, 'Tablaseleccion']);
Route::post('/SeleccionSave', [seleccionController::class, 'store']);
Route::get('/consultarSeleccion/{vacantesId}', [seleccionController::class, 'consultarSeleccion']);
Route::post('/guardarPendiente', [seleccionController::class, 'guardarPendiente']);

Route::post('/noSeleccionar', [seleccionController::class, 'noSeleccionar']);

// AUTORIZACION
Route::get('/ver-archivo/{curp}', [seleccionController::class, 'visualizarArchivo']);
Route::get('/ver-pdf', [seleccionController::class, 'mostrarPDF'])->name('ver-pdf');
Route::get('/Tablaautorizacion', [seleccionController::class, 'Tablaautorizacion']);

// INTELIGENCIA LABORAL
Route::get('/Tablainteligencia', [seleccionController::class, 'Tablainteligencia']);
Route::get('/mostrarcompetencias/{id}', [seleccionController::class, 'mostrarcompetencias']);
Route::get('/mostrarcompleto/{id}', [seleccionController::class, 'mostrarcompleto']);

// BURÓ LABORAL
Route::get('/Tablaburo', [seleccionController::class, 'Tablaburo']);
Route::get('/mostrarburo/{id}', [seleccionController::class, 'mostrarburo']);

// PERFIL DE PUESTO DE TRABAJO (PPT)
Route::get('/Tablapptseleccion', [seleccionController::class, 'Tablapptseleccion']);
Route::get('/consultarformppt/{id}', [seleccionController::class, 'consultarformppt']);

// REFERENCIAS LABORAL
Route::get('/Tablareferencia', [seleccionController::class, 'Tablareferencia']);
Route::get('/mostrareferencias/{id}', [seleccionController::class, 'mostrareferencias']);

// PRUEBAS DE CONOCIMIENTOS
Route::get('/obtenerRequerimientos/{id}', [seleccionController::class, 'obtenerRequerimientos']);
Route::get('/Tablapruebaconocimientoseleccion', [seleccionController::class, 'Tablapruebaconocimientoseleccion']);
Route::get('/mostrarprueba/{id}', [seleccionController::class, 'mostrarprueba']);

// ENTREVISTA
Route::get('/Tablaentrevistaseleccion', [seleccionController::class, 'Tablaentrevistaseleccion']);

// CATÁLOGO DE PRUEBAS DE CONOCIMIENTOS
Route::get('/pruebasconocimientos', function () {return view('RH.Catalogos.catalogo_pruebasconocimiento');});
Route::post('/pruebaSave', [catalogopruebasController::class, 'store']);
Route::get('/pruebaDelete', [catalogopruebasController::class, 'store']);
Route::get('/Tablapruebaconocimiento', [catalogopruebasController::class, 'Tablapruebaconocimiento']);


//==============================================  CONTRATACION  ============================================== 

// PENDIENTE AL CONTRATAR
Route::get('/pendientecontratar', function () {return view('RH.contratacion.pendientecontratar');});
Route::get('/Tablapendientecontratacion', [pendientecontratarController::class, 'Tablapendientecontratacion']);
Route::post('/mandarcontratacion', [pendientecontratarController::class, 'mandarcontratacion']);
Route::get('/obtenerInformacionContrato/{contrato_id}', [contratacionController::class, 'obtenerInformacionContrato']);
Route::post('/obtenerSiguienteNumeroEmpleado', [contratacionController::class, 'obtenerSiguienteNumeroEmpleado']);

/////////////////////////////////////// STEP 1 DATOS GENERALES
Route::get('/contratacion', [contratacionController::class, 'index'])->middleware('role:Superusuario,Administrador,externo');
Route::post('/contratoSave', [contratacionController::class, 'store']);
Route::post('/obtenerbajasalta', [contratacionController::class, 'obtenerbajasalta']);
Route::get('/Tablacontratacion', [contratacionController::class, 'Tablacontratacion']);
Route::get('/Tablacontratacion1', [contratacionController::class, 'Tablacontratacion1']);
Route::post('/activarColaborador/{id}', [contratacionController::class, 'activarColaborador']);
Route::get('/usuariocolaborador/{id}', [contratacionController::class, 'mostrarfotocolaborador']);
Route::post('/verificarestadobloqueo', [contratacionController::class, 'verificarestadobloqueo']);
Route::post('/obtenerUltimoCargo', [contratacionController::class, 'obtenerUltimoCargo']);

// CREAR CREDENCIAL 
Route::get('/descargar-credencial', [PowerPointController::class, 'descargarCredencial']);


/////////////////////////////////////// STEP 2 DOCUMENTOS DE SOPORTE
Route::get('/Tabladocumentosoporte', [contratacionController::class, 'Tabladocumentosoporte']);
Route::get('/mostrardocumentosoporte/{id}', [contratacionController::class, 'mostrardocumentosoporte']);
Route::post('/obtenerguardados', [contratacionController::class, 'obtenerguardados']);

/////////////////////////////////////// STEP 3 CONTRATOS Y ANEXOS 
Route::get('/Tablacontratosyanexos', [contratacionController::class, 'Tablacontratosyanexos']);
Route::get('/mostrarcontratosyanexos/{id}', [contratacionController::class, 'mostrarcontratosyanexos']);
Route::get('/mostraradendacontrato/{id}', [contratacionController::class, 'mostraradendacontrato']);

// DOCUMENTOS DE SOPORTE DEL CONTRATO  
Route::get('/Tabladocumentosoportecontrato', [contratacionController::class, 'Tabladocumentosoportecontrato']);
Route::get('/mostrardocumentosoportecontrato/{id}', [contratacionController::class, 'mostrardocumentosoportecontrato']);

// RENOVACION DE CONTRATO
Route::get('/Tablarenovacioncontrato', [contratacionController::class, 'Tablarenovacioncontrato']);
Route::get('/mostrardocumentorenovacion/{id}', [contratacionController::class, 'mostrardocumentorenovacion']);
Route::get('/mostraradenda/{id}', [contratacionController::class, 'mostraradenda']);

// INFORMACION MEDICA 
Route::get('/Tablainformacionmedica', [contratacionController::class, 'Tablainformacionmedica']);
Route::get('/mostrarinformacionmedica/{id}', [contratacionController::class, 'mostrarinformacionmedica']);

// INCIDENCIAS 
Route::get('/Tablaincidencias', [contratacionController::class, 'Tablaincidencias']);
Route::get('/mostrarincidencias/{id}', [contratacionController::class, 'mostrarincidencias']);
Route::get('/Tablaspermisosrecempleados', [contratacionController::class, 'Tablaspermisosrecempleados']);

// SOLICITUD DE VACACIONES 
Route::get('/Tablasolicitudvacaciones', [contratacionController::class, 'Tablasolicitudvacaciones']);

// ACCIONES DISCIPLINARIAS 
Route::get('/Tablaccionesdisciplinarias', [contratacionController::class, 'Tablaccionesdisciplinarias']);
Route::get('/mostraracciones/{id}', [contratacionController::class, 'mostraracciones']);

// RECIBOS DE NOMINA
Route::get('/Tablarecibonomina', [contratacionController::class, 'Tablarecibonomina']);
Route::get('/mostrarecibosnomina/{id}', [contratacionController::class, 'mostrarecibosnomina']);


// ASIGNACIONES

Route::get('/Tablasignacioncolaborador', [contratacionController::class, 'Tablasignacioncolaborador']);
Route::get('/validarPrimerContrato', [contratacionController::class, 'validarPrimerContrato']);
Route::get('/Tablasignacioncolaboradorgeneral', [contratacionController::class, 'Tablasignacioncolaboradorgeneral']);
Route::get('/TablasignacioncolaboradorEditar', [contratacionController::class, 'TablasignacioncolaboradorEditar']);
Route::get('/pdfAsignacion/{id}',[pdfasingacionController::class, 'pdfAsignacion']);
Route::get('/pdfAsignacionEpp/{id}', [pdfasingacionController::class, 'pdfAsignacionEpp']);
Route::get('/mostrarasignacion/{id}', [contratacionController::class, 'mostrarasignacion']);



/////////////////////////////////////// STEP 4 DOCUMENTOS DE SOPORTE DE LOS CONTRATOS EN GENERAL
Route::get('/Tablasoportecontrato', [contratacionController::class, 'Tablasoportecontrato']);
Route::get('/mostrardocumentocolaboradorcontratosoporte/{id}', [contratacionController::class, 'mostrardocumentocolaboradorcontratosoporte']);
Route::post('/obtenerdocumentosoportescontratos', [contratacionController::class, 'obtenerdocumentosoportescontratos']);

Route::get('/firmacolaborador/{id}', [contratacionController::class, 'mostrarFotofirma']);
Route::get('/firmarh/{id}', [contratacionController::class, 'mostrarFotofirmaRH']);


/////////////////////////////////////// STEP 5 CV

Route::post('/cvSave', [CvController::class, 'store']);
Route::get('/Tablacvs', [CvController::class, 'Tablacvs']);
Route::get('/mostrarFotoCV/{id}', [CvController::class, 'mostrarFotoCV']);


/////////////////////////////////////// STEP 6 REQUISICION DE PERSONAL 

Route::get('/Tablarequisicioncontratacion', [contratacionController::class, 'Tablarequisicioncontratacion']);
Route::get('/obtenerDatosCategoria', [contratacionController::class, 'obtenerDatosCategoria']);
Route::get('/mostrarrequisicon/{id}', [contratacionController::class, 'mostrarrequisicon']);


/// ACTUALIZACION DE DOCUMENTO DEL COLABORADOR 

Route::get('/actualizaciondocumentos', [actualizaciondocsController::class, 'index']);
Route::post('/ActualizarfechasSave',[actualizaciondocsController::class, 'store']);
Route::get('/Tabladocumentosactualizados', [actualizaciondocsController::class, 'Tabladocumentosactualizados']);
Route::get('/mostrardocumentoactualizado/{id}', [actualizaciondocsController::class, 'mostrardocumentoactualizado']);
Route::post('/aceptarDocumentoActualizado', [actualizaciondocsController::class, 'aceptarDocumentoActualizado']);
Route::post('/rechazarDocumentoActualizado', [actualizaciondocsController::class, 'rechazarDocumentoActualizado']);

/// ACTUALIZACION DE DOCUMENTO DEL COLABORADOR  - HISTORIAL 


Route::get('/actualizaciondocumentoshistorial', [actualizaciondochistorialController::class, 'index']);
Route::get('/Tabladocumentosactualizadohistorial', [actualizaciondochistorialController::class, 'Tabladocumentosactualizadohistorial']);

//============================================== RECURSOS DE LOS EMPLEADOS ============================================== 

Route::get('/recempleado', function () {return view('RH.RecEmpleados.RecEmpleados');});
Route::get('/obtenerDatosPermiso', [recempleadoController::class, 'obtenerDatosPermiso']);
Route::get('/obtenerDatosVacaciones', [recempleadoController::class, 'obtenerDatosVacaciones']);

Route::get('/Tablarecempleados', [recempleadoController::class, 'Tablarecempleados']);
Route::post('/RecempleadoSave', [recempleadoController::class, 'store']);
Route::get('/solicitudesvobo', function () { return view('RH.RecEmpleados.recempleadovobo');});
Route::get('/Tablarecempleadovobo', [recempleadoController::class, 'Tablarecempleadovobo']);
Route::get('/solicitudesaprobaciones', function () {return view('RH.RecEmpleados.recempleadoaprobacion');});
Route::get('/Tablarecempleadoaprobacion', [recempleadoController::class, 'Tablarecempleadoaprobacion']);

Route::get('/obtenerContratoPorFechaPermiso/{curp}', [recempleadoController::class, 'obtenerContratoPorFechaPermiso']);
Route::get('/obtenerContratoPorFechaVacaciones/{curp}', [recempleadoController::class, 'obtenerContratoPorFechaVacaciones']);
Route::get('/mostrardocumentosrecempleados/{id}', [recempleadoController::class, 'mostrardocumentosrecempleados']);

//// DESCARGA DOCUMENTOS PDF 

Route::get('/generarPermisoausencia/{id}', [pdfrecempleadoController::class, 'generarPermisoausencia']);
Route::get('/generarVacaciones/{id}', [pdfrecempleadoController::class, 'generarVacaciones']);

/// EXPEDIENTE COLABORADOR

Route::get('/expediente', [expedientecolabController::class, 'index']);
Route::get('/Tablaexpediente', [expedientecolabController::class, 'Tablaexpediente']);
Route::get('/Tabladocumentosoportexpediente', [expedientecolabController::class, 'Tabladocumentosoportexpediente']);
Route::post('/ExpedienteSave', [expedientecolabController::class, 'store']);
Route::get('/validarPeriodoActualizacion', [expedientecolabController::class, 'validarPeriodoActualizacion']);

//==============================================  CAPACITACION  ============================================== 


/// BRECHA DE COMPETENCIA

Route::get('/brechacompetencia', function () {  return view('RH.capacitacion.brechacomp');});
Route::get('/Tablabrecha', [brechaController::class, 'Tablabrecha']);


//==============================================  CATALOGOS CAPACITACION  ============================================== 

Route::get('/catalogoscapacitacion', function () {return view('RH.capacitacion.catalogos.catalogovistageneral');});
Route::post('/CatcapacitacionSave', [catalogoscapacitacionController::class, 'store']);
Route::get('/CatcapacitacionDelete', [catalogoscapacitacionController::class, 'store']);


// CATALOGO TIPO DE CURSO
Route::get('/capacitaciontipocurso', function () {return view('RH.capacitacion.catalogos.catalogotipocurso');});
Route::get('/Tablacaptipocurso', [catalogoscapacitacionController::class, 'Tablacaptipocurso']);

// CATALOGO AREA CONOCIMIENTO
Route::get('/capacitacionareaconocimiento', function () { return view('RH.capacitacion.catalogos.catalogoareaconocimiento');});
Route::get('/Tablacapareaconocimiento', [catalogoscapacitacionController::class, 'Tablacapareaconocimiento']);

// CATALOGO MODALIDAD
Route::get('/capacitacionmodalidad', function () {return view('RH.capacitacion.catalogos.catalogomodalidad');});
Route::get('/Tablacapmodalidad', [catalogoscapacitacionController::class, 'Tablacapmodalidad']);

// CATALOGO FORMATO
Route::get('/capacitacionformato', function () { return view('RH.capacitacion.catalogos.catalogoformato');});
Route::get('/Tablacapformato', [catalogoscapacitacionController::class, 'Tablacapformato']);

// CATALOGO PAIS O REGION 
Route::get('/capacitacionpaisoregion', function () { return view('RH.capacitacion.catalogos.catalogopaisregion');});
Route::get('/Tablacappaisoregion', [catalogoscapacitacionController::class, 'Tablacappaisoregion']);

// CATALOGO IDIOMA 
Route::get('/capacitacionidioma', function () {return view('RH.capacitacion.catalogos.catalogoidiomas');});
Route::get('/Tablacapidioma', [catalogoscapacitacionController::class, 'Tablacapidioma']);

// CATALOGO NORMATIVIDAD O MARCO DE REFERENCIA 
Route::get('/capacitacionnormatividad', function () { return view('RH.capacitacion.catalogos.catalogonormativa');});
Route::get('/Tablacapnormatividad', [catalogoscapacitacionController::class, 'Tablacapnormatividad']);

// RECONOCIMIENTO
Route::get('/capacitacionreconocimiento', function () { return view('RH.capacitacion.catalogos.catalogoreconocimiento');});
Route::get('/Tablacapreconocimiento', [catalogoscapacitacionController::class, 'Tablacapreconocimiento']);

// COMPETENCIA
Route::get('/capacitacioncompetencia', function () {return view('RH.capacitacion.catalogos.catalogocompetenciasdesarrolla');});
Route::get('/Tablacapcompetencias', [catalogoscapacitacionController::class, 'Tablacapcompetencias']);

// TIPO PROVEEDOR
Route::get('/capacitaciontipoproveedor', function () { return view('RH.capacitacion.catalogos.catalogotipoproveedor');});
Route::get('/Tablacaptipoproveedor', [catalogoscapacitacionController::class, 'Tablacaptipoproveedor']);

// METODO DE EVALUACION
Route::get('/capacitacionmetodoevaluacion', function () {return view('RH.capacitacion.catalogos.catalogometodoevaluacion');});
Route::get('/Tablacapmetodoevaluacion', [catalogoscapacitacionController::class, 'Tablacapmetodoevaluacion']);

// EVIDENCIAS GENERADAS
Route::get('/capacitacionevidenciasgeneradas', function () { return view('RH.capacitacion.catalogos.catalogoevidencasgeneradas');});
Route::get('/Tablacapevidenciasgeneradas', [catalogoscapacitacionController::class, 'Tablacapevidenciasgeneradas']);

// UBICACION
Route::get('/capacitacionubicacion', function () {return view('RH.capacitacion.catalogos.catalogoubicacion');});
Route::get('/Tablacapubicacion', [catalogoscapacitacionController::class, 'Tablacapubicacion']);

// MATERIAL DIDACTICO
Route::get('/capacitacionmaterialdidactico', function () { return view('RH.capacitacion.catalogos.catalogomaterialdidactico');});
Route::get('/Tablacapmaterialdidactico', [catalogoscapacitacionController::class, 'Tablacapmaterialdidactico']);

// IMPACTO ESPERADO
Route::get('/capacitacionimpactoesperado', function () {return view('RH.capacitacion.catalogos.catalogoimpactoesperado');});
Route::get('/Tablacapimpactoesperado', [catalogoscapacitacionController::class, 'Tablacapimpactoesperado']);

// DOCUMENTOS EMITIDOS
Route::get('/capacitaciondocumentosemitidos', function () {return view('RH.capacitacion.catalogos.catalogodocumentosemitidos');});
Route::get('/Tablacapemitidos', [catalogoscapacitacionController::class, 'Tablacapemitidos']);


// MONEDA
Route::get('/capacitacionmoneda', function () {return view('RH.capacitacion.catalogos.catalogomoneda');});
Route::get('/Tablacapmoneda', [catalogoscapacitacionController::class, 'Tablacapmoneda']);

// MONEDA
Route::get('/capacitaciolineasnegocios', function () {return view('RH.capacitacion.catalogos.catalogonegocios');});
Route::get('/Tablacaplineanegocios', [catalogoscapacitacionController::class, 'Tablacaplineanegocios']);


// CATALOGO GENERAL DEL CURSO 

Route::get('/capacitacioncursos', [catalogocursosController::class, 'index']);
Route::post('/CapCursoSave', [catalogocursosController::class, 'store']);
Route::get('/CapCursoDelete', [catalogocursosController::class, 'store']);
Route::get('/Tablacapcursos', [catalogocursosController::class, 'Tablacapcursos']);


Route::post('/generarCodigoCurso', [catalogocursosController::class, 'generarCodigoCurso']);
//============================================== DESVINCULACIÓN ============================================== 

Route::get('/desvinculacion', [desvinculacionController::class, 'index']);
Route::post('/desvinculacionSave', [desvinculacionController::class, 'store']);
Route::get('/Tabladesvinculacion', [desvinculacionController::class, 'Tabladesvinculacion']);
Route::get('/mostrardocumentobaja/{id}', [desvinculacionController::class, 'mostrardocumentobaja']);
Route::get('/mostrardocumenconvenio/{id}', [desvinculacionController::class, 'mostrardocumenconvenio']);
Route::get('/mostrardocumenadeudo/{id}', [desvinculacionController::class, 'mostrardocumenadeudo']);



//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////VENTAS////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//==============================================   CLIENTES ============================================== 
Route::get('/clientes', [clientesController::class, 'index']);
Route::post('/ClienteSave', [clientesController::class, 'store']);
Route::get('/Tablaclientesventas', [clientesController::class, 'Tablaclientesventas']);
Route::get('/ClienteDelete', [clientesController::class, 'store']);
Route::get('/mostrarconstanciacliente/{id}', [clientesController::class, 'mostrarconstanciacliente']);
Route::get('/Tablaverificacionusuario', [clientesController::class, 'Tablaverificacionusuario']);
Route::get('/mostrarverificacionclienteventas/{id}', [clientesController::class, 'mostrarverificacionclienteventas']);
Route::get('/Tablactaconstitutivausuario', [clientesController::class, 'Tablactaconstitutivausuario']);
Route::get('/mostraractaclienteventas/{id}', [clientesController::class, 'mostraractaclienteventas']);


//==============================================  SOLICITUDES  ============================================== 
Route::get('/solicitudes', [solicitudesController::class, 'index']);
Route::post('/solicitudSave', [solicitudesController::class, 'store']);
Route::get('/Tablasolicitudes', [solicitudesController::class, 'Tablasolicitudes']);
Route::get('/solicitudDelete', [solicitudesController::class, 'store']);
Route::post('/actualizarEstatusSolicitud', [solicitudesController::class, 'actualizarEstatusSolicitud']);
Route::get('/mostrarverificacioncliente/{id}', [solicitudesController::class, 'mostrarverificacioncliente']);
Route::post('/actualizarSolicitud', [solicitudesController::class, 'actualizarSolicitud']);
Route::get('/buscarCliente', [solicitudesController::class, 'buscarCliente']);

//==============================================  SOLICITUDES  HISTORIAL ============================================== 
Route::get('/solicitudeshistorial', [solicitudeshistorialController::class, 'index']);
Route::get('/Tablasolicitudeshistorial', [solicitudeshistorialController::class, 'Tablasolicitudeshistorial']);


//==============================================  OFERTAS/COTIZACION  ============================================== 

Route::get('/ofertas', [ofertasController::class, 'index']);
Route::post('/ofertaSave', [ofertasController::class, 'store']);
Route::get('/Tablaofertas', [ofertasController::class, 'Tablaofertas']);
Route::get('/ofertaDelete', [ofertasController::class, 'store']);
Route::post('/actualizarEstatusOferta', [ofertasController::class, 'actualizarEstatusOferta']);
Route::get('/mostrarcotizacion/{id}', [ofertasController::class, 'mostrarcotizacion']);
Route::get('/mostrarterminos/{id}', [ofertasController::class, 'mostrarterminos']);

//==============================================  OFERTAS/COTIZACION  HISTORIAL ============================================== 
Route::get('/ofertashistorial', [ofertashistorialController::class, 'index']);
Route::get('/Tablaofertashistorial', [ofertashistorialController::class, 'Tablaofertashistorial']);

//==============================================   CONFIRMACION DEL SERVICIO  ============================================== 
Route::get('/confirmacion', [confirmacionController::class, 'index']);
Route::get('/Tablaconfirmacion', [confirmacionController::class, 'Tablaconfirmacion']);
Route::post('/ContratacionSave', [confirmacionController::class, 'store']);
Route::get('/mostraraceptacion/{id}', [confirmacionController::class, 'mostraraceptacion']);
Route::get('/confirmacionDelete', [confirmacionController::class, 'store']);
Route::get('/mostrarevidencias/{id}', [confirmacionController::class, 'mostrarevidencias']);

//==============================================   CONFIRMACION DEL SERVICIO HISTORIAL  ============================================== 
Route::get('/confirmacionhistorial', [confirmacionhistorialController::class, 'index']);
Route::get('/Tablaconfirmacionhistorial', [confirmacionhistorialController::class, 'Tablaconfirmacionhistorial']);


//==============================================   ORDEN DE TRABAJO  ============================================== 
Route::get('/ordentrabajo', [otController::class, 'index']);
Route::get('/Tablaordentrabajo', [otController::class, 'Tablaordentrabajo']);
Route::post('/otSave', [otController::class, 'store']);
Route::post('/obtenerDatosOferta', [otController::class, 'obtenerDatosOferta']);
Route::get('/descargarOT/{id}', [pdfotController::class, 'descargarOT']);

//==============================================   ORDEN DE TRABAJO HISTORIAL  ============================================== 
Route::get('/ordentrabajohistorial', [othistorialController::class, 'index']);
Route::get('/Tablaordentrabajohistorial', [othistorialController::class, 'Tablaordentrabajohistorial']);

//==============================================   CATALOGOS SOLICITUDES ============================================== 

Route::get('/catalogosolicitudes', function () {return view('ventas.Catalogos.catalogos_solicitud');});

// CATÁLOGO TITULOS CLIENTEs
Route::get('/catalogoclientestitulos', function () { return view('ventas.Catalogos.catalogo_titulosclientes');});

// CATÁLOGO DE MEDIO DE CONTACTO 
Route::get('/catalogomediocontacto', function () {return view('ventas.Catalogos.catalogo_mediocontacto');});
Route::post('/MedioSave', [catalogomediocontactoController::class, 'store']);
Route::get('/MedioDelete', [catalogomediocontactoController::class, 'store']);
Route::get('/Tablamediocontacto', [catalogomediocontactoController::class, 'Tablamediocontacto']);

// CATÁLOGO DE  GIRO DE EMPRESA
Route::get('/catalogogiroempresa', function () {return view('ventas.Catalogos.catalogo_giroempresa');});
Route::post('/GiroSave', [catalogogiroempresaController::class, 'store']);
Route::get('/GiroDelete', [catalogogiroempresaController::class, 'store']);
Route::get('/Tablagiroempresa', [catalogogiroempresaController::class, 'Tablagiroempresa']);

// CATÁLOGO DE  NECESIDAD SERVICIO
Route::get('/catalogonecesidadservicio', function () {return view('ventas.Catalogos.catalogo_necesidadservicio');});
Route::post('/NecesidadSave', [catalogonecesidadController::class, 'store']);
Route::get('/NecesidadDelete', [catalogonecesidadController::class, 'store']);
Route::get('/Tablanecesidadservicio', [catalogonecesidadController::class, 'Tablanecesidadservicio']);

// CATÁLOGO DE LINEA DE NEGOCIO
Route::get('/catalogolineanegocio', function () {return view('ventas.Catalogos.catalogo_lineanegocio');});
Route::post('/LineaSave', [catalogolineanegociosController::class, 'store']);
Route::get('/LineaDelete', [catalogolineanegociosController::class, 'store']);
Route::get('/Tablalineanegocio', [catalogolineanegociosController::class, 'Tablalineanegocio']);

// CATÁLOGO DE TIPO DE SERVICIO
Route::get('/catalogotiposervicio', function () {return view('ventas.Catalogos.catalogo_tiposervicio');});
Route::post('/TiposSave', [catalogotiposervicioController::class, 'store']);
Route::get('/TiposDelete', [catalogotiposervicioController::class, 'store']);
Route::get('/Tablatiposervicio', [catalogotiposervicioController::class, 'Tablatiposervicio']);



//==============================================   CATALOGOS CONFIRMACION ============================================== 

Route::get('/catalogoconfirmacion', function () {return view('ventas.Catalogos.catalogos_confirmacion');});

// CATÁLOGO DE VERIFIACION DEL CLIENTE
Route::get('/catalogoverificacion', function () {return view('ventas.Catalogos.catalago_verificacioncliente');});
Route::post('/InformacionSave', [catalagoverificacioninformacionController::class, 'store']);
Route::get('/InformacionDelete', [catalagoverificacioninformacionController::class, 'store']);
Route::get('/Tablaverificacioncliente', [catalagoverificacioninformacionController::class, 'Tablaverificacioncliente']);


//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////COMPRAS///////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//==============================================  M.R  ============================================== 

Route::get('/requisicionmateriales', function () {return view('compras.requisicionesmaterial.requisicion_material');});
Route::post('/MrSave', [mrController::class, 'store']);
Route::get('/Tablamr', [mrController::class, 'Tablamr']);
Route::get('/obtenerAreaSolicitante', [mrController::class, 'obtenerAreaSolicitante'])->middleware('auth');
Route::post('/guardarYDarVistoBueno', [mrController::class, 'guardarYDarVistoBueno']);
Route::post('/rechazar', [mrController::class, 'rechazar']);

//==============================================  M.R APRUEBA LIDER  ============================================== 

Route::get('/requisicionmaterialeslideres', function () {return view('compras.requisicionesmaterial.requisicionlider');});
Route::get('/Tablarequisicion', [mrController::class, 'Tablarequisicion']);

//==============================================  M.R APRUEBA DIRECCION  ============================================== 

Route::get('/Tablarequsicionaprobada', [mrController::class, 'Tablarequsicionaprobada']);
Route::get('/requisicionmaterialesaprobacion', function () {return view('compras.requisicionesmaterial.requisiconaprobar');});

//==============================================  BITACORA M.R  ============================================== 

Route::get('/bitacora', [mrController::class, 'index']);
Route::get('/Tablabitacora', [mrController::class, 'Tablabitacora']);
Route::post('/guardarHOJAS', [mrController::class, 'guardarHOJAS']);
Route::get('/api/hoja-trabajo/{no_mr}', [mrController::class, 'obtenerPorMR']);
Route::get('/mostrarcotizacionq1/{id}', [mrController::class, 'mostrarcotizacionq1']);
Route::get('/mostrarcotizacionq2/{id}', [mrController::class, 'mostrarcotizacionq2']);
Route::get('/mostrarcotizacionq3/{id}', [mrController::class, 'mostrarcotizacionq3']);
Route::get('/mr/{id}/generar-pdf', [pdfController::class, 'descargarPDF'])->name('mr.generar.pdf');

//==============================================  BITACORA M.R  2025 ============================================== 

Route::get('/bitacoramrhistorial', [bitacora2025Controller::class, 'index']);
Route::get('/Tablabitacoramrhistorial', [bitacora2025Controller::class, 'Tablabitacoramrhistorial']);


//==============================================   DIRECTORIO INTERNO  ============================================== 

Route::get('/bancoproveedores', function () {return view('compras.proveedores.proveedorespotencial');});
Route::get('/Tabladirectorio', [directorioController::class, 'Tabladirectorio']);
Route::get('/ServicioDelete', [directorioController::class, 'store']);
Route::get('/Tablaverificacionproveedor', [directorioController::class, 'Tablaverificacionproveedor']);
Route::get('/mostrarverificacionproveedor/{id}', [directorioController::class, 'mostrarverificacionproveedor']);


//==============================================    LISTA DE PROVEEDORES  ============================================== 

Route::get('/listaproveedores', [listaproveedorController::class, 'index']);
Route::get('/Tablalistaproveedores', [listaproveedorController::class, 'Tablalistaproveedores']);
Route::post('/AltaSave1', [listaproveedorController::class, 'store']);
Route::get('/listaproveedorDelete', [listaproveedorController::class, 'store']);
Route::get('/Tablacuentas', [listaproveedorController::class, 'Tablacuentas']);
Route::get('/Tablacontactos', [listaproveedorController::class, 'Tablacontactos']);
Route::get('/Tablacertificaciones', [listaproveedorController::class, 'Tablacertificaciones']);
Route::get('/Tablareferencias', [listaproveedorController::class, 'Tablareferencias']);
Route::get('/Tabladocumentosoporteproveedores', [listaproveedorController::class, 'Tabladocumentosoporteproveedores']);
Route::get('/documentosProveedorAdmin/{rfc}', [listaproveedorController::class, 'documentosProveedorAdmin']);
Route::post('/enviarCorreoFaltantes/{id}', [listaproveedorController::class, 'enviarCorreoFaltantes']);
Route::post('/actualizarVerificacionSolicitada', [listaproveedorController::class, 'actualizarVerificacionSolicitada']);
Route::post('/verificarEstadoVerificacion', [listaproveedorController::class, 'verificarEstadoVerificacion']);
Route::post('/verificarestadobloqueoproveedor', [listaproveedorController::class, 'verificarestadobloqueoproveedor']);
Route::get('/AltaDelete', [listaproveedorController::class, 'store']);

///// INACTIVO 

Route::get('/Tablalistaproveedorinactivo', [listaproveedorController::class, 'Tablalistaproveedorinactivo']);
Route::post('/activarProveedor', [listaproveedorController::class, 'activarProveedor']);
Route::post('/enviarCorreoActualizacionDocs', [listaproveedorController::class, 'enviarCorreoActualizacionDocs']);

///// ASIGNACIONES PROVEEDOR

Route::get('/Tablasignacionproveedor', [listaproveedorController::class, 'Tablasignacionproveedor']);
Route::get('/Tablasignacionproveedorgeneral', [listaproveedorController::class, 'Tablasignacionproveedorgeneral']);
Route::get('/TablasignacionproveedorEditar', [listaproveedorController::class, 'TablasignacionproveedorEditar']);
Route::get('/mostrarasignacionproveedor/{id}', [listaproveedorController::class, 'mostrarasignacionproveedor']);
Route::get('/pdfAsignacionproveedor/{id}', [pdfasingacionController::class, 'pdfAsignacionproveedor']);
Route::get('/pdfAsignacionEppproveedor/{id}', [pdfasingacionController::class, 'pdfAsignacionEppproveedor']);

///// CONTRATOS PROVEEDOR
Route::get('/Tablacontratosproveedores', [listaproveedorController::class, 'Tablacontratosproveedores']);
Route::get('/mostrarcontratoproveedor/{id}', [listaproveedorController::class, 'mostrarcontratoproveedor']);

Route::get('/folioContrato', [listaproveedorController::class, 'folioContrato']);
Route::get('/mostraradendacontratoproveedores/{id}', [listaproveedorController::class, 'mostraradendacontratoproveedores']);

///// FACTURAS PROVEEDOR
Route::get('/Tablafacturaproveedoresinterno', [listaproveedorController::class, 'Tablafacturaproveedoresinterno']);
Route::get('/obtenerDetalleFactura', [listaproveedorController::class, 'obtenerDetalleFactura']);
Route::get('/mostrarecibodepago/{id}', [listaproveedorController::class, 'mostrarecibodepago']);


Route::get('/verXMLFactura/{id}', [listaproveedorController::class, 'verXMLFactura']);
Route::get('/verXMLREP/{id}', [listaproveedorController::class, 'verXMLREP']);

//==============================================    LISTA DE CONTRATOS PROVEEDORES  ============================================== 

Route::get('/listacontratosproveedores', function () {return view('compras.listacontratos.listacontratos');});
Route::get('/Tablalistacontratosproveedores', [listacontratosController::class, 'Tablalistacontratosproveedores']);


//==============================================    LISTA DE PROVEEDORES CRITICO  ============================================== 

Route::get('/listaproveedorescriticos', [listaproveedorcriticoController::class, 'index']);
Route::get('/Tablalistaproveedorescriticos', [listaproveedorcriticoController::class, 'Tablalistaproveedorescriticos']);

//==============================================    LISTA DE FACTURAS  ============================================== 
Route::get('/listafacturas', function () {return view('compras.listafactura.listafactura');});
Route::get('/Tablalistafacturasproveedores', [listafacturasController::class, 'Tablalistafacturasproveedores']);
Route::post('/aprobarRechazarFactura',[listafacturasController::class, 'aprobarRechazarFactura']);

//============================================== RELACION DE PAGOS   ============================================== 
Route::get('/relacionpagos', function () {return view('compras.relacionpagos.relacionpagos');});
Route::get('/getFacturasRelacionPagos', [relacionpagoController::class, 'getFacturasRelacionPagos']);
Route::post('/RelacionSave', [relacionpagoController::class, 'store']);
Route::get('/Tablarelacionespago', [relacionpagoController::class, 'Tablarelacionespago']);
Route::get('/RelacionDelete', [relacionpagoController::class, 'store']);
Route::get('/descargarExcelRelacionPagos/{ID}', [relacionpagoController::class, 'descargarExcelRelacionPagos']);



Route::get('/pdfFichaErgonomica', [relacionpagoController::class, 'pdfFichaErgonomica']);

//==============================================     PROVEEDORES TEMPORALES  ============================================== 

Route::get('/proveedorestemporales', function () { return view('compras.listaproveedor.proveedorestemporales');});
Route::post('/TempSave', [proveedortempController::class, 'store']);
Route::get('/Tablaproveedortemporal', [proveedortempController::class, 'Tablaproveedortemporal']);
Route::get('/TempDelete', [proveedortempController::class, 'store']);
Route::get('/mostrarequierecontrato/{id}', [proveedortempController::class, 'mostrarequierecontrato']);


//============================================== ACTUALIZACION DE DOCUMENTOS PROVEEDORES   ============================================== 

Route::get('/verificarPeriodoActualizacion', [altadocumentosController::class, 'verificarPeriodoActualizacion']);
Route::post('/actualizarDocumentoProveedor', [altadocumentosController::class, 'actualizarDocumentoProveedor']);

Route::get('/actualizaciondocumentosproveedor', [actualizaciondocumentosController::class, 'index']);
Route::post('/ActualizarfechasProveedorSave', [actualizaciondocumentosController::class, 'store']);
Route::get('/Tabladocumentosactualizadosproveedor', [actualizaciondocumentosController::class, 'Tabladocumentosactualizadosproveedor']);
Route::get('/mostrardocumentoactualizadoproveedor/{id}', [actualizaciondocumentosController::class, 'mostrardocumentoactualizadoproveedor']);
Route::post('/aprobarDocumentoProveedor',[actualizaciondocumentosController::class, 'aprobarDocumentoProveedor']);
Route::post('/rechazarDocumentoProveedor',[actualizaciondocumentosController::class, 'rechazarDocumentoProveedor']);

Route::get('/aprobardocumentosproveedor', function () { return view('compras.proveedores.actualizaciondocsproveedor.aprobaciondocs');});
Route::get('/Tabladocumentosaprobacionproveedor', [actualizaciondocumentosController::class, 'Tabladocumentosaprobacionproveedor']);

Route::post('/aprobarDocumentoProveedorFinal', [actualizaciondocumentosController::class, 'aprobarDocumentoProveedorFinal']);
Route::post('/rechazarDocumentoProveedorFinal', [actualizaciondocumentosController::class, 'rechazarDocumentoProveedorFinal']);

//==============================================    ORDEN DE COMPRA - ACTUALES  ============================================== 

Route::get('/ordencompra', [poController::class, 'index']);
Route::get('/Tablaordencompra', [poController::class, 'Tablaordencompra']);
Route::get('/ordencompraaprobacion', [poController::class, 'index1']);
Route::get('/Tablaordencompraprobacion', [poController::class, 'Tablaordencompraprobacion']);
Route::post('/PoSave', [poController::class, 'store']);
Route::get('/obtenerNombreUsuario/{id}', [poController::class, 'obtenerNombreUsuario']);
Route::get('/generarPDFPO/{id}', [pdfpoController::class, 'generarPDFPO']);
Route::post('/enviarCorreoPO', [pdfpoController::class, 'enviarCorreoPO']);


//==============================================    ORDEN DE COMPRA - HISTORIAL  ============================================== 
Route::get('/ordencomprahistorial', [pohistorialController::class, 'index']);
Route::get('/Tablaordencomprahistorial', [pohistorialController::class, 'Tablaordencomprahistorial']);


//==============================================    MATRIZ COMPARATIVA  ============================================== 

Route::get('/matrizcomparativa', [matrizController::class, 'index']);
Route::get('/Tablamatrizcomparativa', [matrizController::class, 'Tablamatrizcomparativa']);
Route::post('/MatrizSave', [matrizController::class, 'store']);
Route::get('/matrizaprobacion', [matrizController::class, 'index1']);
Route::get('/Tablamatirzaprobada', [matrizController::class, 'Tablamatirzaprobada']);

//==============================================    RECEPCION DE BIENES Y/O SERVICIOS - GR  ============================================== 

Route::get('/bitacoragr', [grController::class, 'index']);
Route::get('/Tablabitacoragr', [grController::class, 'Tablabitacoragr']);
Route::post('/guardarGR', [grController::class, 'guardarGR']);
Route::post('/consultar-gr', [grController::class, 'consultarGR'])->name('consultar.gr');
Route::get('/generarGRpdf/{id}', [pdfgrController::class, 'generarGRpdf']);
Route::post('/enviarCorreoGR', [pdfgrController::class, 'enviarCorreoGR']);

/// VO.BO USUARIO EN GR 

Route::get('/vobogrusuario', [vobogrusuarioController::class, 'index']);
Route::get('/TablaVoBoGRusuarios', [vobogrusuarioController::class, 'TablaVoBoGRusuarios']);
Route::get('/ConsultarProductosVoBo/{idGR}', [vobogrusuarioController::class, 'ConsultarProductosVoBo']);
Route::post('/guardarVoBoUsuario', [vobogrusuarioController::class, 'guardarVoBoUsuario']);


//==============================================    RECEPCION DE BIENES Y/O SERVICIOS - GR HISTORIAL ============================================== 

Route::get('/bitacoragrhistorial', [grhistorialController::class, 'index']);
Route::get('/Tablabitacoragrhistorial', [grhistorialController::class, 'Tablabitacoragrhistorial']);

//==============================================   CATALOGOS PROVEEDORES  ============================================== 
Route::get('/catalogosproveedores', function () {return view('compras.Catalogos.catalogo_generales');});


//  CATALOGO FUNCIONES/AREAS CONTACTOS
Route::get('/catalogofunciones', function () {return view('compras.Catalogos.catalogo_funcionproveedor');});
Route::post('/FuncionesareasSave', [catalagofuncionesproveedorController::class, 'store']);
Route::get('/Tablafuncionescontacto', [catalagofuncionesproveedorController::class, 'Tablafuncionescontacto']);
Route::get('/FuncionesareasDelete', [catalagofuncionesproveedorController::class, 'store']);

//  CATALOGO TITULO 
Route::get('/catalogotitulos', function () { return view('compras.Catalogos.catalogo_titulosproveedor');});
Route::post('/TituloSave', [catalagotituloproveedorController::class, 'store']);
Route::get('/Tablatitulocontacto', [catalagotituloproveedorController::class, 'Tablatitulocontacto']);
Route::get('/TituloDelete', [catalagotituloproveedorController::class, 'store']);

//  CATALOGO VERIFICACION DE LA INFORMACION DEL PROVEEDOR 
Route::get('/catalogoverificacionproveedor', function () {return view('compras.Catalogos.catalogo_verificacionproveedor');});
Route::get('/Tablacatalogoverificacionproveedor', [catalogoverificacionproveedorController::class, 'Tablacatalogoverificacionproveedor']);
Route::post('/CatVerProSave', [catalogoverificacionproveedorController::class, 'store']);
Route::get('/CatVerProDelete', [catalogoverificacionproveedorController::class, 'store']);

//  CATALOGO DOCUMENTOS DE SOPORTE DEL PROVEEDOR 
Route::get('/catalogodocumentosoporte', function () {return view('compras.Catalogos.catalogo_documentosoporte');});
Route::post('/DocumentosSave', [catalagodocumentosproveedorController::class, 'store']);
Route::get('/Tabladocumentosoportes', [catalagodocumentosproveedorController::class, 'Tabladocumentosoportes']);
Route::get('/DocumentosDeleteProveedor', [catalagodocumentosproveedorController::class, 'store']);


//==============================================  MODULO PROVEEDOR  ============================================== 

Route::post('/ServiciosSave', [directorioController::class, 'store']);
Route::get('/mostrarconstanciaproveedor/{id}', [directorioController::class, 'mostrarconstanciaproveedor']);
Route::post('/actualizarinfoproveedor', [directorioController::class, 'actualizarinfoproveedor'])->name('actualizarinfoproveedor');
Route::post('/enviarCorreoProveedor', [directorioController::class, 'enviarCorreoProveedor']);
Route::post('/verificarProveedor', [directorioController::class, 'verificarProveedor']);

//  ALTA 
Route::get('/alta', function () { return view('compras.proveedores.altaproveedores');})->name('Alta');
Route::get('/obtenerDatosProveedor', [altaproveedorController::class, 'obtenerDatosProveedor']);
Route::post('/AltaSave', [altaproveedorController::class, 'store']);
Route::post('/solicitarValidacion', [altaproveedorController::class, 'solicitarValidacion']);
Route::get('/verificarBloqueoPorVerificacion', [altaproveedorController::class, 'verificarBloqueoPorVerificacion']);
Route::get('/verificarcontratoproveedor', [altaproveedorController::class, 'verificarcontratoproveedor']);

//ALTA DE CERTIFICACIONES
Route::get('/proveedorescertificaciones', function () {return view('compras.proveedores.altacertificacion');});
Route::post('/AltacertificacionSave', [altacerticacionController::class, 'store']);
Route::get('/Tablacertificacionproveedores', [altacerticacionController::class, 'Tablacertificacionproveedores']);
Route::get('/CertificacionDelete', [altacerticacionController::class, 'store']);
Route::get('/mostrarcertificacion/{id}', [altacerticacionController::class, 'mostrarcertificacion']);
Route::get('/mostraracreditacion/{id}', [altacerticacionController::class, 'mostraracreditacion']);
Route::get('/mostrarautorizacion/{id}', [altacerticacionController::class, 'mostrarautorizacion']);
Route::get('/mostrarmembresia/{id}', [altacerticacionController::class, 'mostrarmembresia']);

//ALTA DE REFERENCIAS 
Route::get('/proveedoresreferencias', function () {return view('compras.proveedores.altareferencias');});
Route::post('/AltareferenciaSave', [altareferenciasController::class, 'store']);
Route::get('/Tablareferenciasproveedor', [altareferenciasController::class, 'Tablareferenciasproveedor']);
Route::get('/ReferenciasDelete', [altareferenciasController::class, 'store']);

//ALTA DE CONTACTOS
// Route::get('/Proveedores_Contactos', function () {return view('compras.proveedores.altacontactos');});
Route::get('/proveedorescontactos', [altacontactoController::class, 'index']);
Route::get('/Tablacontactosproveedor', [altacontactoController::class, 'Tablacontactosproveedor']);
Route::post('/AltacontactoSave', [altacontactoController::class, 'store']);
Route::get('/ContactoDelete', [altacontactoController::class, 'store']);

//ALTA DOCUMENTOS DE SOPORTE
Route::get('/proveedoresdocumentos', [altadocumentosController::class, 'index']);
Route::get('/Tabladocumentosproveedores', [altadocumentosController::class, 'Tabladocumentosproveedores']);
Route::post('/AltaDocumentosSave', [altadocumentosController::class, 'store']);
Route::get('/DocumentosDelete', [altadocumentosController::class, 'store']);
Route::get('/mostrardocumentosoporteproveedor/{id}', [altadocumentosController::class, 'mostrardocumentosoporteproveedor']);
Route::get('/documentosRegistrados', [altadocumentosController::class, 'documentosRegistrados']);

//ALTA DE CUENTAS BANCARIAS 
Route::get('/proveedorescuentas', function () { return view('compras.proveedores.altacuentas');});
Route::post('/AltacuentaSave', [altacuentaController::class, 'store']);
Route::get('/Tablacuentasproveedores', [altacuentaController::class, 'Tablacuentasproveedores']);
Route::get('/CuentasDelete', [altacuentaController::class, 'store']);
Route::get('/mostrarcaratula/{id}', [altacuentaController::class, 'mostrarcaratula']);

// CONTRATOS
Route::get('/contratoproveedores', function () {return view('compras.proveedores.contratosproveedores');});
Route::get('/Tablaproveedorescontrato', [contratoproveedorController::class, 'Tablaproveedorescontrato']);

// ORDEN DE COMPRA (PO) Y RECEPCIONES DE BIENES (GR)  
Route::get('/po-gr', function () { return view('compras.proveedores.factura.poygrproveedor');});
Route::get('/Tablapoproveedor', [ordencompraproveedorController::class, 'Tablapoproveedor']);
Route::get('/Tablagrproveedor', [ordencompraproveedorController::class, 'Tablagrproveedor']);

// CARGAR FACTURA
Route::get('/factura', function () { return view('compras.proveedores.factura.facturacion');});
Route::get('/validarContratoVigente', [facturaproveedorController::class, 'validarContratoVigente']);
Route::post('/validarPOGR', [facturaproveedorController::class, 'validarPOGR']);
Route::get('/obtenerTipoProveedor', [facturaproveedorController::class, 'obtenerTipoProveedor']);
Route::post('/validarContratoNumero', [facturaproveedorController::class, 'validarContratoNumero']);
Route::post('/FacturacionSave', [facturaproveedorController::class, 'store']);
Route::get('/Tablafacturaproveedores', [facturaproveedorController::class, 'Tablafacturaproveedores']);
Route::get('/mostrarsoportefactura/{id}', [facturaproveedorController::class, 'mostrarsoportefactura']);
Route::get('/mostrarfactura/{id}', [facturaproveedorController::class, 'mostrarfactura']);
Route::get('/validarPuedeSubirFactura', [facturaproveedorController::class, 'validarPuedeSubirFactura']);
Route::get('/obtenerContratosProveedor', [facturaproveedorController::class, 'obtenerContratosProveedor']);

// CARGAR RECIBO ELECTRONICO (REP)
Route::get('/reciboelectronico', function () {return view('compras.proveedores.factura.reciborep');});
Route::get('/Tablacargarrecp', [facturaproveedorController::class, 'Tablacargarrecp']);
Route::get('/mostrareciboelectronico/{id}', [facturaproveedorController::class, 'mostrareciboelectronico']);



//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////ALMACEN//////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//==============================================    INVENTRARIO  ============================================== 

Route::get('/inventario', [inventarioController::class, 'index']);
Route::get('/Tablainventario', [inventarioController::class, 'Tablainventario']);
Route::post('/InventarioSave', [inventarioController::class, 'store']);
Route::get('/equipofoto/{id}', [inventarioController::class, 'mostrarFotoEquipo'])->name('equipofoto');
Route::get('/inventarioDelete', [inventarioController::class, 'store']);
Route::get('/generarCodigoAF', [inventarioController::class, 'generarCodigoAF']);
Route::get('/generarCodigoANF', [inventarioController::class, 'generarCodigoANF']);
Route::get('/cantidadEquipoReadonly', [inventarioController::class, 'cantidadEquipoReadonly']);
Route::get('/metricasInventario', [inventarioController::class, 'metricasInventario']);

/// TABLA INVENTARIO INACIVO 
Route::get('/inventarioinactivo', [inventarioController::class, 'indexinactivo']);
Route::get('/Tablainventarioinactivo', [inventarioController::class, 'Tablainventarioinactivo']);

/// ENTRADA INVENTARIO
Route::get('/Tablaentradainventario', [inventarioController::class, 'Tablaentradainventario']);
Route::post('/inventario/respaldar', [inventarioController::class, 'respaldarInventario'])->name('inventario.respaldar');

/// DOCUMENTOS DEL EQUIPO
Route::get('/Tabladocumentosinventario', [inventarioController::class, 'Tabladocumentosinventario']);
Route::get('/mostrardocumentoquipo/{id}', [inventarioController::class, 'mostrardocumentoquipo']);
Route::post('/guardarRequiereItem', [inventarioController::class, 'guardarRequiereItem']);

/// DETALLE DOCUMENTO
Route::post('/guardarDetallearticulo', [inventarioController::class, 'guardarDetallearticulo']);
Route::get('/Tabladetallearticulos', [inventarioController::class, 'Tabladetallearticulos']);

/// VISUALIZAR FECHAS DE DOCUMENTOS 
Route::get('/obtenerDocumentosPorInventario/{inventario_id}', [inventarioController::class, 'obtenerDocumentosPorInventario']);

//==============================================   CATALOGOS INVENTRARIO  ============================================== 

Route::get('/catalogosinventarios', function () { return view('almacen.Catalogos.catalogo_inventarios');});

/// TIPO
Route::get('/catalogotipoinventario', function () { return view('almacen.Catalogos.catalogo_tipo');});
Route::post('/TipoinventarioSave', [catalogotipoinventarioController::class, 'store']);
Route::get('/Tablatipoinventario', [catalogotipoinventarioController::class, 'Tablatipoinventario']);
Route::get('/TipoinventarioDelete', [catalogotipoinventarioController::class, 'store']);

/// KIT
Route::get('/catalogokits', function () { return view('almacen.Catalogos.catalogo_kits');});
Route::post('/KitsSave', [catalogokitsController::class, 'store']);
Route::get('/Tablakits', [catalogokitsController::class, 'Tablakits']);
Route::get('/KitsDelete', [catalogokitsController::class, 'store']);

//==============================================   APROBACION DE SOLICITUDES  ============================================== 
Route::get('/aprobacionalmacen', function () {return view('almacen.aprobarsolicitudes.aprobarsolicitudes');});
Route::get('/Tablaaprobacionalmacen', [aprobacionsalidalmacenController::class, 'Tablaaprobacionalmacen']);

//==============================================    SALIDA DE ALMACEN   ============================================== 
Route::get('/salidaalmacen', [salidalmacenController::class, 'index']);
Route::get('/Tablasalidalmacen', [salidalmacenController::class, 'Tablasalidalmacen']);
Route::post('/SalidalmacenSave', [salidalmacenController::class, 'store']);

//==============================================    LISTA DE AF   ============================================== 
Route::get('/listadeaf', [listaafController::class, 'index']);
Route::get('/Tablalistadeaf', [listaafController::class, 'Tablalistadeaf']);

//==============================================    LISTA DE AFN   ============================================== 
Route::get('/listadeafn', [listaafnController::class, 'index']);
Route::get('/Tablalistadeafn', [listaafnController::class, 'Tablalistadeafn']);

//==============================================    LISTA DE COMERCIALIZACION   ==============================================
Route::get('/listadecomercializacion', [listacomercializacionController::class, 'index']);
Route::get('/Tablalistacomercializacion', [listacomercializacionController::class, 'Tablalistacomercializacion']);

//==============================================    LISTA DE ITEMS CRITICOS   ==============================================
Route::get('/listadeitemcriticos', [listaitemcriticoController::class, 'index']);
Route::get('/Tablalistaitemcriticos', [listaitemcriticoController::class, 'Tablalistaitemcriticos']);

//==============================================    LISTA DE ALERTAS INVENTARIO  ==============================================
Route::get('/listadealertas', [listaalertaController::class, 'index']);
Route::get('/Tablalistadealertas', [listaalertaController::class, 'Tablalistadealertas']);

//==============================================    LISTA DE ASIGNACION  ==============================================
Route::get('/listadeasignacion', [listaasignacionController::class, 'index']);
Route::get('/Tablalistadeasignacion', [listaasignacionController::class, 'Tablalistadeasignacion']);

//==============================================    LISTA DE INFRAESTRUCURA  ==============================================

Route::get('/listadeinfraestructura', [listainfraestructuraController::class, 'index']);
Route::get('/Tablalistainfraestructura', [listainfraestructuraController::class, 'Tablalistainfraestructura']);



//==============================================    BITACORAS   ============================================== 

/// CONSUMIBLES

Route::get('/bitacoraconsumibles', [bitacoraconsumiblesController::class, 'index']);
Route::get('/Tablabitacoraconsumibles', [bitacoraconsumiblesController::class, 'Tablabitacoraconsumibles']);
Route::get('/obtenerMaterialIndividual', [bitacoraconsumiblesController::class, 'obtenerMaterialIndividual']);
Route::post('/BitacoraSave', [bitacoraconsumiblesController::class, 'store']);

/// RETORNABLES

Route::get('/bitacoraretornables', [bitacoraretornableController::class, 'index']);
Route::get('/Tablabitacoraretornable', [bitacoraretornableController::class, 'Tablabitacoraretornable']);
Route::get('/obtenerMaterialRetornable', [bitacoraretornableController::class, 'obtenerMaterialRetornable']);
Route::post('/BitacoraRetornableSave', [bitacoraretornableController::class, 'store']);

/// VEHICULOS

Route::get('/bitacoravehiculos', [bitacoravehiculosController::class, 'index']);
Route::get('/Tablabitacoravehiculos', [bitacoravehiculosController::class, 'Tablabitacoravehiculos']);
Route::get('/obtenerMaterialVehiculos', [bitacoravehiculosController::class, 'obtenerMaterialVehiculos']);
Route::post('/BitacoraVehiculoSave', [bitacoravehiculosController::class, 'store']);
Route::get('/obtenerDatosInventarioVehiculo',[bitacoravehiculosController::class, 'obtenerDatosInventarioVehiculo']);
Route::get( '/obtenerImagenesBitacora',[bitacoravehiculosController::class, 'obtenerImagenesBitacora'])->name('bitacora.obtenerImagenes');
Route::get('/bitacora/vehiculo/imagen/{id}', [bitacoravehiculosController::class, 'mostrarImagenBitacora'] )->name('bitacora.mostrarImagen');
Route::get('/obtenerLicenciaPersona', [bitacoravehiculosController::class, 'obtenerLicenciaPersona']);

/// ASIGNACION

Route::get('/bitacoraasignacion', [bitacoraasignacionController::class, 'index']);
Route::get('/Tablabitacoraasignacion', [bitacoraasignacionController::class, 'Tablabitacoraasignacion']);
Route::get('/obtenerMaterialAsingnacion', [bitacoraasignacionController::class, 'obtenerMaterialAsingnacion']);
Route::post('/BitacoraAsignacionSave', [bitacoraasignacionController::class, 'store']);



//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////MANTENIMIENTO////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//==============================================    LISTA DE MANTENIMIENTO DE EQUIPOS   ============================================== 

Route::get('/mantenimientoequipos', [listamantenimientoController::class, 'index']);
Route::get('/Tablamantenimiento', [listamantenimientoController::class, 'Tablamantenimiento']);
Route::post('/MantenimientoSave', [listamantenimientoController::class, 'store']);
Route::get('/MantenimientoDelete', [listamantenimientoController::class, 'store']);
Route::get('/mostrarFotoEquipoMan/{id}', [listamantenimientoController::class, 'mostrarFotoEquipoMan'])->name('mostrarFotoEquipoMan');
Route::get('/cantidadEquipoReadonlyMan', [listamantenimientoController::class, 'cantidadEquipoReadonlyMan']);
Route::post('/guardarRequiereCalibracion', [listamantenimientoController::class, 'guardarRequiereCalibracion']);

/// VISUALIZAR FECHAS DE DOCUMENTOS 
Route::get('/obtenerDocumentosPorMantenimiento/{inventario_id}', [listamantenimientoController::class, 'obtenerDocumentosPorMantenimiento']);

/// DOCUMENTOS DEL MANTENIMIENTO
Route::get('/Tabladocumentomantenimiento', [listamantenimientoController::class, 'Tabladocumentomantenimiento']);
Route::get('/mostrardocumentomantenimiento/{id}', [listamantenimientoController::class, 'mostrardocumentomantenimiento']);
Route::get('/FotosDocMtto/{id}', [listamantenimientoController::class, 'FotosDocMtto'])->name('FotosDocMtto');

/// CALIBRACION EQUIPO
Route::get('/Tablacalibracionmantenimiento', [listamantenimientoController::class, 'Tablacalibracionmantenimiento']);
Route::get('/mostrardocumentocalibracion/{id}', [listamantenimientoController::class, 'mostrardocumentocalibracion']);

/// MTTO CRITERIO, PROGRAMACION Y BITACORA   

Route::get('/obtenerInformacionMtto', [listamantenimientoController::class, 'obtenerInformacionMtto']);


//==============================================    LISTA DE MANTENIMIENTO DE INSTALACIONES   ============================================== 
Route::get('/mantenimientoinstalaciones', [listainstalacionController::class, 'index']);
Route::post('/MttoInstalacionSave', [listainstalacionController::class, 'store']);
Route::get('/mostrarFotoInstalacion/{id}', [listainstalacionController::class, 'mostrarFotoInstalacion'])->name('mostrarFotoInstalacion');
Route::get('/Tablalistainstalacion', [listainstalacionController::class, 'Tablalistainstalacion']);
Route::get('/MttoInstalacionDelete', [listainstalacionController::class, 'store']);



//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////PAGINA WEB///////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

Route::get('/mensajespaginaweb', function () { return view('pagina_web.mensajespagina');});
Route::get('/Tablamensajepaginaweb', [mensajespaginaController::class, 'Tablamensajepaginaweb']);
Route::get('/MensajespaginaDelete', [mensajespaginaController::class, 'store']);
Route::post('/PaginawebSave', [mensajespaginaController::class, 'store']);
Route::get('/mensajespaginawebhistorial', function () { return view('pagina_web.mensajespaginahistorial');});
Route::get('/Tablamensajepaginawebhistorial', [mensajespaginaController::class, 'Tablamensajepaginawebhistorial']);


//==============================================  RUTAS EXTERNAS  ============================================== 
Route::get('/inicio', function () { return view('RH.externa.diseño');});
Route::get('/Formulario-vacantes', [bancocvController::class, 'index1']); 
Route::get('/Vacantes', [PuestoController::class, 'index']); 
Route::get('/Proveedor', function () { return view('compras.externa.diseño'); });
Route::get('/Directorio', function () { return view('compras.proveedores.directorio');});



//==============================================  NOTIFICACIONES  ============================================== 

Route::get('/notificaciones', [notificacionController::class, 'notificaciones']);


//============================================== C.P ============================================== 


Route::get('codigo-postal/{cp}', function ($cp) {

    Log::info('Consulta CP desde: ' . request()->ip() . ', User-Agent: ' . request()->header('User-Agent'));

    $token = "a5ba768d-eeac-4c0f-b0be-202ef91df93c";
    $url = "https://api.copomex.com/query/info_cp/{$cp}?type=simplified&token={$token}";

    try {
        $response = Http::timeout(10)->get($url);

        Log::info('Respuesta de Copomex para CP ' . $cp . ': ' . $response->body());

        if ($response->successful()) {
            return response()->json($response->json());
        }

        return response()->json([
            'error' => true,
            'mensaje' => 'No se pudo obtener información de Copomex',
            'status' => $response->status(),
            'detalle' => $response->body()
        ], 400);
    } catch (\Exception $e) {
        Log::error('Error en consulta CP ' . $cp . ': ' . $e->getMessage());

        return response()->json([
            'error' => true,
            'mensaje' => 'Error de conexión con el servicio: ' . $e->getMessage(),
            'detalle' => 'Excepción capturada en el servidor'
        ], 500);
    }
});


//============================================== LIMPIAR RUTAS ============================================== 


Route::get('/clear-cache', function () {
    Artisan::call('config:cache');
    Artisan::call('config:clear');
    Artisan::call('cache:clear');
    Artisan::call('route:clear');
    Artisan::call('view:clear');
    return 'Application cache cleared';
});

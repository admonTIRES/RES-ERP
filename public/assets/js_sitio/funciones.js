const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))




function mostrarCarga() {
    document.getElementById("modal-overlay").style.display = "block";
}

function ocultarCarga() {
    document.getElementById("modal-overlay").style.display = "none";
}

function formatoFecha(texto) {
  if (texto)
    return texto.replace(/^(\d{4})-(\d{2})-(\d{2})$/g, '$3/$2/$1');

  return '';
}

//formatea la Edad de sql
function formatoEdad(texto) {
  if (texto) {
    // Convierte la cadena en un número
    var numero = parseFloat(texto);

    // Verifica si el número tiene decimales y cuántos
    var decimales = (numero % 1 !== 0) ? texto.split('.')[1].length : 0;

    // Utiliza toFixed para formatear el número con la cantidad correcta de decimales
    return numero.toFixed(decimales).replace(/^(\d{4})-(\d{2})-(\d{2})$/g, '$3/$2/$1');
  }

  return '';
}

jQuery.fn.exists = function () { return this.length > 0; }

function formatoFechaSQL(fecha, formato) {
  const map = {
    dd: fecha.getDate(),
    mm: fecha.getMonth() + 1,
    // yy: fecha.getFullYear().toString().slice(-2),
    yy: fecha.getFullYear()
  }

  return formato.replace(/dd|mm|yy|yyy/gi, matched => map[matched]);
}

function formatoFecha2(fecha, optionsDate = [3, 1, 2, 2, 1, 1, 1], formatMat = 'best fit') {
  if (fecha == null)
    return '';
  // let options = {
  //   hourCycle: 'h12', //<-- Formato de 12 horas
  //   timeZone: 'America/Mexico_City'
  // } // p.m. - a.m.

  const options = {
    timeZone: 'America/Mexico_City',
    hourCycle: 'h12',
    weekday: ['narrow', 'short', 'long'][optionsDate[0] - 1],
    year: ['numeric', '2-digit'][optionsDate[1] - 1],
    month: ['narrow', 'short', 'long', 'numeric', '2-digit'][optionsDate[2] - 1],
    day: ['numeric', '2-digit'][optionsDate[3] - 1],
    hour: ['numeric', '2-digit'][optionsDate[4] - 1],
    minute: ['numeric', '2-digit'][optionsDate[5] - 1],
    seconds: ['numeric', '2-digit'][optionsDate[6] - 1]
  };

  let date;
  if (fecha.length == 10) {
    date = new Date(fecha + 'T00:00:00')
  } else {
    date = new Date(fecha)
  }

  // //console.log(date)
  return date.toLocaleDateString('es-MX', options)
}

function calcularQuincena() {
  var fechaActual = new Date();
  var añoActual = fechaActual.getFullYear();
  var mesActual = fechaActual.getMonth(); // Enero es 0 en JavaScript
  var primerDiaMes = new Date(añoActual, mesActual, 1);
  var ultimoDiaMes = new Date(añoActual, mesActual + 1, 0); // El día 0 es el último día del mes anterior
  var mitadDelMes = new Date(añoActual, mesActual, 15);

  var inicioQuincena, finQuincena;
  if (fechaActual.getDate() <= 15) {
    inicioQuincena = primerDiaMes;
    finQuincena = mitadDelMes;
  } else {
    inicioQuincena = new Date(añoActual, mesActual, 16);
    finQuincena = ultimoDiaMes;
  }

  // Formatear fechas para yyyy-mm-dd
  function formatearFecha(fecha) {
    var año = fecha.getFullYear();
    var mes = ('0' + (fecha.getMonth() + 1)).slice(-2);
    var dia = ('0' + fecha.getDate()).slice(-2);
    return año + '-' + mes + '-' + dia;
  }

  return {
    fechaInicio: formatearFecha(inicioQuincena),
    fechaFinal: formatearFecha(finQuincena)
  };
}



function calcularEdad(fecha) {
  var hoy = new Date(), cumpleanos = new Date(fecha);
  var edad = hoy.getFullYear() - cumpleanos.getFullYear();
  var m = hoy.getMonth() - cumpleanos.getMonth();

  if (m < 0 || (m === 0 && hoy.getDate() < cumpleanos.getDate()))
    edad--;
  return edad;
}



//Ajax Async (NO FORM DATA SUPPORT)
async function ajaxAwait(dataJson, apiURL, method,
  config = {
    alertBefore: false
  },
  //Callback
  callbackBefore = function (data) {
    alertMsj({
      title: 'Espera un momento...',
      text: 'Estamos cargando tu solicitud, esto puede demorar un rato',
      icon: 'info',
      showCancelButton: false
    })
  },
  //Callback, antes de devolver la data
  callbackSuccess = function (data) {
    console.log('callback ajaxAwait por defecto')
  }
) {
  return new Promise(function (resolve, reject) {
    //Configura la funcion misma
    config = configAjaxAwait(config)


    $.ajax({
      url: apiURL,
      data: dataJson,
      dataType: 'json',
      type: method,
      beforeSend: function () {
        config.callbackBefore ? callbackBefore() : 1;
      },
      success: function (data) {
        let row = data;
        try {
          if (config.response) {
            if (mensajeAjax(row)) {
              config.callbackAfter ? callbackSuccess(config.WithoutResponseData ? row.response.data : row) : 1;
              config.returnData ? resolve(config.WithoutResponseData ? row.response.data : row) : resolve(1)
            }
          } else {
            config.callbackAfter ? callbackSuccess(config.WithoutResponseData ? row.response.data : row) : 1;
            config.returnData ? resolve(config.WithoutResponseData ? row.response.data : row) : resolve(1)
          }
        } catch (error) {
          alertMensaje('error', 'Error', 'Datos/Configuración erronea', error);
          console.error(error);
        }

      },
      error: function (jqXHR, exception, data) {
        alertErrorAJAX(jqXHR, exception, data)
        // console.log('Error')
      },
    })
  });
}

//
function configAjaxAwait(config) {
  //valores por defecto de la funcion ajaxAwait y ajaxAwaitFormData
  const defaults = {
    alertBefore: false, //Alerta por defecto, "Estamos cargando la solucitud" <- Solo si la api consume tiempo
    response: true, //Si la api tiene la estructura correcta (response.code)
    callbackBefore: false, //Activa la function antes de enviar datos, before
    callbackAfter: false, //Activa una funcion para tratar datos enviados desde ajax, osea success
    returnData: true, // regresa los datos o confirmado (1)
    WithoutResponseData: false, //Manda los datos directos
    resetForm: false, //Reinicia el formulario en ajaxAwaitFormData,
    ajaxComplete: () => { }, //Mete una funcion para cuando se complete
    ajaxError: () => { }, //Mete una funcion para cuando de error
  }

  Object.entries(defaults).forEach(([key, value]) => {
    config[key] = config[key] ?? value;
  });
  return config;
}





//Ajax Async FormData

async function ajaxAwaitFormData(dataJson = { api: 0, }, apiURL, form = 'OnlyForm'  /* <-- Formulario sin # */,btn = 'OnlyBtn',
  config = {
      alertBefore: false
  },
  //Callback antes de enviar datos
  callbackBefore = () => {
    alertMsj({
      title: 'Espera un momento...',
      text: 'Estamos cargando tu solicitud, esto puede demorar un rato',
      icon: 'info',
      showCancelButton: false
    })
  },
  //Callback, antes de devolver la data
  callbackSuccess = () => {
    console.log('callback ajaxAwait por defecto')
  }
) {

    return new Promise(function (resolve, reject) {

    //Configura la funcion misma
    config = configAjaxAwait(config)

    let formID = document.getElementById(form);
      let formData = new FormData(formID);
      
     

    for (const key in dataJson) {
      if (Object.hasOwnProperty.call(dataJson, key)) {
        const element = dataJson[key];
        if (!ifnull(formData.get(`${key}`), false)) {
          formData.set(`${key}`, element);
        }
      }
    }

    $.ajax({
      url: apiURL,
      data: formData,
      processData: false,
      contentType: false,
      dataType: 'json',
      type: 'POST',
      beforeSend: function () {
          config.callbackBefore ? callbackBefore() : 1;
            // $('#' + btn).html('Guardando... <img src="/assets/images/loaderbtn.gif" alt="" style="max-width: 100%; max-height: 40px;">').prop('disabled', true).removeClass('btn-success').addClass('btn-light');  
        
        //   mostrarCarga()
      },
        success: function (data) {
            $('#'+btn).html('Guardar').prop('disabled', false).removeClass('btn-light').addClass('btn-success');
            //  $('#'+btn).html('Guardando... <img src="/assets/images/loaderbtn.gif" alt="" style="max-width: 100%; max-height: 40px;">').prop('disabled', true).removeClass('btn-success').addClass('btn-light');  
            // ocultarCarga()
        config.resetForm ? formID.reset() : false;
        if (config.response) {
          if (mensajeAjax(data)) {
            config.callbackAfter ? callbackSuccess(config.WithoutResponseData ? data.response.data : data) : 1;
            config.returnData ? resolve(config.WithoutResponseData ? data.response.data : data) : resolve(1)
          }
        } else {
          config.callbackAfter ? callbackSuccess(config.WithoutResponseData ? data.response.data : data) : 1;
          config.returnData ? resolve(config.WithoutResponseData ? data.response.data : data) : resolve(1)
        }

      },
      // complete: ajaxComplete(),
      error: function (jqXHR, exception, data) {
        // ajaxError()
        alertErrorAJAX(jqXHR, exception, data)
      },
    })
  } );
}


//Obtener numero rando
function getRandomInt(max) {
  return Math.floor(Math.random() * max);
}

function getRandomString() {
  var n = Math.floor(Math.random() * 11);
  var k = Math.floor(Math.random() * 1000000);
  var m = String.fromCharCode(n) + k;
  return m;
}

// Checa si es un numero
function checkNumber(x, transform = 0) {
  // check if the passed value is a number
  if (typeof x == 'number' && !isNaN(x)) {
    // check if it is integer
    if (Number.isInteger(x)) {
      return 1
    } else {
      return 1
    }
  } else {
    if (transform)
      return parseInt(x); //Entero
    return 0
  }
}


function ifnull(data, siNull = '', values =
  [
    'option1',
    {
      'option2': [
        'suboption1',
        {
          'suboption2': ['valor']
        }
      ],
      'option3': 'suboption1'
    },
    'option4',
  ], callback = (bool) => { return bool }) {

  values = ((typeof values === 'object' && !Array.isArray(values)) || (typeof values === 'string'))
    ? [values]
    : values;

  // Comprobar si el dato es nulo o no es un objeto
  if (!data || typeof data !== 'object') {
    if (data === undefined || data === null || data === 'NaN' || data === '' || data === NaN) {
      switch (siNull) {
        case 'number': return callback(0)
        case 'boolean': return callback(data ? true : false)
        default: return callback(siNull)
      }
    } else {

      let data_modificado = escapeHtmlEntities(`${data}`);

      switch (siNull) {
        case 'number':
          // No hará modificaciones
          break;
        case 'boolean': return callback(ifnull(data, false) ? true : false)
        default:
          //Agregará las modificaciones nuevas
          data = data_modificado
          break;
      }

      return callback(data)
    }
  }
  // Iterar a través de las claves en values
  for (const key of values) {
    if (typeof key === 'string' && key in data) {
      return callback(data[key] || siNull)
    } else if (typeof key === 'object') {
      for (const nestedKey in key) {
        const result = ifnull(data[nestedKey], siNull, key[nestedKey]);
        if (result) return callback(ifnull(result, siNull))
      }
    }
  }

  return callback(siNull)
}


function htmlCaracter(data) {

  st = document.getElementById('ent').value;
  st = st.replace(/&/g, "&amp;");
  st = st.replace(/</g, "&lt;");
  st = st.replace(/>/g, "&gt;");
  st = st.replace(/"/g, "&quot;");
  document.getElementById('result').innerHTML = '' + st;
}

function escapeHtmlEntities(input) {
  if (!input || typeof input !== 'string') {
    return input;
  }

  const replacements = {
    '"': '&quot;',
    '<': '&lt;',
    '>': '&gt;',
    "'": '&apos;',
  };

  const regex = new RegExp(Object.keys(replacements).join('|'), 'g');

  const result = input.replace(regex, match => replacements[match]);

  // Si el resultado aún contiene un & no reemplazado y no es seguido por caracteres, reemplazarlo con &amp;
  if (result.includes('&') && !/[a-zA-Z0-9#]/.test(result.charAt(result.indexOf('&') + 1))) {
    return result.replace('&', '&amp;');
  }

  return result;
}



function firstMayus(str) {
  str = str.charAt(0).toUpperCase() + str.slice(1);
  return str;
}

function truncate(str, maxlength) {
  return (str.length > maxlength) ?
    str.slice(0, maxlength - 1) + '…' : str;
}

//Especifico para areas dinamicas de un valor
function deletePositionString(str, position) {
  str = str.slice(0, position);
  return str;
}

function deleteSpace(str) {
  return str.replace(/ /g, "");
}


$(window).resize(function () {
  //aqui el codigo que se ejecutara cuando se redimencione la ventana
  // var alto=$(window).height();
  // var ancho=$(window).width();
  // alert("alto: "+alto+" ancho:"+ancho);

  $.fn.dataTable
    .tables({
      visible: true,
      api: true
    })
    .columns.adjust();
})

$(document).on('change click', 'input[type="file"]', function () {
  // //console.log($(this)[0])
  if ($(this)[0].files.length > 1) {
    var filename = `${$(this)[0].files.length} Archivos...`;
  } else {
    var filename = $(this).val().split('\\').pop();
    var extension = $(this).val().split('.').pop();

    var filename = filename.replace(`.${extension}`, '')

  }


  // //console.log(filename);
  var label = $(this).parent('div').find('label[class="input-file-label"]')
  if ($(this).val() == '') {
    label.html(`<i class="bi bi-box-arrow-up"></i> Seleccione un archivo`)
  } else {
    label.html(`File: ${truncate(filename, 15)} | ${extension}`)
  }
})

function resetInputLabel() {
  const label = $(`input[type="file"]`).parent('div').find('label[class="input-file-label"]')
  label.html(`<i class="bi bi-box-arrow-up"></i> Seleccione un archivo`)
}

// config = myfunctionconfig(config);

// Esta funcion solo funciona para un solo input,
// si hay mas de uno debe llamarse tantas veces sea posible
let selectedFilesCount = 0;
function InputDragDrop(divPadre, callback = () => { console.log('callback default') }, config = { multiple: false }) {


  let dropArea = $(divPadre) // <- Recomendaible una ID tipo #divPadre
  let inputArea = $(divPadre).find('input'); // <- Deseable a que solo exista un input
  let labelArea = $(divPadre).find('label');// <- Si deseas modificar el texto del div añadelo
  let divCarga = $(divPadre).find('div')//<- Opcional se agrego para hacer un Spinners de bootraps


  // Personalización 
  if (ifnull(config, false, ['width'])) {
    dropArea.css('width', config.width)
  }


  // Antes de configurar la funcionalidad para el nuevo paciente, realiza la limpieza
  dropArea.off();
  labelArea.off();

  // Restaura los elementos DOM al estado original
  inputArea.val(''); // Elimina cualquier archivo seleccionado previamente
  labelArea.html(`Sube tu archivo arrastrándolo aquí`) // Restaura el texto original
  selectedFilesCount = 0; // Reinicia el contador si es necesario

  // Efecto de hover
  // Aviso al input que hay un archivo encima de él
  let hoverInput = (cambio = false) => {

    if (cambio) {
      // Entrada 
      dropArea.addClass('hover_dropDrag');


    } else {
      // Salida
      dropArea.removeClass('hover_dropDrag');

    }

  }

  // Efecto de cargando, subiendo
  // Avisa se coloca aqui mismo antes de ejecutar callback
  let cargandoInput = () => {
    // Valida el tipo de archivo a mandar


    //efecto para cambiar de color el div
    dropArea.css({
      // "color": "red",
      // "font-size": "18px",
      // "background-color": "yellow",
      "border-color": "#00bbb9",
      "background-color": "#c6cacc"

    });
    dropArea.css("font-weight", "bold");
    labelArea.html('Cargando...')
    divCarga.css({ 'display': 'inline-block' })
  }

  // Efecto de cargando e imagen subida lista;
  // Aviso que debe ejecutar callback para saber si ya se subió
  let salidaInput = (msj = 'Archivo actualizado') => {
    // Crear efecto de imagen subida
    // console.log('Salida de input')

    labelArea.html(`${msj}</br> <strong>¿Desea subir otro? </strong>`)
    divCarga.css({ 'display': 'none' })

    dropArea.css({
      'background': '#f4fdff',
      'border': '2px dashed rgb(0 79 90 / 17%)'
    })
  }


  let envioFiles = () => {

    const files = inputArea[0].files;
    if (config.multiple || files.length <= 1) {
      callback(inputArea, salidaInput);
    } else {

      divCarga.css({ 'display': 'none' })

      dropArea.css({
        'background': '#f4fdff',
        'border': '2px dashed rgb(0 79 90 / 17%)'
      })
      labelArea.html('No puedes subir más de un archivo.');
      // alert('No puedes subir más de un archivo.');
      // Restaura el contador de archivos seleccionados
      selectedFilesCount = 0;
      // Restaura el input de archivos
      inputArea.val('No puedes subir más de un archivo.');
    }
    // callback(inputArea, salidaInput);
  }


  dropArea.on('dragenter dragover', function (e) {
    // Prevenir recarga y propagation a otros input
    e.preventDefault();
    e.stopPropagation();

    hoverInput(1)// <- Agrega efecto de entrada
  })

  dropArea.on('dragleave', function (e) {
    // Prevenir recarga y propagation a otros input
    e.preventDefault();
    e.stopPropagation();
    hoverInput(0) // <- Agrega efecto de salida
  })

  // Majeno de arrastrar y soltar
  dropArea.on('drop', function (e) {

    const files = e.originalEvent.dataTransfer.files;
    inputArea[0].files = files;

    hoverInput(0) // <- Agrega efecto de salida y soltar

    // Prevenir recarga y propagation a otros input
    e.preventDefault();
    e.stopPropagation();

    // Dar el efecto de cargando o subiendo
    cargandoInput()

    // callback
    envioFiles() // <- Recordar que debes terminar el proceso de cargando a salida

  })

  inputArea.on('change', function () { // <- se cambio por labelArea
    // Dar el efecto de cargando o subiendo
    cargandoInput()

    // callback
    envioFiles() // <- Recordar que debes terminar el proceso de cargando a salida
  })
}


let lightbox = '#lightbox';
let lightbox_img = '#lightbox-img'
// $(document).on('click', '.lightbox-image', (e) => {
//   let imgSrc = $(this).prop('src');
//   alert(imgSrc.split(',')[1]);

//   let img = $(this)
//   $(lightbox_img).prop('src', (img.prop("src")).split(',')[1])
//   $(lightbox).css('display', 'flex');
//   console.log($(lightbox), img)
//   console.log('¡Imagen abierta!')
// })

// $(document).on('click', '#lightbox', (e) => {
//   $(lightbox).css('display', 'none')
// })



function resetInputFile() {
  $('input[type="file"]').each(function () {
    $(this).val('')
    var label = $(this).parent('div').find('label[class="input-file-label"]')
    label.html(`<i class="bi bi-box-arrow-up"></i> Seleccione un archivo`)
  });
}


function DownloadFromUrl(fileURL, fileName) {
  var link = document.createElement('a');
  link.href = fileURL;
  link.download = fileName;
  document.body.appendChild(link);
  link.click();
  document.body.removeChild(link);
}


function desactivarCampo(div, fade) {
  if (fade == 1) {
    $(div).fadeIn(400);
  } else {
    $(div + ": input").val("");
    $(div).fadeOut(400);
  }
}

// Notifiación  movil
if (window.innerWidth <= 768) {
  position = 'top';
} else {
  position = 'top';
  // position = 'top-start';
}

const Toast = Swal.mixin({
  toast: true,
  position: position,
  showConfirmButton: false,
  timerProgressBar: true,
  didOpen: (toast) => {
    toast.addEventListener('mouseenter', Swal.stopTimer)
    toast.addEventListener('mouseleave', Swal.resumeTimer)
  }
});

function isJson(str) {

  // //console.log(typeof str)

  if (typeof str === 'object') {
    return true;
  } else {
    return false;
  }
  // return false;
  // try {
  //   JSON.parse(str);
  // } catch (e) {
  //   return false;
  // }
  // return true;
}


function setSegmentoOption(select, idProcedencia, idSegmento) {
  var select = document.getElementById(select),
    length = select.options.length;
  while (length--) {
    select.remove(length);
  }
  $.ajax({
    url: http + servidor + "/" + appname + "/api/segmentos_api.php",
    type: "POST",
    data: {
      id: idProcedencia,
      api: 6
    },
    success: function (data) {
      var data = jQuery.parseJSON(data);
      if (mensajeAjax(data)) {
        if (data['response']['data'].length > 0) {
          for (var i = 0; i < data['response']['data'].length; i++) {
            var content = data['response']['data'][i]['segmento'];
            var value = data['response']['data'][i]['id'];
            var el = document.createElement("option");
            el.textContent = content;
            el.value = value;
            if (value == idSegmento) {
              el.selected = true;
            }
            select.appendChild(el);
          }
        } else {
          var content = "No contiene segmentos";
          var value = "";
          var el = document.createElement("option");
          el.textContent = content;
          el.value = value;

          select.appendChild(el);
        }
      }
    },
    error: function (jqXHR, exception, data) {
      alertErrorAJAX(jqXHR, exception, data)
    },
  });

  return true;
}


function rellenarSelect(select = false, api, apinum, v, c, values = {}, callback = function (array) { }) {
  return new Promise(resolve => {
    values.api = apinum;

    let htmlContent;
    // Crear arreglo de contenido
    if (!Number.isInteger(c)) {
      htmlContent = c.split('.');
    }

    $(select).find('option').remove().end()

    $.ajax({
      url: http + servidor + "/" + appname + "/api/" + api + ".php",
      data: values,
      type: "POST",
      // dataType: "json",
      success: function (data) {

        if (typeof data == "string" && data.indexOf('response') > -1) {
          data = JSON.parse(data);
          if (!mensajeAjax(data))
            return false;
          data = data['response']['data'];
          // data = data['data'];
        } else {
          data = JSON.parse(data);
        }

        let selectHTML = '';
        for (const key in data) {
          if (Object.hasOwnProperty.call(data, key)) {
            const element = data[key];
            // Crear el contenido del select por numero o arreglo
            if (Array.isArray(htmlContent)) {
              datao = "";
              for (var a = 0; a < htmlContent.length; a++) {
                if (element[htmlContent[a]] != null) {
                  if (datao == '') {

                    datao += element[htmlContent[a]];
                  } else {
                    datao += " - " + element[htmlContent[a]];
                  }
                }
                // //console.log(datao)

              }
            } else {
              datao = element[c];
            }
            // Rellenar select con Jquery
            var o = new Option("option text", element[v]);
            $(o).html(datao);
            selectHTML += $(o)[0].outerHTML
            if (select) {
              $(select).append(o);
            }
          }
        }

        // //console.log(data);
        callback(data, selectHTML);
      },
      complete: function (data) {
        resolve(1);
      },
      error: function (jqXHR, exception, data) {
        alertErrorAJAX(jqXHR, exception, data)
      },
    })
  });
}


function setSelectContent(array, select, v, c, reset = 1, selected) {
  //console.log(array);
  if (reset) $(select).find('option').remove().end()
  for (const key in array) {
    if (Object.hasOwnProperty.call(array, key)) {
      const element = array[key];
      //console.log(element)
      var o = new Option("option text", element[v]);
      $(o).html(element[c]);
      $(select).append(o);
    }
  }
}


function optionElement(select, value, content) {
  var o = new Option("option text", value);
  $(o).html(content);
  $(select).append(o);
  el.setAttribute('selected', 'selected');
}


$(window).on('hashchange', function (e) {
  var hash = window.location.hash.substring(1);
  switch (hash) {
    case 'LogOut':
      // window.location.hash = '';
      window.location.href = http + servidor + '/' + appname + '/vista/login/';
      break;
    default:
      break;
  }
});

function getParameterByName(name) {
  name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
  var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
    results = regex.exec(location.search);
  return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
}


function loader(fade, scroll = null) {
  if (fade == 'Out') {
    $("#loader").fadeOut(100);
    $('body').removeClass('overflow-hidden');
    // let alturanav = $('nav [class="navbar navbar-expand-lg border-3 border-bottom border-dark bg-navbar"]').height()
    // //console.log(alturanav)
    // $("html, body").animate({ scrollTop: alturanav + "px" });
    // alert("salir");
  } else if (fade == 'In') {
    $("html, body").animate({ scrollTop: "0px" });
    $("#loader").fadeIn(100);
    $('body').addClass('overflow-hidden')
    // alert("entrar");
  }
  if (scroll == 'bottom') {
    let altura = $(document).height();
    $("html, body").animate({ scrollTop: altura + "px" });
  }


}

function loaderDiv(fade, div = null, loader, loaderDiv1 = null, seconds = 50, scroll = 0) {
  switch (fade) {
    case "Out":
      if (div != null) {
        $(div).fadeIn(seconds);
      }

      if (loaderDiv1 != null) {
        $(loaderDiv1).fadeOut(seconds);
      }
      $(loader).fadeOut(seconds);
      // alert("salir");
      break;

    case "In":
      if (div != null) {
        $(div).fadeOut(seconds);
      }
      if (loaderDiv1 != null) {
        $(loaderDiv1).fadeIn(seconds);
      }
      $(loader).fadeIn(seconds);
      // alert("entrar");
      break;

    default:
    // //console.log('LoaderDiv se perdió...')
  }
  // if (scroll == 'bottom') {
  //   let altura = $(document).height();
  //   $("html, body").animate({ scrollTop: altura + "px" });
  // }
}

//Poder ajustar responsivamente una ventana en windows
function autoHeightDiv(div, resta, tipe = 'px') {
  var ventana_alto = $(window).height();
  ventana_alto_porcentaje = Math.floor(ventana_alto * resta) / 100;

  if (div == 0) {
    if (tipe == 'px')
      return (ventana_alto - resta);
    if (tipe == '%')
      return (ventana_alto_porcentaje);
  } else {
    if (tipe == 'px')
      $(div).height(ventana_alto - resta);
    if (tipe == '%')
      $(div).height(ventana_alto_porcentaje);
    return 0;
  }
}

// Mismas funciones, diferentes nombres por no querer cambiar el nombre donde lo llaman xd
function alertSelectTable(msj = 'No ha seleccionado ningún registro', icon = 'error', timer = 2000) {
  Toast.fire({
    icon: icon,
    title: msj,
    timer: timer,
    // width: 'auto'
  });
}

function alertToast(msj = 'No ha seleccionado ningún registro', icon = 'error', timer = 3000) {
  Toast.fire({
    icon: icon,
    title: msj,
    timer: timer,
    // width: 'auto'
  });
}
// 


function alertMensaje(icon = 'success', title = '¡Completado!', text = 'Datos completados', footer = null, html = null, timer = null) {
  Swal.fire({
    icon: icon,
    title: title,
    text: text,
    html: html,
    footer: footer,
    timer: timer
    // width: 'auto',
  })
}



function alertMensaje1(icon = 'success', title = '¡Completado!', text = 'Datos completados', footer = null, html = null, timer = null) {
  Swal.fire({
    icon: icon,
    title: title,
    text: text,
    html: html,
    footer: footer,
    timer: timer,
    showConfirmButton: false,  // No muestra el botón "OK"
    timerProgressBar: true,    // Muestra una barra de progreso
    
  });
}



function alertMsj(options, callback = function () { }) {

  if (!options.hasOwnProperty('title'))
    options['title'] = "¿Desea realizar esta acción?"

  if (!options.hasOwnProperty('text'))
    options['text'] = "Probablemente no podrá revertirlo"

  if (!options.hasOwnProperty('icon'))
    options['icon'] = 'warning'

  if (!options.hasOwnProperty('showCancelButton'))
    options['showCancelButton'] = true

  if (!options.hasOwnProperty('confirmButtonColor'))
    options['confirmButtonColor'] = '#3085d6'

  if (!options.hasOwnProperty('cancelButtonColor'))
    options['cancelButtonColor'] = '#d33'

  if (!options.hasOwnProperty('confirmButtonText'))
    options['confirmButtonText'] = 'Aceptar'

  if (!options.hasOwnProperty('cancelButtonText'))
    options['cancelButtonText'] = 'Cancelar'

  if (!options.hasOwnProperty('allowOutsideClick'))
    options['allowOutsideClick'] = false
  // if (!options.hasOwnProperty('timer'))
  //   options['timer'] = 4000
  // if (!options.hasOwnProperty('timerProgressBar'))
  //   options['timerProgressBar'] = true
  //
  Swal.fire(options).then((result) => {
    callback(result);
  })
}

function alertMensajeConfirm(options, callback = function () { }, set = 0, callbackDenied = function () { }, callbackCanceled = function () {

}) {

  //Options si existe
  switch (set) {
    case 1:
      if (!options.hasOwnProperty('title'))
        options['title'] = "¿Desea realizar esta acción?"

      if (!options.hasOwnProperty('text'))
        options['text'] = "Probablemente no podrá revertirlo"

      if (!options.hasOwnProperty('icon'))
        options['icon'] = 'warning'

      if (!options.hasOwnProperty('showCancelButton'))
        options['showCancelButton'] = true

      if (!options.hasOwnProperty('confirmButtonColor'))
        options['confirmButtonColor'] = '#3085d6'

      if (!options.hasOwnProperty('cancelButtonColor'))
        options['cancelButtonColor'] = '#d33'

      if (!options.hasOwnProperty('confirmButtonText'))
        options['confirmButtonText'] = 'Aceptar'

      if (!options.hasOwnProperty('cancelButtonText'))
        options['cancelButtonText'] = 'Cancelar'

      if (!options.hasOwnProperty('allowOutsideClick'))
        options['allowOutsideClick'] = false
      // if (options.hasOwnProperty('timer'))
      //   options['timer'] = 4000
      // if (options.hasOwnProperty('timerProgressBar'))
      //   options['timerProgressBar'] = true
      //
      break;
    default:
      if (!options) {
        options = {
          title: "¿Desea realizar esta acción?",
          text: "Probablemente no podrá revertirlo",
          icon: "info",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          confirmButtonText: "Aceptar",
          cancelButtonText: "Cancelar",
          // allowOutsideClick: false
          // timer: 4000,
          // timerProgressBar: true,
          //   showDenyButton: true,
          // denyButtonText: `Don't save`,
          // denyButtonColor: "#d33";
        }
      }
      break;
  }


  Swal.fire(options).then((result) => {
    if (result.isConfirmed || result.dismiss === "timer") {
      callback()
    } else if (result.isDenied) {
      callbackDenied();
    } else if (result.dismiss === Swal.DismissReason.cancel) {
      callbackCanceled();
    }
  })
}

//Valida la  contraseña del usuario para ejecutar algunas acciones
function alertPassConfirm(alert = {
  title: 'Titulo por defecto :)',
  icon: 'info'
}, callback = () => { }) {
  Swal.fire({
    title: alert['title'],
    // text: 'Se creará el grupo con los pacientes seleccionados, ¡No podrás revertir los cambios',
    icon: alert['icon'],
    showCancelButton: true,
    confirmButtonText: 'Confirmar',
    cancelButtonText: 'Cancelar',
    showLoaderOnConfirm: true,
    // inputAttributes: {
    //   autocomplete: false
    // },
    // input: 'password',
    html: `<form autocomplete="off" onsubmit="formpassword(); return false;"><input type="password" id="password-confirmar" class="form-control input-color" autocomplete="off" placeholder="${alert['placeholder'] ? alert['placeholder'] : 'Ingrese su contraseña para confirmar'}"></form>`,
    // confirmButtonText: 'Sign in',
    focusConfirm: false,
    didOpen: () => {
      const passwordField = document.getElementById('password-confirmar');
      passwordField.setAttribute('autocomplete', 'new-password');
    },
    preConfirm: () => {
      const password = Swal.getPopup().querySelector('#password-confirmar').value;


      switch (alert['fetch']) {
        case 'turnero':
          url_fetch = `${http}${servidor}/${appname}/api/turnero_api.php?api=8&clave_secreta=${password}`
          break;

        default:
          url_fetch = `${http}${servidor}/${appname}/api/usuarios_api.php?api=9&password=${password}`
          break;
      }


      return fetch(url_fetch)
        .then(response => {
          if (!response.ok) {
            throw new Error(response.statusText)
          }
          return response.json()
        })
        .catch(error => {
          Swal.showValidationMessage(
            `Request failed: ${error}`
          )
        });
    },
    allowOutsideClick: () => !Swal.isLoading()
  }).then((result) => {
    if (result.isConfirmed) {
      if (result.value.status == 1) {
        callback();
      } else {
        alertSelectTable('¡Está incorrecto!', 'error')
      }
    }


  })
}


// function mensajeAjax(data, modulo = null) {
//   if (modulo != null) {
//     text = ' No pudimos cargar'
//   }

//     try {
//     switch (data['code']) {
//       case 1:
//         return 1;
//         break;
//       case 2:
//         Swal.fire({
//           icon: 'error',
//           title: 'Oops...',
//           text: '¡Ha ocurrido un error!',
//           footer: 'Respuesta: ' + data['response']['msj']
//         })
//         break;
//       case "repetido":
//         Swal.fire({
//           icon: 'error',
//           title: 'Oops...',
//           text: '¡Usted ya está registrado!',
//           footer: 'Utilice su CURP para registrarse en una nueva prueba'
//         })
//         break;
//       case "login":
//         Swal.fire({
//           icon: 'error',
//           title: 'Oops...',
//           text: 'Respuesta: ' + data['response']['msj']
//         })
//         break;
//       case "Token": case "Usernovalid":
//         alertMensajeConfirm({
//           title: "¡Sesión no valida!",
//           text: "El token de su sesión ha caducado, vuelva iniciar sesión",
//           footer: "Redireccionando pantalla...",
//           icon: "info",
//           confirmButtonColor: "#d33",
//           confirmButtonText: "Aceptar",
//           cancelButtonText: false,
//           allowOutsideClick: false,
//           timer: 4000,
//           timerProgressBar: true,
//         }, function () {
//           destroySession();
//           window.location.replace(http + servidor + "/" + appname + "/vista/login/");
//         })

//         break;
//       case "turnero":
//         alertMensajeConfirm({
//           title: "Oops",
//           text: `${data['response']['msj']}`,
//           footer: "Tal vez deberias intentarlo nuevamente",
//           icon: "warning",
//         })

//         break;
//       default:
//         Swal.fire({
//           icon: 'error',
//           title: 'Oops...',
//           text: 'Hubo un problema!',
//           footer: 'No sabemos que pasó, reporta este problema...'
//         })
//     }
//   } catch (error) {
//     alertMensaje('warning', 'Error:', 'No se puedo resolver un conflicto interno con validación, si el problema persiste reporte al encargado de area de esto.', '[Error: api no valida, "response: {code: XXXX}", no existe]')
//     return 0
//   }
//   return 0;
// }



function mensajeAjax(data, modulo = null) {
  if (modulo != null) {
    text = ' No pudimos cargar'
  }

  try {
    switch (data['code']) {
      case 1:
        return 1;
        break;
      case 2:
        Swal.fire({
          icon: 'error',
          title: 'Oops...',
          text: '¡Ha ocurrido un error!',
          footer: 'Respuesta: ' + data['response']['msj']
        });
        break;
      case "repetido":
        Swal.fire({
          icon: 'error',
          title: 'Oops...',
          text: '¡Usted ya está registrado!',
          footer: 'Utilice su CURP para registrarse en una nueva prueba'
        });
        break;
      case "login":
        Swal.fire({
          icon: 'error',
          title: 'Oops...',
          text: 'Respuesta: ' + data['response']['msj']
        });
        break;
      case "Token": case "Usernovalid":
        alertMensajeConfirm({
          title: "¡Sesión no valida!",
          text: "El token de su sesión ha caducado, vuelva iniciar sesión",
          footer: "Redireccionando pantalla...",
          icon: "info",
          confirmButtonColor: "#d33",
          confirmButtonText: "Aceptar",
          cancelButtonText: false,
          allowOutsideClick: false,
          timer: 4000,
          timerProgressBar: true,
        }, function () {
          destroySession();
          window.location.replace(http + servidor + "/" + appname + "/vista/login/");
        });
        break;
      case "turnero":
        alertMensajeConfirm({
          title: "Oops",
          text: `${data['response']['msj']}`,
          footer: "Tal vez deberías intentarlo nuevamente",
          icon: "warning",
        });
        break;
        case 0:
          // Caso específico para la postulación a una vacante
          if (data.msj === 'Ya te has postulado a esta vacante') {
            Swal.fire({
              icon: 'warning',
              title: 'Ya estás postulado a esta vacante',
              text: 'Nos pondremos en contacto contigo pronto.',
              confirmButtonText: 'Entendido'
            });
          } else {
            // Manejo general de otros posibles errores con code 0
            Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: data.msj || 'Hubo un problema!',
              footer: 'Por favor, reporta este problema...'
            });
          }
          break;
      
      
      default:
        Swal.fire({
          icon: 'error',
          title: 'Oops...',
          text: 'Hubo un problema!',
          footer: 'No sabemos qué pasó, reporta este problema...'
        });
    }
  } catch (error) {
    alertMensaje('warning', 'Error:', 'No se pudo resolver un conflicto interno con la validación, si el problema persiste reporte al encargado de área de esto.', '[Error: api no valida, "response: {code: XXXX}", no existe]');
    return 0;
  }
  return 0;
}


function alertErrorAJAX(jqXHR, exception, data) {
  var msg = '';
  //Status AJAX
  // console.log(jqXHR, exception, data)

  switch (jqXHR.status) {
    case 0:
      if (exception != 'abort') {
        alertToast('Sin conexión a internet', 'warning'); return 0
      };
    case 404: //console.log('Requested page not found. [404]'); return 0;
    case 500: alertToast('Internal Server Error', 'info'); return 0;
  }

  switch (exception) {
    case 'parsererror': alertMensaje('info', 'Error del servidor', 'Algo ha pasado, estamos trabajando para resolverlo', 'Mensaje de error: ' + data); return 0
    case 'timeout': //console.log('timeout'); return 0
    case 'abort': return 0
  }

  //console.log(jqXHR.responseText);

}

// $(document).on('click', '#btn-beneficiarios-ujat', function (e) {
//   if (session['permiso']['ExcelInfoBeneUjat']) {
//     $.post("", {
//       tipModalDocumento: 'ExcelInfoBeneUjat'
//     }, function (html) {
//       $("#header-js").html(html);
//     });
//   }
// })




let touchtimeFunction
function detectDobleclick() {
  if (touchtimeFunction == 0) {
    // set first click
    touchtimeFunction = new Date().getTime();
    return false;
  } else {
    // compare first click to this click and see if they occurred within double click threshold
    if (((new Date().getTime()) - touchtimeFunction) < 800) {
      // double click occurred
      touchtimeFunction = 0;
      return true;
    } else {
      // not a double click so set as a new first click
      touchtimeFunction = new Date().getTime();
      return false;
    }
  }
}


//FUNCTION OBSOLETA PARA MOBILE
//Control de tablas
function dblclickDatatable(tablename, datatable, callback = function () { }) {
  // Seleccion del registro
  $(tablename).on('dblclick', 'tr', function () {
    callback(datatable.row(this).data())
  });
}
//

//Solo doble click
var dobleClickSelecTable = false; //Ultimo select ()
function selectDatatabledblclick(callback = function (selected, data) { }, tablename, datatable, disabledDblclick = false) {
  // console.log(tablename)
  if (!disabledDblclick)
    dobleClickSelecTable = false
  $(tablename).on('click', 'tr', function () {
    if (!detectDobleclick())
      return false;
    //Funcion
    if (dobleClickSelecTable != datatable.row(this).data()) {
      //console.log($(this).hasClass('selected'))
      if ($(this).hasClass('selected') == true) {
        dobleClickSelecTable = false
        datatable.$('tr.selected').removeClass('selected');
        // array_selected = datatable.row(this).data()

        return callback(0, null, row);
      }
    }
    if (disabledDblclick == false)
      dobleClickSelecTable = datatable.row(this).data()
    datatable.$('tr.selected').removeClass('selected');
    $(this).addClass('selected');
    array_selected = datatable.row(this).data()
    return callback(1, array_selected, this)

  });
}
$.fn.dataTable.ext.errMode = 'throw';
//Doble y de solo un click
var dobleClickSelecTable = false; //Ultimo select ()
function selectDatatable(tablename, datatable, panel, api = {}, tipPanel = {}, idPanel = {
  0: "#panel-informacion"
}, callback = null, callbackDoubleclick = function (data) {
  console.log('hAzZ dAdo dobBlE cLIk aLa TabBlLa')
}) {
  //Se deben enviar las ultimas 3 variables en arreglo y deben coincidir en longitud
  // //console.log(typeof tipPanel);
  if (typeof tipPanel == "string") {
    // Convierte String a Object
    api = {
      0: api
    };
    tipPanel = {
      0: tipPanel
    };
  } else {
    // Coloca por defecto la ID de panel si no existe ID de envio
    if (idPanel[0] == null) {
      idPanel[0] = "#panel-informacion";
    }
  }
  if (typeof tablename === 'string') {
    tablename = '#' + tablename;
  }
  // //console.log(tablename)
  // //console.log(idPanel)
  $(tablename).on('click', 'tr', function () {

    //Doble Click
    if (detectDobleclick()) {
      if (dobleClickSelecTable == datatable.row(this).data()) {
        callbackDoubleclick(datatable.row(this).data())
      }
    }

    //Solo un click
    if (dobleClickSelecTable != datatable.row(this).data()) {
      if ($(this).hasClass('selected')) {
        dobleClickSelecTable = false
        $(this).removeClass('selected');
        for (var i = 0; i < Object.keys(tipPanel).length; i++) {
          obtenerPanelInformacion(0, api, tipPanel[i], idPanel[i])
        }
        if (callback != null) {
          return callback(0, null);
        }
      } else {
        dobleClickSelecTable = datatable.row(this).data();
        datatable.$('tr.selected').removeClass('selected');
        $(this).addClass('selected');
        array_selected = datatable.row(this).data();
        if (array_selected != null) {
          if (panel) {
            // Lee los 3 objetos para llamar a la funcion
            for (var i = 0; i < Object.keys(tipPanel).length; i++) {
              obtenerPanelInformacion(array_selected['ID_TURNO'], api[i], tipPanel[i], idPanel[i])
            }
          }
          if (callback != null) {
            // alert('select')
            // //console.log(array_selected)
            return callback(1, array_selected); // Primer parametro es seleccion y segundo el arreglo del select del registro
          }
        } else {
          for (var i = 0; i < Object.keys(tipPanel).length; i++) {
            obtenerPanelInformacion(0, api, tipPanel[i], idPanel[i])
          }
          if (callback != null) {
            return callback(0, array_selected);
          }
        }

      }
    } else {
      // //console.log(false)
    }
  })
}

//
function inputBusquedaTable(
  tablename, //<-- Sin #
  datatable, //<-- TablaObjeto
  tooltip = [
    {
      msj: 'Hola, soy un tooltip por defecto :)',
      place: 'bottom'
    },
    {
      msj: 'Aqui puedo ocultar mensajes para ayudarte',
      place: 'right'
    }
  ], //<- tooltips
  tooltipinput =
    {
      msj: 'Filtra la lista por coincidencias',
      place: 'top'
    },
  classInput = 'col-sm-12 col-md-6',
  classList = 'col-sm-12 col-md-6',
) {
  setTimeout(() => {
    // Obtener elementos
    const select = $(`#${tablename}_length label select`).first();
    const filterDiv = $(`#${tablename}_filter`).first();
    const input = $(`#${tablename}_filter label input`).first();
    console.log(input);
    const label = $(`#${tablename}_filter label`).first();

    // Configurar tooltips
    tooltipinput['msj'] = tooltipinput['msj'] || 'Filtra la lista por coincidencias';
    tooltipinput['place'] = tooltipinput['place'] || 'top';

    select.removeClass().addClass('input-form');
    removeTextNode(label);

    input.removeClass().addClass('input-form form-control')
      .attr({
        'placeholder': "Filtrar coincidencias",
        'style': 'margin: 0px !important',
        'data-bs-toggle': "tooltip",
        'data-bs-placement': tooltipinput['place'],
        title: tooltipinput['msj']
      });

    const newDivElement = $('<div>').addClass('text-center mt-2');
    const newInputGroupDiv = $('<div>').addClass('input-group flex-nowrap');
    newInputGroupDiv.append(createTooltipHtml(tooltip)).append(input);
    newDivElement.append(newInputGroupDiv);

    filterDiv.after(newDivElement);
    $(`#${tablename}_wrapper`).children('div [class="row"]').eq(1).css('zoom', '90%');

    let divList = filterDiv.parent();
    divList.removeClass('col-sm-12 col-md-6');
    divList.addClass(classInput)

    filterDiv.empty();

  }, 300);

}

function removeTextNode(node) {
  node.contents().filter(function () {
    return this.nodeType === 3; // Filtra los nodos de texto
  }).remove();
}

function createTooltipHtml(tooltipData) {
  let html = '';
  for (const key in tooltipData) {
    if (Object.hasOwnProperty.call(tooltipData, key)) {
      const element = tooltipData[key];
      html += `
                <span class="input-span" id="addon-wrapping" data-bs-toggle="tooltip" 
                    data-bs-placement="${element['place']}" title="${element['msj']}" 
                    style="margin-bottom: 0px !important">
                    <i class="bi bi-info-circle"></i>
                </span>`;
    }
  }
  return html;
}
//



// Configuraciones por defecto para select table
function configSelectTable(config) {
  //valores por defecto de la funcion ajaxAwait y ajaxAwaitFormData
  const defaults = {
    dblClick: false, // Aceptar doble click
    unSelect: false, // Deseleccionar un registro
    anotherClass: 'other-for-table', //Cuando sea seleccionado, se agrega la clase, sino se quita
    ignoreClass: '',
    tabs: [
      {
        title: 'Información',
        element: '#tab-informacion',
        class: 'disabled tab-select'
      },
      {
        title: 'Reporte',
        element: '#tab-reporte',
        class: 'disabled tab-select'
      },
    ],
    "tab-id": '#tab-button',
    "tab-default": 'Reporte',  //Por default, al dar click, abre aqui
    reload: false, //Activa la rueda [Example:  reload: ['col-xl-9'] ]
    movil: false, //Activa la version movil
    multipleSelect: false,
    OnlyData: false,
    noColumns: false,
    // alwaySelected: false,
    ClickClass: [
      {
        class: '.',
        callback: function (data) {

        },
        selected: true
      },
      {
        class: '.',
        callback: function (data) {

        },
        selected: false
      }
    ],
    divPadre: false, //Busca dentro del div las clases, si no hay buscará cualquiera
    visibleColumns: false, // Mantiene activo los DIV en modo escritorio
  }

  Object.entries(defaults).forEach(([key, value]) => {
    config[key] = config[key] ?? value;
  });
  return config;
}
//Detecta la dimension del dispositivo para saber si es movil o escritorio
function isMovil(callback = (response) => { }) {
  var esTabletaVertical = /iPad/i.test(navigator.userAgent)
  // && window.innerHeight > window.innerWidth;
  var esDispositivoMovil = /Android|webOS|iPhone|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) || esTabletaVertical;

  if (esDispositivoMovil)
    callback(esDispositivoMovil);
  return esDispositivoMovil;

  let width = window.innerWidth;
  let height = window.innerHeight;

  if ((width <= 768 && height <= 1366) || (height <= 1366 && width <= 1366)) {
    callback(true);
    return true;
  } else {
    return false;
  }
}

//Visualiza los botones de navegacion
function selecTableTabs() {
  isMovil() ? $('.tab-page-table').fadeIn(0) : $('.tab-page-table').fadeOut(0);
}

// Para la version movil crea y visualiza columnas
function getBtnTabs(config, reloadName) {
  if (config.tabs) {
    let row = config.tabs;
    let html = `<ul class="nav nav-tabs mt-2 tab-page-table" style="display:none">`;
    for (const key in row) {
      if (Object.hasOwnProperty.call(row, key)) {
        const element = row[key];

        html += `<li class="nav-item">
                    <a class="nav-link ${element.class ? element.class : ''} tab-table" data-id-column="${element['element']}" data-reload-column="${reloadName}" id="tab-btn-${element.title}" style="cursor: pointer">${element.title}</a>
                  </li>`;
      }
    }
    html += `</ul>`
    $(config['tab-id']).html(html)

    return true;
  }
}

//Visualiza la columna solo en movil
let dinamicTabFunction = false;
let documentClick = false;
let loader_selectTable = false;  //No usar, en desuso global, solo en selectTable
function dinamicTabs() {
  // dinamicTabFunction = false;
  // // loader = loader
  // isMovil(() => {
  //   dinamicTabFunction = () => {
  //     // console.log('IS MOVIL')
  //     documentClick = false;
  //     // documentClick = 
  //   }

  //   dinamicTabFunction();
  // })

}

// Cambio de tab
$(document).on('click', '.tab-table', function () {
  // loader = loader
  let btn = $(this);
  isMovil(() => {
    if (!btn.hasClass('active')) {

      $('.tab-first').fadeOut(100);
      $('.tab-second').fadeOut(0);

      $('.tab-table').removeClass('active');
      btn.addClass('active');

      setTimeout(() => {
        let id = btn.attr('data-id-column');
        let loader = btn.attr('data-reload-column');
        // console.log(id);
        let loaderVisible = false;

        // console.log(loader_selectTable)
        loaderVisible = function () {
          // console.log($(loader_selectTable))
          if ($(loader).is(":hidden")) {
            $(`${id}`).fadeIn(100);
            $.fn.dataTable
              .tables({
                visible: true,
                api: true
              })
              .columns.adjust();

            loaderVisible = false;
          } else {
            // console.log(loader)
            setTimeout(() => {
              loaderVisible();
            }, 150);
          }
        }
        loaderVisible()
      }, 100);
    }
  })
})

//Agrega el circulo para cargar el panel
function setReloadSelecTable(name, param) {
  let html = `<div class="col-12 col-xl-9 d-flex justify-content-center align-items-center" id='loaderDiv-${name}' style="max-height: 75vh; display:none">
    <div class="preloader" id="loader-${name}"></div>
  </div>`;

  $('#reload-selectable').addClass(`col-12 ${param[0]} d-flex justify-content-center align-items-center`)
  $('#reload-selectable').css('max-height', '75vh')
  $('#reload-selectable').attr("style", "display: none !important");
  $('#reload-selectable').html(`<div class="preloader" id="loader-${name}"></div>`)
  $('#reload-selectable').addClass('loader-tab')

  // $('#reload-selectable').fadeOut('slow');
  $('#reload-selectable').attr('id', `loaderDiv-${name}`)
}

// Sin uso
function reloadSelectTable() {
  if (isMovil()) {
    //Manda al principio
    try {
      $(`.tab-table`)[0].click();
    } catch (error) {
      console.log('BTN class: tab-table not found')
    }
    $('.loader-tab').fadeOut(0)
  } else {
    $('.tab-second').fadeOut();
    // console.log($('.tab-first'))
    $('.tab-first').fadeIn();
    $('.loader-tab').fadeOut(0)
  }

}

//Evalua el estado de click de selectTable
// Arreglo de clases a ignorar
let ignoredClasses = [
  'noClicked', //Algun elemento que podamos crear para que no implique selección
  'dtr-control', //Cuando le da click al primer td con el boton + de visualizar mas columnas
  'child',  //Cuando muestra las columnas ocultas de un regitro
  'dataTables_empty', //Cuando la  tabla esta vacia, no selecciona
];
// Función para verificar si un elemento tiene alguna de las clases ignoradas
const hasIgnoredClass = (elem) => ignoredClasses.some(className => elem.classList.contains(className));

function eventClassClick(event, tr, config, data) {
  //Evalua donde está dando click el usuario
  var clickedElement = event.target;
  ignoredClasses.push(config.ignoreClass) //Ignora el click por algun objeto en clase
  // var computedStyle = window.getComputedStyle(clickedElement, '::before');
  // computedStyle.getPropertyValue('property') === 'value'
  // console.log(computedStyle.getPropertyValue('property') === 'value')
  //Cancela la funcion si el elemento que hace click tiene la siguiente clase
  if (hasIgnoredClass(clickedElement)
    || hasIgnoredClass(tr)
    || $(tr).find('td').hasClass('dataTables_empty') //Ignora si no hay datos que mostrar (serverside)
  )
    return [true, false];

  //Evalua si hay eventos extras que ejecutar
  let rowClick = config.ClickClass;
  for (const key in rowClick) {
    if (Object.hasOwnProperty.call(rowClick, key)) {
      const element = rowClick[key];

      if ($(clickedElement).hasClass(`${element.class}`)) {
        element.callback(data, clickedElement, tr)
        return [true, element.selected];
      }

    }

  }

  return [false, false];
}

function resizeConfigMovil(config, loaderName) {
  if (config.movil) {
    //Cambia la vista del dispositivo
    getBtnTabs(config, loaderName);
    //Activa los botones si es movil
    // console.log(`#loaderDiv-${nameTable}`)

    dinamicTabs()
    //Evalua el tipo de dispositivo
    selecTableTabs()
  }
}

//selectDataTableMovilEdition
let dataDobleSelect, selectTableTimeOutClick, selectTableClickCount = 0;
function selectTable(tablename, datatable,
  config = {
    dblClick: false,
  },
  callbackClick = (select = 1, dataRow = [], callback, tr = '1', row = []) => { },
  callbackDblClick = (select = 1, dataRow = [], callback, tr = '1', row = []) => { }
) {
  //manda valores por defecto
  config = configSelectTable(config)

  //Nombrando para usarlo
  let tableString = tablename.replace('#', '')

  //Permite el reload y lo dibuja
  if (config.reload)
    setReloadSelecTable(tableString, config.reload)

  loader_selectTable = `#loaderDiv-${tableString}`
  //Activa las funciones moviles,
  resizeConfigMovil(config, loader_selectTable);
  resize = false;
  // $(window).resize(function () {
  //   //Toma un tiempo para poder refrescar cambios y no 
  //   //hacerlo cada vez que hay un pequeño pixel de cambio
  //   clearTimeout(resize);
  //   resize = setTimeout(() => {
  //     resizeConfigMovil(config, nameTable);
  //   }, 500);
  // })

  //Callback para procesos, ejemplo: quitar loader y mostrar columnas en escritorio
  let callback = (type = 'Out' || 'In') => {
    if (type === 'In') {
      if (!isMovil() || !config.movil) {
        $('.tab-second').each(function (i) {
          var $item = $(this);
          setTimeout(function () {
            $item.fadeIn(200); // O cualquier otro efecto que desees
          }, 200 * i); // Aumenta el retraso para cada elemento
        });
      }

      $.fn.dataTable
        .tables({
          visible: true,
          api: true
        })
        .columns.adjust();

    }
    $(loader_selectTable).attr("style", "display: none !important");

  }


  //Table Click Registro
  $(`${tablename}`).on(`click`, `tr`, function (event) {
    //Obtener datos, tr, row e información del row
    let tr = this
    let row = datatable.row(tr);
    let dataRow = row.data();

    // let td = $(event.target).is('td')

    // if (config.alwaySelected) {
    //   datatable.$('tr.selected').removeClass('selected');
    //   $(tr).addClass('selected');
    // }


    //Evalua si el objeto es correcto a su click
    let dataClick = eventClassClick(event, tr, config, dataRow);
    if (dataClick[0]) {
      //Verifica si deseas seleccionar o no 
      if (dataClick[1]) {
        //Verifica si ya esta seleccionado
        if (!$(tr).hasClass('selected')) {

          //Reselecciona el tr que interactuas
          selectTable_resetSelect(tr, config)

          //Activar otros tab
          $(`.tab-select`).removeClass('disabled');
          //Reselecciona
          if (config['tab-default']) {
            $(`#tab-btn-${config['tab-default']}`).click();
          }
          //Ejecuta funcion personalizada
          callbackClick(1, dataRow, callback, tr, row);
        }
      }

      return false;
    }

    // Si desea solo obtener los datos
    if (config.OnlyData) {
      return callbackClick(1, dataRow, function (data) { return 'No action' }, tr, row);
    }


    array_selected = row.data();

    selectTableClickCount++;
    if ($(tr).hasClass('selected')) {
      clearTimeout(selectTableTimeOutClick)
      console.log(selectTableClickCount)

      selectTableTimeOutClick = setTimeout(function () {
        if (selectTableClickCount === 1 && config.unSelect === true) {
          //Manda a cargar la vista
          selectTable_cargarVista()

          //Resetea los clicks:
          selectTableClickCount = 0;
          dataDobleSelect = false;

          //Reinicia la seleccion:
          selectTable_resetSelect(tr, false, true)
          //

          //Desactivar otros tab
          $(`.tab-select`).addClass('disabled')

          //Regresa la funcion personalizada
          callbackClick(0, null, callback, null, null);
          //
        } else if (selectTableClickCount === 2 && config.dblClick === true) {
          //Si esta haciendo dobleClick: 
          selectTableClickCount = 0;

          callbackDblClick(1, dataRow, callback, tr, row)

        }

      }, 200)

    } else {
      //Manda a cargar la vista
      // if (!config.noColumns) {
      selectTable_cargarVista()
      // }

      //Si esta seleccionando:
      dataDobleSelect = tr;
      //Tiempo de espera entre multiple click


      //Evalua la selección
      selectTable_resetSelect(tr, config)

      if (config.multipleSelect) {
        //Multiple Seleccion
        //Hará el callback cada que seleccionan a uno nuevo
        let row_length = datatable.rows('.selected').data().length
        let data = datatable.rows('.selected').data()

        callbackClick(row_length, data, null, null)

      } else {
        //Para una sola seleccion

        //Activar otros tab
        $(`.tab-select`).removeClass('disabled');
        //Reselecciona

        if (config['tab-default']) {
          $(`#tab-btn-${config['tab-default']}`).click();
        }

        callbackClick(1, dataRow, callback, tr, row);
      }

    }

    //Reinicia y espera el dobleClick
    setTimeout(() => {
      selectTableClickCount = 0;
    }, 600)

    return 'No action';

  })



  function selectTable_cargarVista() {
    if (config.divPadre) {
      if (!config.visibleColumns)
        $(`${config.divPadre} .tab-second`).fadeOut()
    } else {
      if (!config.visibleColumns)
        $('.tab-second').fadeOut()
    }

    // console.log($(loader_selectTable))
    $(loader_selectTable).fadeIn(0);
  }

  function selectTable_resetSelect(tr, config, resetTR = false) {

    //Deselecciona solo 1
    if (resetTR) {
      $(tr).removeClass('selected');
      $(tr).removeClass(config.anotherClass);
      return true;
    }


    if (!config.multipleSelect) {
      //Reinicia la seleccion:
      datatable.$('tr.selected').removeClass('selected');
      datatable.$('tr.selected').removeClass(config.anotherClass);
      //
    }

    //Agrega la clase para indicar que lo esta seleccionando
    $(tr).addClass('selected');
    $(tr).addClass(config.anotherClass);

    return true;
  }
}


//Panel, este panel se usa ahora en la funcion selectTable, resolviendo el bug
function getPanel(divClass, loader, loaderDiv1, selectLista, fade, callback) { //selectLista es una variable que no se usa 
  switch (fade) {
    case 'Out':
      if ($(divClass).is(':visible')) {
        if (selectLista == null) {
          loaderDiv("Out", null, loader, loaderDiv1, 0);
          $(divClass).fadeOut()
          // //console.log('Invisible!')
        }
      } else {
        // //console.log('Todavia visible!')
        setTimeout(function () {
          return getPanel(divClass, loader, loaderDiv1, selectLista, 'Out')
        }, 100);
      }
      break;
    case 'In':
      $(divClass).fadeOut(0)
      loaderDiv("In", null, loader, loaderDiv1, 0);
      // alert('in');
      return callback(divClass);
      // $(divClass).fadeIn(100)
      break;
    default:
      return 0
  }
  return 1
}

function bugGetPanel(divClass, loaderLo, loaderDiv1, table = '') {
  loaderDiv("Out", null, loaderLo, loaderDiv1, 0);
  while (!$(divClass).is(':visible')) {
    if (!$(divClass).is(':visible')) {
      setTimeout(function () {
        $(divClass).fadeIn(0)
        // loader(0, 'bottom')
        // //console.log("Visible!")
      }, 100)
    }
    $(divClass).fadeIn(0)
  }
  // let altura = $(document).height();
  // $("html, body").animate({ scrollTop: altura + "px" });
}
//


function select2(select, modal = null, placeholder = 'Selecciona una opción', width = '100%') {
  if (!modal) modal = 'body-controlador';
  $(select).select2({
    dropdownParent: $('#' + modal),
    tags: false,
    width: width,
    placeholder: placeholder
  });
}



function selectedTrTable(text, column = 1, table) {
  filter = text.toUpperCase();
  tablesearch = document.getElementById(table);
  tr = tablesearch.getElementsByTagName("tr");
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[column];
    if (td) {
      txtValue = td.textContent || td.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].classList.add("selected");
        return tr[i];
      }
    }
  }
}


function vistaPDF(divContenedor, url, nombreArchivo, callback = function () { }, tipo = {}) {
  $.post(http + servidor + '/' + appname + '/vista/include/funciones/viewer-pdf.php', {
    url: url, nombreArchivo: nombreArchivo, tipo: tipo
  }, function (html) {
    $(divContenedor).html(html);
  }).done(async function () {
    callback()
  })
  // let htmlPDF = '<div id="adobe-dc-view" style="height: 100%"></div>' +
  //   '<script src="https://documentservices.adobe.com/view-sdk/viewer.js"></script>' +
  //   '<script type="text/javascript">' +
  //   'document.addEventListener("adobe_dc_view_sdk.ready", function(){ ' +
  //   'var adobeDCView = new AdobeDC.View({clientId: "cd0a5ec82af74d85b589bbb7f1175ce3", divId: "' + div + '"});' +
  //   'adobeDCView.previewFile({' +
  //   'content:{location: {url: "' + url + '"}},' +
  //   'metaData:{fileName: "' + nombreArchivo + '"}' +
  //   '});' +
  //   '});' +
  //   '</script>';
  // $(divContenedor).html(htmlPDF);
}


//Metodo global
function cambiarFormMetodo(fade, titulo, form = "formEditar") {
  if (fade == 1) {
    $('#RegistrarMetodo' + titulo).fadeOut();
    setTimeout(function () {
      $('#editarMetodo' + titulo).fadeIn();
    }, 400);
  } else {
    //console.log(form)
    document.getElementById(form).reset();
    $('#editarMetodo' + titulo).fadeOut();
    setTimeout(function () {
      $('#RegistrarMetodo' + titulo).fadeIn();
    }, 400);
  }
}

//Scroll zoom images
function ScrollZoom(container, max_scale, factor) {
  var target = container
  var size = {
    w: target.width(),
    h: target.height()
  }
  var pos = {
    x: 0,
    y: 0
  }
  var scale = 1
  var zoom_target = {
    x: 0,
    y: 0
  }
  var zoom_point = {
    x: 0,
    y: 0
  }
  var curr_tranform = target.css('transition')
  var last_mouse_position = {
    x: 0,
    y: 0
  }
  var drag_started = 0

  target.css('transform-origin', '0 0')
  target.on("mousewheel DOMMouseScroll", scrolled)
  target.on('mousemove', moved)
  target.on('mousedown', function () {
    drag_started = 1;
    target.css({
      'cursor': 'move',
      'transition': 'transform 0s'
    });
    /* Save mouse position */
    last_mouse_position = {
      x: event.pageX,
      y: event.pageY
    };
  });

  target.on('mouseup mouseout', function () {
    drag_started = 0;
    target.css({
      'cursor': 'default',
      'transition': curr_tranform
    });
  });

  function scrolled(e) {
    var offset = container.offset()
    zoom_point.x = e.pageX - offset.left
    zoom_point.y = e.pageY - offset.top

    e.preventDefault();
    var delta = e.delta || e.originalEvent.wheelDelta;
    if (delta === undefined) {
      //we are on firefox
      delta = e.originalEvent.detail;
    }
    delta = Math.max(-1, Math.min(1, delta)) // cap the delta to [-1,1] for cross browser consistency

    // determine the point on where the slide is zoomed in
    zoom_target.x = (zoom_point.x - pos.x) / scale
    zoom_target.y = (zoom_point.y - pos.y) / scale

    // apply zoom
    scale += delta * factor * scale
    scale = Math.max(1, Math.min(max_scale, scale))

    // calculate x and y based on zoom
    pos.x = -zoom_target.x * scale + zoom_point.x
    pos.y = -zoom_target.y * scale + zoom_point.y

    update()
  }

  function moved(event) {
    if (drag_started == 1) {
      var current_mouse_position = {
        x: event.pageX,
        y: event.pageY
      };
      var change_x = current_mouse_position.x - last_mouse_position.x;
      var change_y = current_mouse_position.y - last_mouse_position.y;

      /* Save mouse position */
      last_mouse_position = current_mouse_position;
      //Add the position change
      pos.x += change_x;
      pos.y += change_y;

      update()
    }
  }

  function update() {
    // Make sure the slide stays in its container area when zooming out
    if (pos.x > 0)
      pos.x = 0
    if (pos.x + size.w * scale < size.w)
      pos.x = -size.w * (scale - 1)
    if (pos.y > 0)
      pos.y = 0
    if (pos.y + size.h * scale < size.h)
      pos.y = -size.h * (scale - 1)

    target.css('transform', 'translate(' + (pos.x) + 'px,' + (pos.y) + 'px) scale(' + scale + ',' + scale + ')')
  }
}


//Funcion para crear un tooltip grande
function popperHover(container = 'ID_CLASS', tooltip = 'ID_CLASS', callback = (show_hide) => { }, config = { directShow: false }) {

  $(tooltip).append(`<div id="arrow" class="arrow" data-popper-arrow></div>`);
  const arrow = $('#arrow'); // Siempre Introducir un arrow

  const reference = $(container)[0];
  const popper = $(tooltip)[0];

  let popperInstance = null;
  let timeoutId = null;

  function createPopper() {
    popperInstance = Popper.createPopper(reference, popper, {
      placement: 'right-start',
      modifiers: [
        {
          name: 'offset',
          options: {
            offset: [0, 20],
          },
        },
      ],
    });
  }

  function destroyPopper() {
    if (popperInstance) {
      popperInstance.destroy();
      popperInstance = null;
    }
  }

  function show() {
    if (!popperInstance) {
      createPopper();
    }

    $(document).on('click', hide);
    tooltip.setAttribute('data-show', '');
    popperInstance.update();

    // Iniciar temporizador para retrasar el callback
    timeoutId = setTimeout(() => {
      callback(true);
    }, 1000); // Cambia el valor de 500 a la cantidad de milisegundos que desees como retraso antes de ejecutar el callback
  }

  function hide(event) {
    if (!$(event.target).closest(container).length) {
      $(document).off('click', hide);
      tooltip.removeAttribute('data-show');
      destroyPopper();

      // Cancelar el temporizador si el usuario sale antes de que se ejecute el callback
      clearTimeout(timeoutId);
      callback(false);
    }
  }

  function leave(event) {
    if (!$(event.target).closest(container).length) {
      $(document).off('click', leave);

      // Cancelar el temporizador si el usuario sale antes de que se ejecute el callback
      clearTimeout(timeoutId);
      callback(false);
    }
  }

  $(container).on('click', hide);
  $(container).on('mouseenter', show);
  $(container).on('mouseleave', hide);
}


function editarDatoTabla( data, form = 'OnlyForm', modalID = 'ModalID', formComplete = 0) {
  
    //Limpiamos el form en donde vamos a insertar nuestros datos
  $('#'+ form).each(function(){
      this.reset();
  });

  //La variable formComplete nos sirve para decir si es un formulario completo con select, radio, checkbox, textarea, y text, number
if (formComplete == 0) {
  //Recorremos e insertamos los datos en los campos
  for (var key in data) {
    if (data.hasOwnProperty(key)) {
      if (!key.startsWith("btn") && key !== "created_at" && key !== "updated_at") {
            
        var input = $('#' + form).find(`input[name='${key}']`);
        if (input.length) {
          input.val(data[key]);
        } else {
          $('#' + form).find(`textarea[name='${key}']`).val(data[key]);
        }
      }
    }
  }

  //Abrimos el modal
  $('#' + modalID).modal('show');

} else {
    
    //RECOREMOS EL FOMULARIO PRINCIPAL
for (var key in data) {
  if (data.hasOwnProperty(key)) {


    if (!key.startsWith("BTN") && key !== "created_at" && key !== "updated_at") {
          
      var input = $('#' + form).find(`input[name='${key}'][type='text'], input[name='${key}'][type='number']`);
      var email = $('#' + form).find(`input[name='${key}'][type='email']`);
      var password = $('#' + form).find(`input[name='${key}'][type='password']`);
      var date = $('#' + form).find(`input[name='${key}'][type='date']`);
      var time = $('#' + form).find(`input[name='${key}'][type='time']`);
      var textarea = $('#' + form).find(`textarea[name='${key}']`).val(data[key]);
      var select = $('#' + form).find(`select[name='${key}']`).val(data[key]);
      var hidden = $('#' + form).find(`input[name='${key}'][type='hidden']`);

      
      if (input.length) {
        input.val(data[key]);
        
      } else if (textarea.length) {
        textarea.val(data[key]);
        
      }
      else if (email.length) {
        email.val(data[key]);
        
      }
        else if (password.length) {
        password.val(data[key]);
    }

      else if (select.length) {

        select.val(data[key])

      }  else if (date.length) {

        date.val(data[key])

      }else if (time.length) {

        time.val(data[key])

      }else if (hidden.length) {

        hidden.val(data[key])

      
      }
      else {

        $('#' + form).find(`input[name='${key}'][value='${data[key]}'][type='radio']`).prop('checked', true)
                
        $('#' + form).find(`input[name='${key}'][value='${data[key]}'][type='checkbox']`).prop('checked', true)
      }
      
    }
  }
}


  //Abrimos el modal
  $('#' + modalID).modal('show');
    
}

    

}



function editarDatoTablainventario( data, form = 'OnlyForm', modalID = 'ModalID', formComplete = 0) {
  
    //Limpiamos el form en donde vamos a insertar nuestros datos
  $('#'+ form).each(function(){
      this.reset();
  });

  //La variable formComplete nos sirve para decir si es un formulario completo con select, radio, checkbox, textarea, y text, number
if (formComplete == 0) {
  //Recorremos e insertamos los datos en los campos
  for (var key in data) {
    if (data.hasOwnProperty(key)) {
      if (!key.startsWith("btn") && key !== "created_at" && key !== "updated_at") {
            
        var input = $('#' + form).find(`input[name='${key}']`);
        if (input.length) {
          input.val(data[key]);
        } else {
          $('#' + form).find(`textarea[name='${key}']`).val(data[key]);
        }
      }
    }
  }

 // === Lógica especial proveedor ===
let fechaAdquisicion = data.FECHA_ADQUISICION || "";
if (fechaAdquisicion === "2024-12-31") {
    $("#ANTES_2024").show();
    $("#DESPUES_2024").hide();
    $("#PROVEEDOR_ANTESDEL2024").val(data.PROVEEDOR_EQUIPO || "");
} else {
    $("#ANTES_2024").hide();
    $("#DESPUES_2024").show();
    $("#PROVEEDOR_EQUIPO").val(data.PROVEEDOR_EQUIPO || "");
}


  //Abrimos el modal
  $('#' + modalID).modal('show');


} else {
    
    //RECOREMOS EL FOMULARIO PRINCIPAL
for (var key in data) {
  if (data.hasOwnProperty(key)) {


    if (!key.startsWith("BTN") && key !== "created_at" && key !== "updated_at") {
          
      var input = $('#' + form).find(`input[name='${key}'][type='text'], input[name='${key}'][type='number']`);
      var email = $('#' + form).find(`input[name='${key}'][type='email']`);
      var password = $('#' + form).find(`input[name='${key}'][type='password']`);
      var date = $('#' + form).find(`input[name='${key}'][type='date']`);
      var time = $('#' + form).find(`input[name='${key}'][type='time']`);
      var textarea = $('#' + form).find(`textarea[name='${key}']`).val(data[key]);
      var select = $('#' + form).find(`select[name='${key}']`).val(data[key]);
      var hidden = $('#' + form).find(`input[name='${key}'][type='hidden']`);

      
      if (input.length) {
        input.val(data[key]);
        
      } else if (textarea.length) {
        textarea.val(data[key]);
        
      }
      else if (email.length) {
        email.val(data[key]);
        
      }
        else if (password.length) {
        password.val(data[key]);
    }

      else if (select.length) {

        select.val(data[key])

      }  else if (date.length) {

        date.val(data[key])

      }else if (time.length) {

        time.val(data[key])

      }else if (hidden.length) {

        hidden.val(data[key])

      
      }
      else {

        $('#' + form).find(`input[name='${key}'][value='${data[key]}'][type='radio']`).prop('checked', true)
                
        $('#' + form).find(`input[name='${key}'][value='${data[key]}'][type='checkbox']`).prop('checked', true)
      }
      
    }
  }
}


// === Lógica especial proveedor ===
let fechaAdquisicion = data.FECHA_ADQUISICION || "";
if (fechaAdquisicion === "2024-12-31") {
    $("#ANTES_2024").show();
    $("#DESPUES_2024").hide();
    $("#PROVEEDOR_ANTESDEL2024").val(data.PROVEEDOR_EQUIPO || "");
} else {
    $("#ANTES_2024").hide();
    $("#DESPUES_2024").show();
    $("#PROVEEDOR_EQUIPO").val(data.PROVEEDOR_EQUIPO || "");
}


//Abrimos el modal
$('#' + modalID).modal('show');

    
}

    

}




function eliminarDatoTabla1(data, arregloTable, url) {
  alertMensajeConfirm({
         title: "Confirme para eliminar este registro",
         text: "Está acción es irreversible",
         icon: "warning",
     }, function () { 
         
     
     $.ajax({
             type: "GET",
             dataType: "json",
             url: url,
             data: data,
             cache: false,
             success:function(dato)
             {

               for (var i = 0; i < arregloTable.length; i++) {
                 arregloTable[i].ajax.reload();
               }
               
               setTimeout(() => {
                 
                 Swal.fire({
                     icon: 'success',
                     title: 'Registro eliminado',
                     text: 'La eliminación fue realizada exitosamente',
                     timer: 2000,
                     timerProgressBar: true
                 })

               }, 1000);

             },
             error: function(dato){
                 return false;
             }
         })
      
    
     }, 1)

}




function eliminarDatoTabla(data, arregloTable, url) {
  var accion = data.ELIMINAR == 1 ? 'desactivar' : 'activar'; 
  var accion1 = data.ELIMINAR == 1 ? 'desactivado' : 'activado'; 

  
  alertMensajeConfirm({
      title: "Confirme para " + accion + " este registro",
      text: "Esta acción cambiará el estado del registro",
      icon: "warning",
  }, function () { 
      $.ajax({
          type: "GET",
          dataType: "json",
          url: url, 
          data: data,
          cache: false,
          success:function(dato) {
              for (var i = 0; i < arregloTable.length; i++) {
                  arregloTable[i].ajax.reload();
              }

              setTimeout(() => {
                  Swal.fire({
                      icon: 'success',
                      title: 'Registro ' + accion1,
                      text: 'La acción fue realizada exitosamente',
                      timer: 2000,
                      timerProgressBar: true
                  });
              }, 1000);
          },
          error: function(dato) {
              return false;
          }
      });
  }, 1);
}









function loaderbtn(btn) {
    return new Promise(function (resolve, reject) { 
        $('#' + btn).html('Guardando... <img src="/assets/images/loaderbtn.gif" alt="" style="max-width: 100%; max-height: 40px;">').prop('disabled', true).removeClass('btn-success').addClass('btn-light');  
        if ($('#' + btn +' img').length > 0) {
            resolve(1)                    
        } else {
            loaderbtn(btn)  
        }
    })
}


function validarFormulario(form) {
  var formulario = form;

  // Busca todos los elementos input, textarea y select dentro del formulario y agrega la clase "validar"
  formulario.find('input[required]:not([disabled]), textarea[required]:not([disabled]), select[required]:not([disabled])').addClass('validar').removeClass('error');

  // Busca todos los elementos con la clase "validar"
  var campos =  formulario.find('.validar');
  var formularioValido = true;

  campos.each(function () {
      var tipoCampo = $(this).attr('type');
      var valorCampo = $(this).val();

      // Verifica si el campo es un radio o checkbox y si hay uno seleccionado
      if (tipoCampo === 'radio' || tipoCampo === 'checkbox') {
          var nombreGrupo = $(this).attr('name');
          if ($('input[name="' + nombreGrupo + '"]:checked').length === 0) {
              $('input[name="' + nombreGrupo + '"]').addClass('error');
              formularioValido = false;
          } else {
              $('input[name="' + nombreGrupo + '"]').removeClass('error');
          }
      } 
      // Valida otros tipos de campos (text, email, etc.)
      else if (valorCampo === '' || valorCampo === null) {
          $(this).addClass('error');
          formularioValido = false;
      } else {
          $(this).removeClass('error');
      }
  });

  return formularioValido;
}





function validarFormulario3(form) {
  var formulario = form;

  formulario.find('input[required]:not([disabled]):visible, textarea[required]:not([disabled]):visible, select[required]:not([disabled]):visible')
    .addClass('validar')
    .removeClass('error');

  var campos = formulario.find('.validar');
  var formularioValido = true;

  campos.each(function () { 
    var tipoCampo = $(this).attr('type');
    var valorCampo = $(this).val();

    if (tipoCampo === 'radio' || tipoCampo === 'checkbox') {
      var nombreGrupo = $(this).attr('name');
      if ($('input[name="' + nombreGrupo + '"]:checked').length === 0 && $(this).is(':visible')) {
        $('input[name="' + nombreGrupo + '"]').addClass('error');
        formularioValido = false;
      } else {
        $('input[name="' + nombreGrupo + '"]').removeClass('error');
      }
    } 
    // Valida otros campos visibles
    else if ((valorCampo === '' || valorCampo === null) && $(this).is(':visible')) {
      $(this).addClass('error');
      formularioValido = false;
    } else {
      $(this).removeClass('error');
    }
  });

  return formularioValido;
}


// Evento para eliminar la clase "error" cuando el campo cambia o recibe entrada
$(document).on('input change', 'input[required], textarea[required], select[required]', function() {
  var tipoCampo = $(this).attr('type');

  // Si es radio o checkbox, solo remueve el error cuando uno del grupo es seleccionado
  if (tipoCampo === 'radio' || tipoCampo === 'checkbox') {
      var nombreGrupo = $(this).attr('name');
      if ($('input[name="' + nombreGrupo + '"]:checked').length > 0) {
          $('input[name="' + nombreGrupo + '"]').removeClass('error');
      }
  } else {
      if ($(this).val() !== '' && $(this).val() !== null) {
          $(this).removeClass('error');
      }
  }
});



document.querySelectorAll('.modal').forEach(modal => {
  modal.addEventListener('hidden.bs.modal', event => {
    const form = modal.querySelector('form');
    if (form) {
      form.reset();
      form.querySelectorAll('.error').forEach(element => {
        element.classList.remove('error');
      });
    }
  });
});












function validarFormularioV1(form) {
  var formulario = $('#'+form);



  // Busca todos los elementos input, textarea y select dentro del formulario y agrega la clase "validar"
  formulario.find('input[required]:not([disabled]), textarea[required]:not([disabled]), select[required]:not([disabled])').addClass('validar').removeClass('error');

  // Busca todos los elementos con la clase "validar"
  var campos =  $(`#${form} .validar`);
  
  // console.log(campos)


  var formularioValido = true;

  campos.each(function () {
      var tipoCampo = $(this).attr('type');
      var valorCampo = $(this).val();

      // Verifica si el campo es un radio o checkbox y si hay uno seleccionado
      if (tipoCampo === 'radio' || tipoCampo === 'checkbox') {
          var nombreGrupo = $(this).attr('name');
          if ($('input[name="' + nombreGrupo + '"]:checked').length === 0) {
              $('input[name="' + nombreGrupo + '"]').addClass('error');
              formularioValido = false;
          } else {
              $('input[name="' + nombreGrupo + '"]').removeClass('error');
          }
      } 
      // Valida otros tipos de campos (text, email, etc.)
      else if (valorCampo === '' || valorCampo === null) {
          $(this).addClass('error');
          formularioValido = false;
      } else {
          $(this).removeClass('error');
      }
  });

  return formularioValido;
}




function validarFormularioV2(form) {
  var formulario = $('#' + form);

  var visibleFields;
  if ($('#MOSTRAR_ANTES').is(':visible')) {
      visibleFields = $('#MOSTRAR_ANTES').find('input[required], textarea[required], select[required]');
  } else if ($('#MOSTRAR_TODO').is(':visible')) {
      visibleFields = $('#MOSTRAR_TODO').find('input[required], textarea[required], select[required]');
  } else {
      visibleFields = formulario.find('input[required], textarea[required], select[required]');
  }

  visibleFields = visibleFields.filter(':visible');
  visibleFields.addClass('validar').removeClass('error');

  var formularioValido = true;

  visibleFields.each(function () {
      var tipoCampo = $(this).attr('type');
      var valorCampo = $(this).val();

      if (tipoCampo === 'radio' || tipoCampo === 'checkbox') {
          var nombreGrupo = $(this).attr('name');
          if ($('input[name="' + nombreGrupo + '"]:checked').length === 0) {
              $('input[name="' + nombreGrupo + '"]').addClass('error');
              formularioValido = false;
          } else {
              $('input[name="' + nombreGrupo + '"]').removeClass('error');
          }
      } else if (valorCampo === '' || valorCampo === null) {
          $(this).addClass('error');
          formularioValido = false;
      } else {
          $(this).removeClass('error');
      }
  });

  return formularioValido;
}





//  funciones de para el boton de visualizar
function hacerSoloLectura(data, modalSelector) {
    var formElements = $(modalSelector).find(':input, select');

    formElements.each(function() {
        $(this).prop('disabled', true);
    });

    $(modalSelector).find('button').not('.btn-close, .btn-danger, .nav-tabs button, .nav-link' ).hide();

    $(modalSelector).find('.btn-close, .btn-danger, .nav-tabs button, .nav-link').prop('disabled', false);

for (var key in data) {
     if (data.hasOwnProperty(key)) {
        var element = $(modalSelector).find('[name="' + key + '"]');
        if (element.length) {
             if (element.is(':radio') || element.is(':checkbox')) {
                 element.prop('checked', data[key]);
         } else {
            element.val(data[key]);
        }
      }
    }
  }
}



function hacerSoloLectura2(data, modalSelector) {
    var modal = $(modalSelector);

    modal.find(':input, select, textarea').each(function () {
        var input = $(this);
        var fieldName = input.attr('name');

        if (input.attr('type') === 'file') {
            input.prop('disabled', true);
        } else if (input.is(':radio') || input.is(':checkbox')) {
            input.prop('checked', data[fieldName] == input.val());
        } else {
            input.val(data[fieldName] || '');
        }
    });

    modal.find('button').not('.btn-close, .btn-danger, .nav-tabs button, .nav-link').hide();
    
    modal.find('.btn-close, .btn-danger, .nav-tabs button, .nav-link').prop('disabled', false);
}



function hacerSoloLecturabancodeproveedores(data, modalSelector) {
  var modal = $(modalSelector);

  modal.find(':input, select, textarea').each(function () {
      var input = $(this);
      var fieldName = input.attr('name');

      if (input.attr('type') === 'file') {
          input.prop('disabled', true);
      } else if (input.is(':radio') || input.is(':checkbox')) {
          input.prop('checked', data[fieldName] == input.val());
      } else {
          input.val(data[fieldName] || '');
      }
  });

  modal.find('button').not('.btn-close, .btn-danger, .nav-tabs button, .nav-link, .EDITAR, .ver-archivo-verificacion').hide();
  
  modal.find('.btn-close, .btn-danger, .nav-tabs button, .nav-link, .EDITAR, .ver-archivo-verificacion').prop('disabled', false);
}



function hacerSoloLectura3(data, modalSelector) {
    var modal = $(modalSelector);

    modal.find(':input, select, textarea').each(function () {
        var input = $(this);
        var fieldName = input.attr('name');

        if (fieldName && data.hasOwnProperty(fieldName)) { 
            if (input.attr('type') === 'file') {
                input.prop('disabled', true);
            } else if (input.is(':radio') || input.is(':checkbox')) {
                input.prop('checked', data[fieldName] == input.val());
            } else {
                input.val(data[fieldName] || '');
            }
        } else {
            console.warn(`Campo '${fieldName}' no encontrado en los datos recibidos.`);
        }
    });

    modal.find('button').not('.btn-close, .btn-danger').hide();
    modal.find('.btn-close, .btn-danger').prop('disabled', false);
}

function resetFormulario(modalSelector) {
  var form = $(modalSelector).find('form')[0];
  if (form) {
      form.reset();
  }

  var formElements = $(modalSelector).find(':input, select');
  formElements.each(function() {
      $(this).prop('disabled', false);
      $(this).prop('disabled', false);
  });

  $(modalSelector).find('button').show();
}




function hacerSoloLecturainventario(data, modalSelector) {
  var modal = $(modalSelector);

  modal.find(':input, select, textarea').each(function () {
      var input = $(this);
      var fieldName = input.attr('name');

      if (input.attr('type') === 'file') {
          input.prop('disabled', false);
      } else if (input.is(':radio') || input.is(':checkbox')) {
          input.prop('checked', data[fieldName] == input.val());
      } else {
          input.val(data[fieldName] || '');
      }
  });

  modal.find('button').not('.btn-close, .btn-danger, .nav-tabs button, .nav-link, .EDITAR, .ver-archivo-documentosequipo, .ver-archivo-documentoscalibracion').hide();
  
  modal.find('.btn-close, .btn-danger, .nav-tabs button, .nav-link, .EDITAR, .ver-archivo-verificacion').prop('disabled', false);
}



/// VER DOCUMENTOS 

function abrirModal(url, title) {
  $('#modalVerArchivo').remove();
  $('.modal-backdrop').remove(); 

  $.ajax({
      url: url,
      method: 'HEAD', 
      success: function () {
          var modalContent = `
              <div class="modal fade" id="modalVerArchivo" tabindex="-1" aria-labelledby="modalVerArchivoLabel" aria-hidden="true">
                  <div class="modal-dialog modal-lg">
                      <div class="modal-content">
                          <div class="modal-header">
                              <h5 class="modal-title" id="modalVerArchivoLabel">${title}</h5>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body">
                              <iframe src="${url}" width="100%" height="500px"></iframe>
                          </div>
                          <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                          </div>
                      </div>
                  </div>
              </div>
          `;
          $('body').append(modalContent);
          $('#modalVerArchivo').modal('show');
          $('#modalVerArchivo').on('hidden.bs.modal', function () {
              $(this).remove(); // Elimina el modal al cerrarse
          });
      },
      error: function () {
          var errorModalContent = `
              <div class="modal fade" id="modalVerArchivo" tabindex="-1" aria-labelledby="modalVerArchivoLabel" aria-hidden="true">
                  <div class="modal-dialog modal-lg">
                      <div class="modal-content">
                          <div class="modal-header">
                              <h5 class="modal-title" id="modalVerArchivoLabel">${title}</h5>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body text-center">
                              <h5 class="text-danger">Archivo no encontrado.</h5>
                          </div>
                          <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                          </div>
                      </div>
                  </div>
              </div>
          `;
          $('body').append(errorModalContent);
          $('#modalVerArchivo').modal('show');
          $('#modalVerArchivo').on('hidden.bs.modal', function () {
              $(this).remove(); 
          });
      }
  });
}




// Obtén la URL actual
const currentUrl = window.location.href;

// Selecciona todos los enlaces con la clase BOTON y los dropdown-items
const botones = document.querySelectorAll('.BOTON');
const dropdownItems = document.querySelectorAll('.dropdown-item');

// Recorre los botones principales (incluidos los dropdowns)
botones.forEach(boton => {
    if (boton.href === currentUrl) {
        boton.classList.add('active');
    }
});

// Recorre los dropdown-items
dropdownItems.forEach(item => {
    if (item.href === currentUrl) {
        item.classList.add('active'); // Activa el dropdown-item

        // Encuentra el dropdown padre relacionado
        const parentDropdown = item.closest('.nav-item.dropdown');
        if (parentDropdown) {
            parentDropdown.classList.add('active'); // Activa el dropdown principal
        }
    }
});



function escapeHtml(text) {
    if (!text) return '';
    return text
        .replace(/&/g, "&amp;")
        .replace(/"/g, "&quot;")
        .replace(/'/g, "&#039;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;");
}



$(document).on('show.bs.modal', '.modal', function () {

    const modal = bootstrap.Modal.getOrCreateInstance(this);

    modal._config.backdrop = 'static';
    modal._config.keyboard = true;

});


$(document).on('shown.bs.modal', function () {

    let token = $('meta[name="csrf-token"]').attr('content');

    $('form').each(function () {
        let input = $(this).find('input[name="_token"]');
        if (input.length) {
            input.val(token);
        }
    });

});

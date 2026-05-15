
    



function mostrarModalDesdeData(element) {
            const imagen = element.getAttribute('data-imagen');
            const titulo = element.getAttribute('data-titulo');
            const descripcion = element.getAttribute('data-descripcion');

            document.getElementById('modalImagen').src = imagen;
            document.getElementById('modalTitulo').textContent = titulo;
            document.getElementById('modalDescripcion').textContent = descripcion;

            document.getElementById('modalAnuncio').style.display = 'flex';
        }

        function cerrarModal() {
            document.getElementById('modalAnuncio').style.display = 'none';
        }

        function cerrarModal() {
            document.getElementById('modalAnuncio').style.display = 'none';
        }


        function iniciarCarrusel(id, intervalo = 5000) {
            const carrusel = document.getElementById(id);
            if (!carrusel) return;

            const slides = carrusel.querySelectorAll('.carrusel-slide');
            let indice = 0;

            setInterval(() => {
                slides[indice].classList.remove('activo');
                indice = (indice + 1) % slides.length;
                slides[indice].classList.add('activo');
            }, intervalo);
        }

        document.addEventListener('DOMContentLoaded', function() {
            iniciarCarrusel('carruselDiaAnio', 5000); 
            iniciarCarrusel('carruselMes', 5000); 
        });

        document.getElementById('logoutButton').addEventListener('click', function(e) {
            Swal.fire({
                title: '¿Estás seguro?',
                text: '¿Deseas cerrar sesión?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, cerrar sesión',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('logoutForm').submit();
                }
            });
        });
   




function tieneDatos(obj) {
    return obj && Object.values(obj).some(v => v && v.toString().trim() !== "");
}

document.getElementById("btnInfoEmpresa").onclick = () => {

    fetch('/obtenerInfoEmpresa')
        .then(r => r.json())
        .then(data => {

           
            const mensajeGeneral = document.getElementById("mensajeGeneralEmpresa");
            mensajeGeneral.style.display = "none";
            mensajeGeneral.innerHTML = "";

        
            if (data.error) {

                mensajeGeneral.innerHTML =
                    "⚠️ No existe información de la empresa guardada en el sistema.";

                mensajeGeneral.style.display = "block";

                rfcEmpresa.textContent = '—';
                razonSocial.textContent = '—';
                nombreComercial.textContent = '—';
                regimenCapital.textContent = '—';

                contenedorContactos.innerHTML = "";
                contenedorDomicilio.innerHTML = "";
                contenedorSucursales.innerHTML = "";
                seccionSucursales.style.display = "none";

                modalInfoEmpresa.style.display = "flex";
                return;
            }

          
            rfcEmpresa.textContent = data.datos_generales.RFC_EMPRESA || '—';
            razonSocial.textContent = data.datos_generales.RAZON_SOCIAL || '—';
            nombreComercial.textContent = data.datos_generales.NOMBRE_COMERCIAL || '—';
            regimenCapital.textContent = data.datos_generales.REGIMEN_CAPITAL || '—';

           
            contenedorContactos.innerHTML = "";

            if (Array.isArray(data.contactos) && data.contactos.length > 0) {
                data.contactos.forEach(c => {
                    if (tieneDatos(c)) {
                        contenedorContactos.innerHTML += `
                            <div class="contacto-item">
                                <div class="info-grid info-grid-4">
                                    <div><span>Nombre:</span> ${c.CONTACTO_SOLICITUD}</div>
                                    <div><span>Cargo:</span> ${c.CARGO_SOLICITUD}</div>
                                    <div><span>Tel. Oficina:</span> ${c.TELEFONO_SOLICITUD}</div>
                                    <div><span>Celular:</span> ${c.CELULAR_SOLICITUD}</div>
                                </div>
                            </div>
                        `;
                    }
                });

                if (contenedorContactos.innerHTML.trim() === "") {
                    contenedorContactos.innerHTML =
                        `<p class="sin-info">No tiene información de representantes guardada.</p>`;
                }
            } else {
                contenedorContactos.innerHTML =
                    `<p class="sin-info">No tiene información de representantes guardada.</p>`;
            }

          
            contenedorDomicilio.innerHTML = "";
            let hayDomicilio = false;

            if (Array.isArray(data.domicilios)) {
                data.domicilios.forEach(d => {

                    if (d.TIPODEDOMICILIOFISCAL === "nacional" && tieneDatos(d)) {
                        hayDomicilio = true;
                        contenedorDomicilio.innerHTML += `
                            <div class="bloque-direccion nacional">
                                <h4>📍 Domicilio Nacional</h4>
                                <div class="info-grid info-grid-3">
                                    <div><span>CP:</span> ${d.CODIGO_POSTAL_DOMICILIO}</div>
                                    <div><span>Tipo de Vialidad:</span> ${d.TIPO_VIALIDAD_DOMICILIO}</div>
                                    <div class="no-wrap"><span>Nombre de Vialidad:</span> ${d.NOMBRE_VIALIDAD_DOMICILIO}</div>
                                    <div><span>Número Exterior:</span> ${d.NUMERO_EXTERIOR_DOMICILIO}</div>
                                    <div><span>Número Interior:</span> ${d.NUMERO_INTERIOR_DOMICILIO}</div>
                                    <div><span>Colonia:</span> ${d.NOMBRE_COLONIA_DOMICILIO}</div>
                                    <div><span>Localidad:</span> ${d.NOMBRE_LOCALIDAD_DOMICILIO}</div>
                                    <div><span>Municipio:</span> ${d.NOMBRE_MUNICIPIO_DOMICILIO}</div>
                                    <div><span>Entidad:</span> ${d.NOMBRE_ENTIDAD_DOMICILIO}</div>
                                    <div><span>Entre Calle:</span> ${d.ENTRE_CALLE_DOMICILIO}</div>
                                    <div><span>Y Calle:</span> ${d.ENTRE_CALLE_2_DOMICILIO}</div>
                                </div>
                            </div>
                        `;
                    }

                    if (d.TIPODEDOMICILIOFISCAL === "extranjero" && tieneDatos(d)) {
                        hayDomicilio = true;
                        contenedorDomicilio.innerHTML += `
                            <div class="bloque-direccion extranjero">
                                <h4>🌎 Domicilio Extranjero</h4>
                                <div class="info-grid info-grid-3">
                                    <div><span>Domicilio:</span> ${d.DOMICILIO_EXTRANJERO}</div>
                                    <div><span>CP:</span> ${d.CP_EXTRANJERO}</div>
                                    <div><span>Ciudad:</span> ${d.CIUDAD_EXTRANJERO}</div>
                                    <div><span>Estado:</span> ${d.ESTADO_EXTRANJERO}</div>
                                    <div><span>País:</span> ${d.PAIS_EXTRANJERO}</div>
                                </div>
                            </div>
                        `;
                    }
                });
            }

            if (!hayDomicilio) {
                contenedorDomicilio.innerHTML =
                    `<p class="sin-info">No tiene información de domicilio fiscal guardada.</p>`;
            }

         
            seccionSucursales.style.display = "none";
            contenedorSucursales.innerHTML = "";
            let haySucursal = false;

            if (Number(data.cuenta_sucursales) === 1 && Array.isArray(data.sucursales)) {
                seccionSucursales.style.display = "block";

                data.sucursales.forEach(s => {

                    if (s.TIPODEDOMICILIOFISCAL === "nacional" && tieneDatos(s)) {
                        haySucursal = true;
                        contenedorSucursales.innerHTML += `
                            <div class="bloque-sucursal">
                                <h4>${s.NOMBRE_SUCURSAL}</h4>
                                <div class="info-grid info-grid-3">
                                    <div><span>CP:</span> ${s.CODIGO_POSTAL_SUCURSAL}</div>
                                    <div><span>Tipo de Vialidad:</span> ${s.TIPO_VIALIDAD_SUCURSAL}</div>
                                    <div class="no-wrap"><span>Nombre de la Vialidad:</span> ${s.NOMBRE_VIALIDAD_SUCURSAL}</div>
                                    <div><span>No. Exterior:</span> ${s.NUMERO_EXTERIOR_SUCURSAL}</div>
                                    <div><span>No. Interior:</span> ${s.NUMERO_INTERIOR_SUCURSAL}</div>
                                    <div><span>Colonia:</span> ${s.NOMBRE_COLONIA_SUCURSAL}</div>
                                    <div><span>Localidad:</span> ${s.NOMBRE_LOCALIDAD_SUCURSAL}</div>
                                    <div><span>Municipio:</span> ${s.NOMBRE_MUNICIPIO_SUCURSAL}</div>
                                    <div><span>Entidad:</span> ${s.NOMBRE_ENTIDAD_SUCURSAL}</div>
                                    <div><span>Entre Calle:</span> ${s.ENTRE_CALLE_SUCURSAL}</div>
                                    <div><span>Y Calle:</span> ${s.ENTRE_CALLE_2_SUCURSAL}</div>
                                </div>
                            </div>
                        `;
                    }

                    if (s.TIPODEDOMICILIOFISCAL === "extranjero" && tieneDatos(s)) {
                        haySucursal = true;
                        contenedorSucursales.innerHTML += `
                            <div class="bloque-sucursal">
                                <h4>Sucursal Extranjera</h4>
                                <div class="info-grid info-grid-3">
                                    <div><span>Domicilio:</span> ${s.DOMICILIO_EXTRANJERO}</div>
                                    <div><span>CP:</span> ${s.CP_EXTRANJERO}</div>
                                    <div><span>Ciudad:</span> ${s.CIUDAD_EXTRANJERO}</div>
                                    <div><span>Estado:</span> ${s.ESTADO_EXTRANJERO}</div>
                                    <div><span>País:</span> ${s.PAIS_EXTRANJERO}</div>
                                </div>
                            </div>
                        `;
                    }
                });
            }

            if (seccionSucursales.style.display === "block" && !haySucursal) {
                contenedorSucursales.innerHTML =
                    `<p class="sin-info">No tiene información de sucursales guardada.</p>`;
            }

         
            modalInfoEmpresa.style.display = "flex";
        });
};


document.getElementById("cerrarModal").onclick = () => {
    modalInfoEmpresa.style.display = "none";
};

modalInfoEmpresa.onclick = (e) => {
    if (e.target === modalInfoEmpresa) {
        modalInfoEmpresa.style.display = "none";
    }
};

document.addEventListener("keydown", (e) => {
    if (e.key === "Escape") {
        modalInfoEmpresa.style.display = "none";
    }
});




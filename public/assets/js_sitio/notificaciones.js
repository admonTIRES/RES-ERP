document.addEventListener("DOMContentLoaded", function() {
    setTimeout(() => {
        consultaotificaciones();
    }, 2000);
});



  
const btnNoti = document.getElementById('btnNotificaciones');
const panelNoti = document.getElementById('panelNotificaciones');

btnNoti.addEventListener('click', () => {
    panelNoti.style.display = panelNoti.style.display === 'block' ? 'none' : 'block';
});

document.addEventListener('click', function (e) {
    if (!btnNoti.contains(e.target) && !panelNoti.contains(e.target)) {
        panelNoti.style.display = 'none';
    }
});



function consultaotificaciones() {

    fetch('/notificaciones')
        .then(response => response.json())
        .then(data => {

            const contador = document.getElementById('contadorNotificaciones');

            contador.textContent = data && data.total ? data.total : 0;
            contador.style.display = "inline-block";

            const cuerpo = document.querySelector('#panelNotificaciones .notification-body');
            cuerpo.innerHTML = "";

            if (!data || data.total === 0) {
                cuerpo.innerHTML = `
                    <p class="notification-item">📌 No tienes notificaciones por el momento.</p>
                `;
                return;
            }

            data.notificaciones.forEach(n => {
                cuerpo.innerHTML += `
                    <div class="notification-item" 
                        style="cursor:pointer; position:relative;" 
                        onclick="window.open('${n.link}', '_blank')">

                        <div style="display:flex; justify-content:space-between; align-items:center;">
                            <strong>${n.titulo}</strong>
                            ${n.estatus_badge}
                        </div>

                        <small>${n.detalle}</small><br>
                        <small>${n.fecha}</small>
                    </div>
                `;
            });

        })
        .catch(error => {
            console.error("Error cargando notificaciones:", error);
        });
}

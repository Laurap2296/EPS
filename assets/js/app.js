function cargarContenido(ruta) {
    fetch(ruta)
        .then(res => res.text())
        .then(html => {
            document.getElementById('contenido').innerHTML = html;
        })
        .catch(err => console.error('Error al cargar contenido:', err));
}
// Función para el login
document.getElementById('loginForm').addEventListener('submit', function(event) {
    event.preventDefault();
    
    const documento = document.getElementById('documento').value;
    const clave = document.getElementById('clave').value;
    const tipo = document.getElementById('tipo').value; // 'usuario' o 'funcionario'
    
    const data = { documento, clave, tipo };

    fetch('backend/login.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(result => {
        if (result.success) {
            localStorage.setItem('usuario', JSON.stringify(result.usuario));
            localStorage.setItem('tipo', result.tipo);
            window.location.href = 'index.html'; // Redirige a la página principal
        } else {
            document.getElementById('error-message').textContent = result.mensaje;
        }
    })
    .catch(error => console.log('Error en el login:', error));
});

// Función para el registro
document.getElementById('registroForm').addEventListener('submit', function(event) {
    event.preventDefault();

    const nombre = document.getElementById('nombre').value;
    const apellido = document.getElementById('apellido').value;
    const documento = document.getElementById('documento').value;
    const telefono = document.getElementById('telefono').value;
    const direccion = document.getElementById('direccion').value;
    const correo = document.getElementById('correo').value;

    const data = { nombre, apellido, documento, telefono, direccion, correo };

    fetch('backend/registro.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(result => {
        if (result.success) {
            window.location.href = 'login.html'; // Redirige al login después del registro
        } else {
            document.getElementById('error-message').textContent = result.mensaje;
        }
    })
    .catch(error => console.log('Error en el registro:', error));
});

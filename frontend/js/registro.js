const apiURL = 'http://localhost:8888/Proyecto-Tienda/src/index.php'
const alertContainer = document.getElementById('alertContainer')

const crearUsuario = async () => {

    const usuario = {
        nombre: document.getElementById('nombre').value || 'N/A',
        apaterno: document.getElementById('apaterno').value || 'N/A',
        amaterno: document.getElementById('amaterno').value || 'N/A',
        usuario: document.getElementById('usuario').value || 'usuario_default',
        password: document.getElementById('password').value || '',
        correo: document.getElementById('correo').value || 'correo@dominio.com',
        telefono: document.getElementById('telefono').value || '0000000000',
        direccion: document.getElementById('direccion').value || 'Dirección no especificada',
        vendedor: document.getElementById('vendedor').checked
    };


    const url = `${apiURL}/cuenta`;
    const method = 'POST';
    const respuesta = await fetch(url, {
        method: method,
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(usuario),
    });

    const resultado = await respuesta.json();
    console.log(resultado);

    alert(resultado.message);

    if (resultado.status === 'success') {
        window.location.href = resultado.redirect;
    }

};


const iniciarSesion = async () => {

    const data = {
        usuario: document.getElementById('usuario').value,
        password: document.getElementById('password').value
    };

    const url = `${apiURL}/cuenta/iniciarSesion`;
    const method = 'POST';
    const respuesta = await fetch(url, {
        method: method,
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(data),
    });
    const resultado = await respuesta.json();

    alert(resultado.message);

    if (resultado.status === 'success') {

        sessionStorage.setItem('loggedIn', 'true');
        sessionStorage.setItem('name', resultado.nombre);

        
        window.location.href = resultado.redirect;

        document.getElementById('loginLink').classList.add('hide-on-login');
        document.getElementById('logoutLink').classList.remove('hide-on-login');
        document.getElementById('logoutLink').classList.add('show-on-login');
    }

    console.log(resultado);
}

const cerrarSesion = async () => {

    const url = `${apiURL}/cuenta/cerrarSesion`;
    const method = 'POST';
    const respuesta = await fetch(url, {
        method: method,
        headers: {
            'Content-Type': 'application/json',
        }
    });
    const resultado = await respuesta.json();

    alert(resultado.message);

    if (resultado.status === 'success') {
 
        sessionStorage.removeItem('loggedIn');
        sessionStorage.removeItem('name');

        document.getElementById('loginLink').classList.remove('hide-on-login');
        document.getElementById('logoutLink').classList.add('hide-on-login');

        window.location.href = resultado.redirect;
    }
   
}
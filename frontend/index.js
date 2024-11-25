const apiURL = 'http://localhost:8888/Proyecto-Tienda/src/index.php'
const productForm = document.getElementById('productForm')
const alertContainer = document.getElementById('alertContainer')
const productTableBody = document.getElementById('productTableBody')
const btnSubmit = document.getElementById('submitBtn')

document.addEventListener('DOMContentLoaded', () => {
    const botonesAgregar = document.querySelectorAll('.btn-agregar');

    botonesAgregar.forEach(boton => {
        boton.addEventListener('click', () => {
            alert('Producto agregado al carrito');
            agregarAlCarrito();
        });
    });

    const isLoggedIn = sessionStorage.getItem('loggedIn'); 
    const loginLink = document.getElementById('loginLink');
    const logoutLink = document.getElementById('logoutLink');
    const registerlink = document.getElementById('registerLink');
        
    if (isLoggedIn === 'true') {
        loginLink.classList.add('hide-on-login');
        registerlink.classList.add('hide-on-login');
        logoutLink.classList.remove('hide-on-login');
    } else {
        loginLink.classList.remove('hide-on-login');
        registerlink.classList.remove('hide-on-login');
        logoutLink.classList.add('hide-on-login');
    }
});

const crearUsuario = async () => {
    //const usuarioId = document.getElementById('usuarioId').value;

    const usuario = {
        nombre: document.getElementById('nombre').value || 'N/A',
        apaterno: document.getElementById('apaterno').value || 'N/A',
        amaterno: document.getElementById('amaterno').value || 'N/A',
        usuario: document.getElementById('usuario').value || 'usuario_default',
        password: document.getElementById('password').value || '',
        correo: document.getElementById('correo').value || 'correo@dominio.com',
        telefono: document.getElementById('telefono').value || '0000000000',
        direccion: document.getElementById('direccion').value || 'Dirección no especificada',
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

    /*const response = await resultado.json();
    if (response.mensaje === 'Usuario Creado') {
        showAlert('Usuario Registrado Correctamente', 'success');
        loadUsuario();
        userForm.reset();
    } else if (response.mensaje === 'Usuario Actualizado') {
        showAlert('Usuario Actualizado Correctamente', 'success');
        loadUsuario();
        userForm.reset();
    } else {
        showAlert('Error al registrar el usuario', 'danger');
    }*/

    //document.getElementById('usuarioId').value = '';
    //console.log('@@@ response => ', response);
};

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
        sessionStorage.setItem('username', resultado.nombre);

        
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

const loadProductos = async () => {
    try {
        const res = await fetch(apiURL + '/usuario', {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json'
            }
        })
        const productos = await res.json()
        productTableBody.innerHTML = ''
        productos.forEach((item) => {
            const row = document.createElement('tr')
            row.innerHTML =
                `
            <td>${item.idproducto}</td>
            <td>${item.nombre}</td>
            <td>${item.descripcion}</td>
            <td>${item.precio}</td>
            <td>${item.marca}</td>
            <td>${item.estado}</td>
            <td>${item.categoria}</td>
            
            <img src="${item.imagen}" width="100">
            <td>
            <button class="btn btn-warning btn-sm" data_id="${item.idproducto}">Editar</button>
            <button class="btn btn-danger btn-sm" data_id="${item.idproducto}">Borrar</button>
            </td>
            `
            productTableBody.appendChild(row)
        })
    } catch (error) {
        console.error('Error:', error);
    }
}

const agregarAlCarrito = async () => {
    const productId = document.getElementById('productId').value

    const producto = {
        usuario: document.getElementById('nombre').value || 'N/A',
        producto: document.getElementById('descripcion').value || 'Descripción no disponible'
    }

    if (productId) {
        producto.idproducto = productId
    }

    const url = `${apiURL}/usuario`
    const method = productId ? 'PUT' : 'POST'

    console.log('ruta y metodo => ', url, method, producto)
    const resultado = await fetch(url, {
        method: method,
        body: JSON.stringify(producto)
    })

    const response = await resultado.json()
    if (response.mensaje === 'Producto Creado') {
        showAlert('Producto Agregado', 'success')
        loadProductos()
        productForm.reset()
    } else if (response.mensaje === 'Producto Actualizado') {
        showAlert('Producto Actualizado', 'success')
        loadProductos()
        productForm.reset()
    } else {
        showAlert('Error al agregar el producto', 'danger')
    }
    document.getElementById('productId').value = ''

    console.log('@@@ response => ', response)
}
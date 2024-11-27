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
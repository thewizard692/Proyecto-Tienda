const apiURL = 'http://localhost:8888/Proyecto-Tienda/src/index.php'
const alertContainer = document.getElementById('alertContainer')
const productForm = document.getElementById('productForm')
const productTableBody = document.getElementById('productTableBody')
const btnSubmit = document.getElementById('submitBtn')

document.addEventListener('DOMContentLoaded', () => {
    loadProductos() 
});

//****FUNCIONES PARA PRODUCTOS******
//AGREGAR PRODUCTOS - CAMBIO
const crearProducto = async () => {
    const idproducto = document.getElementById('idproducto').value
    let producto
    if (idproducto) {
        producto = {
            idproducto: idproducto,
            prd_nombre: document.getElementById('prd_nombre').value,
            prd_descrip: document.getElementById('prd_descrip').value,
            prd_precio: document.getElementById('prd_precio').value,
            prd_marca: document.getElementById('prd_marca').value,
            prd_imagen: document.getElementById('prd_imagen').value,
            prd_estado: document.getElementById('prd_estado').value,
        }
    } else {
        producto = {
            prd_nombre: document.getElementById('prd_nombre').value,
            prd_descrip: document.getElementById('prd_descrip').value,
            prd_precio: document.getElementById('prd_precio').value,
            prd_marca: document.getElementById('prd_marca').value,
            prd_imagen: document.getElementById('prd_imagen').value,
            prd_estado: document.getElementById('prd_estado').value,
        }
    }
    const url = `${apiURL}/usuario/vendedor`
    const method = idproducto ? 'PUT' : 'POST'
    console.log('@@@ ruta y metodo => ', url, method, producto) //sal
    const resultado = await fetch(url, {
        method: method,
        body: JSON.stringify(producto)
    })

    //mensajes del sistema
    const response = await resultado.json()
    if (response.mensaje === 'Producto Creado') {
        showAlert('Producto Agregado', 'success')
        loadProductos()
        productForm.reset()
    } else if (response.mensaje === 'Producto Actualizado') {
        showAlert('ProductoActualizado', 'warning')
        loadProductos()
        productForm.reset()
    } else {
        showAlert('Error al agregar el producto', 'danger')
    }
    document.getElementById('idproducto').value = ''

    console.log('@@@ response => ', response)
} //FIN DE AGREGAR PRODUCTOS


//OBTENER PRODUCTO POR ID - DETALLES
const getProducto = async (id) => {
    try {
        const send = {
            id: id
        }
        const res = await fetch(apiURL + '/usuario/vendedor', {
            method: 'POST',
            body: JSON.stringify(send)
        })
        const producto = await res.json()
        if (producto) {
            document.getElementById('idproducto').value = producto.idproducto
            document.getElementById('prd_nombre').value = producto.prd_nombre
            document.getElementById('prd_descrip').value = producto.prd_descrip
            document.getElementById('prd_precio').value = producto.prd_precio
            document.getElementById('prd_marca').value = producto.prd_marca
            document.getElementById('prd_imagen').value = producto.prd_imagen
            document.getElementById('prd_estado').value = producto.prd_estado
        }
        console.log('@@ producto =>', producto)
    }
    catch (error) {
        console.error('Error: ', error)
    }
}
//CARGA DE PRODUCTOS Y MUESTRA EN LA TABLA
const loadProductos = async () => {
    try {
        const res = await fetch(apiURL + '/usuario/vendedor', {
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
          <td>${item.prd_nombre}</td>
          <td>${item.prd_descrip}</td>
          <td>${item.prd_precio}</td>
          <td>${item.prd_marca}</td>
          <img src="${item.prd_imagen}" width="100">
          <td>${item.prd_estado}</td>
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

//BORRAR PRODUCTOS
const borrarProducto = async (id) => {
    try {
        const send = {
            id: id
        }
        const res = await fetch(apiURL + '/usuario/vendedor', {
            method: 'DELETE',
            body: JSON.stringify(send)
        })
        const borrado = await res.json()
        console.log('@@@ borrado =>', borrado.mensaje)
        if (borrado && borrado.mensaje && borrado.mensaje === 'Producto Borrado') {
            showAlert('Producto Borrado', 'danger')
            loadProductos()
        }
        console.log('@@@ res => ', borrado)
    } catch (error) {
        console.error('Error: ', error)
    }
}

/*const obtenerCategorias = async (categoria) => {
    try {
        const send = {
            categoria: categoria
        }
        const res = await fetch(apiURL + '/usuario/vendedor/categoria', {
            method: 'POST',
            body: JSON.stringify(send)
        })
        const categoria = await res.json()
        if (categoria) {
        /*
        <select name="categorias" id="id">
        <option value="1"></option>
        <option value="2"></option>
        <option value="3"></option>
        <option value="4"></option>
        <option value="5"></option>
        <option value="6"></option>
        <option value="7"></option>
        <option value="8"></option>
        </select>
            
        }
        console.log('@@ categoria =>', categoria)
    }
    catch (error) {
        console.error('Error: ', error)
    }
} */


productTableBody.addEventListener('click', (e) => {
  if (e.target.classList.contains('btn-danger')) {
    borrarProducto(e.target.getAttribute('data_id'))
  }
  if (e.target.classList.contains('btn-warning')) {
    getProducto(e.target.getAttribute('data_id'))
  }
})
 
btnSubmit.addEventListener('click', (event) => {
  event.preventDefault()
  crearProducto()
})

const showAlert = (mensaje, tipo) => {
    alertContainer.innerHTML =
        `
          <div class="alert alert-${tipo} alert-dismissable fade show" role="alert">
            ${mensaje}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
            </button>
          </div>
        `
    setTimeout(() => {
        alertContainer.innerHTML = ''
    }, 3000)
}
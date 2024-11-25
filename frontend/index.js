const apiURL = 'http://localhost:8888/Proyecto-Tienda/src/index.php'
const productForm = document.getElementById('productForm')
const alertContainer = document.getElementById('alertContainer')
const productTableBody = document.getElementById('productTableBody')
const btnSubmit = document.getElementById('submitBtn')

//Carrito
document.addEventListener('DOMContentLoaded', () => {
    const botonesAgregar = document.querySelectorAll('.btn-agregar');
    loadProductos()

    botonesAgregar.forEach(boton => {
        boton.addEventListener('click', () => {
            alert('Producto agregado al carrito');
            agregarAlCarrito();
        });
    });
  })


const agregarAlCarrito = async () => {
    const idproducto = document.getElementById('idproducto').value
    
    const producto = {
        usuario: document.getElementById('nombre').value || 'N/A',
        producto: document.getElementById('descripcion').value || 'Descripción no disponible'
    }

    if (idproducto) {
        producto.idproducto = idproducto
    }

    const url = `${apiURL}/usuario`
    const method = idproducto ? 'PUT' : 'POST'

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
    document.getElementById('idproducto').value = ''

    console.log('@@@ response => ', response)
}

//****FUNCIONES PARA PRODUCTOS******
  //AGREGAR PRODUCTOS - CAMBIO
  const crearProducto = async () => {
    const idproducto = document.getElementById('idproducto').value
    let producto
    if (idproducto){
      producto = {
        idproducto: idproducto,
        nombre: document.getElementById('nombre').value,
        descripcion: document.getElementById('descripcion').value,
        precio: document.getElementById('precio').value,
        marca: document.getElementById('marca').value,
        estado: document.getElementById('estado').value,
      }
    }else {
    producto = {
      nombre: document.getElementById('nombre').value,
      descripcion: document.getElementById('descripcion').value,
      precio: document.getElementById('precio').value,
      marca: document.getElementById('marca').value,
      estado: document.getElementById('estado').value,
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
    }else if(response.mensaje === 'Producto Actualizado'){
      showAlert('ProductoActualizado', 'warning')
      loadProductos()
      productForm.reset()
    }else {
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
        document.getElementById('nombre').value = producto.nombre
        document.getElementById('descripcion').value = producto.descripcion
        document.getElementById('precio').value = producto.precio
        document.getElementById('marca').value = producto.marca
        document.getElementById('estado').estado = producto.estado
      }
      console.log('@@ producto =>', producto)
      } 
    catch (error) {
      console.error('Error: ', error)
    }
  }
  //CARGA DE PRODUCTOS
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
          <td>${item.nombre}</td>
          <td>${item.descrip}</td>
          <td>${item.precio}</td>
          <td>${item.marca}</td>
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
  
  


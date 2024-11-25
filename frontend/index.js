const apiURL = 'http://localhost:8888/Proyecto-Tienda/src/index.php'
const productForm = document.getElementById('productForm')
const alertContainer = document.getElementById('alertContainer')
const productTableBody = document.getElementById('productTableBody')
const btnSubmit = document.getElementById('submitBtn')

//Carrito
document.addEventListener('DOMContentLoaded', () => {
    const botonesAgregar = document.querySelectorAll('.btn-agregar');

    botonesAgregar.forEach(boton => {
        boton.addEventListener('click', () => {
            alert('Producto agregado al carrito');
            agregarAlCarrito();
        });
    });
});

//Productos
document.addEventListener('DOMContentLoaded', () => {
    loadProductos()
  })

//********FUNCIONES PARA USUARIOS*******
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

//******FUNCIONES PARA CARRITO******
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


//****FUNCIONES PARA PRODUCTOS******

  
  //AGREGAR PRODUCTOS - CAMBIO
  const crearProducto = async () => {
    const productId = document.getElementById('productId').value
    let producto
    if (productId){
      producto = {
        idproducto: productId,
        nombre: document.getElementById('nombre').value,
        descripcion: document.getElementById('descripcion').value,
        precio: document.getElementById('precio').value,
        marca: document.getElementById('marca').value,
        estado: document.getElementById('estado').value,
        categoria: document.getElementById('categoria').value,
       //imagen: document.getElementById('imagen').value,
        
      }
    }else {
    producto = {
      nombre: document.getElementById('nombre').value,
      descripcion: document.getElementById('descripcion').value,
      precio: document.getElementById('precio').value,
      marca: document.getElementById('marca').value,
      estado: document.getElementById('estado').value,
      categoria: document.getElementById('categoria').value,
      //imagen: document.getElementById('imagen').value,
      
    }
  }
    const url = `${apiURL}/usuario/vendedor`
    const method = productId ? 'PUT' : 'POST'
  
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
    document.getElementById('productId').value = ''
  
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
        document.getElementById('productId').value = producto.idproducto
        document.getElementById('nombre').value = producto.nombre
        document.getElementById('descripcion').value = producto.descripcion
        document.getElementById('precio').value = producto.precio
        document.getElementById('marca').value = producto.marca
        document.getElementById('estado').estado = producto.estado
        document.getElementById('categoria').categoria = producto.categoria
        //document.getElementById('imagen').value = producto.imagen
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
          <td>${item.descripcion}</td>
          <td>${item.tipo}</td>
          <td>${item.precio}</td>
          <td>${item.imagen}</td>
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
  
  


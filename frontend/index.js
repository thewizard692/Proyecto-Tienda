const apiURL = 'http://localhost:8888/Proyecto-Tienda/src/index.php'
const alertContainer = document.getElementById('alertContainer')

//Carrito
document.addEventListener('DOMContentLoaded', () => {
    const botonesAgregar = document.querySelectorAll('.btn-agregar');
    //loadProductos()

    botonesAgregar.forEach(boton => {
        boton.addEventListener('click', () => {
            alert('Producto agregado al carrito');
            agregarAlCarrito();
        });
    });

    const isLoggedIn = sessionStorage.getItem('loggedIn'); 
    const loginMenu = document.getElementById('loginMenu');
    const logoutMenu = document.getElementById('logoutMenu');
    const loginEmail = document.getElementById('loginEmail');
    const loginName = document.getElementById('loginName');
    const loginUserName = document.getElementById('loginUserName');

    const isVendedor = sessionStorage.getItem('isVendedor'); 
    const loginVendor = document.getElementById('loginVendor');
  
    if (isLoggedIn === 'true') {
      loginMenu.classList.toggle('hide-on-login', false);
      logoutMenu.classList.toggle('hide-on-login', true);
      loginEmail.textContent = sessionStorage.getItem('correo');
      loginName.textContent = sessionStorage.getItem('nombre');
      loginUserName.textContent = "Tu Cuenta: " + sessionStorage.getItem('usuario');

      if(isVendedor){
        loginVendor.classList.toggle('hide-on-vendor', false);
      }else{
        loginVendor.classList.toggle('hide-on-vendor', true);
      }

    } else {
      loginMenu.classList.toggle('hide-on-login', true);
      loginVendor.classList.toggle('hide-on-vendor', true);
      logoutMenu.classList.toggle('hide-on-login', false);
    }
});

function toggleMenu() {
    var menu = document.getElementById('sideMenu');
    menu.classList.toggle('open');
}

//************FUNCIONES PARA LA BARRA DE BUSQUEDA */
//BUSQUEDA POR NOMBRE
const obtenerProductosPorBusqueda = async (busqueda) => {
    $search = document.getElementById('BarraBusqueda');
      try {
        const send = {
          busqueda: busqueda
        }
        const res = await fetch(apiURL +'/usuario/busqueda', {
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
          document.getElementById('prd_estado').value = producto.prd_estado
        }
        console.log('@@ producto =>', producto)
        } 
      catch (error) {
        console.error('Error: ', error)
      }
}

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
      document.getElementById('prd_estado').value = producto.prd_estado
    }
    console.log('@@ producto =>', producto)
    } 
  catch (error) {
    console.error('Error: ', error)
  }
}


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
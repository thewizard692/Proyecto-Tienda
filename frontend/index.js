const apiURL = 'http://localhost:8888/Proyecto-Tienda/src/index.php'
const alertContainer = document.getElementById('alertContainer')

//Carrito
document.addEventListener('DOMContentLoaded', () => {

    const isLoggedIn = sessionStorage.getItem('loggedIn'); 
    const loginMenu = document.getElementById('loginMenu');
    const logoutMenu = document.getElementById('logoutMenu');
    const loginEmail = document.getElementById('loginEmail');
    const loginName = document.getElementById('loginName');
    const loginUserName = document.getElementById('loginUserName');
    const cuentaBtn = document.getElementById('cuentaBtn');

    const isVendedor = sessionStorage.getItem('isVendedor'); 
    const loginVendor = document.getElementById('loginVendor');
  
    if (isLoggedIn === 'true') {
      loginMenu.classList.toggle('hide-on-login', false);
      logoutMenu.classList.toggle('hide-on-login', true);
      cuentaBtn.classList.toggle('logged-in',true);
      cuentaBtn.classList.toggle('logged-out',false);
      loginEmail.textContent = sessionStorage.getItem('correo');
      loginName.textContent = sessionStorage.getItem('nombre');
      loginUserName.textContent = "Tu Cuenta: " + sessionStorage.getItem('usuario');

      if(isVendedor){
        loginVendor.classList.toggle('hide-on-vendor', false);
      }else{
        loginVendor.classList.toggle('hide-on-vendor', true);
      }

    } else {
      cuentaBtn.classList.toggle('logged-in',false);
      cuentaBtn.classList.toggle('logged-out',true);
      loginMenu.classList.toggle('hide-on-login', true);
      loginVendor.classList.toggle('hide-on-vendor', true);
      logoutMenu.classList.toggle('hide-on-login', false);
    }
});

function toggleMenu() {
    var menu = document.getElementById('sideMenu');
    menu.classList.toggle('open');
}

document.querySelector('.categorias-destacadas').addEventListener('click', (event) => {
  const categoria = event.target.closest('.categoria');
  if (categoria) {
      const categoriaId = categoria.getAttribute('data-id');
      location.href = `./pages/todo.html?categoriaId=${categoriaId}`;
  }
});

document.getElementById('btnBuscar').addEventListener('click', (event) => {
  const busqueda = document.getElementById('BarraBusqueda').value;
  if (busqueda) {
      location.href = `./pages/todo.html?busqueda=${busqueda}`;
  }
});

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
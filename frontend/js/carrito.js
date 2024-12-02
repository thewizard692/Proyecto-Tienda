const apiURL = 'http://localhost:8888/Proyecto-Tienda/src/index.php';
const tablaCarrito = document.getElementById('tabla-carrito').getElementsByTagName('tbody')[0];
const totalContainer = document.getElementById('total');
const payButton = document.getElementById('pay-button');

const cargarCarrito = async () => {
    try {
        const url = `${apiURL}/usuario/carrito`;
        const respuesta = await fetch(url, { method: 'GET' });

        if (!respuesta.ok) {
            throw new Error(`HTTP Error: ${respuesta.status}`);
        }

        const productos = await respuesta.json();
        tablaCarrito.innerHTML = '';
        let total = 0;

        productos.forEach((producto) => {
            const row = tablaCarrito.insertRow();

            row.insertCell(0).textContent = producto.nombre;
            row.insertCell(1).textContent = `$${producto.precio.toFixed(2)}`;
            row.insertCell(2).textContent = producto.cantidad;
            row.insertCell(3).textContent = `$${(producto.precio * producto.cantidad).toFixed(2)}`;

            const eliminarCell = row.insertCell(4);
            const eliminarBtn = document.createElement('button');
            eliminarBtn.textContent = 'Eliminar';
            eliminarBtn.style.backgroundColor = 'red';
            eliminarBtn.style.color = 'white';
            eliminarBtn.addEventListener('click', () => eliminarProducto(producto.id));
            eliminarCell.appendChild(eliminarBtn);

            total += producto.precio * producto.cantidad;
        });

        totalContainer.textContent = `Total: $${total.toFixed(2)}`;
    } catch (error) {
        console.error('Error al cargar el carrito:', error);
        alert('Ocurrió un error al cargar el carrito.');
    }
};

const agregarProducto = async (producto) => {
    try {
        const url = `${apiURL}/usuario/carrito/agregar`;
        const respuesta = await fetch(url, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(producto),
        });

        const resultado = await respuesta.json();
        if (resultado.status === 'success') {
            alert('Producto agregado al carrito.');
            cargarCarrito();
        } else {
            alert(`Error: ${resultado.message}`);
        }
    } catch (error) {
        console.error('Error al agregar producto:', error);
        alert('Ocurrió un error al agregar el producto.');
    }
};

const eliminarProducto = async (productoId) => {
    try {
        const url = `${apiURL}/usuario/carrito/quitar`;
        const respuesta = await fetch(url, {
            method: 'DELETE',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ id: productoId }),
        });

        const resultado = await respuesta.json();
        if (resultado.status === 'success') {
            alert('Producto eliminado del carrito.');
            cargarCarrito();
        } else {
            alert(`Error: ${resultado.message}`);
        }
    } catch (error) {
        console.error('Error al eliminar producto:', error);
        alert('Ocurrió un error al intentar eliminar el producto.');
    }
};

const pagarPedido = async () => {
    try {
        const url = `${apiURL}/usuario/carrito/orden`;
        const respuesta = await fetch(url, { method: 'POST' });

        const resultado = await respuesta.json();
        if (resultado.status === 'success') {
            alert('Productos pagados correctamente.');
            cargarCarrito(); 
        } else {
            alert(`Error: ${resultado.message}`);
        }
    } catch (error) {
        console.error('Error al procesar el pago:', error);
        alert('Ocurrió un error al intentar procesar el pago.');
    }
};

payButton.addEventListener('click', pagarPedido);

cargarCarrito();


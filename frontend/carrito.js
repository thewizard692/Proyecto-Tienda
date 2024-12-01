// Simula una llamada a la base de datos para obtener los productos del carrito
const obtenerProductos = async () => {
    try {
        // Simula una API o base de datos con fetch
        const response = await fetch('https://localhost:8889/Proyecto-tienda/src/index.php'); // Reemplaza esta URL con tu API real
        if (!response.ok) throw new Error('Error al obtener los productos');
        const productos = await response.json();
        return productos;
    } catch (error) {
        console.error(error);
        return [];
    }
};

// Renderiza los productos en la tabla del carrito
const renderizarCarrito = (productos) => {
    const tablaCarrito = document.getElementById('tabla-carrito').getElementsByTagName('tbody')[0];
    const totalContainer = document.getElementById('total');
    let total = 0;

    // Limpiar la tabla antes de cargar los productos
    tablaCarrito.innerHTML = '';

    // Agregar productos a la tabla
    productos.forEach((producto, index) => {
        const row = tablaCarrito.insertRow();
        row.insertCell(0).textContent = producto.name;
        row.insertCell(1).textContent = `$${producto.price.toFixed(2)}`;
        row.insertCell(2).textContent = producto.quantity;
        row.insertCell(3).textContent = `$${(producto.price * producto.quantity).toFixed(2)}`;

        // Botón de eliminar
        const eliminarCell = row.insertCell(4);
        const eliminarBtn = document.createElement('button');
        eliminarBtn.textContent = 'Eliminar';
        eliminarBtn.style.backgroundColor = 'red';
        eliminarBtn.style.color = 'white';
        eliminarBtn.addEventListener('click', () => eliminarProducto(index, productos));
        eliminarCell.appendChild(eliminarBtn);

        // Sumar al total
        total += producto.price * producto.quantity;
    });

    // Mostrar el total
    totalContainer.textContent = `Total: $${total.toFixed(2)}`;
};

// Elimina un producto del carrito
const eliminarProducto = (index, productos) => {
    productos.splice(index, 1); // Elimina el producto del array
    renderizarCarrito(productos); // Vuelve a renderizar el carrito
};

// Acción del botón de "Pagar Pedido"
const pagarPedido = () => {
    const totalText = document.getElementById('total').textContent;
    const total = parseFloat(totalText.replace('Total: $', ''));
    if (total > 0) {
        alert('¡Gracias por tu compra! Total pagado: ' + totalText);
        // Simula vaciar el carrito tras el pago
        renderizarCarrito([]);
    } else {
        alert('No hay productos en el carrito para pagar.');
    }
};

// Cargar productos y configurar eventos
const cargarCarrito = async () => {
    const productos = await obtenerProductos();
    renderizarCarrito(productos);

    // Configura el botón de pagar
    const pagarBtn = document.querySelector('.pay-button');
    pagarBtn.addEventListener('click', pagarPedido);
};

// Inicializar el carrito al cargar la página
document.addEventListener('DOMContentLoaded', cargarCarrito);


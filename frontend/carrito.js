// Selecciona todos los botones "Eliminar"
const eliminarBtns = document.querySelectorAll(".cart-item button");
const cartSummary = document.querySelector(".cart-summary h3");

// Función para calcular el total
function actualizarTotal() {
    let total = 0;
    const precios = document.querySelectorAll(".cart-item p");
    precios.forEach(precio => {
        const valor = parseFloat(precio.textContent.replace("Precio: $", ""));
        total += valor;
    });
    cartSummary.textContent = `Total: $${total.toFixed(2)}`;
}

// Evento para eliminar productos
eliminarBtns.forEach(btn => {
    btn.addEventListener("click", function () {
        const cartItem = this.closest(".cart-item");
        cartItem.remove(); // Elimina el producto del DOM
        actualizarTotal(); // Actualiza el total
    });
});

// Obtiene el carrito del localStorage o inicializa uno vacío
let carrito = JSON.parse(localStorage.getItem("carrito")) || [];

// Función para agregar un producto al carrito
function agregarAlCarrito(id, name, price) {
    // Verifica si el producto ya está en el carrito
    const productoExistente = carrito.find(item => item.id === id);
    if (productoExistente) {
        productoExistente.cantidad += 1;
    } else {
        carrito.push({ id, name, price, cantidad: 1 });
    }

    // Actualiza el localStorage
    localStorage.setItem("carrito", JSON.stringify(carrito));
    alert(`${name} ha sido agregado al carrito`);
}

// Escucha los clics en los botones "Agregar al carrito"
document.addEventListener("click", (e) => {
    if (e.target.classList.contains("add-to-cart")) {
        const id = parseInt(e.target.dataset.id);
        const name = e.target.dataset.name;
        const price = parseFloat(e.target.dataset.price);
        agregarAlCarrito(id, name, price);
    }
});

// Función para mostrar productos en la página del carrito
function mostrarCarrito() {
    const container = document.querySelector(".container");
    container.innerHTML = "<h2>Productos en tu carrito</h2>";

    if (carrito.length === 0) {
        container.innerHTML += "<p>Tu carrito está vacío</p>";
        return;
    }

    carrito.forEach(producto => {
        const item = document.createElement("div");
        item.classList.add("cart-item");
        item.innerHTML = `
            <h3>${producto.name}</h3>
            <p>Precio: $${producto.price.toFixed(2)}</p>
            <p>Cantidad: ${producto.cantidad}</p>
            <button class="eliminar" data-id="${producto.id}">Eliminar</button>
        `;
        container.appendChild(item);
    });

    // Mostrar total
    const total = carrito.reduce((sum, producto) => sum + producto.price * producto.cantidad, 0);
    container.innerHTML += `<h3>Total: $${total.toFixed(2)}</h3>`;
}

// Elimina productos del carrito
document.addEventListener("click", (e) => {
    if (e.target.classList.contains("eliminar")) {
        const id = parseInt(e.target.dataset.id);
        carrito = carrito.filter(item => item.id !== id);
        localStorage.setItem("carrito", JSON.stringify(carrito));
        mostrarCarrito();
    }
});

// Llama a mostrarCarrito cuando la página del carrito se carga
if (window.location.pathname.includes("carrito.html")) {
    mostrarCarrito();
}


// Inicializa el total al cargar la página
actualizarTotal();
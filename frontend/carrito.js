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

// Inicializa el total al cargar la página
actualizarTotal();

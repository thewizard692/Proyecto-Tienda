const apiURL = 'http://localhost:8888/Proyecto-Tienda/src/index.php';
const cards = document.querySelector('#card');
const templateCard = document.querySelector('#template-card').content;

// Ejecutar al cargar el DOM
document.addEventListener('DOMContentLoaded', () => {
    obtenerProductos();
});

// Obtener productos desde la API
const obtenerProductos = async () => {
    const url = `${apiURL}/usuario/productos`;
    const method = 'GET';

        const respuesta = await fetch(url, {
            method: method,
            headers: {
                'Content-Type': 'application/json',
            },
        });

        const resultado = await respuesta.json();
 
        const fragment = document.createDocumentFragment();
        cards.textContent = ''; // Limpia el contenedor antes de añadir nuevos elementos

        resultado.forEach((item) => {
            const clone = templateCard.cloneNode(true);
            clone.querySelector('h5').textContent = item.prd_nombre; // Nombre del producto
            clone.querySelector('p:nth-child(2)').textContent = `Descripción: ${item.prd_descrip}`; // Descripción
            clone.querySelector('p:nth-child(3)').textContent = `Precio: $${item.prd_precio}`; // Precio
            clone.querySelector('p:nth-child(4)').textContent = `Marca: ${item.prd_marca}`; // Marca
            clone.querySelector('p:nth-child(5)').textContent = `Estado: ${item.prd_estado}`; // Estado
            clone.querySelector('img').setAttribute('src', item.Imagen || '../placeholder.jpg'); // Imagen (placeholder si no hay)
            fragment.appendChild(clone);
        });

        cards.appendChild(fragment);
 
};

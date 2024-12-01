const apiURL = 'http://localhost:8888/Proyecto-Tienda/src/index.php';
const cards = document.querySelector('#card');
const templateCard = document.querySelector('#template-card').content;

const urlParams = new URLSearchParams(window.location.search);
const categoriaId = urlParams.get('categoriaId');
const busqueda = urlParams.get('busqueda');

document.addEventListener('DOMContentLoaded', () => {

    if(busqueda) {
        obtenerProductosPorBusqueda(busqueda);
    }else
    if (categoriaId) {
        obtenerProductosPorCategoria(categoriaId);
    } else {
        obtenerProductos();
    }
});

// Obtener productos por categoría desde la API
const obtenerProductosPorCategoria = async (categoriaId) => {
    const url = `${apiURL}/usuario/productos/categoria`;
    const method = 'POST';

    try {

        const send = {
            id: categoriaId
        }

        const respuesta = await fetch(url, {
            method: method,
            body: JSON.stringify(send)
        });

        const resultado = await respuesta.json();
        const fragment = document.createDocumentFragment();
        cards.textContent = '';

        resultado.forEach((item) => {
            const clone = templateCard.cloneNode(true);
            clone.querySelector('h5').textContent = item.prd_nombre;
            clone.querySelector('p:nth-child(2)').textContent = `Descripción: ${item.prd_descrip}`;
            clone.querySelector('p:nth-child(3)').textContent = `Precio: $${item.prd_precio}`;
            clone.querySelector('p:nth-child(4)').textContent = `Marca: ${item.prd_marca}`;
            clone.querySelector('p:nth-child(5)').textContent = `Estado: ${item.prd_estado}`;
            clone.querySelector('img').setAttribute('src', item.prd_imagen || '../placeholder.jpg');
            fragment.appendChild(clone);
        });

        cards.appendChild(fragment);
    } catch (error) {
        console.error('Error al obtener los productos por categoría:', error);
    }
};

const obtenerProductosPorBusqueda = async (busqueda) => {
    const url = `${apiURL}/usuario/productos/busqueda`;
    const method = 'POST';

        const send = {
            busqueda: busqueda
        };
    
        const respuesta = await fetch(url, {
            method: method,
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(send)
        });

        const resultado = await respuesta.json();
        const fragment = document.createDocumentFragment();
        cards.textContent = '';

        if (resultado && resultado.length > 0) {
            resultado.forEach((item) => {

                const clone = templateCard.cloneNode(true);

                clone.querySelector('h5').textContent = item.prd_nombre;
                clone.querySelector('p:nth-child(2)').textContent = `Descripción: ${item.prd_descrip}`;
                clone.querySelector('p:nth-child(3)').textContent = `Precio: $${item.prd_precio}`;
                clone.querySelector('p:nth-child(4)').textContent = `Marca: ${item.prd_marca}`;
                clone.querySelector('p:nth-child(5)').textContent = `Estado: ${item.prd_estado}`;
                clone.querySelector('img').setAttribute('src', item.prd_imagen || '../placeholder.jpg');

                fragment.appendChild(clone);
            });

            cards.appendChild(fragment);
        } else {
            console.log('No se encontraron productos para la búsqueda.');
        }

};

const obtenerProductos = async () => {
    const url = `${apiURL}/usuario/productos`;
    const method = 'GET';

    try {
        const respuesta = await fetch(url, {
            method: method,
            headers: {
                'Content-Type': 'application/json',
            },
        });

        const resultado = await respuesta.json();
        const fragment = document.createDocumentFragment();
        cards.textContent = '';

        resultado.forEach((item) => {
            const clone = templateCard.cloneNode(true);
            clone.querySelector('h5').textContent = item.prd_nombre;
            clone.querySelector('p:nth-child(2)').textContent = `Descripción: ${item.prd_descrip}`;
            clone.querySelector('p:nth-child(3)').textContent = `Precio: $${item.prd_precio}`;
            clone.querySelector('p:nth-child(4)').textContent = `Marca: ${item.prd_marca}`;
            clone.querySelector('p:nth-child(5)').textContent = `Estado: ${item.prd_estado}`;
            clone.querySelector('img').setAttribute('src', item.prd_imagen || '../placeholder.jpg');
            fragment.appendChild(clone);
        });

        cards.appendChild(fragment);
    } catch (error) {
        console.error('Error al obtener los productos:', error);
    }
};

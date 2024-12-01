// Código para los copos de nieve
document.addEventListener("DOMContentLoaded", function() {
    const numberOfFlakes = 100; // Número de copos de nieve
    const snowContainer = document.body;

    // Crear los copos de nieve
    for (let i = 0; i < numberOfFlakes; i++) {
        const snowflake = document.createElement('div');
        snowflake.classList.add('snowflake');
        snowContainer.appendChild(snowflake);

        // Posición aleatoria
        snowflake.style.left = Math.random() * 100 + 'vw';  // 100vw = 100% del ancho de la ventana
        snowflake.style.animationDuration = Math.random() * 3 + 2 + 's'; // Duración aleatoria entre 2s y 5s
        snowflake.style.animationDelay = Math.random() * 5 + 's'; // Retraso aleatorio para cada copo
    }
});


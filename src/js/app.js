document.addEventListener('DOMContentLoaded', function () {

    eventListeners();

    darkMode();
});

function darkMode() {
    const prefiereDarkMode = window.matchMedia('(prefers-color-scheme: dark)');

    // console.log(prefiereDarkMode.matches);

    if (prefiereDarkMode.matches) {
        document.body.classList.add('dark-mode');
    } else {
        document.body.classList.remove('dark-mode');
    }

    prefiereDarkMode.addEventListener('change', function () {
        if (prefiereDarkMode.matches) {
            document.body.classList.add('dark-mode');
        } else {
            document.body.classList.remove('dark-mode');
        }

    });
    const botonDarkMode = document.querySelector('.dark-mode-boton');
    botonDarkMode.addEventListener('click', function () {
        document.body.classList.toggle('dark-mode');

        // Guardar el estado del modo oscuro en localStorage
        if (document.body.classList.contains('dark-mode')) {
            localStorage.setItem('darkMode', 'enabled');
        } else {
            localStorage.setItem('darkMode', 'disabled');
        }
    });
}

function eventListeners() {
    const mobileMenu = document.querySelector('.mobile-menu');

    mobileMenu.addEventListener('click', navegacionResponsive);

    //Muestra campos condicionales
    const metodoContacto = document.querySelectorAll('input[name="contacto[contacto]"');
    metodoContacto.forEach(input => input.addEventListener('click', mostrarMetodosContacto));

}

function navegacionResponsive() {
    const navegacion = document.querySelector('.navegacion');

    if (navegacion.classList.contains('mostrar')) {
        navegacion.classList.remove('mostrar');
    } else {
        navegacion.classList.add('mostrar');
    }
}

function mostrarMetodosContacto(e) {
    const contactoDiv = document.querySelector('#contacto');
    contactoDiv.textContent = 'Seleccione un método de contacto';

    if (e.target.value === 'telefono') {
        contactoDiv.innerHTML = `
            <label for="telefono">Número Teléfono</label>
            <input type="tel" placeholder="Tu teléfono" id="telefono" name="contacto[telefono]">
            
            <p>Elija la fecha y la hora para la llamada</p>

            <label for="fecha">fecha</label>
            <input type="date" id="fecha" name="contacto[fecha]">

            <label for="hora">Hora</label>
            <input type="time" id="hora" min="09:00" max="18:00" name="contacto[hora]">
        `;
    } else {
        contactoDiv.innerHTML = `
            <label for="email">E-mail</label>
            <input type="text" placeholder="Tu Email" id="email" name="contacto[email]" >
        `;
    }
    
}

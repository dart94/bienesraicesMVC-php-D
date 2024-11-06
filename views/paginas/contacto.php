<main class="contenedor seccion">
    <h1>Contacto</h1>

    <?php if($mensaje){ ?>
        <p class ='alerta exito'> <?php echo $mensaje; ?></p>;
    <?php } ?>

    <picture>
        <source srcset="build/img/destacada3.webp" type="image/webp">
        <source srcset="build/img/destacada3.jpg" type="image/jpeg">
        <img loading="lazy" src="build/img/destacada3.jpg" alt="Imagen Contacto">
    </picture>

    <h2>Llene el formulario de Contacto</h2>

    <form class="formulario"  action="/contacto" method="POST">
        <fieldset>
            <legend>Información Personal</legend>

            <label for="nombre">Nombre</label>
            <input type="text" placeholder="Tu Nombre" id="nombre" name="contacto[nombre]" >
            <label for="Mensaje">Mensaje</label>
            <textarea id="mensaje" name="contacto[mensaje]" requiered></textarea>
        </fieldset>
        <fieldset>
            <legend>Información sobre la propiedad</legend>
            <label for="Opciones">Vender o compra</label>
            <select id="Opciones" name ="contacto[tipo]" >
                <option value="" disabled selected>--Selecione--</option>
                <option value="Compra">Compra</option>
                <option value="Vende">Vende</option>
            </select>

            <label for="presupuesto">Precio o Presupuesto</label>
            <input type="number" placeholder="Tu precio o presupuesto" id="pres" name="contacto[precio]" >
        </fieldset>

        <fieldset>
            <legend>Contacto</legend>

            <p>Como desea ser contactado</p>
            <div class="forma-contacto">
                <label for="contactar-telefono">Teléfono</label>
                <input type="radio" value="telefono" id="contactar-telefono" name="contacto[contacto]" >
                <label for="contactar-Email">E-mail</label>
                <input type="radio" value="email" id="contactar-Email" name="contacto[contacto]" >
            </div>

            <div id="contacto"></div>

            <p>Si eligió teléfono, elija la fecha y la hora</p>

            <label for="fecha">fecha</label>
            <input type="date" id="fecha" name="contacto[fecha]">

            <label for="hora">Hora</label>
            <input type="time" id="hora" min="09:00" max="18:00" name="contacto[hora]">
        </fieldset>
        <input type="submit" value="Enviar" class="boton-verde">
    </form>
</main>
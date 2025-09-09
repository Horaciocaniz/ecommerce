<?php include 'partials/header.php'; ?>

<div class="container my-5">
    <h1 class="text-center mb-4">Preguntas Frecuentes</h1>
    <p class="text-center text-muted mb-5">
        Encuentra aquí las respuestas a las dudas más comunes sobre nuestra tienda.
    </p>

    <div class="accordion" id="faqAccordion">

        <!-- Pregunta 1 -->
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingOne">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                    ¿Cuánto tarda en llegar mi pedido?
                </button>
            </h2>
            <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#faqAccordion">
                <div class="accordion-body">
                    Los envíos suelen tardar entre <strong>2 a 5 días hábiles</strong> dependiendo de tu ubicación.
                </div>
            </div>
        </div>

        <!-- Pregunta 2 -->
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingTwo">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                    ¿Hacen envíos a todo el país?
                </button>
            </h2>
            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#faqAccordion">
                <div class="accordion-body">
                    Sí, realizamos envíos a <strong>todas las regiones de Guatemala</strong> mediante paquetería confiable. Y a otros paises siempre mantenemos buena comunicacion para su mayor tranquilidad.
                </div>
            </div>
        </div>

        <!-- Pregunta 3 -->
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingThree">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                    ¿Qué métodos de pago aceptan?
                </button>
            </h2>
            <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#faqAccordion">
                <div class="accordion-body">
                    Aceptamos pagos con <strong>tarjeta de crédito o débito</strong> mediante Recurrente, 
                    así como transferencias bancarias.
                </div>
            </div>
        </div>

        <!-- Pregunta 4 -->
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingFour">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                    ¿Puedo cambiar o devolver un producto?
                </button>
            </h2>
            <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#faqAccordion">
                <div class="accordion-body">
                    Sí, puedes solicitar un <strong>cambio o devolución</strong> dentro de los primeros 7 días si el producto presenta defectos o no es el correcto.
                </div>
            </div>
        </div>

    </div>
</div>

<?php include 'partials/footer.php'; ?>

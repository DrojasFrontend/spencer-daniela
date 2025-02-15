<!-- template-parts/rsvp-button.php -->
<!-- <button id="openRSVP">RSVP</button> -->

<div id="rsvpModal" class="rsvpModal">
    <div class="rsvpModal__content">

        <span class="rsvpModal__close">&times;</span>

        <div class="rsvpModal__progress">
            <div class="rsvpModal__progress-bar"></div>
        </div>
        <!-- Step 1: Search -->
        <div id="step1" class="rsvpModal__step rsvpModal__step--active">
            <h2 class="heading--32 uppercase color--836923">Daniela & Spencer</h2>
            <p class="heading--24 uppercase color--4F4F4F">WEDDING RSVP</p>
            <span class="space space--30"></span>
            <p class="heading--16 color--000" style="font-family: 'Poppins', serif; ">
                Please enter below your First Name <br> and your Last Name, all in capitals.
            </p>
            <span class="space space--30 "></span>
            <label for="" class="heading--16 color--000" style="font-family: 'Poppins', serif; ">Full Name</label>
            <input type="text" id="searchInput" placeholder="Full Name">
            <div id="searchResults"></div>
        </div>

        <!-- Step 2: Wedding -->
        <div id="step2" class="rsvpModal__step">
            <h2 class="heading--32 uppercase color--836923">Wedding</h3>
            <p class="heading--24 uppercase color--4F4F4F">NUESTRO MATRIMONIO</p>
            <span class="space space--20"></span>
            <p class="heading--16 color--000" style="font-family: 'Poppins', serif; ">
            October 12th, 2025 / 12 de Octubre 2025
            Hacienda San José, Pereira - Colombia
            3:30 P.M.
            </p>
            <span class="space space--20"></span>
            <div class="guest-response">
                <p>Name Guest 1</p>
                <div>
                    <button class="button button--small" onclick="acceptWedding()">Accept</button>
                    <button class="button button--small" onclick="declineWedding()">Decline</button>
                </div>
            </div>
            <button class="button button--secondary" onclick="prevStep(1)">Back</button>
            <span class="space space--10"></span>
            <button class="button button--secondary" onclick="nextStep(3)">Continue</button>
        </div>

        <!-- Step 3: Wedding -->
        <div id="step3" class="rsvpModal__step">
            <h2 class="heading--32 color--836923">Which menu do you prefer?</h2>
            <p class="heading--24 color--4F4F4F">¿Qué Menú prefieres?</p>
            <span class="space space--20"></span>
            <p class="heading--16 color--000" style="font-family: 'Poppins', serif; ">
                October 12th, 2025 / 12 de Octubre 2025
                Hacienda San José, Pereira - Colombia
                3:30 P.M.
            </p>
            <span class="space space--20"></span>
            <div class="guest-response">
                <p>Name Guest 1</p>
                <div>
                    <select class="select--small" onchange="handleMenuChoice(this.value)">
                        <option value="">Select an option</option>
                        <option value="true">Beef / Carne de Res</option>
                        <option value="true">Fish / Pescado</option>
                        <option value="true">Vegetarian / Vegetariano</option>
                    </select>
                </div>
            </div>
            <div class="navigation-buttons">
                <button class="button button--secondary" onclick="prevStep(2)">Back</button>
                <span class="space space--10"></span>
                <button class="button button--secondary" onclick="nextStep(4)">Continue</button>
            </div>
        </div>

        <!-- Step 4: Cocktail -->
        <div id="step4" class="rsvpModal__step">
            <h2 class="heading--32 uppercase color--836923">Welcome Cocktail</h3>
            <p class="heading--24 uppercase color--4F4F4F">COCTEL DE BIENVENIDA</p>
            <span class="space space--20"></span>
            <p class="heading--16 color--000" style="font-family: 'Poppins', serif; ">
                October 11th, 2025 / 11 de Octubre 2025 <br>
                Hacienda Gavilanes <br>
                4:00 P.M.
            </p>
            <span class="space space--30"></span>
            <div class="guest-response">
                <p>Name Guest 1</p>
                <div>
                    <button class="button button--small" onclick="acceptCocktail()">Accept</button>
                    <button class="button button--small" onclick="declineCocktail()">Decline</button>
                </div>
            </div>
            <div class="navigation-buttons">
            <button class="button button--secondary" onclick="prevStep(3)">Back</button>
            <span class="space space--10"></span>
            <button class="button button--secondary" onclick="nextStep(5)">Continue</button>
            </div>
        </div>

        <!-- Step 5: Cocktail -->
        <div id="step5" class="rsvpModal__step">
            <h2 class="heading--32 uppercase color--836923">Beach Day Makani</h3>
            <p class="heading--24 uppercase color--4F4F4F">DÍA DE PLAYA MAKANI</p>
            <span class="space space--20"></span>
            <p class="heading--16 color--000" style="font-family: 'Poppins', serif; ">
                May 24th, 2025 / 24 de Mayo 2025 <br>
                Makani Beach Club <br>
                9:00 P.M.
            </p>
            <span class="space space--30"></span>
            <div class="guest-response">
                <p>Name Guest 1</p>
                <div>
                    <button class="button button--small" onclick="acceptCocktail()">Accept</button>
                    <button class="button button--small" onclick="declineCocktail()">Decline</button>
                </div>
            </div>
            <button class="button button--secondary" onclick="prevStep(4)">Back</button>
            <span class="space space--10"></span>
            <button class="button button--secondary" onclick="nextStep(6)">Continue</button>
        </div>

        <!-- Step 6: Additional Info -->
        <div id="step6" class="rsvpModal__step">
            <h2 class="heading--32 uppercase color--836923">Additional Info</h3>
            <p class="heading--24 uppercase color--4F4F4F">INFORMACIÓN ADICIONAL</p>
            <span class="space space--20"></span>
            <label for="" class="heading--16 color--000" style="font-family: 'Poppins', serif; ">Phone / Teléfono</label>
            <input type="text" id="phone">
            <span class="space space--10"></span>
            <label for="" class="heading--16 color--000" style="font-family: 'Poppins', serif; ">Email address (Correo Electrónico)</label>
            <span class="space space--10"></span>
            <input type="email" id="email">
            <label for="" class="heading--16 color--000" style="font-family: 'Poppins', serif; ">Share sound you would like play at reception? <br> Comparte una canción que quieras agregar al playlist de la fiesta?</label>
            <input type="text" id="play">
            <span class="space space--10"></span>
            <label for="" class="heading--16 color--000" style="font-family: 'Poppins', serif; ">Tell us if you have any food allergies or restrictions? <br> Tienes alguna alergia o restricción alimentaria?</label>
            <textarea id="restrictions"></textarea>
            <span class="space space--10"></span>
            <div class="navigation-buttons">
            <button class="button button--secondary" onclick="prevStep(5)">Back</button>
            <button class="button button--secondary" onclick="submitRSVP()">R.S.V.P.</button>
            </div>
        </div>

        <!-- Step 7: Thanks -->
        <div id="step7" class="rsvpModal__step">
            <h2 class="heading--32 uppercase color--836923">Thanks</h3>
            <p class="heading--24 uppercase color--4F4F4F">GRACIAS</p>
            <p class="heading--16 color--000" style="font-family: 'Poppins', serif; ">
                Thank you for confirming your attendance to our wedding. We are very happy to share this special day with you. We will send a copy of your RSVP to your email.
            </p>
            <span class="space space--10"></span>
            <p class="heading--16 color--000" style="font-family: 'Poppins', serif; ">
            Gracias por confirmar tu asistencia a nuestro matrimonio. Estamos muy contentos de compartir este día tan especial con ustedes.
            Te enviaremos una copia del RSVP a tu correo electrónico.
            </p>

            <a class="button button--secondary" style="font-family: 'Poppins', serif;margin-top: 20px;font-size: 18px;" href="/">BACK TO HOME</a>
        </div>
    </div>
</div>
document.addEventListener("DOMContentLoaded", function () {
	// =========================================
	// Configuración inicial y variables globales
	// =========================================
	if (!window.appState) {
		window.appState = {
			rsvp: {
				isLoading: false,
			},
		};
	} else if (!window.appState.rsvp) {
		window.appState.rsvp = {
			isLoading: false,
		};
	}

	const formData = {
		invitados: [], // Array para almacenar las respuestas de todos los invitados
		phone: "",
		email: "",
		play: "",
		restrictions: "",
		numEvents: 0,
	};

	// Detectar tipo de dispositivo para eventos
	const userAgent = navigator.userAgent.toLowerCase();
	const eventType = userAgent.match(/(iphone|ipod|ipad)/)
		? "touchstart"
		: "click";

	// Elementos del DOM
	const searchInput = document.getElementById("searchInput");
	const searchResults = document.getElementById("searchResults");
	const modal = document.getElementById("rsvpModal");
	const progressBar = document.querySelector(".rsvpModal__progress-bar");
	const totalSteps = 7;

	// =========================================
	// Funciones de utilidad
	// =========================================
	function updateProgress(currentStep) {
		const progressPercentage = (currentStep / totalSteps) * 100;
		progressBar.style.width = `${progressPercentage}%`;
	}

	function resetForm() {
		formData.invitados = [];
		formData.phone = "";
		formData.email = "";
		formData.play = "";
		formData.restrictions = "";
		formData.numEvents = 0;

		searchInput.value = "";
		searchResults.innerHTML = "";
		showStep(1);
	}

	// =========================================
	// Funciones de navegación y pasos
	// =========================================
	window.showStep = function (step) {
		document.querySelectorAll(".rsvpModal__step").forEach((s) => {
			s.classList.remove("rsvpModal__step--active");
		});

		const stepElement = document.getElementById(`step${step}`);
		stepElement.classList.add("rsvpModal__step--active");
		updateProgress(step);

		switch (step) {
			case 2:
				stepElement.innerHTML = `
									<h2 class="heading--32 uppercase color--836923">Wedding</h2>
									<p class="heading--24 uppercase color--4F4F4F">NUESTRA BODA</p>
									<span class="space space--30"></span>
									<p class="heading--16 color--000" style="font-family: 'Poppins', serif; ">
											May 25th, 2025 / 25 de Mayo 2025 <br>
											Sofitel Legend Santa Clara<br>
											5:00 P.M.
									</p>
									<span class="space space--20"></span>
									<div class="guest-responses-container"></div>
									<div class="navigation-buttons">
											<button class="button button--secondary" onclick="prevStep(1)">Back</button>
											<span class="space space--10"></span>
											<button class="button button--secondary" onclick="prevStep(3)">Continue</button>
									</div>
							`;

				const weddingContainer = stepElement.querySelector(
					".guest-responses-container"
				);
				formData.invitados.forEach((invitado) => {
					const guestResponse = document.createElement("div");
					guestResponse.className = "guest-response";
					guestResponse.innerHTML = `
											<p>${invitado.nombre}</p>
											<div>
													<button class="button button--small" onclick="updateGuestResponse(this, true, 'wedding', '${invitado.nombre}')">Accept</button>
													<button class="button button--small" onclick="updateGuestResponse(this, false, 'wedding', '${invitado.nombre}')">Decline</button>
											</div>
									`;
					weddingContainer.appendChild(guestResponse);
				});
				break;

			case 3:
				if (formData.numEvents === 2) {
					stepElement.innerHTML = `
											<h2 class="heading--32 color--836923">Which menu do you prefer?</h2>
											<p class="heading--24 color--4F4F4F">¿Qué Menú prefieres?</p>
											<span class="space space--20"></span>
											<span class="space space--20"></span>
											<div class="guest-responses-container"></div>
											<div class="navigation-buttons">
													<button class="button button--secondary" onclick="prevStep(2)">Back</button>
													<span class="space space--10"></span>
													<button class="button button--secondary" onclick="nextStep(4)">Continue</button>
											</div>
									`;

					const menuContainer = stepElement.querySelector(
						".guest-responses-container"
					);
					formData.invitados.forEach((invitado) => {
						const guestResponse = document.createElement("div");
						guestResponse.className = "guest-response";
						guestResponse.innerHTML = `
							<p>${invitado.nombre}</p>
							<div>
									<select class="select--small" onchange="updateGuestResponse(this, this.value, 'menu', '${invitado.nombre}')">
											<option value="">Select an option</option>
											<option value="beef">Beef / Carne de Res</option>
											<option value="fish">Fish / Pescado</option>
											<option value="vegetarian">Vegetarian / Vegetariano</option>
									</select>
							</div>
					`;
						menuContainer.appendChild(guestResponse);
					});
				}
				break;

			case 4:
				if (formData.numEvents === 3) {
					stepElement.innerHTML = `
												<h2 class="heading--32 uppercase color--836923">COCKTAIL HOUR</h2>
												<p class="heading--24 uppercase color--4F4F4F">HORA DE CÓCTEL</p>
												<span class="space space--20"></span>
												<p class="heading--16 color--000" style="font-family: 'Poppins', serif; ">
														May 23th, 2025 / 23 de Mayo 2025 <br>
														El Mirador Gastro Bar, <br>
														Cartagena, Colombia <br>
														5:00 - 7:00 P.M.
												</p>
												<span class="space space--20"></span>
												<div class="guest-responses-container"></div>
												<div class="navigation-buttons">
														<button class="button button--secondary" onclick="prevStep(3)">Back</button>
														<span class="space space--10"></span>
														<button class="button button--secondary" onclick="nextStep(5)">Continue</button>
												</div>
										`;

					const cocktailContainer = stepElement.querySelector(
						".guest-responses-container"
					);
					formData.invitados.forEach((invitado) => {
						const guestResponse = document.createElement("div");
						guestResponse.className = "guest-response";
						guestResponse.innerHTML = `
														<p>${invitado.nombre}</p>
														<div>
																<button class="button button--small" onclick="updateGuestResponse(this, true, 'cocktail', '${invitado.nombre}')">Accept</button>
																<button class="button button--small" onclick="updateGuestResponse(this, false, 'cocktail', '${invitado.nombre}')">Decline</button>
														</div>
												`;
						cocktailContainer.appendChild(guestResponse);
					});
				}
				break;

			case 5:
				stepElement.innerHTML = `
							<h2 class="heading--32 uppercase color--836923">BEACH DAY MAKANI</h2>
							<p class="heading--24 uppercase color--4F4F4F">DÍA DE PLAYA MAKANI</p>
							<span class="space space--20"></span>
							<p class="heading--16 color--000" style="font-family: 'Poppins', serif; ">
									May 24th, 2025 / 24 de Mayo 2025 <br>
									Makani Beach Club<br>
									9:00 A.M.
							</p>
							<span class="space space--20"></span>
							<div class="guest-responses-container"></div>
							<div class="navigation-buttons">
									<button class="button button--secondary" onclick="prevStep(4)">Back</button>
									<span class="space space--10"></span>
									<button class="button button--secondary" onclick="nextStep(6)">Continue</button>
							</div>
					`;

				const beachContainer = stepElement.querySelector(
					".guest-responses-container"
				);
				formData.invitados.forEach((invitado) => {
					const guestResponse = document.createElement("div");
					guestResponse.className = "guest-response";
					guestResponse.innerHTML = `
									<p>${invitado.nombre}</p>
									<div>
											<button class="button button--small" onclick="updateGuestResponse(this, true, 'beach', '${invitado.nombre}')">Accept</button>
											<button class="button button--small" onclick="updateGuestResponse(this, false, 'beach', '${invitado.nombre}')">Decline</button>
									</div>
							`;
					beachContainer.appendChild(guestResponse);
				});
				break;

			case 6:
				showAdditionalInfo();
				break;

			case 6:
				showThanks();
				break;
		}
	};

	window.nextStep = function (step) {
		showStep(step);
	};

	window.prevStep = function (step) {
		showStep(step);
	};

	// =========================================
	// Funciones de búsqueda y selección
	// =========================================
	searchInput.addEventListener("keyup", function (e) {
		const search = e.target.value.toLowerCase();
		const filtered = invitados.filter(
			(inv) =>
				inv.nombre.toLowerCase().includes(search) ||
				inv.acompanantes.some((acomp) => acomp.toLowerCase().includes(search))
		);

		searchResults.innerHTML = filtered
			.map(
				(inv) => `
            <div class="rsvpModal__result" onclick='selectInvitado("${
							inv.nombre
						}", ${inv.eventos}, ${JSON.stringify(inv.acompanantes).replace(
					/'/g,
					"&apos;"
				)})'">
            ${inv.nombre}
            </div>
        `
			)
			.join("");
	});

	window.selectInvitado = function (nombre, eventos, acompanantes) {
		const acompanantesArray = Array.isArray(acompanantes) ? acompanantes : [];

		formData.invitados = []; // Resetear las respuestas
		formData.numEvents = eventos;

		// Inicializar el formData con el invitado principal
		formData.invitados.push({
			nombre: nombre,
			wedding: null,
			menu: null,
			cocktail: null,
			beach: null,
		});

		// Agregar acompañantes
		acompanantesArray.forEach((acompanante) => {
			formData.invitados.push({
				nombre: acompanante,
				wedding: null,
				menu: null,
				cocktail: null,
				beach: null,
			});
		});

		showStep(2);
	};

	// =========================================
	// Función para actualizar respuestas
	// =========================================
	window.updateGuestResponse = function (
    element,
    value,
    eventType,
    guestName
) {
    const container = element.parentElement;
    const buttons = container.querySelectorAll(".button--small");
    
    // Only add button selection logic if it's not a select element
    if (element.tagName.toLowerCase() !== 'select') {
        buttons.forEach((btn) => btn.classList.remove("selected"));
        element.classList.add("selected");
    }

    const guestIndex = formData.invitados.findIndex(
        (g) => g.nombre === guestName
    );
    if (guestIndex !== -1) {
        formData.invitados[guestIndex][eventType] = value;
    }
};

	// =========================================
	// Funciones de envío
	// =========================================
	window.submitRSVP = function () {
		const submitButton = document.querySelector(
			'button[onclick="submitRSVP()"]'
		);
		const originalText = submitButton.innerHTML;
		let dots = "";
		let loadingInterval;

		function updateLoadingText() {
			dots = dots.length >= 3 ? "" : dots + ".";
			submitButton.innerHTML = `Sending${dots}`;
		}

		function startLoading() {
			submitButton.disabled = true;
			loadingInterval = setInterval(updateLoadingText, 500);
			window.appState.rsvp.isLoading = true;
		}

		function stopLoading() {
			clearInterval(loadingInterval);
			submitButton.disabled = false;
			submitButton.innerHTML = originalText;
			window.appState.rsvp.isLoading = false;
		}

		formData.phone = document.getElementById("phone").value;
		formData.email = document.getElementById("email").value;
		formData.play = document.getElementById("play").value;
		formData.restrictions = document.getElementById("restrictions").value;

		if (!formData.email || !formData.phone) {
			alert("Por favor completa todos los campos requeridos");
			return;
		}

		const submitData = () => {
			startLoading();

			const formDataToSend = new FormData();
			formDataToSend.append("action", "send_rsvp_email");
			formDataToSend.append("rsvp_data", JSON.stringify(formData));
			formDataToSend.append("nonce", wpData.nonce);

			fetch(wpData.ajaxurl, {
				method: "POST",
				body: formDataToSend,
			})
				.then((response) => response.json())
				.then((data) => {
					stopLoading();
					if (data.success) {
						showStep(7);
					} else {
						throw new Error(data.data || "Error al enviar el formulario");
					}
				})
				.catch((error) => {
					stopLoading();
					console.error("Error:", error);
				});
		};

		if (wpData.isLocal) {
			submitData();
		} else {
			grecaptcha.ready(function () {
				startLoading();
				grecaptcha
					.execute("6Lf-UdIqAAAAAMUnAwZ3LO0lInGTx667TNOqGkEA", {
						action: "rsvp",
					})
					.then(function (token) {
						const formDataToSend = new FormData();
						formDataToSend.append("action", "send_rsvp_email");
						formDataToSend.append("rsvp_data", JSON.stringify(formData));
						formDataToSend.append("recaptcha_response", token);
						formDataToSend.append("nonce", wpData.nonce);

						return fetch(wpData.ajaxurl, {
							method: "POST",
							body: formDataToSend,
						});
					})
					.then((response) => response.json())
					.then((data) => {
						stopLoading();
						if (data.success) {
							showStep(7);
						} else {
							throw new Error(data.data || "Error en la verificación");
						}
					})
					.catch((error) => {
						stopLoading();
						console.error("Error:", error);
					});
			});
		}
	};

	// =========================================
	// Event Listeners iniciales
	// =========================================
	document.getElementById("openRSVP").addEventListener(eventType, function () {
		modal.classList.add("rsvpModal__show");
		updateProgress(1);
	});

	const closeBtn = document.querySelector(".rsvpModal__close");
	closeBtn.addEventListener(eventType, function () {
		modal.classList.remove("rsvpModal__show");
		setTimeout(resetForm, 300);
	});

	window.addEventListener(eventType, function (e) {
		if (e.target === modal) {
			modal.classList.remove("rsvpModal__show");
			setTimeout(resetForm, 300);
		}
	});

	// =========================================
	// Estilos
	// =========================================
	const style = document.createElement("style");
	style.textContent = `
			.guest-responses-container {
					margin: 20px 0;
			}

			.guest-response {
					padding: 10px;
					border-radius: 4px;
			}

			.guest-response p {
					margin-bottom: 8px;
			}

			.button--small.selected {
					background-color: #836923 !important;
					color: white !important;
					transform: scale(0.98);
					transition: transform 0.1s ease;
			}

			.button--small {
					-webkit-touch-callout: none;
					-webkit-user-select: none;
					user-select: none;
					cursor: pointer;
					transition: transform 0.1s ease;
			}

			.button--small:active {
					transform: scale(0.95);
			}

			.navigation-buttons {
					display: flex;
					gap: 10px;
					justify-content: center;
			}
	`;
	document.head.appendChild(style);

	// Inicialización
	updateProgress(1);
});

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Agendar hora - Sans Inc</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            background: #e5e5e5;
            color: #111827;
            font-family: 'Segoe UI', system-ui, sans-serif;
        }

        .agenda-page {
            display: flex;
            justify-content: center;
            padding: 2.5rem 1rem;
        }

        .agenda-card {
            width: min(100%, 640px);
            background: #ffffff;
            border-radius: 9px;
            padding: 2rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.18);
        }

        .agenda-title {
            margin: 0 0 0.45rem;
            font-size: 1.9rem;
            line-height: 1.15;
            font-weight: 800;
            color: #0f1b33;
            letter-spacing: 0;
        }

        .agenda-subtitle {
            margin: 0 0 2rem;
            color: #24324d;
            font-size: 1rem;
        }

        .agenda-field {
            margin-bottom: 1.45rem;
        }

        .agenda-label {
            display: flex;
            align-items: center;
            gap: 0.55rem;
            color: #0f1b33;
            font-size: 0.88rem;
            font-weight: 700;
            margin-bottom: 0.6rem;
        }

        .agenda-label svg {
            width: 17px;
            height: 17px;
            color: #1f2937;
        }

        .agenda-input,
        .agenda-select-button {
            width: 100%;
            height: 50px;
            border: 1px solid #cfd5df;
            border-radius: 9px;
            background: #ffffff;
            color: #111827;
            padding: 0 1rem;
            font-size: 1rem;
            outline: none;
        }

        .agenda-input:focus,
        .agenda-select-button:focus {
            border-color: #1a2332;
            box-shadow: 0 0 0 3px rgba(26, 35, 50, 0.12);
        }

        .agenda-input::placeholder {
            color: #7f8794;
        }

        .agenda-date-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }

        .agenda-date-item {
            position: relative;
        }

        .agenda-date-item > span {
            display: block;
            color: #0f1b33;
            font-size: 0.82rem;
            margin-bottom: 0.35rem;
        }

        .agenda-select-button {
            display: flex;
            align-items: center;
            justify-content: space-between;
            cursor: pointer;
            text-align: left;
        }

        .agenda-dropdown {
            position: absolute;
            top: calc(100% + 0.45rem);
            left: 0;
            z-index: 80;
            display: none;
            width: 275px;
            background: #ffffff;
            border-radius: 14px;
            padding: 0.9rem;
            box-shadow: 0 12px 28px rgba(0, 0, 0, 0.18);
        }

        .agenda-dropdown.is-open {
            display: block;
        }

        .calendar-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: #1a2332;
            color: #ffffff;
            border-radius: 10px;
            padding: 0.65rem 0.7rem;
            font-weight: 700;
            margin-bottom: 0.75rem;
        }

        .calendar-nav {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 28px;
            height: 28px;
            border: 0;
            border-radius: 7px;
            background: transparent;
            color: #ffffff;
            cursor: pointer;
        }

        .calendar-week,
        .calendar-grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            text-align: center;
        }

        .calendar-week {
            color: #1a2332;
            font-size: 0.8rem;
            margin-bottom: 0.35rem;
            font-weight: 700;
        }

        .calendar-day {
            width: 34px;
            height: 28px;
            margin: 0.1rem auto;
            border: 0;
            border-radius: 999px;
            background: transparent;
            color: #111827;
            cursor: pointer;
            font-size: 0.9rem;
        }

        .calendar-day:hover,
        .calendar-day.is-selected {
            background: #e8edf6;
            color: #1a2332;
            font-weight: 700;
        }

        .calendar-day.is-disabled {
            color: #c8c8c8;
            cursor: not-allowed;
            background: transparent;
            font-weight: 400;
        }

        .time-list {
            display: grid;
            gap: 0.45rem;
            max-height: 260px;
            overflow: auto;
        }

        .time-option {
            width: 100%;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            background: #ffffff;
            padding: 0.7rem 0.85rem;
            color: #111827;
            text-align: left;
            cursor: pointer;
            font-size: 0.95rem;
        }

        .time-option:hover,
        .time-option.is-selected {
            background: #1a2332;
            color: #ffffff;
            border-color: #1a2332;
        }

        .time-empty {
            margin: 0;
            color: #6b7280;
            font-size: 0.9rem;
            line-height: 1.35;
        }

        .agenda-message {
            display: none;
            border-radius: 8px;
            padding: 0.8rem 0.9rem;
            margin-bottom: 1rem;
            font-size: 0.9rem;
        }

        .agenda-message.is-error {
            display: block;
            background: #fef2f2;
            border: 1px solid #fecaca;
            color: #991b1b;
        }

        .agenda-message.is-success {
            display: block;
            background: #ecfdf3;
            border: 1px solid #bbf7d0;
            color: #166534;
        }

        .agenda-submit {
            width: 100%;
            height: 49px;
            border: 0;
            border-radius: 8px;
            background: #1a2332;
            color: #ffffff;
            font-size: 1rem;
            font-weight: 750;
            cursor: pointer;
        }

        .agenda-submit:hover {
            background: #2a3442;
        }

        .agenda-submit:disabled {
            cursor: wait;
            opacity: 0.75;
        }

        @media (max-width: 640px) {
            .agenda-card {
                padding: 1.5rem 1rem;
            }

            .agenda-title {
                font-size: 1.55rem;
            }

            .agenda-date-grid {
                grid-template-columns: 1fr;
            }

            .agenda-dropdown {
                width: 100%;
            }
        }
    </style>
</head>
<body>

<x-navbar />

<x-login-panel>
    <form data-login-form>
        <div class="panel-message" data-login-message></div>
        <input type="email" name="email" class="panel-input" placeholder="Correo electrónico" required />
        <input type="password" name="password" class="panel-input" placeholder="Contraseña" required />

        <button type="submit" class="btn-login" data-login-submit>Iniciar Sesión</button>
        <a href="/register" class="btn-register">Registrarse</a>
        <a href="/recuperar" class="panel-recover">Recuperar contraseña</a>
    </form>
</x-login-panel>

<main class="agenda-page">
    <section class="agenda-card" aria-labelledby="agenda-title">
        <h1 class="agenda-title" id="agenda-title">Agendar Hora de Atención</h1>
        <p class="agenda-subtitle">Complete el formulario para solicitar una cita</p>

        <form id="agendaForm">
            <div id="agendaMessage" class="agenda-message"></div>

            <div class="agenda-field">
                <label class="agenda-label" for="reason">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 7h8M8 11h8M8 15h5M6 3h12a2 2 0 0 1 2 2v14l-4-2-4 2-4-2-4 2V5a2 2 0 0 1 2-2Z" />
                    </svg>
                    Motivo de la Cita
                </label>
                <input class="agenda-input" id="reason" name="reason" type="text" maxlength="500" placeholder="Ingrese el motivo de la cita" required>
            </div>

            <div class="agenda-field">
                <label class="agenda-label" for="phone">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M22 16.92v3a2 2 0 0 1-2.18 2 19.8 19.8 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6A19.8 19.8 0 0 1 2.12 4.18 2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.12.9.32 1.77.57 2.61a2 2 0 0 1-.45 2.11L8 9.67a16 16 0 0 0 6.33 6.33l1.23-1.23a2 2 0 0 1 2.11-.45c.84.25 1.71.45 2.61.57A2 2 0 0 1 22 16.92Z" />
                    </svg>
                    Teléfono
                </label>
                <input class="agenda-input" id="phone" name="phone" type="tel" maxlength="20" placeholder="Ingrese su teléfono" required>
            </div>

            <div class="agenda-field">
                <div class="agenda-label">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <rect x="3" y="4" width="18" height="18" rx="2" stroke-width="1.8" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16 2v4M8 2v4M3 10h18" />
                    </svg>
                    Fecha de la Cita
                </div>

                <div class="agenda-date-grid">
                    <div class="agenda-date-item">
                        <span>Día</span>
                        <button type="button" class="agenda-select-button" id="dayButton">
                            <span id="dayText">Día</span>
                            <span>⌄</span>
                        </button>
                        <div class="agenda-dropdown" id="calendarDropdown">
                            <div class="calendar-head">
                                <button type="button" class="calendar-nav" id="prevMonth" aria-label="Mes anterior">‹</button>
                                <span id="calendarTitle"></span>
                                <button type="button" class="calendar-nav" id="nextMonth" aria-label="Mes siguiente">›</button>
                            </div>
                            <div class="calendar-week">
                                <span>L</span><span>M</span><span>M</span><span>J</span><span>V</span><span>S</span><span>D</span>
                            </div>
                            <div class="calendar-grid" id="calendarGrid"></div>
                        </div>
                    </div>

                    <div class="agenda-date-item">
                        <span>Hora</span>
                        <button type="button" class="agenda-select-button" id="timeButton">
                            <span id="timeText">Hora</span>
                            <span>⌄</span>
                        </button>
                        <div class="agenda-dropdown" id="timeDropdown">
                            <div class="time-list" id="timeList"></div>
                        </div>
                    </div>
                </div>
            </div>

            <button type="submit" class="agenda-submit" id="agendaSubmit">Enviar Solicitud</button>
        </form>
    </section>
</main>

<script>
    const agendaForm = document.getElementById('agendaForm');
    const agendaMessage = document.getElementById('agendaMessage');
    const agendaSubmit = document.getElementById('agendaSubmit');
    const dayButton = document.getElementById('dayButton');
    const dayText = document.getElementById('dayText');
    const timeButton = document.getElementById('timeButton');
    const timeText = document.getElementById('timeText');
    const calendarDropdown = document.getElementById('calendarDropdown');
    const timeDropdown = document.getElementById('timeDropdown');
    const calendarTitle = document.getElementById('calendarTitle');
    const calendarGrid = document.getElementById('calendarGrid');
    const timeList = document.getElementById('timeList');
    const monthNames = ['ENE', 'FEB', 'MAR', 'ABR', 'MAY', 'JUN', 'JUL', 'AGO', 'SEP', 'OCT', 'NOV', 'DIC'];
    const availableHours = ['10:00', '11:00', '12:00', '13:00', '14:00', '15:00', '16:00', '17:00', '18:00'];
    let calendarDate = new Date();
    let selectedDate = null;
    let selectedTime = '';
    let bookedTimes = new Set();

    function showAgendaMessage(type, text) {
        agendaMessage.className = 'agenda-message is-' + type;
        agendaMessage.textContent = text;
    }

    function pad(value) {
        return String(value).padStart(2, '0');
    }

    function formatDisplayDate(date) {
        return `${pad(date.getDate())}-${pad(date.getMonth() + 1)}-${date.getFullYear()}`;
    }

    function formatApiDate(date, time) {
        return `${date.getFullYear()}-${pad(date.getMonth() + 1)}-${pad(date.getDate())} ${time}:00`;
    }

    function isPastDay(date) {
        const today = new Date();
        today.setHours(0, 0, 0, 0);
        const candidate = new Date(date);
        candidate.setHours(0, 0, 0, 0);
        return candidate < today;
    }

    function renderCalendar() {
        const year = calendarDate.getFullYear();
        const month = calendarDate.getMonth();
        const firstDay = new Date(year, month, 1);
        const lastDay = new Date(year, month + 1, 0);
        const startOffset = (firstDay.getDay() + 6) % 7;
        calendarTitle.textContent = `${monthNames[month]} ${year}`;
        calendarGrid.innerHTML = '';

        for (let i = 0; i < startOffset; i++) {
            calendarGrid.appendChild(document.createElement('span'));
        }

        for (let day = 1; day <= lastDay.getDate(); day++) {
            const date = new Date(year, month, day);
            const button = document.createElement('button');
            button.type = 'button';
            button.className = 'calendar-day';
            button.textContent = day;

            if (isPastDay(date)) {
                button.classList.add('is-disabled');
                button.disabled = true;
            }

            if (selectedDate && formatDisplayDate(selectedDate) === formatDisplayDate(date)) {
                button.classList.add('is-selected');
            }

            button.addEventListener('click', function () {
                selectedDate = date;
                selectedTime = '';
                dayText.textContent = formatDisplayDate(date);
                timeText.textContent = 'Hora';
                calendarDropdown.classList.remove('is-open');
                renderCalendar();
                loadBookedTimes();
            });

            calendarGrid.appendChild(button);
        }
    }

    async function loadBookedTimes() {
        bookedTimes = new Set();

        if (!selectedDate) {
            renderTimes();
            return;
        }

        const token = localStorage.getItem('jwtToken');

        if (!token) {
            renderTimes();
            return;
        }

        try {
            const response = await fetch('/api/agenda', {
                headers: {
                    'Accept': 'application/json',
                    'Authorization': 'Bearer ' + token,
                },
            });

            if (!response.ok) {
                renderTimes();
                return;
            }

            const agendas = await response.json();
            const selected = formatDisplayDate(selectedDate);

            agendas.forEach(function (agenda) {
                const date = new Date(agenda.scheduled_date);

                if (formatDisplayDate(date) === selected) {
                    bookedTimes.add(`${pad(date.getHours())}:${pad(date.getMinutes())}`);
                }
            });
        } catch (error) {
            bookedTimes = new Set();
        }

        renderTimes();
    }

    function renderTimes() {
        timeList.innerHTML = '';

        if (!selectedDate) {
            const empty = document.createElement('p');
            empty.className = 'time-empty';
            empty.textContent = 'Selecciona primero un día.';
            timeList.appendChild(empty);
            return;
        }

        const freeHours = availableHours.filter(function (hour) {
            return !bookedTimes.has(hour);
        });

        if (freeHours.length === 0) {
            const empty = document.createElement('p');
            empty.className = 'time-empty';
            empty.textContent = 'No hay horas disponibles para este día. Debe quedar en horas hábiles laborales de 10 a 18 horas.';
            timeList.appendChild(empty);
            return;
        }

        freeHours.forEach(function (hour) {
            const button = document.createElement('button');
            button.type = 'button';
            button.className = 'time-option';
            button.textContent = hour;

            if (selectedTime === hour) {
                button.classList.add('is-selected');
            }

            button.addEventListener('click', function () {
                selectedTime = hour;
                timeText.textContent = hour;
                timeDropdown.classList.remove('is-open');
                renderTimes();
            });

            timeList.appendChild(button);
        });
    }

    dayButton.addEventListener('click', function () {
        calendarDropdown.classList.toggle('is-open');
        timeDropdown.classList.remove('is-open');
    });

    timeButton.addEventListener('click', function () {
        timeDropdown.classList.toggle('is-open');
        calendarDropdown.classList.remove('is-open');
        renderTimes();
    });

    document.getElementById('prevMonth').addEventListener('click', function () {
        calendarDate = new Date(calendarDate.getFullYear(), calendarDate.getMonth() - 1, 1);
        renderCalendar();
    });

    document.getElementById('nextMonth').addEventListener('click', function () {
        calendarDate = new Date(calendarDate.getFullYear(), calendarDate.getMonth() + 1, 1);
        renderCalendar();
    });

    document.addEventListener('click', function (event) {
        if (!event.target.closest('.agenda-date-item')) {
            calendarDropdown.classList.remove('is-open');
            timeDropdown.classList.remove('is-open');
        }
    });

    agendaForm.addEventListener('submit', async function (event) {
        event.preventDefault();

        const token = localStorage.getItem('jwtToken');

        if (!token) {
            abrirPanel();
            showAgendaMessage('error', 'Debes iniciar sesión para agendar una hora.');
            return;
        }

        if (!selectedDate || !selectedTime) {
            showAgendaMessage('error', 'Selecciona un día y una hora disponible.');
            return;
        }

        agendaSubmit.disabled = true;
        agendaSubmit.textContent = 'Enviando...';

        try {
            const response = await fetch('/api/agenda', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'Authorization': 'Bearer ' + token,
                },
                body: JSON.stringify({
                    reason: document.getElementById('reason').value,
                    phone: document.getElementById('phone').value,
                    scheduled_date: formatApiDate(selectedDate, selectedTime),
                }),
            });
            const data = await response.json();

            if (response.ok) {
                agendaForm.reset();
                selectedDate = null;
                selectedTime = '';
                dayText.textContent = 'Día';
                timeText.textContent = 'Hora';
                bookedTimes = new Set();
                renderCalendar();
                renderTimes();
                showAgendaMessage('success', 'Solicitud enviada correctamente.');
                return;
            }

            if (data.errors) {
                showAgendaMessage('error', Object.values(data.errors).flat()[0] || 'No se pudo agendar la hora.');
                return;
            }

            showAgendaMessage('error', data.message || 'No se pudo agendar la hora.');
        } catch (error) {
            showAgendaMessage('error', 'No se pudo conectar con el servidor.');
        } finally {
            agendaSubmit.disabled = false;
            agendaSubmit.textContent = 'Enviar Solicitud';
        }
    });

    renderCalendar();
    renderTimes();
</script>

</body>
</html>

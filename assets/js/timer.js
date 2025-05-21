// Duración del temporizador (en segundos)
let duration = 120; // 2 minutos para la demo
let display = document.getElementById('timer');

function startTimer() {
    let timer = duration, minutes, seconds;
    let interval = setInterval(function () {
        minutes = parseInt(timer / 60, 10);
        seconds = parseInt(timer % 60, 10);

        minutes = minutes < 10 ? "0" + minutes : minutes;
        seconds = seconds < 10 ? "0" + seconds : seconds;

        display.textContent = minutes + ":" + seconds;

        if (--timer < 0) {
            clearInterval(interval);
            // Puedes deshabilitar el formulario o autoenviarlo aquí
            display.textContent = "¡Tiempo!";
            document.querySelector('form').submit(); // Comenta esto si aún no hay backend
        }
    }, 1000);
}

window.onload = function () {
    if (display) startTimer();
};

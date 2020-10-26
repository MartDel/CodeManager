var settings = {
    id: 'settings',
    modal: document.getElementById("bcc_settings"),
    show_btn: document.getElementById("gear_logo_img"),
    close_btn: document.getElementById("close_settings"),
    dark_mode_btn: document.getElementById("dark_mode"),
    night_shift_btn: document.getElementById("night_shift"),
    bug_input: document.getElementById("textarea_bug"),
};

window.onload = () => {
    closeMenu()

    // Turn ON/OFF dark mode
    if (getCookie('dark-mode') === 'on') {
        turnOnDarkMode()
        settings.dark_mode_btn.checked = true
    } else {
        turnOffDarkMode()
        settings.dark_mode_btn.checked = false
    }

    // Turn ON/OFF night shift
    if (getCookie('night-shift') === 'on') {
        turnOnNightShift()
        settings.night_shift_btn.checked = true
    } else {
        turnOffNightShift()
        settings.night_shift_btn.checked = false
    }

    // Print modal div
    document.querySelector('#modals').style.display = 'block'
};



function turnOnDarkMode() {
    body.style.filter = "invert(100%) hue-rotate(200deg)";
    account_logo.style.filter = "invert(100%) hue-rotate(-200deg)";
    settings.night_shift_btn.checked = false;

    // Set dark-mode cookie
    setCookie('dark-mode', 'on')
}
function turnOffDarkMode() {
    body.style.filter = "invert(0%) hue-rotate(0deg)";
    account_logo.style.filter = "invert(0%) hue-rotate(0deg)";

    // Set dark-mode cookie
    setCookie('dark-mode', 'off')
}

// Night shift
settings.night_shift_btn.onchange = () => {
    if (settings.night_shift_btn.checked) turnOnNightShift()
    else turnOffNightShift()
};
function turnOnNightShift() {
    body.style.filter = "sepia(70%)";
    account_logo.style.filter = "invert(0%) hue-rotate(0deg)";
    settings.dark_mode_btn.checked = false;

    // Set dark-mode cookie
    setCookie('night-shift', 'on')
}
function turnOffNightShift(){
    body.style.filter = "sepia(0%)";
    account_logo.style.filter = "invert(0%) hue-rotate(0deg)";

    // Set dark-mode cookie
    setCookie('night-shift', 'off')
}

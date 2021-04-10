toggleDarkMode = () => {
    if ((document.getElementById('darkmode').value = !document.getElementById('darkmode').value) === true) {
        enableDarkMode();
        localStorage.setItem("darkmode", "true");
    } else {
        disableDarkMode();
        localStorage.setItem("darkmode", "false");
    }
}

loadDarkMode = () => {
    if (localStorage.getItem("darkmode") === "true") {
        document.getElementById('darkmode').value = true;
        enableDarkMode();
    } else {
        document.getElementById('darkmode').value = false;
        disableDarkMode();
    }
}

enableDarkMode = () => {
    document.querySelectorAll(".bg-white").forEach((it) => {
        it.classList.remove('bg-white');
        it.classList.add('bg-dark');
        it.classList.add('text-white-75');
    });
    document.querySelectorAll(".text-primary").forEach((it) => {
        it.classList.remove('text-primary');
        it.classList.add('text-light');
    });
    document.querySelectorAll(".text-dark").forEach((it) => {
        it.classList.remove('text-dark');
        it.classList.add('text-white-75');
    });
}

disableDarkMode = () => {
    document.querySelectorAll(".bg-dark").forEach((it) => {
        it.classList.remove('bg-dark');
        it.classList.add('bg-white');
    });
    document.querySelectorAll(".text-light").forEach((it) => {
        it.classList.remove('text-light');
        it.classList.add('text-primary');
    });
    document.querySelectorAll(".text-white-75").forEach((it) => {
        it.classList.remove('text-white-75');
        it.classList.add('text-dark');
    });
}

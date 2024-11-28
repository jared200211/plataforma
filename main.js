let listElements = document.querySelectorAll('.list_button--click');

listElements.forEach(listElement => {
    listElement.addEventListener('click', () => {
        // Cierra todas las demás secciones
        listElements.forEach(otherElement => {
            if (otherElement !== listElement) {
                otherElement.classList.remove('arrow');
                let otherMenu = otherElement.nextElementSibling;
                if (otherMenu) {
                    otherMenu.style.height = "0";
                }
            }
        });

        // Alterna la sección seleccionada
        listElement.classList.toggle('arrow');
        let height = 0;
        let menu = listElement.nextElementSibling;

        if (menu.clientHeight == "0") {
            height = menu.scrollHeight;
        }
        menu.style.height = `${height}px`;
    });
});

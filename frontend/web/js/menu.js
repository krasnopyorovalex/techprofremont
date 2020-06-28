document.addEventListener("DOMContentLoaded", function () {

    const mainMenu = document.querySelector('.menu_head');

    if (mainMenu) {
        const downIcons = mainMenu.querySelectorAll('.icon-down');
        const downIconsLength = downIcons.length;

        for (let i = 0; i < downIconsLength; i++) {
            downIcons[i].addEventListener("click", function (event) {
                console.log('ujhkjhj')
                return event.currentTarget.closest('li').classList.toggle('is-open');
            });
        }

        const burger = document.querySelector('.mob-menu');
        const btnClose = document.querySelector('.mob-menu-close');
        if (burger) {
            burger.addEventListener('click', function () {
                btnClose.classList.add('is-open');
                return mainMenu.classList.add('is-open');
            });
            btnClose.addEventListener('click', function (event) {
                event.currentTarget.classList.remove('is-open');
                return mainMenu.classList.remove('is-open');
            });
        }
    }
});
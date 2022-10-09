//variables for dropdown nav
const navDropdown = document.getElementById('nav-dropdown');

//DROPDOWN
function showDropdown(target) {
    let targetElement = document.querySelector(`${target} + .dropdown`);
    targetElement.classList.toggle('show');
};

//DROPDOWN NAVIGATION
    navDropdown.addEventListener('click', function() {
        showDropdown( '#nav-dropdown' );
    });

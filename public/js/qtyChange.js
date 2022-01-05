const selectElements = document.querySelectorAll('.qtySelect');
for (let i = 0; i < selectElements.length; i++) {
    selectElements[i].addEventListener('change', (event) => {
        document.getElementById(`item${selectElements[i].id}`).submit();
    });
};
const editBtn = document.querySelectorAll('.edit');
const addBtn = document.querySelectorAll('.add');

const modalContainer = document.getElementById('main-modal');
const modalEdit = document.getElementById('modal-edit');
const modalAdd = document.getElementById('modal-add');
const closeBtns = document.querySelectorAll('.btn-cancel');

editBtn.forEach(btn =>{
    btn.addEventListener('click', () => {
        modalContainer.classList.add('active');
        modalEdit.classList.add('active-modal');
        modalAdd.classList.remove('active-modal');

        // Populate Edit Modal Data
        document.getElementById('edit-id').value = btn.getAttribute('data-id');
        document.getElementById('edit-fname').value = btn.getAttribute('data-fname');
        document.getElementById('edit-lname').value = btn.getAttribute('data-lname');
        document.getElementById('edit-gender').value = btn.getAttribute('data-gender');
        document.getElementById('edit-voter').value = btn.getAttribute('data-voter');
    });
});

addBtn.forEach(btn =>{
    btn.addEventListener('click', () => {
        modalContainer.classList.add('active'); 
        modalAdd.classList.add('active-modal');
        modalEdit.classList.remove('active-modal');
    });
});

closeBtns.forEach(btn => {
    btn.addEventListener('click', () => {
        modalContainer.classList.remove('active');
        modalEdit.classList.remove('active-modal');
        modalAdd.classList.remove('active-modal');
    });
});
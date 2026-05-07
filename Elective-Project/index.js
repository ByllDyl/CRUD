
function navigate(pageId, element) {
    const navItems = document.querySelectorAll('.nav-item');
    navItems.forEach(item => item.classList.remove('active'));

    if (element) {
        element.classList.add('active');
    } else {
        const targetNav = Array.from(navItems).find(item => item.getAttribute('onclick').includes(pageId));
        if (targetNav) targetNav.classList.add('active');
    }

    // 3. Hide all page contents
    const pages = document.querySelectorAll('.page-content');
    pages.forEach(page => page.classList.remove('active'));

    // 4. Show the target page
    const targetPage = document.getElementById('page-' + pageId);
    if (targetPage) {
        targetPage.classList.add('active');
    }

    // 5. Update topbar title based on the active nav item
    const topbarTitle = document.getElementById('topbarTitle');
    const activeItem = document.querySelector('.nav-item.active');
    if (topbarTitle && activeItem) {
        let titleText = "";
        activeItem.childNodes.forEach(node => {
            if (node.nodeType === Node.TEXT_NODE) {
                titleText += node.textContent;
            }
        });
        topbarTitle.innerText = titleText.trim();
    }

    // Close sidebar on mobile after navigation
    closeSidebar();
}

// --- MOBILE SIDEBAR TOGGLE ---
function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebarOverlay');
    if (sidebar && overlay) {
        sidebar.classList.toggle('open');
        overlay.classList.toggle('active');
    }
}

function closeSidebar() {
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebarOverlay');
    if (sidebar && overlay) {
        sidebar.classList.remove('open');
        overlay.classList.remove('active');
    }
}

// --- MODAL FUNCTIONS ---
function openModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.classList.add('open');
    }
}

function closeModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.classList.remove('open');
    }
}

// Close modal when clicking outside the modal content
window.addEventListener('click', function(event) {
    if (event.target.classList.contains('modal-overlay')) {
        event.target.classList.remove('open');
    }
});

// --- TOPBAR DATE ---
function updateDate() {
    const dateElement = document.getElementById('topbarDate');
    if (dateElement) {
        const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
        dateElement.innerText = new Date().toLocaleDateString('en-US', options);
    }
}
updateDate();

// --- STUBS FOR INLINE FORM FUNCTIONS ---
// These ensure there are no errors when you click the save/filter buttons

function handleGlobalSearch(val) { 
    console.log('Searching globally for:', val); 
}

function renderResidents() { 
    console.log('Rendering residents...'); 
}

function filterCerts(type, btn) { 
    const tabs = document.querySelectorAll('.pill-tab');
    tabs.forEach(t => t.classList.remove('active'));
    if (btn) btn.classList.add('active');
    console.log('Filtering certificates by:', type);
}

function saveResident() { 
    closeModal('modalResident'); 
    alert('Resident registered successfully!'); 
}

function saveHousehold() { 
    closeModal('modalHousehold'); 
    alert('Household registered successfully!'); 
}

function updateCertPreview() { 
    const nameInput = document.getElementById('cResident');
    const purposeInput = document.getElementById('cPurpose');
    
    if (nameInput) document.getElementById('certName').innerText = nameInput.value || '___________';
    if (purposeInput) document.getElementById('certPurpose').innerText = purposeInput.value || '___________';
}

function saveCert() { 
    closeModal('modalCert'); 
    alert('Certificate issued successfully!'); 
}

function saveBlotter() { 
    closeModal('modalBlotter'); 
    alert('Blotter report filed successfully!'); 
}

function saveAnnouncement() { 
    closeModal('modalAnnounce'); 
    alert('Announcement posted successfully!'); 
}

function saveOfficial() { 
    closeModal('modalOfficial'); 
    alert('Barangay official added successfully!'); 
}

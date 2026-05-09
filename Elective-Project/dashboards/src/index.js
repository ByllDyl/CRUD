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

window.addEventListener('click', function(event) {
    if (event.target.classList.contains('modal-overlay')) {
        event.target.classList.remove('open');
    }
});

function updateDate() {
    const dateElement = document.getElementById('topbarDate');
    if (dateElement) {
        const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
        dateElement.innerText = new Date().toLocaleDateString('en-US', options);
    }
}
updateDate();


function filterResidentsTable() {
    const table = document.getElementById('residentTable');
    if (!table) return;

    const purokSelect = document.getElementById('residentPurok');
    const genderSelect = document.getElementById('residentGender');
    const statusSelect = document.getElementById('residentStatus');
    const globalSearchInput = document.getElementById('globalSearch');
    const residentSearchInput = document.getElementById('residentSearch');

    const purokFilter = purokSelect ? purokSelect.value.toLowerCase() : '';
    const genderFilter = genderSelect ? genderSelect.value.toLowerCase() : '';
    const statusFilter = statusSelect ? statusSelect.value.toLowerCase() : '';
    const globalSearch = globalSearchInput ? globalSearchInput.value.toLowerCase() : '';
    const residentSearch = residentSearchInput ? residentSearchInput.value.toLowerCase() : '';
    const searchFilter = residentSearch || globalSearch;

    const rows = table.getElementsByTagName('tr');
    for (let i = 0; i < rows.length; i++) {
        const row = rows[i];
        if (row.cells.length < 5) continue; 

        const name = row.cells[1].innerText.toLowerCase();
        const gender = row.cells[3].innerText.toLowerCase();
        const purok = row.cells[4].innerText.toLowerCase();
        const voterStatus = row.cells[6] ? row.cells[6].innerText.toLowerCase() : '';

        let matchesPurok = purokFilter === '' || purok.includes(purokFilter);
        let matchesGender = genderFilter === '' || gender === genderFilter;
        let matchesStatus = statusFilter === '' || voterStatus === statusFilter;
        let matchesSearch = searchFilter === '' || name.includes(searchFilter);

        if (matchesPurok && matchesGender && matchesStatus && matchesSearch) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    }
}

function handleGlobalSearch(val) { 
    filterResidentsTable();
}

function renderResidents() { 
    filterResidentsTable();
}

function filterCerts(type, btn) { 
    const tabs = document.querySelectorAll('.pill-tab');
    tabs.forEach(t => t.classList.remove('active'));
    if (btn) btn.classList.add('active');
    console.log('Filtering certificates by:', type);
}

function viewResident(btn) {
    const name = btn.getAttribute('data-name') || 'N/A';
    const dob = btn.getAttribute('data-dob') || 'N/A';
    const age = btn.getAttribute('data-age') || 'N/A';
    const gender = btn.getAttribute('data-gender') || 'N/A';
    const civil = btn.getAttribute('data-civil') || 'N/A';
    const purok = btn.getAttribute('data-purok') || 'N/A';
    const contact = btn.getAttribute('data-contact') || 'N/A';
    const address = btn.getAttribute('data-address') || 'N/A';
    const occupation = btn.getAttribute('data-occupation') || 'N/A';
    const voter = btn.getAttribute('data-voter') || 'No';
    const added = btn.getAttribute('data-added') || 'N/A';

    const nameParts = name.trim().split(' ').filter(n => n.length > 0);
    let initials = 'NA';
    if (nameParts.length >= 2) {
        initials = (nameParts[0][0] + nameParts[nameParts.length - 1][0]).toUpperCase();
    } else if (nameParts.length === 1) {
        initials = nameParts[0].substring(0, 2).toUpperCase();
    }

    const badgeColor = voter === 'Yes' ? 'blue' : 'gray';
    const voterText = voter === 'Yes' ? 'Registered Voter' : 'Unregistered';

    const body = document.getElementById('viewResidentBody');
    body.innerHTML = `
        <div style="display:flex;gap:20px;align-items:center;margin-bottom:20px;">
            <div style="width:60px;height:60px;border-radius:50%;background:var(--navy);color:var(--white);display:flex;align-items:center;justify-content:center;font-size:22px;font-weight:700;flex-shrink:0;">${initials}</div>
            <div>
                <div style="font-size:18px;font-weight:700;">${name}</div>
                <div style="font-size:13px;color:var(--gray-400);">${purok} &bull; ${age} yrs old</div>
                <span class="badge badge-${badgeColor}" style="margin-top:4px;">${voterText}</span>
            </div>
        </div>
        <table style="width:100%;font-size:13.5px;">
            <tr><td style="color:var(--gray-400);padding:6px 0;width:140px;">Date of Birth</td><td>${dob}</td></tr>
            <tr><td style="color:var(--gray-400);padding:6px 0;">Gender</td><td>${gender}</td></tr>
            <tr><td style="color:var(--gray-400);padding:6px 0;">Civil Status</td><td>${civil}</td></tr>
            <tr><td style="color:var(--gray-400);padding:6px 0;">Occupation</td><td>${occupation}</td></tr>
            <tr><td style="color:var(--gray-400);padding:6px 0;">Complete Address</td><td>${address}</td></tr>
            <tr><td style="color:var(--gray-400);padding:6px 0;">Contact</td><td>${contact}</td></tr>
            <tr><td style="color:var(--gray-400);padding:6px 0;">Registered Voter</td><td>${voter}</td></tr>
            <tr><td style="color:var(--gray-400);padding:6px 0;">Date Registered</td><td>${added}</td></tr>
        </table>
    `;

    openModal('modalViewResident');
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

function updateBlotterStatus(id, newStatus) {
    fetch('backend/update_blotter_status.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'id=' + id + '&status=' + encodeURIComponent(newStatus)
    })
    .then(response => response.text())
    .then(data => {
        console.log(data);
        // You can add a success notification here if you want
    })
    .catch(error => console.error('Error:', error));
}

function viewBlotter(btn) {
    const narrative = btn.getAttribute('data-narrative') || 'No narrative provided.';
    const narrativeEl = document.getElementById('viewBlotterNarrative');
    if (narrativeEl) {
        narrativeEl.innerText = narrative;
    }
    openModal('modalViewBlotter');
}

function editOfficial(id, name, position, committee, contact, term) {
    document.getElementById('edit_oId').value = id;
    document.getElementById('edit_oName').value = name;
    document.getElementById('edit_oPosition').value = position;
    document.getElementById('edit_oCommittee').value = committee;
    document.getElementById('edit_oContact').value = contact;
    document.getElementById('edit_oTerm').value = term;
    openModal('modalEditOfficial');
}

function toggleSidebar() {
  const sidebar = document.getElementById("sidebar");
  const overlay = document.getElementById("sidebarOverlay");
  if (sidebar && overlay) {
    sidebar.classList.toggle("open");
    overlay.classList.toggle("active");
  }
}

function closeSidebar() {
  const sidebar = document.getElementById("sidebar");
  const overlay = document.getElementById("sidebarOverlay");
  if (sidebar && overlay) {
    sidebar.classList.remove("open");
    overlay.classList.remove("active");
  }
}

function openModal(modalId) {
  const modal = document.getElementById(modalId);
  if (modal) {
    modal.classList.add("open");
  }
}

function closeModal(modalId) {
  const modal = document.getElementById(modalId);
  if (modal) {
    modal.classList.remove("open");
  }
}

window.addEventListener("click", function (event) {
  if (event.target.classList.contains("modal-overlay")) {
    event.target.classList.remove("open");
  }
});

function updateDate() {
  const dateElement = document.getElementById("topbarDate");
  if (dateElement) {
    const options = {
      weekday: "long",
      year: "numeric",
      month: "long",
      day: "numeric",
    };
    dateElement.innerText = new Date().toLocaleDateString("en-US", options);
  }
}
updateDate();

function filterResidentsTable() {
  const table = document.getElementById("residentTable");
  if (!table) return;

  const purokSelect = document.getElementById("residentPurok");
  const genderSelect = document.getElementById("residentGender");
  const statusSelect = document.getElementById("residentStatus");
  const globalSearchInput = document.getElementById("globalSearch");
  const residentSearchInput = document.getElementById("residentSearch");

  const purokFilter = purokSelect ? purokSelect.value.toLowerCase() : "";
  const genderFilter = genderSelect ? genderSelect.value.toLowerCase() : "";
  const statusFilter = statusSelect ? statusSelect.value.toLowerCase() : "";
  const globalSearch = globalSearchInput
    ? globalSearchInput.value.toLowerCase()
    : "";
  const residentSearch = residentSearchInput
    ? residentSearchInput.value.toLowerCase()
    : "";
  const searchFilter = residentSearch || globalSearch;

  const rows = table.getElementsByTagName("tr");
  for (let i = 0; i < rows.length; i++) {
    const row = rows[i];
    if (row.cells.length < 5) continue;

    const name = row.cells[1].innerText.toLowerCase();
    const gender = row.cells[3].innerText.toLowerCase();
    const purok = row.cells[4].innerText.toLowerCase();
    const voterStatus = row.cells[6]
      ? row.cells[6].innerText.toLowerCase()
      : "";

    let matchesPurok = purokFilter === "" || purok.includes(purokFilter);
    let matchesGender = genderFilter === "" || gender === genderFilter;
    let matchesStatus = statusFilter === "" || voterStatus === statusFilter;
    let matchesSearch = searchFilter === "" || name.includes(searchFilter);

    if (matchesPurok && matchesGender && matchesStatus && matchesSearch) {
      row.style.display = "";
    } else {
      row.style.display = "none";
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
  const tabs = document.querySelectorAll(".pill-tab");
  tabs.forEach((t) => t.classList.remove("active"));
  if (btn) btn.classList.add("active");

  const tableBody = document.getElementById("certTable");
  if (!tableBody) return;

  const rows = tableBody.getElementsByTagName("tr");
  for (let i = 0; i < rows.length; i++) {
    const row = rows[i];
    if (row.cells.length < 3) continue; 

    const certType = row.cells[2].innerText.trim();

    if (type === "all" || certType === type) {
      row.style.display = "";
    } else {
      row.style.display = "none";
    }
  }
}

function viewResident(btn) {
  const name = btn.getAttribute("data-name") || "N/A";
  const dob = btn.getAttribute("data-dob") || "N/A";
  const age = btn.getAttribute("data-age") || "N/A";
  const gender = btn.getAttribute("data-gender") || "N/A";
  const civil = btn.getAttribute("data-civil") || "N/A";
  const purok = btn.getAttribute("data-purok") || "N/A";
  const contact = btn.getAttribute("data-contact") || "N/A";
  const address = btn.getAttribute("data-address") || "N/A";
  const occupation = btn.getAttribute("data-occupation") || "N/A";
  const voter = btn.getAttribute("data-voter") || "No";
  const added = btn.getAttribute("data-added") || "N/A";

  const nameParts = name
    .trim()
    .split(" ")
    .filter((n) => n.length > 0);
  let initials = "NA";
  if (nameParts.length >= 2) {
    initials = (
      nameParts[0][0] + nameParts[nameParts.length - 1][0]
    ).toUpperCase();
  } else if (nameParts.length === 1) {
    initials = nameParts[0].substring(0, 2).toUpperCase();
  }

  const badgeColor = voter === "Yes" ? "blue" : "gray";
  const voterText = voter === "Yes" ? "Registered Voter" : "Unregistered";

  const body = document.getElementById("viewResidentBody");
  body.innerHTML = `
        <div style="display:flex;gap:20px;align-items:center;margin-bottom:20px;">
            <div style="width:60px;height:60px;border-radius:50%;background:var(--primary);color:var(--white);display:flex;align-items:center;justify-content:center;font-size:22px;font-weight:700;flex-shrink:0;">${initials}</div>
            <div>
                <div style="font-size:18px;font-weight:700; ">${name}</div>
                <div style="font-size:13px;color:var(--gray-400);">${purok} &bull; ${age} yrs old</div>
                <span class="badge badge-${badgeColor}" style="margin-top:4px;">${voterText}</span>
            </div>
        </div>
        <table style="width:100%;font-size:13.5px;">
            <tr><td style="color:var(--gray-600);padding:6px 0;width:140px;">Date of Birth</td><td>${dob}</td></tr>
            <tr><td style="color:var(--gray-600);padding:6px 0;">Gender</td><td>${gender}</td></tr>
            <tr><td style="color:var(--gray-600);padding:6px 0;">Civil Status</td><td>${civil}</td></tr>
            <tr><td style="color:var(--gray-600);padding:6px 0;">Occupation</td><td>${occupation}</td></tr>
            <tr><td style="color:var(--gray-600);padding:6px 0;">Complete Address</td><td>${address}</td></tr>
            <tr><td style="color:var(--gray-600);padding:6px 0;">Contact</td><td>${contact}</td></tr>
            <tr><td style="color:var(--gray-600);padding:6px 0;">Registered Voter</td><td>${voter}</td></tr>
            <tr><td style="color:var(--gray-600);padding:6px 0;">Date Registered</td><td>${added}</td></tr>
        </table>
    `;

  openModal("modalViewResident");
}

function saveResident() {
  closeModal("modalResident");
  alert("Resident registered successfully!");
}

function viewHousehold(btn) {
  const head = btn.getAttribute("data-head") || "N/A";
  const address = btn.getAttribute("data-address") || "N/A";
  const purok = btn.getAttribute("data-purok") || "N/A";
  const members = btn.getAttribute("data-members") || "0";
  const housing = btn.getAttribute("data-housing") || "N/A";
  const contact = btn.getAttribute("data-contact") || "N/A";

  const nameParts = head
    .trim()
    .split(" ")
    .filter((n) => n.length > 0);
  let initials = "HH";
  if (nameParts.length >= 2) {
    initials = (
      nameParts[0][0] + nameParts[nameParts.length - 1][0]
    ).toUpperCase();
  } else if (nameParts.length === 1) {
    initials = nameParts[0].substring(0, 2).toUpperCase();
  }

  const body = document.getElementById("viewHHBody");
  if (body) {
    body.innerHTML = `
            <div style="display:flex;gap:20px;align-items:center;margin-bottom:20px;">
                <div style="width:60px;height:60px;border-radius:50%;background:var(--primary);color:var(--white);display:flex;align-items:center;justify-content:center;font-size:22px;font-weight:700;flex-shrink:0;">${initials}</div>
                <div>
                    <div style="font-size:18px;font-weight:700; ">${head}</div>
                    <div style="font-size:13px;color:var(--gray-400);">${purok}</div>
                    <span class="badge badge-blue" style="margin-top:4px;">${members} Members</span>
                </div>
            </div>
            <table style="width:100%;font-size:13.5px;">
                <tr><td style="color:var(--gray-600);padding:6px 0;width:140px;">Complete Address</td><td>${address}</td></tr>
                <tr><td style="color:var(--gray-600);padding:6px 0;">Purok</td><td>${purok}</td></tr>
                <tr><td style="color:var(--gray-600);padding:6px 0;">Housing Type</td><td>${housing}</td></tr>
                <tr><td style="color:var(--gray-600);padding:6px 0;">Contact Number</td><td>${contact}</td></tr>
                <tr><td style="color:var(--gray-600);padding:6px 0;">No. of Members</td><td>${members}</td></tr>
            </table>
        `;
  }
  openModal("modalViewHH");
}

function saveHousehold() {
  closeModal("modalHousehold");
  alert("Household registered successfully!");
}

function updateCertPreview() {
  const nameInput = document.getElementById("cResident");
  const purposeInput = document.getElementById("cPurpose");

  if (nameInput)
    document.getElementById("certName").innerText =
      nameInput.value || "___________";
  if (purposeInput)
    document.getElementById("certPurpose").innerText =
      purposeInput.value || "___________";
}

function saveCert() {
  closeModal("modalCert");
  alert("Certificate issued successfully!");
}

function saveBlotter() {
  closeModal("modalBlotter");
  alert("Blotter report filed successfully!");
}

function saveAnnouncement() {
  closeModal("modalAnnounce");
  alert("Announcement posted successfully!");
}

function saveOfficial() {
  closeModal("modalOfficial");
  alert("Barangay official added successfully!");
}

function updateBlotterStatus(id, newStatus) {
  fetch("backend/update_blotter_status.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/x-www-form-urlencoded",
    },
    body: "id=" + id + "&status=" + encodeURIComponent(newStatus),
  })
    .then((response) => response.text())
    .then((data) => {
      console.log(data);
    })
    .catch((error) => console.error("Error:", error));
}

function viewBlotter(btn) {
  const narrative =
    btn.getAttribute("data-narrative") || "No narrative provided.";
  const narrativeEl = document.getElementById("viewBlotterNarrative");
  if (narrativeEl) {
    narrativeEl.innerText = narrative;
  }
  openModal("modalViewBlotter");
}

function editOfficial(id, name, position, committee, contact, term) {
  document.getElementById("edit_oId").value = id;
  document.getElementById("edit_oName").value = name;
  document.getElementById("edit_oPosition").value = position;
  document.getElementById("edit_oCommittee").value = committee;
  document.getElementById("edit_oContact").value = contact;
  document.getElementById("edit_oTerm").value = term;
  openModal("modalEditOfficial");
}

const commonBarOptions = {
  responsive: true,
  maintainAspectRatio: false,
  plugins: {
    legend: { display: false },
    tooltip: {
      backgroundColor: '#1E293B',
      titleColor: '#F8FAFC',
      bodyColor: '#F8FAFC',
      padding: 12,
      cornerRadius: 8,
      displayColors: true,
      boxPadding: 4,
      usePointStyle: true
    }
  },
  scales: {
    y: {
      beginAtZero: true,
      border: { display: false },
      grid: { color: '#F1F5F9', drawTicks: false },
      ticks: { color: '#64748B', font: { family: 'Inter', size: 11 }, padding: 8, stepSize: 1 }
    },
    x: {
      border: { display: false },
      grid: { display: false },
      ticks: { color: '#64748B', font: { family: 'Inter', size: 11 }, padding: 8 }
    }
  }
};

const commonDoughnutOptions = {
  responsive: true,
  maintainAspectRatio: false,
  cutout: '75%',
  plugins: {
    legend: {
      display: true,
      position: 'bottom',
      labels: {
        color: '#475569',
        usePointStyle: true,
        pointStyle: 'circle',
        padding: 20,
        font: { family: 'Inter', size: 12 }
      }
    },
    tooltip: {
      backgroundColor: '#1E293B',
      titleColor: '#F8FAFC',
      bodyColor: '#F8FAFC',
      padding: 12,
      cornerRadius: 8,
      displayColors: true,
      boxPadding: 4,
      usePointStyle: true
    }
  }
};

const modernColors = [
  '#4F46E5', // Indigo
  '#38BDF8', // Sky Blue
  '#F472B6', // Pink
  '#34D399', // Emerald
  '#FBBF24', // Amber
  '#A78BFA', // Violet
  '#F87171'  // Red
];

fetch("analyticsCharts/purok_pop.php")
  .then((response) => response.json())
  .then((data) => {
    const labels = data.map((item) => item.purok_no);
    const residentCount = data.map((item) => item.resident_count);

    const el = document.getElementById("chartPurokBar");
    if (!el) return;
    const ctx = el.getContext("2d");
    
    // Create a gradient
    const gradient = ctx.createLinearGradient(0, 0, 0, 400);
    gradient.addColorStop(0, 'rgba(79, 70, 229, 0.2)');
    gradient.addColorStop(1, 'rgba(79, 70, 229, 0)');

    new Chart(ctx, {
      type: "line",
      data: {
        labels: labels,
        datasets: [{
          label: "Number of Residents",
          data: residentCount,
          backgroundColor: gradient,
          borderColor: '#4F46E5',
          borderWidth: 3,
          pointBackgroundColor: '#FFFFFF',
          pointBorderColor: '#4F46E5',
          pointBorderWidth: 2,
          pointRadius: 4,
          pointHoverRadius: 6,
          fill: true,
          tension: 0.4
        }]
      },
      options: commonBarOptions
    });
  })
  .catch((error) => console.error("Error:", error));

fetch("analyticsCharts/gender.php")
  .then((response) => response.json())
  .then((data) => {
    const labels = data.map((item) => item.gender);
    const genderCount = data.map((item) => item.gender_count);

    const el = document.getElementById("chartGender");
    if (!el) return;
    const ctx = el.getContext("2d");
    new Chart(ctx, {
      type: "doughnut",
      data: {
        labels: labels,
        datasets: [{
          data: genderCount,
          backgroundColor: ['#4F46E5', '#F472B6'],
          borderWidth: 0,
          hoverOffset: 4
        }]
      },
      options: commonDoughnutOptions
    });
  })
  .catch((error) => console.error("Error:", error));

fetch("analyticsCharts/residents_age.php")
  .then((response) => response.json())
  .then((data) => {
    const labels = data.map((item) => item.age_group);
    const ageCount = data.map((item) => item.resident_count);

    const el = document.getElementById("chartAge");
    if (!el) return;
    const ctx = el.getContext("2d");
    new Chart(ctx, {
      type: "bar",
      data: {
        labels: labels,
        datasets: [{
          label: "Residents",
          data: ageCount,
          backgroundColor: modernColors,
          borderWidth: 0,
          borderRadius: 6,
          barPercentage: 0.6
        }]
      },
      options: commonBarOptions
    });
  })
  .catch((error) => console.error("Error:", error));

fetch("analyticsCharts/vote.php")
  .then((response) => response.json())
  .then((data) => {
    const labels = data.map((item) => item.voter);
    const voteCount = data.map((item) => item.count);

    const el = document.getElementById("chartVoter");
    if (!el) return;
    const ctx = el.getContext("2d");
    new Chart(ctx, {
      type: "doughnut",
      data: {
        labels: labels,
        datasets: [{
          data: voteCount,
          backgroundColor: ['#38BDF8', '#94A3B8'],
          borderWidth: 0,
          hoverOffset: 4
        }]
      },
      options: commonDoughnutOptions
    });
  })
  .catch((error) => console.error("Error:", error));

fetch("analyticsCharts/civil_status.php")
  .then((response) => response.json())
  .then((data) => {
    const labels = data.map((item) => item.civil_status);
    const count = data.map((item) => item.total_count);

    const el = document.getElementById("chartCivil");
    if (!el) return;
    const ctx = el.getContext("2d");
    new Chart(ctx, {
      type: "bar",
      data: {
        labels: labels,
        datasets: [{
          label: "Residents",
          data: count,
          backgroundColor: modernColors[3],
          borderWidth: 0,
          borderRadius: 6,
          barPercentage: 0.5
        }]
      },
      options: commonBarOptions
    });
  })
  .catch((error) => console.error("Error:", error));

fetch("analyticsCharts/blotter.php")
  .then((response) => response.json())
  .then((data) => {
    const labels = data.map((item) => item.status);
    const count = data.map((item) => item.total_count);

    const el = document.getElementById("chartBlotterStatus");
    if (!el) return;
    const ctx = el.getContext("2d");
    new Chart(ctx, {
      type: "bar",
      data: {
        labels: labels,
        datasets: [{
          label: "Cases",
          data: count,
          backgroundColor: modernColors[4],
          borderWidth: 0,
          borderRadius: 6,
          barPercentage: 0.5
        }]
      },
      options: commonBarOptions
    });
  })
  .catch((error) => console.error("Error:", error));

fetch("analyticsCharts/certificates.php")
  .then((response) => response.json())
  .then((data) => {
    const labels = data.map((item) => item.certificate_type);
    const count = data.map((item) => item.total_count);

    const el = document.getElementById("chartCertType");
    if (!el) return;
    const ctx = el.getContext("2d");
    new Chart(ctx, {
      type: "bar",
      data: {
        labels: labels,
        datasets: [{
          label: "Requests",
          data: count,
          backgroundColor: modernColors[5],
          borderWidth: 0,
          borderRadius: 6,
          barPercentage: 0.5
        }]
      },
      options: {
        ...commonBarOptions,
        indexAxis: 'y', // Makes it a horizontal bar chart
        scales: {
          x: {
            beginAtZero: true,
            border: { display: false },
            grid: { color: '#F1F5F9', drawTicks: false },
            ticks: { color: '#64748B', font: { family: 'Inter', size: 11 }, padding: 8, stepSize: 1 }
          },
          y: {
            border: { display: false },
            grid: { display: false },
            ticks: { color: '#64748B', font: { family: 'Inter', size: 11 }, padding: 8 }
          }
        }
      }
    });
  })
  .catch((error) => console.error("Error:", error));

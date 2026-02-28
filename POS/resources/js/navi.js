// Sidebar toggle
const sidebar = document.getElementById('sidebar');
const toggleBtn = document.getElementById('sidebarToggle');

toggleBtn.addEventListener('click', () => {
    sidebar.classList.toggle('collapsed');
});

// Tooltip for collapsed sidebar
document.querySelectorAll('.nav-links li a').forEach(link => {
    link.addEventListener('mouseenter', () => {
        if(sidebar.classList.contains('collapsed')){
            const tooltip = document.createElement('span');
            tooltip.classList.add('tooltip');
            tooltip.innerText = link.dataset.tooltip;
            link.appendChild(tooltip);
        }
    });
    link.addEventListener('mouseleave', () => {
        const tooltip = link.querySelector('.tooltip');
        if(tooltip) tooltip.remove();
    });
});

// Date & time display
function updateDateTime() {
    const now = new Date();
    const options = { weekday: 'short', year: 'numeric', month: 'short', day: 'numeric' };
    const dateStr = now.toLocaleDateString('en-US', options);
    const timeStr = now.toLocaleTimeString('en-US', { hour12: false });
    const dateTimeEl = document.getElementById('datetime');
    if(dateTimeEl) dateTimeEl.innerText = `${dateStr} | ${timeStr}`;
}
setInterval(updateDateTime, 1000); // update every second
updateDateTime();

// Profile dropdown toggle
const profileDropdown = document.getElementById('profileDropdown');
const dropdownContent = document.getElementById('dropdownContent');

if(profileDropdown && dropdownContent){
    profileDropdown.addEventListener('click', (e) => {
        e.stopPropagation(); // prevent closing immediately
        dropdownContent.style.display = dropdownContent.style.display === 'block' ? 'none' : 'block';
    });

    // Close dropdown when clicking outside
    document.addEventListener('click', (e) => {
        if (!profileDropdown.contains(e.target)) {
            dropdownContent.style.display = 'none';
        }
    });
}
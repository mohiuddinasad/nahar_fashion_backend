// Get elements
const menuBtn = document.getElementById("menuBtn");
const closeBtn = document.getElementById("closeBtn");
const overlay = document.getElementById("overlay");
const sidebar = document.getElementById("sidebar");
const tabBtns = document.querySelectorAll(".tab-btn");
const tabContents = document.querySelectorAll(".tab-content");

// Open sidebar
function openSidebar() {
  sidebar.classList.add("active");
  overlay.classList.add("active");
}

// Close sidebar
function closeSidebar() {
  sidebar.classList.remove("active");
  overlay.classList.remove("active");
}

// Switch tabs
function switchTab(tabName) {
  // Remove active class from all tabs and contents
  tabBtns.forEach((btn) => btn.classList.remove("active"));
  tabContents.forEach((content) => content.classList.remove("active"));

  // Add active class to clicked tab and corresponding content
  const activeBtn = document.querySelector(`[data-tab="${tabName}"]`);
  const activeContent = document.getElementById(tabName);

  activeBtn.classList.add("active");
  activeContent.classList.add("active");
}

// Event listeners
menuBtn.addEventListener("click", openSidebar);
closeBtn.addEventListener("click", closeSidebar);
overlay.addEventListener("click", closeSidebar);

// Tab switching
tabBtns.forEach((btn) => {
  btn.addEventListener("click", () => {
    const tabName = btn.getAttribute("data-tab");
    switchTab(tabName);
  });
});

// Close sidebar when clicking menu items
const menuItems = document.querySelectorAll(".menu-item, .category-item");
menuItems.forEach((item) => {
  item.addEventListener("click", closeSidebar);
});

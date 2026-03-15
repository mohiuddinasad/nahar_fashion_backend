$(document).ready(function () {

    const menuBtn = document.getElementById("menuBtn");
    const closeBtn = document.getElementById("closeBtn");
    const overlay = document.getElementById("overlay");
    const sidebar = document.getElementById("sidebar");
    const tabBtns = document.querySelectorAll(".tab-btn");
    const tabContents = document.querySelectorAll(".tab-content");

    // ══ Open sidebar ══
    function openSidebar() {
        sidebar.classList.add("active");
        overlay.classList.add("active");
    }

    // ══ Close sidebar ══
    function closeSidebar() {
        sidebar.classList.remove("active");
        overlay.classList.remove("active");
        $('.category-dropdown').slideUp(200);
        $('.dropdown-toggle-btn').removeClass('open');
    }

    // ══ Switch tabs ══
    function switchTab(tabName) {
        tabBtns.forEach((btn) => btn.classList.remove("active"));
        tabContents.forEach((content) => content.classList.remove("active"));

        const activeBtn = document.querySelector(`[data-tab="${tabName}"]`);
        const activeContent = document.getElementById(tabName);

        activeBtn.classList.add("active");
        activeContent.classList.add("active");
    }

    // ══ Sidebar open/close events ══
    menuBtn.addEventListener("click", openSidebar);
    closeBtn.addEventListener("click", closeSidebar);
    overlay.addEventListener("click", closeSidebar);

    // ══ Tab switching ══
    tabBtns.forEach((btn) => {
        btn.addEventListener("click", () => {
            const tabName = btn.getAttribute("data-tab");
            switchTab(tabName);
        });
    });

    // ══ Close sidebar on plain menu-item clicks ══
    document.querySelectorAll(".menu-item").forEach((item) => {
        item.addEventListener("click", closeSidebar);
    });

    // ══ Close sidebar on category-item click only if no dropdown ══
    document.querySelectorAll(".category-item:not(.has-dropdown)").forEach((item) => {
        item.addEventListener("click", closeSidebar);
    });

    // ══ Toggle dropdown on category-left OR arrow button click ══
    $(document).on("click", ".category-item.has-dropdown .category-left, .dropdown-toggle-btn", function (e) {
        e.stopPropagation(); // prevent sidebar from closing

        const $dropdown = $(this).closest(".has-dropdown").find(".category-dropdown");
        const $btn = $(this).closest(".has-dropdown").find(".dropdown-toggle-btn");

        // close other open dropdowns first
        $(".category-dropdown").not($dropdown).slideUp(200);
        $(".dropdown-toggle-btn").not($btn).removeClass("open");

        // toggle clicked dropdown
        $btn.toggleClass("open");
        $dropdown.slideToggle(250);
    });

    // ══ Close sidebar when a dropdown item link is clicked ══
    $(document).on("click", ".category-dropdown li a", function () {
        closeSidebar();
    });

});

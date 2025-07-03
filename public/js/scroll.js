document.addEventListener("DOMContentLoaded", function () {
    const header = document.getElementById("header");
    const links = document.querySelectorAll(
        "nav ul li a, #mobile-menu ul li a"
    );
    const mobileMenu = document.getElementById("mobile-menu");
    const hamburger = document.getElementById("hamburger");
    const menuOverlay = document.getElementById("menu-overlay");

    function toggleMobileMenu() {
        mobileMenu.classList.toggle("open");
        menuOverlay.classList.toggle("active");
    }
    menuOverlay.addEventListener("click", toggleMobileMenu);

    links.forEach((link) => {
        link.addEventListener("click", function (event) {
            if (this.getAttribute("href").startsWith("#")) {
                event.preventDefault();
                const targetId = this.getAttribute("href").substring(1);
                const targetSection = document.getElementById(targetId);
                if (targetSection) {
                    window.scrollTo({
                        top: targetSection.offsetTop - 60,
                        behavior: "smooth",
                    });
                }
            }

            if (mobileMenu.classList.contains("open")) {
                toggleMobileMenu();
            }
        });
    });

    function updateActiveLink() {
        let scrollPosition = window.scrollY + window.innerHeight / 2;
        links.forEach((link) => {
            const href = link.getAttribute("href");
            if (href.startsWith("#")) {
                const section = document.querySelector(href);
                if (
                    section &&
                    section.offsetTop <= scrollPosition &&
                    section.offsetTop + section.offsetHeight > scrollPosition
                ) {
                    link.classList.add("active-link");
                } else {
                    link.classList.remove("active-link");
                }
            }
        });
    }

    window.addEventListener("scroll", function () {
        if (window.scrollY > 50) {
            header.classList.add("bg-white", "shadow-2xl", "opacity-none");
            header.classList.remove("bg-transparent");
            hamburger.classList.add("text-black");
            hamburger.classList.remove("text-white");

            links.forEach((link) => {
                link.classList.add("text-cinnabar-700");
                link.classList.remove("text-white");
            });
        } else {
            header.classList.remove("bg-white", "shadow-2xl", "opacity-none");
            header.classList.add("bg-transparent");
            hamburger.classList.remove("text-black");
            hamburger.classList.add("text-white");

            links.forEach((link) => {
                link.classList.remove("text-black");
                link.classList.add("text-white");
            });
        }
    });

    window.addEventListener("scroll", updateActiveLink);
    updateActiveLink();

    hamburger.addEventListener("click", function (event) {
        event.stopPropagation();
        toggleMobileMenu();
    });
});

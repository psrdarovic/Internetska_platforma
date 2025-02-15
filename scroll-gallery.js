document.addEventListener("DOMContentLoaded", function () {
    const galleryContainer = document.querySelector(".gallery");
    const prevButton = document.getElementById("prev-gallery");
    const nextButton = document.getElementById("next-gallery");
    const panels = document.querySelectorAll(".panel");

    let scrollAmount = 0;
    const panelWidth = galleryContainer.offsetWidth / 3; // Širina jednog panela

    function scrollGallery(direction) {
        if (document.querySelector(".panel.active")) {
            return; // Ako je neki panel aktivan, ne skrolaj galeriju
        }

        if (direction === "next") {
            scrollAmount += panelWidth;
            if (scrollAmount > galleryContainer.scrollWidth - galleryContainer.clientWidth) {
                scrollAmount = galleryContainer.scrollWidth - galleryContainer.clientWidth;
            }
        } else {
            scrollAmount -= panelWidth;
            if (scrollAmount < 0) scrollAmount = 0;
        }

        galleryContainer.scrollTo({
            left: scrollAmount,
            behavior: "smooth"
        });
    }

    nextButton.addEventListener("click", () => scrollGallery("next"));
    prevButton.addEventListener("click", () => scrollGallery("prev"));

    // Omogućavanje povećavanja panela i prikaza "See More" gumba
    panels.forEach((panel) => {
        panel.addEventListener("click", (event) => {
            if (panel.classList.contains("active")) {
                panel.classList.remove("active");
            } else {
                panels.forEach(p => p.classList.remove("active"));
                panel.classList.add("active");
            }
            event.stopPropagation(); // Sprječava zatvaranje zbog globalnog klika
        });
    });

    // Klik izvan panela zatvara aktivni panel
    document.addEventListener("click", (event) => {
        if (!event.target.closest(".panel") && !event.target.classList.contains("see-more")) {
            panels.forEach(panel => panel.classList.remove("active"));
        }
    });

    // Swipe (povlačenje prstom) za mobilne uređaje
    let isTouching = false;
    let startX = 0;
    let scrollLeft = 0;

    galleryContainer.addEventListener("touchstart", (e) => {
        isTouching = true;
        startX = e.touches[0].pageX;
        scrollLeft = galleryContainer.scrollLeft;
    });

    galleryContainer.addEventListener("touchmove", (e) => {
        if (document.querySelector(".panel.active")) {
            return; // Ako je panel aktivan, ne dozvoli scroll
        }

        const x = e.touches[0].pageX;
        const walk = startX - x;
        galleryContainer.scrollLeft = scrollLeft + walk;
    });

    galleryContainer.addEventListener("touchend", () => {
        isTouching = false;
    });
});

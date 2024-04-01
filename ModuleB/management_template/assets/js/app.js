document.querySelectorAll(".collapse-menu").forEach((item) => {
    item.style.height = window.getComputedStyle(item).getPropertyValue("height");
});

window.addEventListener("click", (e) => {
    if (e.target.classList.contains("sidebar-heading")) {
        let target_element = document.querySelector(e.target.getAttribute("data-target"));
        target_element.classList.toggle("collapse-true");
        e.target.classList.toggle("collapse-true-menu-title");
    }
});


function openModal(id) {
    const modal = document.querySelector(id);
    modal.style.display = "block";
}

function closeModal(id) {
    const modal = document.querySelector(id);
    modal.style.display = "none";
}

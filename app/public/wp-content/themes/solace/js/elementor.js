// JS for syncronize elementor effect to gutenberg blocks buttons or classic buttons
document.addEventListener("DOMContentLoaded", function () {
    const body = document.body;
    
    if (body.classList.contains("elementor-page")) {
        // const wpButtons = document.querySelectorAll(".wp-element-button, .tag-cloud-link, .search-submit");
        const wpButtons = document.querySelectorAll(".wp-element-button, .tag-cloud-link");
    
        wpButtons.forEach((button) => {
        button.classList.add("elementor-button");
        });
    }
});
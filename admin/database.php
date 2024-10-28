// Show dropdown on hover for larger screens
dropdownToggle.onmouseenter = function(e) {
if (window.innerWidth > 850) {
e.stopPropagation();
dropdownMenu.classList.add("show");
dropdownMenu.style.display = "flex";
}
};

dropdownToggle.onmouseleave = function(e) {
if (window.innerWidth > 850) {
dropdownMenu.classList.remove("show");
dropdownMenu.style.display = "none";
}
};

// Show dropdown on click for smaller screens
dropdownToggle.onclick = function(e) {
if (window.innerWidth <= 850) {
    e.stopPropagation();
    dropdownMenu.classList.toggle("show");
    dropdownMenu.style.display=dropdownMenu.classList.contains("show") ? "flex" : "none" ;
    }
    };
    }

    // Call the function on page load and on window resize
    handleHover();
    window.onresize=handleHover;
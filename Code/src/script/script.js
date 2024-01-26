function filterCity() {

    d = document.getElementById("canton").value;
    var selectElement = document.getElementById("zipCity");
    if (d === "") {
        // Loop through each option in the select element
        for (var i = 0; i < selectElement.options.length; ++i) {
            var option = selectElement.options[i];
            option.style.display = "";
        }
    } else {
        // Loop through each option in the select element
        for (var i = 0; i < selectElement.options.length; ++i) {
            var option = selectElement.options[i];

            // Check if the option's ID matches the desired ID
            if (option.id === d) {
                // If it matches, show the option
                option.style.display = "";
            } else {
                // If it does not match, hide the option
                if (option.id != "default") {
                    option.style.display = "none";
                    if (option.selected) {
                        document.getElementById("zipCity").selectedIndex = 0;
                    }
                }
            }
        }
    }
}

$(document).ready(function () {
    if (document.getElementById("canton") && document.getElementById("zipCity")) {
        filterCity();
    }
});
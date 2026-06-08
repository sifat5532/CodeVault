async function validate_username(uname_input, uname_label, btn) {
    input_data = uname_input.value;
    if (input_data != "") {
        if (isValid(input_data) && input_data.length >= 3) {
            let url = "php/validate_username.php?username=" + encodeURIComponent(input_data);
            let response = await fetch(url);
            let data = await response.json();

            if (data.status == true) {
                btn.disabled = true;
                uname_label.innerHTML = "Username: <span style='color: #dc3545;'>This username is already taken</span>";
            } else {
                btn.disabled = false;
                uname_label.innerHTML = "Username: <span style='color: #00de76;'>It's available</span>";
            }
        } else if (isValid(input_data) && input_data.length < 3) {
            btn.disabled = true;
            uname_label.innerHTML = "Username: <span style='color: #dc3545;'>Too small</span>";
        } else {
            btn.disabled = true;
            uname_label.innerHTML = "Username: <span style='color: #dc3545;'>Invalid format. Allowed [a-z,A-Z,0-9,_]</span>";
        }
    } else {
        uname_label.innerHTML = "Username";
        btn.disabled = true;
    }
}

function isValid(username) {
    return /^[a-zA-Z0-9_]+$/.test(username);
}
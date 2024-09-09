const form = document.querySelector("form");
const email = document.getElementById("email");
const emailError = document.querySelector(".email-error");
const name = document.getElementById("name");
const nameError = document.querySelector(".name-error");
const lastname = document.getElementById("lastName");
const lastnameError = document.querySelector(".lastname-error");
const username = document.getElementById("username");
const usernameError = document.querySelector(".username-error");
const password = document.getElementById("password");
const passwordError = document.querySelector(".password-error");
const confirmPassword = document.getElementById("confirmPassword");
const confirmPasswordError = document.querySelector(".confirm-password-error");

let regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@.#$!%*?&])[A-Za-z\d@.#$!%*?&]{8,15}$/;
let usernameData = [];
$(document).ready(function() {
    $.ajax({
        url: './usernames.php',
        type: 'GET',
        success: function(response) {
            let data = JSON.parse(response)
            data.forEach((element, index, array) => {
                usernameData.push(element.username)
            })
        },
        error: function(error) {
            console.log("Error fetching data: ", error);
        }
    });
});

//INPUTS VALIDATION
name.addEventListener("input", (event) => {
    if (name.validity.valueMissing) {
        showNameError()
    } else {
        nameError.textContent = ""
    }
});

lastname.addEventListener("input", (event) => {
    if (lastname.validity.valueMissing) {
        showLastnameError()
    } else {
        lastnameError.textContent = ""
    }
});

username.addEventListener("input", (event) => {
    if (!username.validity.valid || usernameData.includes(username.value)) {
        showUsernameError();

    } else {
        usernameError.textContent = "";
    }

});
email.addEventListener("input", (event) => {
    // Each time the user types something, we check if the
    // form fields are valid.

    if (email.validity.valid) {
        // In case there is an error message visible, if the field
        // is valid, we remove the error message.
        emailError.textContent = "";
        // emailError.className = "";
    } else {
        // If there is still an error, show the correct error
        showEmailError();
    }
});

password.addEventListener("input", (event) => {
    if (regex.test(password.value)) {
        passwordError.textContent = ""
    } else {
        showPasswordError()
    }
});

confirmPassword.addEventListener("input", (event) => {
    if (password.value === confirmPassword.value) {
        confirmPasswordError.textContent = ""
    } else {
        showConfirmPasswordError()
    }
})


// SUBMIT FORM VALIDATION
form.addEventListener("submit", (event) => {

    if (!email.validity.valid) {
        showEmailError();
        event.preventDefault();
    }

    if (name.validity.valueMissing) {
        showNameError()
        event.preventDefault()
    }

    if (lastname.validity.valueMissing) {
        showLastnameError()
        event.preventDefault()
    }

    if (!username.validity.valid) {
        showUsernameError()
        event.preventDefault()
    }

    if (!regex.test(password.value)) {
        showPasswordError()
        event.preventDefault()
    }

    if (password.value !== confirmPassword.value) {
        showConfirmPasswordError()
        event.preventDefault()
    }
});


// DISPLAY ERROR MESSAGE FUNCTIONS
const showLastnameError = () => {
    if (lastname.validity.valueMissing) {
        lastnameError.textContent = "You need to enter you lastname"
    }
}
const showNameError = () => {
    if (name.validity.valueMissing) {
        nameError.textContent = "You need to enter you name"
    }
};
const showEmailError = () => {
    if (email.validity.valueMissing) {
        emailError.textContent = "You need to enter an email address.";
    } else if (email.validity.typeMismatch) {
        emailError.textContent = "Entered value needs to be an email address.";
    } else if (email.validity.tooShort) {
        emailError.textContent = `Email should be at least ${email.minLength} characters; you entered ${email.value.length}.`;
    }
}

const showUsernameError = () => {
    if (username.validity.valueMissing) {
        usernameError.textContent = "You need to enter your username."
    } else if (username.validity.tooShort) {
        usernameError.textContent = "Username too short. Minimum length 4 characters."
    } else if (username.validity.tooLong) {
        usernameError.textContent = "Username too long. Maximum length 12 characters."
    } else if (usernameData.includes(username.value)) {
        usernameError.textContent = "Username is taken!"
    }
}

const showPasswordError = () => {
    if (!regex.test(password.value)) {
        passwordError.textContent = "Password must be between 8 - 15 characters and must contain one lowercase, uppercase, numeric, special character!"
    }
}

const showConfirmPasswordError = () => {
    if (password.value !== confirmPassword.value) {
        confirmPasswordError.textContent = "Passwords don't match"
    }
}
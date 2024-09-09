const form = document.querySelector("form");
const userCredential = document.getElementById("user-credential")
const userCredentialError = document.querySelector(".credential-error")
const password = document.getElementById("password")
const passwordError = document.querySelector(".password-error")

userCredential.addEventListener("input", (event) => {
    if (userCredential.value.length === 0) {
        showUserCredentialError()
    } else {
        userCredentialError.textContent = ""
    }
})

password.addEventListener("input", (event) => {
    if (password.value.length === 0) {
        showPasswordError()
    } else {
        passwordError.textContent = ""
    }
})
form.addEventListener("submit", (event) => {
    if (userCredential.value.length === 0) {
        showUserCredentialError();
        event.preventDefault()
    }

    if (password.value.length === 0) {
        showPasswordError();
        event.preventDefault()
    }

})

const showUserCredentialError = () => {
    if (userCredential.value.length === 0) {
        userCredentialError.textContent = "Field can't be empty!";
    }
}

const showPasswordError = () => {
    if (password.value.length === 0) {
        passwordError.textContent = "Field can't be empty!";
    }
}
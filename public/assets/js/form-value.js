/**
 * Clear form by range of data
 *
 * @param data
 */
function clearSelectedFormInput(...data) {
    data.forEach(function (item, index) {
        console.log('data' + item + index)
        document.getElementById(item).value = ""
    })
}

function obscureSecretText() {
    let passwordInput = document.getElementById("password");
    let passwordObscureIcon = document.getElementById("password_obscure_icon");

    if (passwordInput.type === "password") {
        passwordInput.type = "text";
        passwordObscureIcon.classList.remove('fa-eye')
        passwordObscureIcon.classList.add('fa-eye-slash')
    } else {
        passwordInput.type = "password";
        passwordObscureIcon.classList.remove('fa-eye-slash')
        passwordObscureIcon.classList.add('fa-eye')
    }
}

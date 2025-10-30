document.addEventListener("DOMContentLoaded", function () {
  const form = document.querySelector("form");
  const nomInput = document.getElementById("floatingInputNom");
  const prenomInput = document.getElementById("floatingInputPrenom");
  const passwordInput = document.getElementById("floatingPassword");
  const password2Input = document.getElementById("floatingPassword2");

  // Function to validate inputs
  function validateInput(input, regex, errorMsg) {
    if (!regex.test(input.value)) {
      input.classList.add("is-invalid");
      input.nextElementSibling.textContent = errorMsg;
      return false;
    } else {
      input.classList.remove("is-invalid");
      input.nextElementSibling.textContent = "";
      return true;
    }
  }

  // Event listeners for blur events
  nomInput.addEventListener("blur", function () {
    validateInput(
      nomInput,
      /^[a-zA-Z]+$/,
      "Le nom ne doit contenir que des lettres."
    );
  });

  prenomInput.addEventListener("blur", function () {
    validateInput(
      prenomInput,
      /^[a-zA-Z]+$/,
      "Le prénom ne doit contenir que des lettres."
    );
  });

  passwordInput.addEventListener("blur", function () {
    validateInput(
      passwordInput,
      /^(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9]).{8,}$/,
      "Le mot de passe doit comporter au moins 8 caractères, dont une majuscule, une minuscule et un chiffre."
    );
  });

  password2Input.addEventListener("blur", function () {
    if (passwordInput.value !== password2Input.value) {
      password2Input.classList.add("is-invalid");
      password2Input.nextElementSibling.textContent =
        "Les mots de passe ne correspondent pas.";
    } else {
      password2Input.classList.remove("is-invalid");
      password2Input.nextElementSibling.textContent = "";
    }
  });

  // Form submit event listener
  form.addEventListener("submit", function (event) {
    let isValid = true;

    if (
      !validateInput(
        nomInput,
        /^[a-zA-Z]+$/,
        "Le nom ne doit contenir que des lettres."
      )
    )
      isValid = false;
    if (
      !validateInput(
        prenomInput,
        /^[a-zA-Z]+$/,
        "Le prénom ne doit contenir que des lettres."
      )
    )
      isValid = false;
    if (
      !validateInput(
        passwordInput,
        /^(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9]).{8,}$/,
        "Le mot de passe doit comporter au moins 8 caractères, dont une majuscule, une minuscule et un chiffre."
      )
    )
      isValid = false;
    if (passwordInput.value !== password2Input.value) {
      password2Input.classList.add("is-invalid");
      password2Input.nextElementSibling.textContent =
        "Les mots de passe ne correspondent pas.";
      isValid = false;
    } else {
      password2Input.classList.remove("is-invalid");
      password2Input.nextElementSibling.textContent = "";
    }

    if (!isValid) {
      event.preventDefault();
    }
  });
});

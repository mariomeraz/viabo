(() => {
  "use strict";

  const contactForm = document.querySelector("#set-form-contact");

  contactForm.addEventListener(
    "submit",
    (event) => {
      event.preventDefault();
      const information = getInformation(contactForm);
      sendContactInformation(information, contactForm);
    },
    false
  );
})();

function getInformation(form) {
  const formData = new FormData(form);
  const formObject = {};
  formData.forEach((value, key) => {
    formObject[key] = value;
  });

  return formObject;
}

async function sendContactInformation(information, contactForm) {
  setButtonByStatus(true);
  const toastSuccess = document.getElementById("notification-contact-success");
  const toastError = document.getElementById("notification-contact-error");
  const toastWarning = document.getElementById("notification-contact-warning");
  const toastMessageWarning = document.getElementById(
    "message-warning-notification"
  );

  try {
    const toast = new bootstrap.Toast(toastSuccess);
    const toast_warning = new bootstrap.Toast(toastWarning);

    const configRequest = {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify(information),
    };

    const response = await fetch("/api/set/register/prospect", configRequest);

    if (response?.status === 400) {
      const message = await response?.json();
      toastMessageWarning.innerHTML =
        message !== ""
          ? message
          : "Ocurrio un problema al guardar la información";
      toast_warning.show();
      return;
    }

    if (response?.status !== 200) {
      throw new Exception("Problema al guardar la información");
    }

    toast.show();
    contactForm?.reset();
  } catch (error) {
    console.error(error);
    const toast = new bootstrap.Toast(toastError);
    toast.show();
  } finally {
    setButtonByStatus(false);
  }
}

function setButtonByStatus(loading = false) {
  const button_container = document.getElementById("container-submit-button");

  if (loading) {
    return (button_container.innerHTML = `
      <button type="submit" disabled class="viabo-button-inverse no-wrap-text">
          <div class="d-flex flex-row justify-content-center align-items-center gap-2">
            <div class="spinner-border spinner-border-sm" role="status">
              <span class="visually-hidden">Enviando...</span>
            </div>
            <span>Enviando...</span>
          </div>
			</button>
      `);
  }

  return (button_container.innerHTML =
    '<button type="submit" class="viabo-button-inverse no-wrap-text">Enviar</button>');
}

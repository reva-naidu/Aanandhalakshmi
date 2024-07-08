document
  .getElementById("openFormButton")
  .addEventListener("click", function () {
    // document.getElementById("formPopup").style.display = "block";
    document.getElementById("formOverlay").style.display = "block";
    document.getElementById("formPopup").style.display = "block";
  });

document
  .getElementById("closeFormButton")
  .addEventListener("click", function () {
    // document.getElementById("formPopup").style.display = "none";
    document.getElementById("formOverlay").style.display = "none";
    document.getElementById("formPopup").style.display = "none";
    document.querySelector('input[name="name"]').value = "";
    document.querySelector('input[name="email"]').value = "";
    document.querySelector('input[name="phone"]').value = "";
  });

document
  .getElementById("contactForm")
  .addEventListener("submit", function (event) {
    event.preventDefault();
    if (validateForm()) {
      // Trigger file download
      try {
        const myDiv = document.getElementById("openFormButton");
        if (myDiv) {
          const dataInfoValue = myDiv.getAttribute("data-href");

          const link = document.createElement("a");

          link.href = dataInfoValue;
          link.target = "_blank";
          link.download = dataInfoValue.split("/media/")[0];
          link.click();
        }
      } catch (error) {}

      // Access the 'data-info' attribute
    }
    this.submit();

    // Optionally close the form
    document.getElementById("formPopup").style.display = "none";
  });
function validateForm() {
  const name = document.querySelector('input[name="name"]').value.trim();
  const email = document.querySelector('input[name="email"]').value.trim();
  const phone = document.querySelector('input[name="phone"]').value.trim();

  if (name === "") {
    alert("Name must be filled out");
    return false;
  } else if (!validateName(name)) {
    alert("Name must not contain numbers or special characters.");
    return false;
  }

  if (email === "") {
    alert("Email must be filled out");
    return false;
  } else if (!validateEmail(email)) {
    alert("Invalid email format");
    return false;
  }

  if (phone === "") {
    alert("Phone number must be filled out");
    return false;
  } else if (!validatePhone(phone)) {
    alert("Invalid phone number format");
    return false;
  }

  return true;
}

function validateName(name) {
  const re = /^[A-Za-z\s'-]+$/;
  return re.test(name);
}
function validateEmail(email) {
  const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  return re.test(email);
}

function validatePhone(phone) {
  const re = /^\d{10}$/; // Adjust this regex according to your requirements
  return re.test(phone);
}

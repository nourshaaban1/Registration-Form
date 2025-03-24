const whatsappButton = document.getElementById("whatsapp-button");

whatsappButton.addEventListener("click", () => {
  let number = whatsapp.value.trim();
  number = "2" + number; // Add Egypt country code (20)

  const data = JSON.stringify({
    phone_number: number,
  });

  const xhr = new XMLHttpRequest();

  xhr.addEventListener("readystatechange", function () {
    if (this.readyState === this.DONE) {
      const responseData = JSON.parse(this.responseText);
      if (responseData.status && responseData.status === "valid") {
        whatsapp.nextElementSibling.textContent = `✅ Your WhatsApp number +${number} is valid`;
        whatsapp.nextElementSibling.style.color = "#008F17";
        whatsapp.nextElementSibling.style.fontSize = "14px";
      } else if (responseData.status && responseData.status === "invalid") {
        whatsapp.nextElementSibling.textContent = `❌ Your WhatsApp number +${number} is invalid!`;
        whatsapp.nextElementSibling.style.color = "D40D0D";
        whatsapp.nextElementSibling.style.fontSize = "14px";
      } else {
        console.log(responseData.message);
      }
    }
  });

  xhr.open(
    "POST",
    "https://whatsapp-number-validator3.p.rapidapi.com/WhatsappNumberHasItWithToken"
  );

  xhr.setRequestHeader(
    "x-rapidapi-key",
    "a35ad6807cmsha6e1dd3d1b6738ap15fc26jsn1bb622a901ac"
  );
  xhr.setRequestHeader(
    "x-rapidapi-host",
    "whatsapp-number-validator3.p.rapidapi.com"
  );
  xhr.setRequestHeader("Content-Type", "application/json");

  xhr.send(data);
});

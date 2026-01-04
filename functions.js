document.addEventListener("DOMContentLoaded", function () {
const copyButton = document.getElementById("copyButton");
  if (!copyButton) return;

  copyButton.addEventListener("click", function (event) {
    event.preventDefault(); // evita submit acidental

    const text = copyButton.getAttribute("data-text");
    if (!text) return; // nada para copiar

    navigator.clipboard
      .writeText(text)
      .then(() => alert("Texto copiado para a área de transferência!"))
      .catch((err) => console.error("Falha ao copiar o texto:", err));
  });
});

const franchiseContainer = document.querySelector(".franchise-container");

const inputFields = document.querySelectorAll(".form-input-fields");
inputFields.forEach((tags) => {
  console.log(tags);
  tags.addEventListener("input", (e) => {
    if (e.target.value.trim() !== " " &&  franchiseContainer) {
      franchiseContainer.style.display = "none";
    } 
  });
});

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

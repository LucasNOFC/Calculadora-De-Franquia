const franchiseForm = document.querySelector("#franchise-form");

const getFormValues = () => {
  const fipeValue = document.getElementById("fipeValue").value;
  const fipePercentage = document.getElementById("fipePercentage").value;

  const vehicleType = document.querySelector(
    'input[name="isCar"]:checked',
  )?.value;

  let isFirstFranchise = document.querySelector(
    'input[name="isFirstFranchise"]:checked',
  )?.value;

  if (isFirstFranchise === "true") isFirstFranchise = true;
  else isFirstFranchise = false;

  const formData = {
    fipeValue,
    fipePercentage,
    vehicleType,
    isFirstFranchise,
  };

  return formData;
};

const parseBRL = (value) => {
  if (!value) return 0;

  return Number(value.replace(/\./g, "").replace(",", ".").trim());
};

const formatToBRL = (value) => {
  return new Intl.NumberFormat("pt-BR", {
    style: "currency",
    currency: "BRL",
  }).format(value);
};

const franchiseValueHandler = (
  franchiseValue,
  percentageValue,
  vehicleType,
  isFirstFranchise,
) => {
  let finalFranchiseValue = franchiseValue;

  if (!vehicleType) {
    return false;
  } else if (vehicleType === "bike") {
    if (franchiseValue < 800 && percentageValue === 8)
      finalFranchiseValue = 800;
    else if (franchiseValue < 1200 && percentageValue === 10)
      finalFranchiseValue = 1200;
  } else if (vehicleType === "car") {
    if (franchiseValue < 1000 && percentageValue === 4)
      finalFranchiseValue = 1000;
    else if (franchiseValue < 1400 && percentageValue === 7)
      finalFranchiseValue = 1400;
  } else if (vehicleType === "truck") {
    if (franchiseValue < 1000 && percentageValue === 5)
      finalFranchiseValue = 1000;
    else if (franchiseValue < 1200 && percentageValue === 6)
      finalFranchiseValue = 1200;
    else if (franchiseValue < 1400 && percentageValue === 7)
      finalFranchiseValue = 1400;
  }

  if (!isFirstFranchise) return finalFranchiseValue;
  else return finalFranchiseValue * 2;
};

const fipeValueHandler = (fipeValue, percentageValue) => {
  fipeValue = parseBRL(fipeValue);
  return (fipeValue / 100) * percentageValue;
};

const scriptHandler = (franchiseValue, percentageValue, fipeValue) => {
  const message = `
    
    A participação individual, também conhecida como “Franquia”, é uma parte do custo que o associado contratante deve pagar. Conforme previsto em contrato, essa cobrança ocorre, somente em casos de acionamentos. Em casos pequenas ou grandes colisões, perca total, roubo e furto.

A PI é calculada com base em ${percentageValue} do valor FIPE do veículo no mês vigente ao do sinistro. O valor FIPE do seu veículo no mês do sinistro é de R$ ${fipeValue} sendo assim a PI para este acionamento será de ${franchiseValue} e esse é o valor que será pago para cobrir os custos relacionados a este acionamento.

Porém, este pagamento não é efetuado agora, primeiramente solicitamos algumas documentações, após o envio completo destas documentações serão encaminhadas para análise do processo que tem um prazo de até 72hs úteis para conclusão, concluída e aprovada seguiremos para o pagamento, confirmado o pagamento será iniciado a fase final deste acionamento.

➡️ Podemos seguir para documentação necessária ou há alguma dúvida?
    `;

  return message;
};

const copyScript = (message) => {
    navigator.clipboard.writeText(message);
}

const generateModal = (value, scriptMessage) => {
  if (document.getElementById("franchiseModal")) return;

  const modal = document.createElement("div");
  modal.id = "franchiseModal";
  modal.className =
    "fixed inset-0 bg-black/40 flex items-center justify-center z-50";

  modal.innerHTML = `
        <div class="p-5 rounded-xl bg-white flex flex-col items-center justify-center relative">
            
            <button id="closeModalButton" class="absolute top-2 right-3 font-bold text-gray-500">
                ×
            </button>

            <div class="flex flex-col items-center justify-center">
                <p class="text-blue-600 text-[10px] font-semibold">
                    VALOR DA FRANQUIA:
                </p>
                <h2 id="franchiseValue" class="font-bold text-[18px] text-blue-800">
                    ${value}
                </h2>
            </div>

            <div class="flex flex-col items-center justify-center gap-2 mt-4">
                <button id="copyScriptButton" class="bg-blue-700 p-3 rounded-xl w-52 text-white font-bold hover:bg-blue-800 transition-all flex items-center gap-1 justify-center">
                    <img src="images/copy_icon.png" alt="Copy" class="w-6">
                    Copiar script
                </button>

                <a id="newSimulationButton" href="/" class="w-52 p-3 bg-gray-300 text-gray-600 font-bold hover:bg-gray-400 text-center rounded-xl transition-all">
                    Novo calculo
                </a>
            </div>

        </div>
    `;

  document.body.appendChild(modal);
  modalEventHandler(modal, scriptMessage);
};

const closeModal = (modal) => {
  modal.remove();
};

const modalEventHandler = (modal, scriptMessage) => {
  const closeButton = modal.querySelector("#closeModalButton");
  const copyScriptButton = modal.querySelector("#copyScriptButton");

  copyScriptButton.addEventListener("click", () => {
    copyScript(scriptMessage);
  })

  closeButton.addEventListener("click", () => {
    closeModal(modal);
  });

  modal.addEventListener("click", (event) => {
    if (event.target === modal) {
      closeModal(modal);
    }
  });
};

franchiseForm.addEventListener("submit", (e) => {
  e.preventDefault();

  const formData = getFormValues();
  const newFipe = fipeValueHandler(formData.fipeValue, formData.fipePercentage);
  const franchiseValue = formatToBRL(
    franchiseValueHandler(
      newFipe,
      formData.fipePercentage,
      formData.vehicleType,
      formData.isFirstFranchise,
    ),
  );

  const message = scriptHandler(
    franchiseValue,
    formData.fipePercentage,
    formData.fipeValue,
  );

  generateModal(franchiseValue, message);
});

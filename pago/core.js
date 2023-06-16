const mp = new MercadoPago("TEST-ee10fc35-6c13-4ede-bf9d-3575251ec436", {
  locale: "es-AR",
});

const initialize = () => {
  const cardNumberElement = mp.fields
    .create("cardNumber", {
      placeholder: "1234 1234 1234 1234",
    })
    .mount("formCheckout__cardNumber");

  const expirationDateElement = mp.fields
    .create("expirationDate", {
      placeholder: "MM/YY",
    })
    .mount("formCheckout__expirationDate");
  const securityCodeElement = mp.fields
    .create("securityCode", {
      placeholder: "123",
    })
    .mount("formCheckout__securityCode");

  (async function getIdentificationTypes() {
    try {
      const identificationTypes = await mp.getIdentificationTypes();
      const identificationTypeElement = document.getElementById(
        "formCheckout__identificationType"
      );
      createSelectOptions(identificationTypeElement, identificationTypes);
    } catch (e) {
      return console.error("Error getting identificationTypes: ", e);
    }
  })();

  function createSelectOptions(
    elem,
    options,
    labelsAndKeys = { label: "name", value: "id" }
  ) {
    const { label, value } = labelsAndKeys;

    elem.options.length = 0;

    const tempOptions = document.createDocumentFragment();

    options.forEach((option) => {
      const optValue = option[value];
      const optLabel = option[label];

      const opt = document.createElement("option");
      opt.value = optValue;
      opt.textContent = optLabel;

      tempOptions.appendChild(opt);
    });

    elem.appendChild(tempOptions);
  }
  async function updateInstallments(paymentMethod, bin) {
    try {
      const installments = await mp.getInstallments({
        amount: document.getElementById("transactionAmount").value,
        bin,
        paymentTypeId: "credit_card",
      });
      const installmentOptions = installments[0].payer_costs;
      const installmentOptionsKeys = {
        label: "recommended_message",
        value: "installments",
      };
      createSelectOptions(
        installmentsElement,
        installmentOptions,
        installmentOptionsKeys
      );
    } catch (error) {
      console.error("error getting installments: ", e);
    }
  }
  async function updateIssuer(paymentMethod, bin) {
    const { additional_info_needed, issuer } = paymentMethod;
    let issuerOptions = [issuer];

    if (additional_info_needed.includes("issuer_id")) {
      issuerOptions = await getIssuers(paymentMethod, bin);
    }

    createSelectOptions(issuerElement, issuerOptions);
  }

  async function getIssuers(paymentMethod, bin) {
    try {
      const { id: paymentMethodId } = paymentMethod;
      return await mp.getIssuers({ paymentMethodId, bin });
    } catch (e) {
      console.error("error getting issuers: ", e);
    }
  }

  const paymentMethodElement = document.getElementById("paymentMethodId");
  const issuerElement = document.getElementById("formCheckout__issuer");
  const installmentsElement = document.getElementById(
    "formCheckout__installments"
  );

  const issuerPlaceholder = "Banco emisor";
  const installmentsPlaceholder = "Cuotas";

  let currentBin;
  cardNumberElement.on("binChange", async (data) => {
    const { bin } = data;
    try {
      if (!bin && paymentMethodElement.value) {
        clearSelectsAndSetPlaceholders();
        paymentMethodElement.value = "";
      }

      if (bin && bin !== currentBin) {
        const { results } = await mp.getPaymentMethods({ bin });
        const paymentMethod = results[0];

        paymentMethodElement.value = paymentMethod.id;
        updatePCIFieldsSettings(paymentMethod);
        updateIssuer(paymentMethod, bin);
        updateInstallments(paymentMethod, bin);
      }

      currentBin = bin;
    } catch (e) {
      console.error("error getting payment methods: ", e);
    }
  });

  function clearSelectsAndSetPlaceholders() {
    clearHTMLSelectChildrenFrom(issuerElement);
    createSelectElementPlaceholder(issuerElement, issuerPlaceholder);

    clearHTMLSelectChildrenFrom(installmentsElement);
    createSelectElementPlaceholder(
      installmentsElement,
      installmentsPlaceholder
    );
  }

  function clearHTMLSelectChildrenFrom(element) {
    const currOptions = [...element.children];
    currOptions.forEach((child) => child.remove());
  }

  function createSelectElementPlaceholder(element, placeholder) {
    const optionElement = document.createElement("option");
    optionElement.textContent = placeholder;
    optionElement.setAttribute("selected", "");
    optionElement.setAttribute("disabled", "");

    element.appendChild(optionElement);
  }

  // Este paso mejora las validaciones de cardNumber y securityCode
  function updatePCIFieldsSettings(paymentMethod) {
    const { settings } = paymentMethod;

    const cardNumberSettings = settings[0].card_number;
    cardNumberElement.update({
      settings: cardNumberSettings,
    });

    const securityCodeSettings = settings[0].security_code;
    securityCodeElement.update({
      settings: securityCodeSettings,
    });
  }

  return { cardNumberElement, expirationDateElement, securityCodeElement };
};

async function createCardToken(event) {
  try {
    const tokenElement = document.getElementById("token");
    if (!tokenElement.value) {
      event.preventDefault();
      const token = await mp.fields.createCardToken({
        cardholderName: document.getElementById("formCheckout__cardholderName")
          .value,
        identificationType: document.getElementById(
          "formCheckout__identificationType"
        ).value,
        identificationNumber: document.getElementById(
          "formCheckout__identificationNumber"
        ).value,
      });
      tokenElement.value = token.id;
      console.log(tokenElement.value);
    }
  } catch (e) {
    return e;
  }
}

const formContainer = document.querySelector("#invoiceContainer");
url = window.location.href;

document.addEventListener('DOMContentLoaded', (event) => {
    fetch("/pedaleJoyeuse/Invoice/dataProduct", {
        method: "GET",
        headers: { "Content-Type": "application/json" },
    })
        .then(function (response) {
            return response.json();
        })
        .then(function (response) {
            // console.log(response);
            const selectContainer = document.createElement("div");
            selectContainer.classList.add("d-flex", "justify-content-evenly", "m-2");
            const selectEl = document.createElement("select");
            selectEl.classList.add("selector", "form-select", "w-25");
            selectContainer.appendChild(selectEl);
            const optionFirstEl = document.createElement("option");
            optionFirstEl.innerText = "Selectionnez un produit";
            selectEl.appendChild(optionFirstEl);
            formContainer.appendChild(selectContainer);
            const inputContainer = document.createElement("div");
            inputContainer.classList.add("w-50");
            const input = document.createElement("input");
            inputContainer.appendChild(input);
            input.classList.add("numberOfProducts", "form-control");
            input.type = "number";
            input.name = "numberOfProducts";
            input.placeholder = "Nombre d'articles";
            selectContainer.appendChild(inputContainer);

            var i = 1;

            response.forEach(function (element) {
                const optionEl = document.createElement("option");
                selectEl.appendChild(optionEl);
                optionEl.value = i;
                optionEl.innerText = element.name;
                i++;
            })
        })
        .catch(function (error) {
            console.log(error);
        });
});




console.log('coucou');
const FORMCONTAINER = document.querySelector("#invoiceContainer");

document.addEventListener('DOMContentLoaded', (event) => {
    fetch("/pedaleJoyeuse/Invoice/dataProduct", {
        method: "GET",
        headers: { "Content-Type": "application/json" },
    })
        .then(function (response) {
            return response.json();
        })
        .then(function (response) {
            console.log(response);
        })
        .catch(function (error) {
            console.log(error);
        })
});



let produto = document.getElementById("produto");
let tempo = document.getElementById("time");
let total = document.getElementById("total");

produto.addEventListener("change", () => {
    let optionSelecionada = produto.options[produto.selectedIndex]; 
    let pricePerHour = parseFloat(optionSelecionada.dataset.totalhora); 

    total.value = "";
    tempo.value = "";

    tempo.addEventListener("input", () => {
        let formatTime = tempo.value.replace(",", "."); // Garante que vírgula também funcione
        let totalHoras = 0;

        if (formatTime.includes(".")) {
            let [horas, minutos] = formatTime.split(".").map(Number); 
            minutos = (minutos / 60); // Converte minutos para fração decimal correta
            totalHoras = horas + minutos; 
        } else {
            totalHoras = parseFloat(formatTime);
        }

        let sum = totalHoras * pricePerHour;
        total.value = sum.toFixed(2);
    });
});

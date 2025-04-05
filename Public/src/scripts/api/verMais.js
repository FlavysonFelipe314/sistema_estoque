let modalInfo = document.getElementById("modalInfo");
let activeInfo = document.querySelectorAll(".active-info");
let dados = document.querySelector(".dados");
let closeInfo = document.getElementById("close-info");

async function getInfos(id){
    const url = `http://localhost/orlaclub/compras/${id}`;

    dados.innerHTML = ""

    axios.get(url)
    .then(response => {
        let data = response.data;
        console.log(data)

        for(let chave in data){
            dados.innerHTML += `
                <h4>${chave}</h4>
                <input class="input-gray" value="${data[chave]}" disabled><br><br>
            `
        }

    })
    .catch(err => {
        console.log("algo deu errado" + err)
    })

}

activeInfo.forEach((item,index) => {
    activeInfo[index].addEventListener("click", () => {
        modalInfo.classList.add("slide-modal");

        let id = activeInfo[index].value;
        getInfos(id)
    })
})



closeInfo.addEventListener("click", () => {
    modalInfo.classList.remove("slide-modal")
})


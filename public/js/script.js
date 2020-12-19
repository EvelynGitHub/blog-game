
window.onload = function () {
    console.clear()
    readAll()
}

function create(params) {
    console.log("Create")
    ajax({
        method: "POST",
        url: "api/game/",
        data: params,
        before() { },
        success(e) {
            console.log(e)
        },
        error() { },
        complete() {
            console.log("Complete Create")
        }

    })
}

function readAll() {
    console.log("Ler Todos")

    ajax({
        method: "GET",
        url: "api/game/",
        data: null,
        before() { },
        success(e) {
            if (e.list.length == 0) return;

            posts = document.querySelector(".box-posts")
            posts.innerHTML = ""

            console.log("Success read:", e.list)

            for (let i = 0; i < e.list.length; i++) {
                html = `<div class="item-post">
                            <div class="img-post">
                                <img src="${(e.list[i].videoId == "" ? "./img/console.png" : e.list[i].videoId)}" alt="Imagem do Poste">
                            </div>
                            <h4>${e.list[i].title}</h4>
                            <div class="info-post">                                                    
                                <button type="submit" class="btn btn-warning" onclick="update(${e.list[i].id})">Editar</button>
                                <button type="submit" class="btn" onclick="readById(${e.list[i].id})">Visualiza</button>
                                <button type="submit" class="btn btn-danger" onclick="deleteArticle(${e.list[i].id})">Deletar</button>
                            </div >
                        </div > `
                posts.innerHTML += html;

            }


        },
        error() { },
        complete() {
            console.log("Complete read")
        }

    })
}

function readById(id) {
    console.log("Ler por ID: ", id)
}

function update(params) {
    console.log("Update")
}
function deleteArticle(id) {
    console.log("delete")
}

function ajax(params) {

    $.ajax({
        type: params.method,
        url: params.url,
        data: params.data,
        dataType: "json",
        beforeSend: params.before,
        success: params.success,
        error: params.error,
        complete: params.complete
    });

    console.log("Entrou no Ajax")
}


//=====================================
document.getElementById("newPost").addEventListener("click", function (e) {
    e.preventDefault()
    openModal()
}, false);

document.getElementById("btnClose").addEventListener("click", function (e) {
    e.preventDefault();
    closeModal()
}, false);

document.getElementById("btnSave").addEventListener("click", function (e) {
    e.preventDefault();

    obj = {
        id: document.getElementById("id").value,
        title: document.getElementById("title").value,
        description: document.getElementById("description").value,
        videoId: document.getElementById("videoId").value,
    }

    if (obj.id == "") {
        create(obj)
    } else {
        update(obj)
    }

}, false);

function openModal() {
    modal = document.querySelector(".modal-container")
    modal.classList.remove("hidden")
}
function closeModal() {
    modal = document.querySelector(".modal-container")
    modal.classList.add("hidden")
    clearModal()
}

function clearModal() {
    document.querySelector(".modal-container .modal form").reset()
    document.querySelector(".modal-container .modal .modal-header").innerHTML = "Faça uma Sujestão de Post"
}
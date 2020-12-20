
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
        before() { document.getElementById("btnSave").disable = true },
        success(e) {
            alert(e.result)

            readAll()
        },
        error(e) { console.log("EROOOO:", e.result) },
        complete() {
            console.log("Complete Create")
            document.getElementById("btnSave").disable = false
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

            for (let i = 0; i < e.list.length; i++) {
                html = `<div class="item-post">
                            <div class="img-post">
                                <img src="${(e.list[i].videoId == "" ? "./img/console.png" : e.list[i].videoId)}" alt="Imagem do Poste">
                            </div>
                            <h4>${e.list[i].title}</h4>
                            <div class="info-post">                                                    
                                <button type="submit" class="btn btn-warning" onclick="openUpdate(${e.list[i].id})">Editar</button>
                                <button type="submit" class="btn" onclick="openView(${e.list[i].id})">Visualiza</button>
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
    let res = "";

    let = ajax({
        method: "GET",
        url: "api/game/" + id,
        data: {},
        before() { },
        success(e) {
            res = e
        },
        error(e) { console.log("EROOOO:", e.result) },
        complete() {
        }

    })

    return res
}

function update(params) {

    ajax({
        method: "PUT",
        url: "api/game/" + params.id,
        data: params,
        before() { document.getElementById("btnSave").disable = true },
        success(e) {
            alert(e.result)

            readAll()
            console.log(e)
        },
        error(e) { console.log("EROOOO:", e.result) },
        complete() {
            console.log("Complete Create")
            document.getElementById("btnSave").disable = false
        }

    })
}
function deleteArticle(id) {
    console.log("delete")

    if (!confirm("Deseja realmente excluir este port?"))
        return

    ajax({
        method: "DELETE",
        url: "api/game/" + id,
        data: {},
        before() { },
        success(e) {
            alert(e.result)
            console.log(e)
        },
        error(e) { console.log("EROOOO:", e.result) },
        complete() {
            console.log("Complete DELETE")
        }

    })

    readAll()
}

function ajax(params) {

    $.ajax({
        type: params.method,
        url: params.url,
        data: params.data,
        async: false,
        dataType: "json",
        beforeSend: params.before,
        success: params.success,
        error: params.error,
        complete: params.complete
    });

    console.log("Entrou no Ajax")
}


//=================EVENTS====================
document.getElementById("newPost").addEventListener("click", function (e) {
    e.preventDefault()
    CKEDITOR.instances['description'].setData("");
    openModal()
}, false);

document.getElementById("btnClose").addEventListener("click", function (e) {
    e.preventDefault();
    closeModal()
}, false);
document.getElementById("btnCloseView").addEventListener("click", function (e) {
    e.preventDefault();
    closeModal(".modal-view")
}, false);

document.getElementById("btnSave").addEventListener("click", function (e) {
    e.preventDefault();
    console.log("SALVO")

    let article = CKEDITOR.instances['description'].getData();

    obj = {
        id: document.getElementById("id").value,
        title: document.getElementById("title").value,
        description: article, //document.getElementById("description").value,
        videoId: document.getElementById("videoId").value,
    }

    if (obj.id == "") {
        console.log("Sem ID chama create()")
        create(obj)
    } else {
        console.log("Com ID chama update()")
        update(obj)
    }

}, false);

function openModal(modal = ".modal-container") {
    modal = document.querySelector(modal)
    modal.classList.remove("hidden")
}
function closeModal(modal = ".modal-container") {
    modal = document.querySelector(modal)
    modal.classList.add("hidden")
    clearModal()
}

function clearModal() {
    document.querySelector(".modal-container .modal form").reset()
    document.querySelector(".modal-container .modal .modal-header").innerHTML = "Faça uma Sujestão de Post"
    document.getElementById("id").value = ""
}

function openUpdate(id) {
    console.log("Update")
    document.querySelector(".modal-container .modal .modal-header").innerHTML = "EDITAR"
    openModal()

    obj = readById(id).result

    document.getElementById("id").value = obj.id
    document.getElementById("title").value = obj.title

    document.getElementById("videoId").value = obj.videoId

    CKEDITOR.instances['description'].setData(obj.description);
    console.log("Entrou openUpdate")

}

function openView(id) {
    console.log("OPEN VIEW")
    openModal(".modal-view")

    post = readById(id).result

    document.querySelector(".modal-view .modal .modal-header").innerHTML = post.title
    document.querySelector(".modal-view .modal .modal-body img").src = post.videoId

    let des = document.querySelector(".modal-view .modal .modal-body article #article")

    des.innerHTML = ""
    des.insertAdjacentHTML("beforeend", post.description)

}

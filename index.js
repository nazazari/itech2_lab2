

if (sessionStorage.getItem("from") !== null) {
    document.getElementById("from").value = parseInt(sessionStorage.getItem("from"))
}

if (sessionStorage.getItem("to") !== null) {
    document.getElementById("to").value = parseInt(sessionStorage.getItem("to"))
}

function handleClick() {
    let res = parseInt(document.getElementById("from").value);
    if(!isNaN(res)){
        sessionStorage.setItem("from", res.toString());
    }

    res = parseInt(document.getElementById("to").value);
    if(!isNaN(res)){
        sessionStorage.setItem("to", res.toString());
    }
}
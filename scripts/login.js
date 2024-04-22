
document.querySelector('form').addEventListener('submit', sendLogin);

async function sendLogin(e) {
    e.preventDefault();

    const formEl = document.querySelector('form');
    const data = new FormData(formEl);
    const json = Object.fromEntries(data.entries());
    console.log(json);

    const alertEl = document.querySelector(`.alert`);
    alertEl.classList.add('hidden');
    alertEl.innerHTML = "";

    const response = await fetch('./login.php', {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
        },
        body: JSON.stringify(json),
    })

    const body = await new Response(response.body).text();
    if(body == "ok") {
        localStorage.setItem("username",  json.name);
        window.location.pathname = "/"; 
    } else if(body == "no") {
        alertEl.classList.remove('hidden');
        alertEl.innerHTML = "Die Kombination von Passwort und Nutzername ist falsch oder existiert nicht.";
    } else {
        alertEl.classList.remove('hidden');
        alertEl.innerHTML = "Es ist ein Fehler aufgetreten.";
    }
    
}
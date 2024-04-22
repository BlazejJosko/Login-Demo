
document.querySelector('form').addEventListener('submit', sendRegister);

async function sendRegister(e) {
    e.preventDefault();

    const formEl = document.querySelector('form');
    const data = new FormData(formEl);
    const json = Object.fromEntries(data.entries());
    console.log(json);

    document.querySelectorAll(`input ~ small`).forEach((elem) => {
        elem.classList.add('hidden');
        elem.innerHTML = "";
    })

    const response = await fetch('./register.php', {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
        },
        body: JSON.stringify(json),
    })

    const bodyRaw = await new Response(response.body).text();
    const body = JSON.parse(bodyRaw);

    if(body == false) window.location.pathname = "/login.html"; 

    for(const key in body) {
        const warningEl = document.querySelector(`input[name="${key}"] ~ small`);
        warningEl.classList.toggle("hidden");
        warningEl.innerHTML = body[key];
        console.log(warningEl);
    }
}
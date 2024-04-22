const user = localStorage.getItem("username");

if(!user) {
    window.location.pathname = "/login.html";
}

document.querySelector('span#name').innerHTML = user;

document.querySelector('button').addEventListener('click', () => {
    localStorage.clear();
    window.location.pathname = "/login.html";
})
function amosarFormularioLogin() {
    const formulario = document.getElementById("iniciar-session");
    const iniciarSession = document.getElementById("form-iniciar-session");
    iniciarSession.addEventListener("click", function(){
        formulario.style.display = "block";
    });
}

function agacharFormularioLogin() {
    const formulario = document.getElementById("iniciar-session");
    addEventListener("click",function(){
        formulario.style.display = "none";
    });
}
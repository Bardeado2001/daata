<!-- SCRIPTS -->

<!--IFRAME-->
<script>
    function carregarPagina(pagina) {
        var dinamicContainer = document.getElementById("dinamic");
        dinamicContainer.innerHTML = "";
        var iframe = document.createElement("iframe");
        iframe.src = pagina || 'chamadas/projetos.php'; // Carrega a página inicial se nenhum argumento for fornecido
        iframe.style.border = "none";
        dinamicContainer.appendChild(iframe);
    }

    // Chama carregarPagina para exibir a página inicial quando o documento é carregado
    document.addEventListener("DOMContentLoaded", function () {
        carregarPagina(); // Carrega a página inicial por padrão
    });
</script>


<script>
    // Função para validar o formulário
    function validarForm() {
        var nome = document.getElementById("nome").value;
        var apelido = document.getElementById("apelido").value;
        var telemovel = document.getElementById("telemovel").value;
        var email = document.getElementById("email").value;
        var data = document.getElementById("data").value;
        var motivo = document.getElementById("motivo").value;

        if (nome === "" || apelido === "" || telemovel === "" || email === "" || data === "" || motivo === "") {
            alert("Por favor, preencha todos os campos.");
            return false; // Impede o envio do formulário se algum campo estiver em branco.
        }
        return true;
    }
</script>

<script>
/*
    document.addEventListener("DOMContentLoaded", function () {
        setTimeout(function () {
            alert("Bem-vindo ao Janio Entertainment!");
        }, 5000);
    });
*/
</script>

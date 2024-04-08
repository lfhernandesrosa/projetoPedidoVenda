/*
 * Função para logout
 */
function logout() {
    window.location.href = "../util/logout.php";
}

/*
 * Função para retornar a página anterior
 */
function goBack() {
    window.history.back();
}

/*
 * Função para formatar Número
 */
function formatarPreco(preco) {
// Converte para número e verifica se é um número válido
    preco = parseFloat(preco);
    if (isNaN(preco)) {
        return "Preço inválido";
    }
    return preco.toFixed(2).replace(".", ",");
}

/*
 * Adicionar zero a esquerda
 */
function addZerosEsquerda(numero, tamanho) {
    return numero.toString().padStart(tamanho, '0');
}
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciamento de Tarefas</title>
    <link rel="stylesheet" href="../Public/css/index.css">
    <script src="../node_modules/jquery/dist/jquery.min.js"></script>
</head>

<body>
    <div class="my-loader">
        <img src="../Public/img/loader.gif">
    </div>
    <div class="container" id="container">
        <div class="form-container sign-up-container">
            <form id="form-cadastro" action="">
                <h1 id="h1-criar-conta">Crie sua conta</h1>

                <div class="social-container">
                </div>
                <div style="display: none;" class="message-error">
                    <span class="span-message">Preencha todos os campos!</span>
                </div>
                <label class="label-form">Nome</label>
                <input maxlength="50" name="name" type="text" placeholder="Nome" />
                <label class="label-form">Cpf</label>
                <input name="document" type="text" maxlength="11" placeholder="Cpf" />
                <label class="label-form">Idade</label>
                <input name="age" type="number" placeholder="Idade" />
                <label class="label-form">E-mail</label>
                <input maxlength="80" name="email" type="text" placeholder="Email" />
                <label class="label-form">Senha</label>
                <input name="password" type="password" placeholder="Senha" />
                <button onclick="signUp()" type="button" id="cadastrar" class="mybtn">Cadastrar-se</button>
            </form>
        </div>
        <div class="form-container sign-in-container">
            <form action="">
                <h1>Tarefas</h1>
                <div class="social-container">
                </div>
                <span class="span-aux">Faça login com a sua conta.</span>
                <div style="display: none;margin-top: 1.3rem;" class="message-error">
                    <span class="span-message">Preencha todos os campos!</span>
                </div>
                <input type="email" placeholder="Email" />
                <input type="password" placeholder="Senha" />
                <a href="#">Esqueceu sua senha?</a>
                <button class="mybtn">Entrar</button>
            </form>
        </div>
        <div class="overlay-container">
            <div class="overlay">
                <div class="overlay-panel overlay-left">
                    <h1>Seja bem vindo!</h1>
                    <p>Mantenha sua organização através do melhor gerenciador de tarefas.</p>
                    <button class="ghost" id="signIn">Entrar</button>
                </div>
                <div class="overlay-panel overlay-right">
                    <h1 class="teste22">Olá meu amigo!</h1>
                    <p>Crie sua conta sem burocracia, seja eficiente e organizado através do nosso sistema.</p>
                    <button class="ghost" id="signUp">Criar Conta</button>
                </div>
            </div>
        </div>
    </div>
    <script src="../Public/js/index.js" type="text/javascript"></script>
</body>

</html>
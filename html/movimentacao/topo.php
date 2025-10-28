<?php
    if ($exibirTopo){
    ?>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-8"><h3 class="azul">Sistemas de visitas - Entrada e Saída</h3></div>
            </div>
        </div>
    <?php
    }
?>

<p><b>Operador: </b> <?php echo $_SESSION['usuNome']; ?><br>
<b>Unidade: </b><?php echo $_SESSION['uniNome']; ?><br>
<b>Portaria: </b><?php echo $_SESSION['porNome']; ?></p>

<nav class="navbar navbar-expand-lg navbar-dark fundo-azul">
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
        <div class="navbar-nav">
            <a class="nav-link text-white" href="index.php?action=inicio&control=movimentacao">Início</a>
            <span class="nav-link text-white"><b>|</b></span>
            <a class="nav-link text-white" href="index.php?action=empresas&control=empresa">Empresas</a>
            <span class="nav-link text-white"><b>|</b></span>
            <a class="nav-link text-white" href="index.php?action=novo&control=movimentacao">Movimentar Entrada</a>
            <span class="nav-link text-white"><b>|</b></span>
            <a class="nav-link text-white" href="index.php?action=logout">Sair</a>
        </div>
    </div>
</nav>
<h4 style="margin-top:5px"><?php echo $titulo; ?></h4>
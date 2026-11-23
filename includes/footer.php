<?php
$scripts = $scripts ?? [];
?>
    <footer class="rodape">
        <div class="container rodape-conteudo">
            <p>Este site é um clone feito para fins educacionais na disciplina de Desenvolvimento Web I, sem vínculo com a empresa original. Todos os dados são fictícios.</p>
            <p class="texto-auxiliar-sm">André Rigo, William Kunzler e Yasmin Zerbielli · <a href="<?= $raiz ?>admin/login.php">Área administrativa</a></p>
        </div>
    </footer>

    <script src="<?= $raiz ?>assets/js/lucide.min.js"></script>
    <script src="<?= $raiz ?>assets/js/main.js"></script>
    <?php foreach ($scripts as $script): ?>
        <script src="<?= $raiz ?>assets/js/<?= $script ?>.js"></script>
    <?php endforeach; ?>
</body>

</html>
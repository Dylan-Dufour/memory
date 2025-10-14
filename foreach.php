<?php foreach ($cards as $index => $card): ?>
    <?php  // Début du code PHP
        // Vérifier si la carte doit être affichée
        $isFlipped = in_array($index, $_SESSION["flipped"]);
    ?>

    <?php if ($card->found): ?>
        <!-- Carte trouvée définitivement -->
        <div class="card found"><?php echo $card->symbol; ?></div>
    <?php elseif ($isFlipped): ?>
        <!-- Carte retournée temporairement -->
        <div class="card"><?php echo $card->symbol; ?></div>
    <?php else: ?>
        <!-- Carte face cachée -->
        <a href="game.php?pairs=<?php echo $pairs; ?>&flip=<?php echo $index; ?>">
            <div class="card">?</div>
        </a>
    <?php endif; ?>
<?php endforeach; ?>

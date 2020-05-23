<?php
    session_start();
?>
<!DOCTYPE html>
<html>

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
        <link rel="stylesheet" href="assets/styles.css">
        <title>Analyser</title>
    </head>

    <body>

    <div id="first-layout">

        <div class="main-text">
            Convert Text to Tokens
        </div>

    </div>

    </body>

</html>


<form action="form_processor.php" method="post">
        <input type="text" placeholder="Input your text..." name="text">
        <label for="analyzer">Choose an analyzer:</label>
        <select id="analyzers" name="analyzer">
            <?php include 'constants.php' ?>
            <?php
                $sorted_analyzers = analyzers;
                ksort($sorted_analyzers);
            ?>
            <?php foreach($sorted_analyzers as $analyzer) {?>
            <option value="<?= $analyzer ?>"><?= ucfirst($analyzer); ?></option>
            <?php }?>
        </select>
        <input type="submit" style="width: 124px;">
    </form>

    <?php if ($_SESSION['is_analysed'] && !checkFileTimeout()) {?>
        <form method="post" action="download.php">
            <input type="submit" name="download" id="test" value="Download script" /><br/>
        </form>
    <?php }?>
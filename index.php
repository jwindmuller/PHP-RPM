<?php
$baseUrl = str_replace("?success", "", $_SERVER['REQUEST_URI']);
$errorMessage = "";
if (!empty($_POST)) {
    include "code/ProcessForm.php";
    $ProcessForm = new ProcessForm();
    $ProcessForm->go();
    $errorMessage = $ProcessForm->errorMessage();
    if ($errorMessage == "") {
        header('Location: .?success');
    }
}
?>
<html>
    <head>
        <link href="assets/css/bootstrap.css" rel="stylesheet">
        <link href="assets/css/custom.css" rel="stylesheet">
    </head>
    <body>
        <div class="container">
            <div class="header">
                <ul class="nav nav-pills pull-right">
                    <li><a href="setup.php">Help</a></li>
                    <li><a href="http://rpmsoftware.wordpress.com">API Documentation</a></li>
                    <li><a href="http://rpmsoftware.com">Rpm Software</a></li>
                </ul>
                <h3 class="text-muted">RPM Api Usage With PHP</h3>
            </div>

            <div class="jumbotron">
            <?php if (isset($_GET['success'])): ?>
                <h1>Thanks!</h1>
                <p>We have received your message.</p>
                <p><a class="btn btn-lg btn-success" href="<?php echo $baseUrl; ?>">Contact</a></p>
            <?php else: ?>
                <h1>Example Contact Form</h1>
                <p>This form will store the data in an RPM process!</p>
                <?php if (!empty($errorMessage)): ?>
                    <p class="error"><?php echo $errorMessage; ?></p>
                <?php endif ?>
                <form action="" method="POST">
                    <div class="input">
                        <label for="name">Name:</label>
                        <input type="text" name="name" value="<?php echo @$_POST['name']; ?>" />
                    </div>
                    <div class="input">
                        <label for="email">Email:</label>
                        <input type="text" name="email" value="<?php echo @$_POST['email']; ?>" />
                    </div>
                    <div class="input">
                        <label for="message">Your Message:</label>
                        <textarea name="message" id="message" cols="30" rows="5"><?php
                         echo @$_POST['message'];
                        ?></textarea>
                    </div>
                    <div class="input">
                        <input class="btn btn-lg btn-success" type="submit" value="Contact Us">
                    </div>
                </form>
            <?php endif ?>
            </div>

            <div class="footer">
                <p>&copy;2013 <a href="http://rpmsoftware.com/">RPM Software</a></p>
            </div>
        </div>
	</body>
</html>
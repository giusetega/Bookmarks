<?php
session_start();

$wbName = "";
$wbUrl = "";

if (isset($_POST['websiteUrl']) && isset($_POST['websiteName'])){

    // If name and url are "" or null the user must return here(index.php)
    $condName = ($_POST['websiteName'] == '' || $_POST['websiteName'] == null);
    $condUrl = ($_POST['websiteUrl'] == '' || $_POST['websiteUrl'] == null);
    
    // Redirects the user to the index.php id wbUrl or wbName are null or ""
    if ($condName || $condUrl){
        $errorMsg = "?error=Fill in all fields";
        // It acts kindalike a return
        header("Location: index.php".$errorMsg);
        echo $_GET['error'];
    } else {
        $wbName = $_POST['websiteName'];
        $wbUrl = $_POST['websiteUrl'];

        // Start a new session variable
        if (isset($_SESSION['bookmarks'])){
            // Add a new item inside the session variable $_SESSION['bookmarks']
            $_SESSION['bookmarks'][$wbName] = $wbUrl;
        } else {
            $_SESSION['bookmarks'] = array($wbName => $wbUrl);
        }
    }
}

// Delete just one bookmark
if (isset($_GET['action']) && $_GET['action'] == "delete"){
    unset($_SESSION['bookmarks'][$_GET['name']]);
}

// Delete all bookmarks and destroy session
if (isset($_GET['action']) && $_GET['action'] == "clear"){
    session_unset();
    session_destroy();
}

?>
<html>
    <head>
        <title> Bookmarker - PHP </title>
        <link rel="stylesheet" href="style.css">
        <script src="script.js"></script>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <h1> Your favourite websites</h1>
        
        <div id="error">
            <?php 
            if (isset($_GET['error'])){
                echo $_GET['error'];
            } 
            ?>
        </div>

        <div id="main-container">
            <div id="form-container">
                <form method="POST" name="" action="index.php">
                    <div>
                        <label for="websiteName"> Website name:</label>
                        <input type="text" id="websiteName" name="websiteName">
                    </div>
                    <div>
                        <label for="websiteUrl"> Website URL:</label>
                        <input type="text" id="websiteUrl" name="websiteUrl"><br>
                    </div>
                    <input type="submit" value="Add bookmark">
                </form>
            </div>

            <div id="bookmarks-container">
                <div>
<!--                    Print out the clear link only of there are bookmarks-->
                    <?php if(isset($_SESSION['bookmarks']) && count($_SESSION['bookmarks']) > 0) : ?>
                    <div id="clear"> 
                        <a href="index.php?action=clear">Clear all</a>
                    </div>
                    <?php endif; ?>

<!--                    Print out all the bookmarks -->
                    <?php if (isset($_SESSION['bookmarks'])) : ?>
                    <ul>
                        <?php foreach ($_SESSION['bookmarks'] as $name => $url) : ?>
                        <li>
                            <a href="<?php echo $url; ?>" target="_blank"><?php echo strtoupper($name); ?></a>
                            <a href="index.php?action=delete&name=<?php echo $name; ?>">[X]</a>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                    <?php endif; ?>
                </div>
            </div>
        </div>

    </body>
</html>
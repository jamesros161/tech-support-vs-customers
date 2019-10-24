<?php header("Connection: close"); ?>
<!DOCTYPE html>
<html lang="en">
<head>
 
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
 
    <!-- set the page title, for seo purposes too -->
    <title><?php echo isset($page_title) ? strip_tags($page_title) : "Store Front"; ?></title>
 
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.0/css/bootstrap.min.css" rel="stylesheet" media="screen" />
 
    <!-- admin custom CSS -->
    <link href="<?php echo $home_url . "../libs/css/players.css" ?>" rel="stylesheet" />
    
</head>
<body>
 
    <!-- include the navigation bar -->
    <?php include_once 'navigation.php'; ?>
 
    <!-- container -->
    <div class="container">
 
        <?php
        // if given page title is 'Login', do not display the title
        if($page_title!="Login" || $page_title!="Active Contact"){
        ?>
        <div class='col-md-12'>
            <div class="page-header">
                <?php if ($page_title !='Active Contact') {?>
                <h1><?php echo isset($page_title) ? $page_title : "The Code of a Ninja"; ?></h1>
                <?php } ?>
            </div>
        </div>
        <?php
        }
        ?>
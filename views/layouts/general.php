<?php 
  use core\Application;
 ?> 
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paste It</title>
    <meta name="subject" content="Paste It">
    <meta name="description" content="Paste It. Provide a simple way to share your code" > 
    <meta name="keywords" content="share code, paste code, copy code, share, code"/>
    <meta name="author" content=" Petrariu Iustin, Burca Rafael">
    
    
    <link rel="stylesheet" href="/styles/{{style}}.css">
    <link rel="stylesheet" href="/styles/menu.css">
    <link rel="stylesheet" href="/styles/footer.css">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
    <script src="./scripts/{{script}}.js"></script>


</head>

<body itemscope itemtype="http://schema.org/WebPage" >
    <nav itemscope itemtype="http://schema.org/SiteNavigationElement" class="navbar">
        <div class="content">
            <div class="logo">
                <a href="/home">Paste It</a>
            </div>
            <ul class="menu-list">
                <li><div class="icon cancel-btn"><i class="fas fa-times"></i></div></li>
                <li><a href="/faq">FAQ</a></li>
                <li><a href="/contact">Contact</a></li>
                <li><a href="/signin">Sign in</a></li>
                <li><a href="/signup">Sign up</a></li>
            </ul>
            <div class="icon menu-btn">
                <i class="fas fa-bars"></i>
            </div>
        </div>
    </nav>
    <div class="banner"></div>


    <?php if(Application::$app->session->getFlash('success')): ?>

        <div class="alert"> 
            <?php echo Application::$app->session->getFlash('success') ?>
        </div>

    <?php endif; ?>


     
    {{content}}

    <div class="footer">   
        <p>Copyright &copy; Paste IT</p>
        <p>Scholarly HTML <a href="./scholarly.html">HERE</a></p>
    </div>
</body>
</html>


































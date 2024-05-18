<!DOCTYPE html>
<html>
<head>
    <title>{{ $pageTitle ?? 'Sendiri Bake' }}</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/custstyle.css') }}">
</head>
<body>
    <div>   
        <header class="header-line"><h1>Sendiri Bake</h1></header>
    </div>
    <!-- Navigation Bar with Clickable Categories -->
    <div class="cust-nav">
        <ul>
            <li><a href="#creampuffs">Creampuff and Eclairs</a></li>
            <li><a href="#cupcakes">Cupcakes</a></li>
            <li><a href="#munchies">Munchies</a></li>
            <li><a href="#cakes">Cakes</a></li>
        </ul>
    </div>
    
    <!-- Content Area -->
    <section id="creampuffs"> 
        <div class="main" style="padding-top: 50px;">
            <!-- Content for Creampuff and Eclairs -->
        </div>
    </section>
    
    <section id="cupcakes"> 
        <div class="main" style="padding-top: 50px;">
            <!-- Content for Cupcakes -->
        </div>
    </section>
    
    <section id="munchies"> 
        <div class="main" style="padding-top: 50px;">
            <!-- Content for Munchies -->
        </div>
    </section>
    
    <section id="cakes"> 
        <div class="main" style="padding-top: 50px;">
            <!-- Content for Cakes -->
        </div>
    </section>
</body>
</html>

<!doctype html>
<html lang="<?php echo $language; ?>">
<head>
    <meta charset="utf-8">
    <title>Travelholic - Find your next trip!</title>
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <style type="text/css"><?php 
        print css("//fonts.googleapis.com/css?family=Raleway:300,500,700",true);
        print css("//fonts.googleapis.com/css?family=Roboto:300,500,700",true);
    ?></style>
    <link rel="stylesheet" href="<?php print less("styles","main.less");?>">
</head>
<body itemscope itemtype="http://schema.org/WebPage" class="not-signed-in">
    <div id="menu">
        <div class="menu-toggles">
            <div class="menu-toggle menu-open">
                <button type="button" class="btn-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 512 512">
                        <path d="M48 272l416 0 0-32-416 0z m0 96l416 0 0-32-416 0z m0-192l416 0 0-32-416 0z"></path>
                    </svg>
                </button>
            </div>
            
            <div class="menu-toggle menu-close">
                <button type="button" class="btn-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 512 512">
                        <path d="M475 453l-22 22-197-197-197 197-22-22 197-197-197-197 22-22 197 197 197-197 22 22-197 197z"></path>
                    </svg>
                </button>
            </div>
        </div>
        
        <div class="menu-container">
            <nav class="header-nav" itemscope="" itemtype="http://schema.org/SiteNavigationElement">
                <ul class="header-nav-list">
                    <li><a href="#" class='active'>{menu.places{Places}}</a></li>
                    <li><a href="#">{menu.accommodations{Accommodations}}</a></li>
                    <li><a href="#">{menu.restaurants{Eat & drink}}</a></li>
                    <li><a href="#">{menu.todo{Things to do}}</a></li>
                    <li><a href="#">{menu.deals{Travel deals}}</a></li>
                </ul>
            </nav>
        </div>
    </div>
    
    <header id="header">
        <div class="header-brand" itemscope="" itemprop="provider" itemtype="http://schema.org/Organization" role="button" tabindex="0">
            <a href="/" class="header-link">
                <span class="header-brand-logo"><img src="/images/logo.svg" alt="{brand.name}" width="32" itemprop="logo"></span>
                <span class="header-brand-name" itemprop="name">{brand.name}</span>
            </a>
        </div>
        
        <div class="header-nav">
            <ul class="header-nav-list">
                <li><a href="#" class='active'>{menu.places{Places}}</a></li>
                <li><a href="#">{menu.accommodations{Accommodations}}</a></li>
                <li><a href="#">{menu.restaurants{Eat & drink}}</a></li>
                <li><a href="#">{menu.todo{Things to do}}</a></li>
                <li><a href="#">{menu.deals{Travel deals}}</a></li>
            </ul>
        </div>
    </header>
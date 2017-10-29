<!doctype html>
<html lang="{page.language{en}}">
<head>
    <meta charset="utf-8">
    <title>{page.title{Travelholic - Find your next trip!}}</title>
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="description" content="{page.description{Let Travelholic keep you updated with all relevant travels matched to your preferences.}}">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <script src="//ajax.googleapis.com/ajax/libs/webfont/1.6.26/webfont.js"></script>
    <script>WebFontConfig={google:{families:['Raleway:n4','Roboto:n4,n7']}}</script>
    <link rel="stylesheet" href="<?=$this->less("styles/main.less");?>">
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
<?php

$menu = (function() {
    return "
                    <li><a href='#'>{menu.deals{Deals}}</a></li>
                    <li><a href='#' class='active'>{menu.places{Places}}</a></li>
                    <li><a href='#'>{menu.accommodations{Accommodations}}</a></li>
                    <li><a href='#'>{menu.restaurants{Eat & drink}}</a></li>
                    <li><a href='#'>{menu.todo{Things to do}}</a></li>
                    <li><a href='#'>{menu.flights{Flights}}</a></li>
    ";
})();

echo $menu;

?>
                </ul>
            </nav>
        </div>
    </div>
    
    <header id="header">
        <div class="header-brand" itemscope="" itemprop="provider" itemtype="http://schema.org/Organization" role="button" tabindex="0">
            <a href="/" class="header-link">
                <img src="/images/logo.svg" alt="{brand.name}" width="32" itemprop="logo" class="header-brand-logo" align="top">
                <span class="header-brand-name" itemprop="name">{brand.name}</span>
            </a>
        </div>
        
        <div class="header-nav">
            <ul class="header-nav-list">
                <?=$menu?>
                
                <button type="button" class="btn-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 512 512">
                        <path d="M96 288l128 0 0 128-128 0z m13 115l102 0 0-102-102 0z m179 13l0-128 128 0 0 128z m115-115l-102 0 0 102 102 0z m-307-205l128 0 0 128-128 0z m13 115l102 0 0-102-102 0z m179-115l128 0 0 128-128 0z m13 115l102 0 0-102-102 0z"></path>
                    </svg>
                </button>
            </ul>
        </div>
        
        <div class="header-icons">
            <button type="button" class="btn-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 512 512" class="rotate180 flip">
                    <path d="M256 369c-58 0-59-49-59-49l13 0c0 1 0 36 46 36 45 0 46-32 46-36l0-1c1-2 5-22-27-48-25-21-25-48-25-66l12 0c0 18 0 38 21 56 34 28 33 54 32 59 0 6-4 49-59 49z m-6-190l12 0 0-13-12 0z m6 250c-95 0-173-78-173-173 0-95 78-173 173-173 95 0 173 78 173 173 0 95-78 173-173 173z m0-333c-88 0-160 72-160 160 0 88 72 160 160 160 88 0 160-72 160-160 0-88-72-160-160-160z"></path>
                </svg>
            </button>
            
            <button type="button" class="btn-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 512 512" class="rotate180">
                    <path d="M426 83l0 42c0 2 2 23-18 39-7 8-20 10-33 13-15 2-32 6-46 19 0 0-10 6-12 16-1 8 3 13 11 22 23 30 34 59 34 89 0 58-47 106-106 106-59 0-106-49-106-106 0-27 11-56 33-87l0 0c8-11 10-20 9-27-1-11-10-16-12-17-11-12-28-15-44-19-13-3-25-7-34-13-19-15-18-37-18-37l0-40z m-317 68c6 5 16 8 28 10 17 3 36 8 50 21 0 1 14 9 17 24 2 11-1 23-10 36l1 0c-21 28-32 56-32 81 0 51 42 93 93 93 51 0 93-42 93-93 0-27-10-54-32-81-9-12-15-22-12-33 2-14 14-23 16-25 16-14 35-18 51-21 12-3 22-6 29-11 14-11 12-27 12-28l0-27-317 0 0 27c0 0-1 16 13 27z"></path>
                </svg>
            </button>
        </div>
    </header>
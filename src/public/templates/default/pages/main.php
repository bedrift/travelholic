<?php

include("header.php");

?>

<div id="page" class="<?=(isset($addlisttopageclass)&&$addlisttopageclass)?"list":""?>">
    <div id="container">
        <div id="toolbox">
            <div class="toolbox-menu">
                <div class="toolbox-menu-item">
                    <div class="toolbox-menu-item-toggle toolbox-menu-item-search toolbox-menu-item-search-open">
                        <button type="button" class="btn-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 512 512" class="rotate90">
                                <path d="M475 59l-149 149c26 30 42 70 42 112 0 98-78 176-176 176-98 0-176-78-176-176 0-98 78-176 176-176 43 0 82 16 112 42l149-149z m-283 117c-80 0-144 64-144 144 0 80 64 144 144 144 80 0 144-64 144-144 0-80-64-144-144-144z"></path>
                            </svg>
                        </button>
                    </div>
            
                    <div class="toolbox-menu-item-toggle toolbox-menu-item-search toolbox-menu-item-search-close">
                        <button type="button" class="btn-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 512 512">
                                <path d="M475 453l-22 22-197-197-197 197-22-22 197-197-197-197 22-22 197 197 197-197 22 22-197 197z"></path>
                            </svg>
                        </button>
                    </div>
                </div>
                
                <div class="toolbox-menu-item">
                    <div class="toolbox-menu-item-toggle toolbox-menu-item-filter toolbox-menu-item-filter-open">
                        <button type="button" class="btn-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 512 512">
                                <path d="M112 288l32 0 0-240-32 0z m0 176l32 0 0-112-32 0z m128-320l32 0 0-96-32 0z m0 320l32 0 0-256-32 0z m128-176l32 0 0-240-32 0z m0 176l32 0 0-112-32 0z m-304-128l128 0 0-32-128 0z m256 0l128 0 0-32-128 0z m-128-144l128 0 0-32-128 0z"></path>
                            </svg>
                        </button>
                    </div>
            
                    <div class="toolbox-menu-item-toggle toolbox-menu-item-filter toolbox-menu-item-filter-close">
                        <button type="button" class="btn-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 512 512">
                                <path d="M475 453l-22 22-197-197-197 197-22-22 197-197-197-197 22-22 197 197 197-197 22 22-197 197z"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
            
            <div class="toolbox-container">
                toolbox
            </div>
        </div>
        
        <div id="list">
            <div class="list-search">
                <input id="search" type="text" placeholder="What do you need?">
            </div>
            
            <div class="list-container">
                <div class="list-item">
                    test
                </div>
                
                <div class="list-item">
                    test
                </div>
            </div>
        </div>
        
        <main id="main" itemscope itemprop="mainContentOfPage" itemtype="http://schema.org/WebPageElement">
            <div id="content">
                <ol id="breadcrumb" itemscope itemtype="http://schema.org/BreadcrumbList">
                    <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
                        <a itemprop="item" href="#"><span itemprop="name">Steder</span></a>
                    </li>
                    <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
                        <a itemprop="item" href="#"><span itemprop="name">Europa</span></a>
                    </li>
                    <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
                        <a itemprop="item" href="#"><span itemprop="name">Frankrig</span></a>
                    </li>
                </ol>
                
                <div class="content-container passive">
                    <h1>Spain</h1>
                </div>
                
                <div class="content-container">
                    <h1>France</h1>
                    
                    <button type="button" class="sign-in-required">OK, sign me up!</button>
                    <button type="button" class="btn-primary">OK, sign me up!</button>
                </div>
                
                <div class="content-container passive">
                    <h1>Australia</h1>
                </div>
            </div>
        </main>
        
        <footer id="footer">
            footer
        </footer>
    </div>
</div>

<?php

include("footer.php");

?>
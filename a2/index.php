include('includes/db_connect.inc');
include('includes/header.inc');
include('includes/nav.inc');



<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Pets Victoria</title>
        <meta charset="utf-8">
        <link rel="stylesheet" href="css/styles.css">
        <link href="https://fonts.googleapis.com/css2?family=Permanent+Marker&family=Poetsen+One&family=Ysabeau+SC&display=swap" rel="stylesheet">
        
        

    </head>
    <body>
        <header>
            <nav class="navbar">
                <div class="nav-left">
                <a href="index.html" class="logo"><img src="images/logo.png" alt="Logo"></a>
                <select id="menu" class="nav-select" onchange="navigateToPage(this.value)">
                    <option value="">Select an Option...</option>
                    <option value="index.html">Home</option>
                    <option value="pets.html">Pets</option>
                    <option value="add.html">Add More</option>
                    <option value="gallery.html">Gallery</option>
                </select>
                </div>
                <form id="search-bar">
                    <input type="text" placeholder="Search" class="search-input">
                    </form>
            </nav>
        </header>
        <main>
            
            <h1 class="site-title">PETS VICTORIA</h1>
            <h2 class="subheading">WELCOME TO PET 
                <br> 
                ADOPTION</h2>
            
            <img src="images/main.jpg" alt="A puppy and a kitten cuddling" class="index-image">
        </main>
      include('includes/footer.inc');
        
        <script src="js/main.js"></script>
    </body>
</html>

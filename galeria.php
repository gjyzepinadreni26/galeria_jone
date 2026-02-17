<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html >
<head>
 <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Galeria fotove</title>
</head>

<style type="text/css">
   * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
 body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f7f6;
            color: #333;
            line-height: 1.6;
        }
/* Stilimi i titullit */
.gallery-title {
    font-size: 2.5rem;
    font-weight: 800;
    text-align: center;
    margin-bottom: 3rem;
    
    /* GRADIENTI I TEKSTIT */
    background: linear-gradient(90deg, #4f46e5, #ec4899);
    
    /* Këto 3 rreshta duhen fiks kështu për të funksionuar */
    -webkit-background-clip: text;
    background-clip: text;
    -webkit-text-fill-color: transparent;
    color: transparent; /* Fallback për browserat e vjetër */

    /* Pozicionimi për vijën dekorative */
    position: relative;
    display: table; /* E mban gradientin vetëm te teksti dhe jo në gjithë rreshtin */
    margin-left: auto;
    margin-right: auto;
}

/* VIJA DEKORATIVE */
.gallery-title::after {
    content: "";
    position: absolute;
    bottom: -8px;
    left: 50%;
    transform: translateX(-50%);
    width: 0; 
    height: 4px;
    background: linear-gradient(90deg, #4f46e5, #ec4899);
    border-radius: 2px;
    
    /* Animacioni */
    animation: growWidth 1s ease-out forwards;
}

@keyframes growWidth {
    from { width: 0; }
    to { width: 600px; }
}

@media (max-width: 480px) {
    .gallery-title {
        font-size: 1.8rem; /* E zvogëlojmë pak madhësinë për telefon */
        padding: 0 20px;   /* I japim pak frymëmarrje anash */
    }
}
/* Rrjeta e fotove (Grid) */
.photo-grid {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr)); /* 1 kolonë në mobile */
    gap: 2.5rem;
	margin-left:10px;
}

/* Responsiveti për tableta dhe desktop */
@media (min-width: 640px) {
    .photo-grid {
        grid-template-columns: repeat(2, minmax(0, 1fr)); /* 2 kolona */
    }
}

@media (min-width: 768px) {
    .photo-grid {
        grid-template-columns: repeat(3, minmax(0, 1fr)); /* 3 kolona */
    }
}

/* Stilimi i Kartës */
.photo-card {
    background-color: white;
    border-radius: 0.5rem;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    overflow: hidden;
    transition: transform 0.3s ease; /* Tranzicioni për hover */
}

/* Efekti Hover (Zmadhimi) */
.photo-card:hover {
    transform: scale(1.05);
}

/* Stilimi i Imazhit */
.card-image {
    width: 100%;
    height: 300px;
    object-fit: cover;
}

/* Teksti brenda kartës */
.card-content {
    padding: 1rem;
}

.card-title {
    font-weight: bold;
    font-size: 1.125rem;
}

.card-author {
    font-size: 0.875rem;
    color: #4a5568; /* Ngjyra gri-600 */
	font-style: italic; 
}
/* Stilimi i Lightbox */
.lightbox {
    display: none; /* I fshehur fillimisht */
    position: fixed;
    z-index: 1000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.9); /* Sfond i zi i errët */
    justify-content: center;
    align-items: center;
    flex-direction: column;
}

/* Fotoja e zmadhuar */
.lightbox-content {
    max-width: 80%;
    max-height: 80%;
    border-radius: 5px;
    box-shadow: 0 0 20px rgba(255, 255, 255, 0.2);
    animation: zoomIn 0.3s ease;
}

/* Butoni për mbyllje (X) */
.close-lightbox {
    position: absolute;
    top: 20px;
    right: 40px;
    color: white;
    font-size: 40px;
    font-weight: bold;
    cursor: pointer;
}

/* Titulli poshtë fotos */
#lightbox-caption {
    color: #ccc;
    margin-top: 15px;
    font-size: 1.2rem;
}

@keyframes zoomIn {
    from { transform: scale(0.7); opacity: 0; }
    to { transform: scale(1); opacity: 1; }
}
.nav-btn {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    background: rgba(255, 255, 255, 0.1);
    color: white;
    border: none;
    font-size: 2rem;
    padding: 15px;
    cursor: pointer;
    transition: background 0.3s;
    border-radius: 5px;
}

.nav-btn:hover {
    background: rgba(255, 255, 255, 0.3);
}

.prev-btn { left: 20px; }
.next-btn { right: 20px; }

/* Fshehim shigjetat në mobile që të mos zënë ekranin */
@media (max-width: 600px) {
    .nav-btn { padding: 10px; font-size: 1.5rem; }
}
/* Efekti i zbehjes kur ndryshon fotoja */
.lightbox-content {
    /* ... kodi ekzistues ... */
    animation: fadeInImg 0.4s ease-in-out;
}

@keyframes fadeInImg {
    from { opacity: 0; }
    to { opacity: 1; }
}

   .container {
            width: 90%;
            max-width: 1100px;
            margin: 0 auto;
        }

        /* Header & Navigimi */
        header {
            background: #ffffff;
            padding: 1rem 0;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            font-size: 1.5rem;
            font-weight: bold;
            text-decoration: none;
            color: #1a1a1a;
        }

        nav ul {
            display: flex;
            list-style: none;
            gap: 20px;
        }

        .nav-link {
            text-decoration: none;
            color: #555;
            font-weight: 500;
            transition: 0.3s;
            padding-bottom: 5px;
        }

  .nav-link:hover {
            color: #3b82f6;
        }

   .nav-link.active {
            color: #3b82f6;
            border-bottom: 2px solid #3b82f6;
        }
  .empty-gallery {
            grid-column: 1 / -1; /* Zë gjithë gjerësinë */
            text-align: center;
            padding: 40px;
            color: #7f8c8d;
            font-size: 18px;
            background: white;
            border-radius: 10px;
        }
/* Stili për Lightbox */
  .lightbox {
            display: none; /* E fshehur në fillim */
            position: fixed;
            z-index: 9999;
            left: 0; top: 0;
            width: 100%; height: 100%;
            background-color: rgba(0,0,0,0.95); /* Sfond i zi */
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }

 .lightbox-content-wrapper {
            text-align: center;
            position: relative;
            max-width: 90%;
        }

 .lightbox-content {
            max-height: 80vh;
            max-width: 100%;
            border-radius: 4px;
            box-shadow: 0 0 20px rgba(255,255,255,0.1);
        }

 .lightbox-caption {
            color: white;
            margin-top: 15px;
        }
        .lightbox-caption h3 { margin: 0; font-size: 24px; }
        .lightbox-caption p { color: #ccc; margin-top: 5px; }

        /* Butoni X për mbyllje */
 .close-lightbox {
            position: absolute;
            top: 20px; right: 30px;
            color: white;
            font-size: 50px;
            font-weight: bold;
            cursor: pointer;
            z-index: 10001;
        }

        /* Shigjetat */
 .prev, .next {
            cursor: pointer;
            position: absolute;
            top: 50%;
            width: auto;
            padding: 20px;
            margin-top: -50px;
            color: white;
            font-weight: bold;
            font-size: 40px;
            transition: 0.3s;
            user-select: none;
            z-index: 10000;
        }
  .prev { left: 20px; }
   .next { right: 20px; }
   .prev:hover, .next:hover { background-color: rgba(255,255,255,0.1); border-radius: 5px; }
</style>
<script type="text/javascript">

    // --- VARIABLAT KRYESORE ---
    let indeksiAktual = 0; // Mban mend te cila foto jemi
    const cards = document.querySelectorAll('.photo-card'); // Të gjitha kartat
    const lightbox = document.getElementById('lightbox');
    const lightboxImg = document.getElementById('lightbox-img');
    const lightboxTitle = document.getElementById('lightbox-title');
    const lightboxAuthor = document.getElementById('lightbox-author');

    // --- 1. HAPJA E LIGHTBOX ---
    // I shtojmë klikimin çdo karte
    cards.forEach((card, index) => {
        card.addEventListener('click', () => {
            indeksiAktual = index; // Ruajmë numrin e fotos (psh: 5)
            perditesoLightbox();   // Shfaqim foton
            lightbox.style.display = 'flex';
        });
    });

    // --- 2. FUNKSIONI PËR TË NDRYSHUAR FOTON ---
    function ndryshoFoton(drejtimi) {
        // drejtimi është +1 (para) ose -1 (mbrapa)
        indeksiAktual += drejtimi;

        // Logjika "Loop": Nëse shkon pas fotos së fundit, kthehu te e para
        if (indeksiAktual >= cards.length) {
            indeksiAktual = 0;
        }
        // Nëse shkon para fotos së parë, shko te e fundit
        if (indeksiAktual < 0) {
            indeksiAktual = cards.length - 1;
        }

        perditesoLightbox();
    }

    // --- 3. FUNKSIONI QË MERR TË DHËNAT DHE I SHFAQ ---
    function perditesoLightbox() {
        // Gjejmë kartën sipas numrit aktual
        const kartaAktuale = cards[indeksiAktual];

        // Marrim elementët brenda asaj karte
        const img = kartaAktuale.querySelector('img');
        const title = kartaAktuale.querySelector('.card-title');
        const author = kartaAktuale.querySelector('.card-author');

        // I vendosim te Lightbox-i i madh
        lightboxImg.src = img.src;
        
        // Përdorim 'innerText' nëse ekziston, përndryshe bosh
        lightboxTitle.innerText = title ? title.innerText : "";
        lightboxAuthor.innerText = author ? author.innerText : "";
    }

    // --- 4. MBYLLJA ---
    function mbyllLightbox() {
        lightbox.style.display = 'none';
    }

    // Mbyllje me butonin ESC të tastierës
    document.addEventListener('keydown', function(event) {
        if (event.key === "Escape") {
            mbyllLightbox();
        }
        // Opsionale: Mbyllje edhe me shigjetat e tastierës
        if (event.key === "ArrowRight") ndryshoFoton(1);
        if (event.key === "ArrowLeft") ndryshoFoton(-1);
    });
</script>
   

<body>
   <header>
        <nav class="container">
            <a href="#" class="logo" onclick="showPage('home')">📸 Klubi i Fotografisë</a>
            <ul>
                <li><a href="#" id="nav-home" class="nav-link active" onclick="showPage('home')">Home</a></li>
                <li><a href="#" id="nav-rreth-nesh" class="nav-link" onclick="showPage('rreth-nesh')">Rreth Nesh</a></li>
                <li><a href="galeria.html" id="nav-galeria" class="nav-link" >Galeria</a></li>
                <li><a href="kontakt.html" id="nav-kontakt" class="nav-link" >Kontakt</a></li>
            </ul>
        </nav>
    </header>

    
<div class="gallery-title ">
    <h1 class="gallery-title">Galeria e Punimeve</h1></div>
    
    <div class="photo-grid">
        <div class="photo-card">
            <img src="suit.jpg" class="card-image">
            <div class="card-content">
                <h3 class="card-title">Titulli i Fotos 1</h3>
                <p class="card-author">nga Autori 1</p>
            </div>
        </div>

        
        
        <div class="photo-card">
            <img src="suit.jpg" class="card-image">
            <div class="card-content">
                <h3 class="card-title">Titulli i Fotos 1</h3>
                <p class="card-author">nga Autori 1</p>
            </div>
        </div>

    
        
        <div class="photo-card">
            <img src="https://placehold.co/600x400/a0aec0/ffffff?text=Foto+1" alt="Foto 1" class="card-image">
            <div class="card-content">
                <h3 class="card-title">Titulli i Fotos 1</h3>
                <p class="card-author">nga Autori 1</p>
            </div>
        </div>

      
        <div class="photo-card">
            <img src="https://placehold.co/600x400/a0aec0/ffffff?text=Foto+1" alt="Foto 1" class="card-image">
            <div class="card-content">
                <h3 class="card-title">Titulli i Fotos 1</h3>
                <p class="card-author">nga Autori 1</p>
            </div>
        </div>

        
        <div class="photo-card">
            <img src="https://placehold.co/600x400/a0aec0/ffffff?text=Foto+1" alt="Foto 1" class="card-image">
            <div class="card-content">
                <h3 class="card-title">Titulli i Fotos 1</h3>
                <p class="card-author">nga Autori 1</p>
            </div>
        </div>

        
        <div class="photo-card">
            <img src="https://placehold.co/600x400/a0aec0/ffffff?text=Foto+1" alt="Foto 1" class="card-image">
            <div class="card-content">
                <h3 class="card-title">Titulli i Fotos 1</h3>
                <p class="card-author">nga Autori 1</p>
            </div>
        </div>

      
      <!--  <div class="photo-card">
         <!--  <div class="gallery-grid">
            <div class="photo-grid">-->
       <?php
            $folderi_publik = "galeria_zyrtare/"; 
            // Kërkojmë të gjitha imazhet
            $fotot = glob($folderi_publik . "*.{jpg,jpeg,png,gif,JPG,JPEG,PNG}", GLOB_BRACE);

            if (count($fotot) == 0) {
                echo '<div style="grid-column: 1/-1; text-align: center; padding: 20px;">
                        <h3>Galeria është ende bosh!</h3>
                      </div>';
            }

            foreach ($fotot as $foto) {
                // 1. Përcaktojmë emrin e skedarit tekst shoqërues
                // Heqim prapashtesën e fotos (.jpg) dhe shtojmë .txt
                $skedari_txt = substr($foto, 0, strrpos($foto, ".")) . ".txt";
                
                // Vlerat default (nëse nuk ka skedar tekst)
                $titulli_faqes = "Foto pa titull";
                $autori_faqes = "Anonim";

                // 2. Nëse ekziston skedari tekst, lexojmë të dhënat
                if (file_exists($skedari_txt)) {
                    $linjat = file($skedari_txt, FILE_IGNORE_NEW_LINES);
                    if (isset($linjat[0])) $titulli_faqes = $linjat[0]; // Rreshti i parë
                    if (isset($linjat[1])) $autori_faqes = $linjat[1];  // Rreshti i dytë
                }
                
                // 3. Shfaqim Kartën
                echo '<div class="photo-card">';
                echo '    <img src="' . $foto . '" class="card-image" alt="Foto">';
                echo '    <div class="card-content">';
                // Këtu vendosim variablat që lexuam
                echo '        <h3 class="card-title">' . htmlspecialchars($titulli_faqes) . '</h3>';
                echo '        <p class="card-author">nga ' . htmlspecialchars($autori_faqes) . '</p>';
                echo '    </div>';
                echo '</div>';
            }
        ?>
   <!-- </div>
        </div>
            <div class="card-content">
                <h3 class="card-title">Titulli i Fotos 1</h3>
                <p class="card-author">nga Autori 1</p>
            </div>
     </div>-->

     
        
</div>
<div id="lightbox" class="lightbox">
    <span class="close-lightbox" onclick="mbyllLightbox()">&times;</span>
    
    <a class="prev" onclick="ndryshoFoton(-1)">&#10094;</a>
    <a class="next" onclick="ndryshoFoton(1)">&#10095;</a>

    <div class="lightbox-content-wrapper">
        <img class="lightbox-content" id="lightbox-img">
        
        <div class="lightbox-caption">
            <h3 id="lightbox-title"></h3>
            <p id="lightbox-author"></p> </div>
    </div>
</div>
</div>
</body>
</html>

<!DOCTYPE html>
<html lang="sq">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Galeria e Shkollës - Bujtina</title>
    <style>
        /* --- STILI I PËRGJITHSHËM --- */
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f4f7f6;
            margin: 0; padding: 20px;
            color: #333;
        }

        /* Navigimi i thjeshtë (Menuja) */
        nav ul {
            list-style-type: none;
            padding: 0;
            text-align: center;
            background: white;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        nav ul li { display: inline; margin: 0 15px; }
        nav a { text-decoration: none; color: #333; font-weight: bold; font-size: 18px; }
        nav a:hover { color: #27ae60; }

        /* --- GRID-I I FOTOVE --- */
        .photo-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
            max-width: 1200px;
            margin: 40px auto;
        }

        .photo-card {
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
            cursor: pointer; /* Tregon që mund të klikohet */
        }

        .photo-card:hover { transform: translateY(-5px); }

        .photo-card img {
            width: 100%;
            height: 250px;
            object-fit: cover;
            display: block;
        }

        .card-content { padding: 15px; }
        .card-title { margin: 0; font-size: 18px; color: #2c3e50; }
        .card-author { margin: 5px 0 0; font-size: 14px; color: #7f8c8d; font-style: italic; }

        /* --- DRITARJA E ZMADHIMIT (LIGHTBOX) --- */
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
</head>
<body>

    <nav>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="galeria.php" style="color: #27ae60;">Galeria</a></li>
            <li><a href="ngarko.php">Ngarko Foto</a></li>
        </ul>
    </nav>

    <h1 style="text-align: center; color: #333;">Galeria e Klasës 📸</h1>

    <div class="photo-grid">
        <?php
            $folderi_publik = "galeria_zyrtare/"; 
            // Kërkojmë fotot
            $fotot = glob($folderi_publik . "*.{jpg,jpeg,png,gif,JPG,JPEG,PNG}", GLOB_BRACE);

            if (count($fotot) == 0) {
                echo '<div style="grid-column: 1/-1; text-align: center; padding: 20px;">
                        <h3>Galeria është ende bosh!</h3>
                      </div>';
            }

            // Leximi i fotove dhe skedarëve txt
            foreach ($fotot as $foto) {
                // Gjejmë skedarin tekst shoqërues
                $skedari_txt = substr($foto, 0, strrpos($foto, ".")) . ".txt";
                
                $titulli_faqes = "Foto pa titull";
                $autori_faqes = "Anonim";

                if (file_exists($skedari_txt)) {
                    $linjat = file($skedari_txt, FILE_IGNORE_NEW_LINES);
                    if (isset($linjat[0])) $titulli_faqes = $linjat[0];
                    if (isset($linjat[1])) $autori_faqes = $linjat[1];
                }
                
                echo '<div class="photo-card">';
                echo '    <img src="' . $foto . '" alt="Foto">';
                echo '    <div class="card-content">';
                echo '        <h3 class="card-title">' . htmlspecialchars($titulli_faqes) . '</h3>';
                echo '        <p class="card-author">nga ' . htmlspecialchars($autori_faqes) . '</p>';
                echo '    </div>';
                echo '</div>';
            }
        ?>
    </div>

    <div id="lightbox" class="lightbox">
        <span class="close-lightbox" onclick="mbyllLightbox()">&times;</span>
        
        <a class="prev" onclick="ndryshoFoton(-1)">&#10094;</a>
        <a class="next" onclick="ndryshoFoton(1)">&#10095;</a>

        <div class="lightbox-content-wrapper">
            <img class="lightbox-content" id="lightbox-img">
            <div class="lightbox-caption">
                <h3 id="lightbox-title"></h3>
                <p id="lightbox-author"></p>
            </div>
        </div>
    </div>

    <script>
        // Variablat globale
        let indeksiAktual = 0;
        const cards = document.querySelectorAll('.photo-card');
        const lightbox = document.getElementById('lightbox');
        const lightboxImg = document.getElementById('lightbox-img');
        const lightboxTitle = document.getElementById('lightbox-title');
        const lightboxAuthor = document.getElementById('lightbox-author');

        // 1. Hapja e Lightbox kur klikohet një kartë
        cards.forEach((card, index) => {
            card.addEventListener('click', () => {
                indeksiAktual = index;
                perditesoLightbox();
                lightbox.style.display = 'flex';
            });
        });

        // 2. Funksioni për të lëvizur (Para/Mbrapa)
        function ndryshoFoton(drejtimi) {
            // Ndalojmë klikimin të hapet nëse nuk ka foto
            if (cards.length === 0) return;

            indeksiAktual += drejtimi;

            // Loop infinit
            if (indeksiAktual >= cards.length) indeksiAktual = 0;
            if (indeksiAktual < 0) indeksiAktual = cards.length - 1;

            perditesoLightbox();
        }

        // 3. Përditësimi i të dhënave (Foto, Titull, Autor)
        function perditesoLightbox() {
            const kartaAktuale = cards[indeksiAktual];
            
            // Marrim elementët nga HTML e kartës
            const img = kartaAktuale.querySelector('img');
            const title = kartaAktuale.querySelector('.card-title');
            const author = kartaAktuale.querySelector('.card-author');

            // I vendosim në Lightbox
            lightboxImg.src = img.src;
            lightboxTitle.innerText = title ? title.innerText : "";
            lightboxAuthor.innerText = author ? author.innerText : "";
        }

        // 4. Mbyllja
        function mbyllLightbox() {
            lightbox.style.display = 'none';
        }

        // Mbyllje me tastierë (ESC, Shigjeta)
        document.addEventListener('keydown', function(e) {
            if (lightbox.style.display === 'flex') {
                if (e.key === "Escape") mbyllLightbox();
                if (e.key === "ArrowRight") ndryshoFoton(1);
                if (e.key === "ArrowLeft") ndryshoFoton(-1);
            }
        });
    </script>

</body>
</html>
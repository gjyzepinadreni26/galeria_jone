<?php
/**
 * SISTEMI I GALERISË ME APROVIM
 * -----------------------------
 * 1. Nxënësit ngarkojnë -> Shkon te folderi "ngarkime_pritje"
 * 2. Mësuesi kontrollon -> I lëviz fotot te folderi "galeria_zyrtare"
 * 3. Faqja shfaq -> Vetëm fotot nga "galeria_zyrtare"
 */

// --- KONFIGURIMI ---

// --- LOGJIKA E BACKEND-it ---
$folderi_pritjes = "ngarkime_pritje/"; 

if (!is_dir($folderi_pritjes)) mkdir($folderi_pritjes, 0777, true);

$mesazh = "";
$tipi = "";

if (isset($_POST['dergo_foto'])) {
    // 1. Marrim të dhënat nga formulari
    $titulli = htmlspecialchars($_POST['titulli']); // Pastrojmë tekstin për siguri
    $autori = htmlspecialchars($_POST['autori']);
    
    $emri = $_FILES['fotoja']['name'];
    $tmp = $_FILES['fotoja']['tmp_name'];
    
    // 2. Krijojmë emrin unik bazë (pa prapashtesë ende)
    $emri_baze = time() . "_" . pathinfo($emri, PATHINFO_FILENAME);
    $shtesa = strtolower(pathinfo($emri, PATHINFO_EXTENSION));
    
    // Emri i plotë i fotos
    $emri_foto_final = $emri_baze . "." . $shtesa;
    $destinacioni_foto = $folderi_pritjes . $emri_foto_final;
    
    // Emri i skedarit tekst (shoqëruesit)
    $destinacioni_txt = $folderi_pritjes . $emri_baze . ".txt";

    if(in_array($shtesa, ['jpg', 'jpeg', 'png', 'gif'])) {
        if ($_FILES['fotoja']['size'] < 5000000) {
            
            // 3. Ruajmë Foton
            if (move_uploaded_file($tmp, $destinacioni_foto)) {
                
                // 4. Ruajmë Titullin dhe Autorin në skedarin .txt
                // Rreshti 1: Titulli, Rreshti 2: Autori
                $permbajtja = $titulli . "\n" . $autori;
                file_put_contents($destinacioni_txt, $permbajtja);

                $mesazh = "✅ Foto dhe të dhënat u ruajtën! Prisni aprovimin.";
                $tipi = "success";
            } else {
                $mesazh = "❌ Pati një gabim gjatë ngarkimit.";
                $tipi = "error";
            }
        } else {
            $mesazh = "⚠️ Fotoja është shumë e madhe.";
            $tipi = "error";
        }
    } else {
        $mesazh = "⚠️ Format i gabuar.";
        $tipi = "error";
    }
}
?>

<!DOCTYPE html>
<html lang="sq">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ngarko foto</title>
    <style>
        /* STILI I PËRGJITHSHËM (CSS) */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f7f6;
            margin: 0;
            padding: 0;
            color: #333;
        }

        /* Titujt */
        h1, h2 { text-align: center; color: #2c3e50; }

        /* KUTIA E NGARKIMIT (UPLOAD) */
        .upload-container {
            background: white;
            max-width: 500px;
            margin: 40px auto;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            text-align: center;
            border-top: 5px solid #27ae60;
        }

        .upload-icon { font-size: 50px; margin-bottom: 10px; }

        /* Inputi i zgjedhjes së skedarit */
        input[type="file"] {
            margin: 20px 0;
            padding: 10px;
            border: 2px dashed #bdc3c7;
            border-radius: 6px;
            width: 80%;
            background: #fafafa;
        }

        /* Butoni */
        .btn-submit {
            background-color: #27ae60;
            color: white;
            border: none;
            padding: 12px 30px;
            font-size: 16px;
            border-radius: 30px;
            cursor: pointer;
            transition: 0.3s;
            font-weight: bold;
        }

        .btn-submit:hover { background-color: #219150; transform: scale(1.05); }

        /* Mesazhet */
        .msg { padding: 10px; margin-bottom: 20px; border-radius: 5px; font-weight: bold; }
        .msg.success { background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .msg.error { background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }

        /* ZONA E GALERISË */
        .gallery-section {
            padding: 40px 20px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
        }

        .photo-card {
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }

        .photo-card:hover { transform: translateY(-5px); }

        .photo-card img {
            width: 100%;
            height: 250px;
            object-fit: cover;
            display: block;
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
    </style>
</head>
<body>

    <div class="upload-container">
        <div class="upload-icon">📸</div>
        <h2>Bëhu pjesë e kujtimeve!</h2>
        <p>Ngarko foton tënde më të bukur nga aktiviteti.</p>

        <?php if($mesazh != ""): ?>
            <div class="msg <?php echo $tipi_mesazhit; ?>">
                <?php echo $mesazh; ?>
            </div>
        <?php endif; ?>

        <form action="" method="POST" enctype="multipart/form-data">
        <input type="text" name="titulli" placeholder="Titulli i fotos (psh: Perëndim)" required>
            <input type="text" name="autori" placeholder="Emri Mbiemri juaj" required>
            <input type="file" name="fotoja" required accept="image/*">
            <br>
            <button type="submit" name="dergo_foto" class="btn-submit">Dërgo Foton 🚀</button>
        </form>
        <p style="font-size: 12px; color: #999; margin-top: 15px;">Fotot do të shfaqen pas aprovimit.</p>
    </div>

    <hr style="border: 0; border-top: 1px solid #e0e0e0; margin: 0;">

    <div class="gallery-section">
      <!-- <h1>Galeria e Klasës</h1>
        
        <div class="gallery-grid">
           /* <?php
                // Marrim fotot vetem nga folderi PUBLIK
                // GLOB_BRACE lejon kërkimin e disa formateve njëkohësisht
                $fotot = glob($folderi_publik . "*.{jpg,jpeg,png,gif,JPG,JPEG,PNG}", GLOB_BRACE);

                // Nëse nuk ka foto
                if (count($fotot) == 0) {
                    echo '<div class="empty-gallery">
                            <h3>Galeria është ende bosh! 📂</h3>
                            <p>Prisni sa mësuesi të aprovojë fotot e para.</p>
                          </div>';
                }

                // Cikli për të shfaqur fotot
                foreach ($fotot as $foto) {
                    echo '<div class="photo-card">';
                    // Kujdes: $foto përmban rrugën (galeria_zyrtare/foto1.jpg)
                    echo '    <img src="' . $foto . '" alt="Foto Nxënësi" loading="lazy">';
                    echo '</div>';
                }
            ?> */
        </div> --> 
    </div>

</body>
</html>
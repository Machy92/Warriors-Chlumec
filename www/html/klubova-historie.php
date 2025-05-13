<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Warriors Chlumec – Historie klubu</title>
    <link rel="icon" type="image/x-icon" href="chlumeclogo.png">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome pro ikony -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    
    <link rel="stylesheet" href="styles.css">
    <style>
        .hero {
            position: relative;
            background-image: url('images/team_photo.jpg');
            background-size: cover;
            background-position: center;
            height: 400px;
            color: white;
        }

        .hero::before {
            content: "";
            position: absolute;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background-color: rgba(0, 0, 0, 0.6);
        }

        .hero-content {
            position: relative;
            z-index: 1;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
        }

        .hero h1 {
            font-size: 3rem;
            font-weight: bold;
        }

        .timeline {
            border-left: 3px solid #dc3545;
            padding-left: 20px;
            margin-top: 20px;
        }

        .timeline-entry {
            margin-bottom: 20px;
        }

        .timeline-entry h6 {
            font-weight: bold;
            margin-bottom: 5px;
        }

        .social-icons a {
            color: #333;
            text-decoration: none;
            margin-right: 15px;
        }

        .social-icons a:hover {
            color: #dc3545;
        }
    </style>
</head>
<body>

    <!-- Navigace -->
    <nav>
        <?php include 'header.php'; ?>
    </nav>

    <!-- Hero sekce -->
    <div class="hero">
        <div class="hero-content">
            <h1>HSÚ SHC Warriors Chlumec</h1>
        </div>
    </div>

    <!-- Sekce Historie klubu -->
    <section class="container my-5">
        <div class="row">
            <!-- Historie -->
            <div class="col-lg-6">
                <h2 class="mb-4">Historie klubu</h2>
                <p>
                    <strong>HSÚ SHC Warriors Chlumec</strong> je hokejbalový klub založený v roce <strong>2006</strong>. Od svého vzniku působí na severu Čech jako významný regionální celek, který se účastní soutěží Českomoravského svazu hokejbalu (ČMSHb).
                </p>
                <p>
                    Klub vychoval řadu mladých talentů a je známý svou týmovou kulturou, bojovností a silnou komunitní základnou. Domácí zápasy se odehrávají na hřišti ve <em>Stradovské ulici</em>, které je centrem dění nejen pro fanoušky, ale i pro mládežnické kategorie.
                </p>
                <button id="toggleInfoBtn" class="btn btn-danger mt-3">Zobrazit více</button>
                <div id="extraInfo" class="mt-3" style="display: none;">
                    <ul>
                        <li><strong>Největší úspěch:</strong> Účast ve finále krajské ligy v roce 2019.</li>
                        <li><strong>Kapitán týmu:</strong> Patrik Barčák</li>
                        <li><strong>Vedoucí klubu:</strong> Vladislav Trnka</li>
                        <li><strong>Trenér klubu:</strong> Jan Celner</li>
                        <li><strong>Filozofie:</strong> "Srdcem na hřišti, rozumem v týmu."</li>
                    </ul>
                </div>

                <p class="mt-4">
                    Sledujte nás na sociálních sítích:
                </p>
                <div class="social-icons">
                    <a href="https://www.facebook.com/p/HS%C3%9A-SHC-Warriors-Chlumec-100069910536674/?locale=cs_CZ" target="_blank">
                        <i class="fab fa-facebook fa-lg"></i> Facebook
                    </a>
                    <a href="https://www.instagram.com/warriorschlumec/" target="_blank">
                        <i class="fab fa-instagram fa-lg"></i> Instagram
                    </a>
                </div>
            </div>

            <!-- Časová osa -->
            <div class="col-lg-6">
                <h3 class="mb-4">Časová osa</h3>
                <div class="timeline">
                    <div class="timeline-entry">
                        <h6>2006</h6>
                        <p>Založení klubu HSÚ SHC Warriors Chlumec.</p>
                    </div>
                    <div class="timeline-entry">
                        <h6>2010</h6>
                        <p>Účast v první krajské soutěži.</p>
                    </div>
                    <div class="timeline-entry">
                        <h6>2015</h6>
                        <p>Rekonstrukce domácího hřiště ve Stradovské ulici.</p>
                    </div>
                    <div class="timeline-entry">
                        <h6>2019</h6>
                        <p>Postup do finále krajské ligy.</p>
                    </div>
                    <div class="timeline-entry">
                        <h6>2023</h6>
                        <p>Nový týmový vizuál a rozšíření mládežnických kategorií.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Patka -->
    <?php include 'footer.php'; ?>

    <!-- Bootstrap JS a vlastní skript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const toggleBtn = document.getElementById("toggleInfoBtn");
            const extraInfo = document.getElementById("extraInfo");

            toggleBtn.addEventListener("click", function () {
                const isVisible = extraInfo.style.display === "block";
                extraInfo.style.display = isVisible ? "none" : "block";
                toggleBtn.textContent = isVisible ? "Zobrazit více" : "Skrýt informace";
            });
        });
    </script>
</body>
</html>

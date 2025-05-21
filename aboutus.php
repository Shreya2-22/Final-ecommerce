<?php include "includes/header.php"; ?>
<!DOCTYPE html>
<html>
<head>
    <title>About Us – Cleck-E-Mart</title>
    <link rel="stylesheet" href="css/about.css">
    <style>
        body {
            background-color: #f4f9f3;
            font-family: 'Segoe UI', sans-serif;
        }

        h1.section-title {
            font-weight: bold;
            margin-top: 40px;
            margin-bottom: 20px;
            color: #1d392a;
        }

        hr.section-divider {
            width: 80px;
            border: 3px solid #28A745;
            margin: 0 auto 40px;
        }

        .about-text {
            font-size: 1.1rem;
            text-align: justify;
            line-height: 1.8;
            padding: 0 10%;
            color: #343A40;
        }

        .team-section {
            padding: 60px 0;
        }

        .member-card {
            border-radius: 10px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.08);
            overflow: hidden;
            transition: 0.3s ease;
            background-color: transparent; /* ✅ No white background */
        }

        .member-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.1);
        }

        .member-img img {
            width: 100%;
            height: 260px;
            object-fit: cover;
        }

        .member-info {
            padding: 20px;
            text-align: center;
            background-color: transparent;
        }

        .member-info h5 {
            font-weight: bold;
            margin-bottom: 8px;
            color: #212529;
        }

        .member-info span {
            font-size: 0.95rem;
            color: #6c757d;
        }

        @media (max-width: 768px) {
            .about-text {
                padding: 0 5%;
            }
        }
    </style>
</head>
<body>

<div class="container-fluid">
    <section class="text-center">
        <h1 class="section-title">Our Story</h1>
        <hr class="section-divider">
        <p class="about-text">
            Cleck-E-Mart was founded with a simple mission: to empower local traders and small businesses in Cleckhuddersfax and surrounding communities through a modern digital platform. In a market increasingly dominated by large-scale chains, we believe in providing equal opportunity and visibility to grassroots entrepreneurs. Our platform allows traders to collaborate, grow their presence, and serve their communities while customers enjoy easy, affordable, and local access to quality products.<br><br>
            Since our inception, we’ve remained committed to reshaping local commerce by combining cutting-edge online retail technology with the spirit of traditional markets. Together, we’re building a digital marketplace that’s accessible, sustainable, and community-first.
        </p>
    </section>

    <section class="team-section text-center">
        <h1 class="section-title">Our Team</h1>
        <hr class="section-divider">

        <div class="row justify-content-center g-4 px-4">

            <div class="col-lg-4 col-md-6 col-sm-6">
                <div class="member-card">
                    <div class="member-img">
                        <img src="images/shreya.jpg" alt="Shreya">
                    </div>
                    <div class="member-info">
                        <h5>Shreya Khadka</h5>
                        <span>Specialist</span>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 col-sm-6">
                <div class="member-card">
                    <div class="member-img">
                        <img src="images/saswot.jpg" alt="Saswot">
                    </div>
                    <div class="member-info">
                        <h5>Saswot Shah</h5>
                        <span>Resource Investigator</span>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 col-sm-6">
                <div class="member-card">
                    <div class="member-img">
                        <img src="images/sisham.jpg" alt="Sisham">
                    </div>
                    <div class="member-info">
                        <h5>Sisham Maharjan</h5>
                        <span>Plant</span>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 col-sm-6">
                <div class="member-card">
                    <div class="member-img">
                        <img src="images/riwant.jpg" alt="Riwant">
                    </div>
                    <div class="member-info">
                        <h5>Riwant Rayamajhi</h5>
                        <span>Plant</span>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 col-sm-6">
                <div class="member-card">
                    <div class="member-img">
                        <img src="images/sabin.jpg" alt="Sabin">
                    </div>
                    <div class="member-info">
                        <h5>Sabin Kumar Mandal</h5>
                        <span>Team Worker</span>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 col-sm-6">
                <div class="member-card">
                    <div class="member-img">
                        <img src="images/pustika.jpg" alt="Pustika">
                    </div>
                    <div class="member-info">
                        <h5>Pustika Pokharel</h5>
                        <span>Team Worker</span>
                    </div>
                </div>
            </div>

        </div>
    </section>
</div>

<?php include "includes/footer.php"; ?>
</body>
</html>

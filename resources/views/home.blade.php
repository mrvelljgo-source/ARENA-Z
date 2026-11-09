
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ARENA Z - Student Esports</title>

    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@500;600;700;800&family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            background: #070b16;
            color: white;
            font-family: 'Poppins', sans-serif;
            overflow-x: hidden;
        }

        :root {
            --blue: #3685ff;
            --purple: #8b5cf6;
            --muted: #9ba8c7;
            --panel: #101a30;
            --border: rgba(255,255,255,.09);
        }

        a {
            text-decoration: none;
        }

        /* NAVBAR */
        header {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 100;
            padding: 18px 8%;
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: rgba(7,11,22,.88);
            backdrop-filter: blur(18px);
            border-bottom: 1px solid var(--border);
        }

        .logo {
            font-family: 'Orbitron', sans-serif;
            font-size: 25px;
            font-weight: 800;
            letter-spacing: 2px;
        }

        .logo span {
            color: var(--blue);
        }

        nav {
            display: flex;
            align-items: center;
            gap: 25px;
        }

        nav a {
            color: #c5cde0;
            font-size: 12px;
            transition: .3s;
        }

        nav a:hover {
            color: var(--blue);
        }

        .nav-actions {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .login-btn,
        .register-btn,
        .dashboard-btn,
        .logout-btn {
            border-radius: 8px;
            padding: 10px 15px;
            font-size: 11px;
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
            cursor: pointer;
            transition: .3s;
        }

        .login-btn {
            color: white;
            border: 1px solid #34415e;
            background: transparent;
        }

        .login-btn:hover {
            border-color: var(--blue);
            color: #83b5ff;
        }

        .register-btn,
        .dashboard-btn {
            color: white;
            background: var(--blue);
            border: 1px solid var(--blue);
        }

        .register-btn:hover,
        .dashboard-btn:hover {
            background: #1765e8;
            transform: translateY(-2px);
        }

        .logout-btn {
            color: #ff8d8d;
            background: rgba(255,80,80,.1);
            border: 1px solid rgba(255,80,80,.3);
        }

        .logout-btn:hover {
            background: rgba(255,80,80,.2);
        }

        /* HERO */
        .hero {
            min-height: 760px;
            padding: 170px 8% 100px;
            display: flex;
            align-items: center;
            position: relative;
            overflow: hidden;
            background:
                radial-gradient(ellipse at 80% 40%, rgba(54,133,255,.2), transparent 40%),
                radial-gradient(ellipse at 15% 80%, rgba(139,92,246,.15), transparent 40%),
                #070b16;
        }

        .hero::before {
            content: "";
            position: absolute;
            width: 550px;
            height: 550px;
            right: -100px;
            top: 100px;
            border: 1px solid rgba(54,133,255,.12);
            border-radius: 50%;
            box-shadow: 0 0 100px rgba(54,133,255,.1);
        }

        .hero-content {
            width: 55%;
            max-width: 600px;
            position: relative;
            z-index: 3;
        }

        .tag {
            display: inline-block;
            color: #83b5ff;
            background: rgba(54,133,255,.12);
            border: 1px solid rgba(54,133,255,.3);
            padding: 9px 16px;
            border-radius: 30px;
            font-size: 10px;
            letter-spacing: 2px;
            margin-bottom: 25px;
        }

        .hero h1 {
            font-family: 'Orbitron', sans-serif;
            font-size: clamp(38px, 5vw, 65px);
            line-height: 1.2;
            margin-bottom: 22px;
        }

        .hero h1 span {
            color: var(--blue);
            text-shadow: 0 0 35px rgba(54,133,255,.5);
        }

        .hero p {
            color: var(--muted);
            font-size: 14px;
            line-height: 1.9;
            max-width: 510px;
        }

        .hero-actions {
            display: flex;
            gap: 13px;
            margin-top: 32px;
            flex-wrap: wrap;
        }

        .main-button,
        .second-button {
            display: inline-block;
            padding: 14px 23px;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 600;
            transition: .3s;
        }

        .main-button {
            background: var(--blue);
            color: white;
            box-shadow: 0 8px 25px rgba(54,133,255,.2);
        }

        .main-button:hover {
            background: #1765e8;
            transform: translateY(-3px);
        }

        .second-button {
            border: 1px solid #34415e;
            color: white;
        }

        .second-button:hover {
            border-color: var(--blue);
            color: #83b5ff;
        }

        .hero-image {
            position: absolute;
            right: 8%;
            top: 50%;
            transform: translateY(-50%);
            width: 40%;
            max-width: 530px;
            z-index: 2;
        }

        .hero-image img {
            width: 100%;
            height: 350px;
            object-fit: cover;
            border-radius: 20px;
            border: 1px solid rgba(54,133,255,.4);
            box-shadow: 0 0 70px rgba(54,133,255,.2);
        }

 

        .floating-card small {
            color: var(--muted);
            font-size: 10px;
        }

        .floating-card h3 {
            color: #83b5ff;
            font-family: 'Orbitron', sans-serif;
            font-size: 17px;
            margin-top: 4px;
        }

        /* STATS */
        .stats {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            padding: 35px 8%;
            background: #0d1425;
            border-top: 1px solid var(--border);
            border-bottom: 1px solid var(--border);
        }

        .stat {
            text-align: center;
            border-right: 1px solid var(--border);
        }

        .stat:last-child {
            border-right: none;
        }

        .stat h2 {
            color: #66a5ff;
            font-family: 'Orbitron', sans-serif;
            font-size: 27px;
        }

        .stat p {
            color: var(--muted);
            font-size: 10px;
            letter-spacing: 1px;
            margin-top: 8px;
        }

        /* GENERAL SECTION */
        .section {
            padding: 100px 8%;
        }

        .section-heading {
            margin-bottom: 40px;
        }

        .section-heading small {
            color: var(--blue);
            letter-spacing: 3px;
            font-size: 10px;
            font-weight: 600;
        }

        .section-heading h2 {
            font-family: 'Orbitron', sans-serif;
            font-size: 30px;
            margin-top: 12px;
        }

        .section-heading p {
            color: var(--muted);
            font-size: 13px;
            line-height: 1.8;
            margin-top: 12px;
        }

        /* FEATURE CARDS */
        .cards {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
        }

        .card {
            position: relative;
            padding: 28px;
            background: linear-gradient(145deg, #121d34, #0c1323);
            border: 1px solid #253552;
            border-radius: 15px;
            transition: .3s;
            overflow: hidden;
        }

        .card::after {
            content: "";
            position: absolute;
            width: 100px;
            height: 100px;
            right: -40px;
            bottom: -40px;
            background: rgba(54,133,255,.08);
            filter: blur(25px);
            border-radius: 50%;
        }

        .card:hover {
            transform: translateY(-7px);
            border-color: var(--blue);
            box-shadow: 0 15px 40px rgba(54,133,255,.1);
        }

        .game-icon {
            width: 52px;
            height: 52px;
            display: grid;
            place-items: center;
            border-radius: 12px;
            background: rgba(54,133,255,.15);
            color: #83b5ff;
            font-family: 'Orbitron', sans-serif;
            font-size: 17px;
            font-weight: 700;
            margin-bottom: 25px;
        }

        .card h3 {
            font-size: 17px;
            margin-bottom: 12px;
        }

        .card p {
            color: var(--muted);
            font-size: 12px;
            line-height: 1.9;
        }

        /* TOURNAMENT */
        .tournament-section {
            background: linear-gradient(180deg, #070b16, #0c1426);
        }

        .tournament-card {
            display: grid;
            grid-template-columns: 1fr 1fr;
            overflow: hidden;
            border: 1px solid #294b83;
            border-radius: 18px;
            background: #101a30;
        }

        .tournament-visual {
            min-height: 300px;
            display: grid;
            place-items: center;
            background:
                radial-gradient(circle, rgba(54,133,255,.3), transparent 65%),
                linear-gradient(135deg, #111d36, #101326);
        }

        .ml-logo {
            font-family: 'Orbitron', sans-serif;
            font-size: 75px;
            font-weight: 800;
            color: #75adff;
            text-shadow: 0 0 40px rgba(54,133,255,.5);
        }

        .tournament-info {
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .status {
            display: inline-block;
            width: fit-content;
            color: #ffc66d;
            background: rgba(255,190,70,.1);
            border: 1px solid rgba(255,190,70,.2);
            padding: 6px 11px;
            border-radius: 20px;
            font-size: 10px;
            margin-bottom: 18px;
        }

        .tournament-info h3 {
            font-family: 'Orbitron', sans-serif;
            font-size: 23px;
            margin-bottom: 15px;
        }

        .tournament-info p {
            color: var(--muted);
            font-size: 12px;
            line-height: 1.9;
        }

        .tournament-details {
            display: flex;
            gap: 25px;
            margin: 25px 0;
            flex-wrap: wrap;
        }

        .detail small {
            color: var(--muted);
            display: block;
            font-size: 10px;
        }

        .detail strong {
            display: block;
            margin-top: 5px;
            font-size: 13px;
        }

        /* LOGIN AREA */
        .access-section {
            padding: 90px 8%;
        }

        .access-box {
            padding: 55px 35px;
            border: 1px solid rgba(54,133,255,.3);
            border-radius: 18px;
            background:
                radial-gradient(ellipse at top, rgba(54,133,255,.17), transparent 65%),
                #101a30;
            text-align: center;
        }

        .access-box h2 {
            font-family: 'Orbitron', sans-serif;
            font-size: 27px;
            margin-bottom: 13px;
        }

        .access-box > p {
            color: var(--muted);
            font-size: 12px;
            margin-bottom: 30px;
        }

        .access-buttons {
            display: flex;
            justify-content: center;
            gap: 13px;
            flex-wrap: wrap;
        }

        .access-buttons a {
            min-width: 170px;
        }

        /* FOOTER */
        footer {
            padding: 35px 8%;
            background: #0d1425;
            border-top: 1px solid var(--border);
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
            flex-wrap: wrap;
        }

        footer p {
            color: #7e8ba8;
            font-size: 11px;
        }

        .footer-logo {
            font-family: 'Orbitron', sans-serif;
            font-size: 18px;
            font-weight: 800;
        }

        .footer-logo span {
            color: var(--blue);
        }

        /* RESPONSIVE */
        @media (max-width: 950px) {
            header {
                padding: 18px 5%;
            }

            nav {
                gap: 13px;
            }

            .hero {
                padding-left: 5%;
                padding-right: 5%;
            }

            .hero-image {
                right: 5%;
                width: 42%;
            }

            .hero-image img {
                height: 270px;
            }

            .hero-content {
                width: 55%;
            }

            .cards {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 650px) {
            header {
                padding: 15px 5%;
                flex-wrap: wrap;
                gap: 15px;
            }

            .logo {
                font-size: 21px;
            }

            nav {
                order: 3;
                width: 100%;
                justify-content: center;
                flex-wrap: wrap;
                gap: 13px;
            }

            nav a {
                font-size: 10px;
            }

            .nav-actions {
                gap: 6px;
            }

            .login-btn,
            .register-btn,
            .dashboard-btn,
            .logout-btn {
                padding: 8px 10px;
                font-size: 10px;
            }

            .hero {
                min-height: auto;
                padding: 175px 6% 75px;
                display: block;
            }

            .hero-content {
                width: 100%;
            }

            .hero h1 {
                font-size: clamp(35px, 10vw, 48px);
            }

            .hero p {
                font-size: 12px;
            }

            .hero-image {
                position: relative;
                top: auto;
                right: auto;
                transform: none;
                width: 100%;
                margin-top: 50px;
            }

            .hero-image img {
                height: 230px;
            }

            .floating-card {
                left: 10px;
            }

            .stats {
                padding: 25px 3%;
            }

            .stat h2 {
                font-size: 17px;
            }

            .stat p {
                font-size: 8px;
            }

            .section {
                padding: 75px 6%;
            }

            .section-heading h2 {
                font-size: 23px;
            }

            .cards {
                grid-template-columns: 1fr;
            }

            .tournament-card {
                grid-template-columns: 1fr;
            }

            .tournament-visual {
                min-height: 210px;
            }

            .ml-logo {
                font-size: 60px;
            }

            .tournament-info {
                padding: 27px;
            }

            .tournament-info h3 {
                font-size: 19px;
            }

            .access-section {
                padding: 60px 6%;
            }

            .access-box {
                padding: 40px 20px;
            }

            .access-box h2 {
                font-size: 21px;
            }

            .access-buttons {
                flex-direction: column;
            }

            .access-buttons a {
                width: 100%;
            }

            footer {
                justify-content: center;
                text-align: center;
            }
        }

        body {
            background:
                radial-gradient(ellipse at 50% -18%, rgba(54, 133, 255, .12), transparent 42%),
                #070b16;
        }

        header {
            padding-top: 15px;
            padding-bottom: 15px;
            background: rgba(7, 11, 22, .78);
            border-bottom-color: rgba(148, 163, 184, .12);
            box-shadow: 0 10px 35px rgba(0, 0, 0, .12);
        }

        .logo {
            font-size: 23px;
            text-shadow: 0 0 24px rgba(54, 133, 255, .24);
        }

        nav a {
            position: relative;
            padding: 8px 0;
        }

        nav a::after {
            content: '';
            position: absolute;
            right: 0;
            bottom: 1px;
            left: 0;
            height: 2px;
            border-radius: 2px;
            background: var(--blue);
            transform: scaleX(0);
            transform-origin: left;
            transition: transform .2s ease;
        }

        nav a:hover::after {
            transform: scaleX(1);
        }

        .login-btn,
        .register-btn,
        .dashboard-btn,
        .logout-btn {
            padding: 10px 16px;
            border-radius: 10px;
        }

        .register-btn,
        .dashboard-btn {
            box-shadow: 0 8px 22px rgba(54, 133, 255, .2);
        }

        .hero {
            min-height: 790px;
            padding-top: 155px;
            background:
                radial-gradient(ellipse at 78% 46%, rgba(54, 133, 255, .18), transparent 36%),
                radial-gradient(ellipse at 5% 90%, rgba(139, 92, 246, .14), transparent 38%),
                linear-gradient(135deg, #080d1a 4%, #080e1d 56%, #0b1021);
        }

        .hero::before {
            width: 610px;
            height: 610px;
            right: 2%;
            top: 90px;
            border-color: rgba(96, 165, 250, .12);
            box-shadow: 0 0 120px rgba(54, 133, 255, .12), inset 0 0 90px rgba(139, 92, 246, .05);
        }

        .hero::after {
            content: '';
            position: absolute;
            inset: 0;
            pointer-events: none;
            opacity: .14;
            background-image: linear-gradient(rgba(148, 163, 184, .08) 1px, transparent 1px), linear-gradient(90deg, rgba(148, 163, 184, .08) 1px, transparent 1px);
            background-size: 58px 58px;
            mask-image: linear-gradient(90deg, transparent, #000 65%, transparent);
        }

        .hero-content {
            width: 54%;
            max-width: 650px;
        }

        .tag {
            padding: 9px 14px;
            border-radius: 9px;
            font-weight: 600;
            letter-spacing: 1.7px;
            box-shadow: inset 0 1px rgba(255, 255, 255, .06);
        }

        .hero h1 {
            font-size: clamp(42px, 5.2vw, 72px);
            line-height: 1.15;
            letter-spacing: -1.6px;
            text-shadow: 0 10px 45px rgba(0, 0, 0, .22);
        }

        .hero h1 span {
            background: linear-gradient(100deg, #60a5fa 12%, #a78bfa 88%);
            background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .hero p {
            max-width: 490px;
            font-size: 14px;
        }

        .hero-actions {
            gap: 12px;
            margin-top: 27px;
        }

        .main-button,
        .second-button {
            padding: 14px 20px;
            border-radius: 10px;
        }

        .main-button {
            background: linear-gradient(105deg, #2563eb, #3685ff);
            box-shadow: 0 12px 30px rgba(54, 133, 255, .24);
        }

        .second-button {
            border-color: rgba(148, 163, 184, .25);
            background: rgba(15, 23, 42, .4);
        }

        .hero-image {
            right: 8%;
            width: 39%;
            max-width: 520px;
            padding: 10px;
            border: 1px solid rgba(148, 163, 184, .18);
            border-radius: 25px;
            background: linear-gradient(145deg, rgba(255, 255, 255, .1), rgba(255, 255, 255, .015));
            box-shadow: 0 35px 90px rgba(0, 0, 0, .38), 0 0 55px rgba(54, 133, 255, .1);
            transform: translateY(-50%) rotate(1deg);
        }

        .hero-image img {
            display: block;
            height: 390px;
            border: 1px solid rgba(96, 165, 250, .25);
            border-radius: 17px;
            object-position: center 42%;
            box-shadow: inset 0 0 30px rgba(0, 0, 0, .2);
        }

        .floating-card {
            position: relative;
            width: fit-content;
            margin: 14px 0 0 10px;
            padding: 15px 20px;
            border: 1px solid rgba(96, 165, 250, .25);
            border-radius: 13px;
            background: rgba(10, 17, 31, .9);
            box-shadow: 0 18px 45px rgba(0, 0, 0, .35);
            backdrop-filter: blur(14px);
        }

        .floating-card small {
            letter-spacing: 1.3px;
        }

        .floating-card h3 {
            font-size: 15px;
            letter-spacing: .5px;
        }

        .stats {
            position: relative;
            padding-top: 30px;
            padding-bottom: 30px;
            background: linear-gradient(90deg, #0b1222, #0f182b 50%, #0b1222);
        }

        .stat {
            padding: 4px 12px;
        }

        .stat h2 {
            font-size: 25px;
            text-shadow: 0 0 24px rgba(102, 165, 255, .16);
        }

        .stat p {
            letter-spacing: 1.4px;
        }

        .section {
            padding-top: 88px;
            padding-bottom: 88px;
        }

        .section-heading {
            max-width: 650px;
            margin-bottom: 32px;
        }

        .section-heading small {
            display: inline-block;
            padding: 7px 10px;
            border: 1px solid rgba(54, 133, 255, .17);
            border-radius: 7px;
            background: rgba(54, 133, 255, .07);
            letter-spacing: 2.2px;
        }

        .section-heading h2 {
            font-size: clamp(24px, 3vw, 32px);
            line-height: 1.35;
            letter-spacing: -.5px;
        }

        .section-heading p {
            max-width: 540px;
        }

        .cards {
            gap: 16px;
        }

        .card {
            min-height: 220px;
            padding: 24px;
            border-color: rgba(148, 163, 184, .14);
            border-radius: 17px;
            background: linear-gradient(145deg, rgba(18, 29, 52, .96), rgba(11, 18, 33, .96));
            box-shadow: 0 15px 40px rgba(0, 0, 0, .13);
        }

        .card:hover {
            transform: translateY(-5px);
            border-color: rgba(96, 165, 250, .45);
        }

        .game-icon {
            width: 48px;
            height: 48px;
            margin-bottom: 22px;
            border: 1px solid rgba(96, 165, 250, .16);
            border-radius: 14px;
            background: linear-gradient(145deg, rgba(54, 133, 255, .19), rgba(54, 133, 255, .06));
        }

        .card h3 {
            font-size: 16px;
        }

        .tournament-section {
            background:
                radial-gradient(ellipse at 10% 75%, rgba(139, 92, 246, .08), transparent 35%),
                linear-gradient(180deg, #080d19, #0c1426);
        }

        .tournament-card {
            border-color: rgba(96, 165, 250, .22);
            border-radius: 20px;
            background: linear-gradient(145deg, #111c31, #0d1527);
            box-shadow: 0 24px 60px rgba(0, 0, 0, .2);
        }

        .tournament-visual {
            position: relative;
            overflow: hidden;
            background:
                radial-gradient(circle at 50% 45%, rgba(54, 133, 255, .27), transparent 48%),
                repeating-linear-gradient(135deg, rgba(255, 255, 255, .025) 0 1px, transparent 1px 14px),
                linear-gradient(135deg, #111d36, #101326);
        }

        .tournament-visual::before,
        .tournament-visual::after {
            content: '';
            position: absolute;
            width: 170px;
            height: 170px;
            border: 1px solid rgba(96, 165, 250, .15);
            border-radius: 50%;
        }

        .tournament-visual::after {
            width: 245px;
            height: 245px;
        }

        .ml-logo {
            z-index: 1;
            font-size: clamp(60px, 8vw, 88px);
        }

        .tournament-info {
            padding: clamp(28px, 4vw, 46px);
        }

        .status {
            font-weight: 600;
            letter-spacing: .7px;
        }

        .tournament-info h3 {
            font-size: clamp(19px, 2.3vw, 25px);
            letter-spacing: -.4px;
        }

        .detail strong {
            font-size: 12px;
        }

        .access-section {
            padding-top: 70px;
            padding-bottom: 82px;
        }

        .access-box {
            position: relative;
            overflow: hidden;
            padding: 58px 30px;
            border-color: rgba(96, 165, 250, .25);
            border-radius: 22px;
            background:
                radial-gradient(ellipse at 10% 100%, rgba(139, 92, 246, .14), transparent 38%),
                radial-gradient(ellipse at 90% 0, rgba(54, 133, 255, .2), transparent 42%),
                linear-gradient(135deg, #101a30, #11192d);
            box-shadow: 0 24px 65px rgba(0, 0, 0, .2);
        }

        .access-box h2 {
            font-size: clamp(23px, 3vw, 31px);
            letter-spacing: -.5px;
        }

        .access-box > p {
            max-width: 500px;
            margin-right: auto;
            margin-left: auto;
            line-height: 1.8;
        }

        .access-buttons a {
            min-width: 175px;
        }

        footer {
            background: #0a101e;
            border-top-color: rgba(148, 163, 184, .12);
        }

        .footer-logo {
            letter-spacing: 1.5px;
        }

        a:focus-visible,
        button:focus-visible {
            outline: 2px solid #93c5fd;
            outline-offset: 3px;
        }

        @media (max-width: 950px) {
            .hero {
                min-height: 700px;
            }

            .hero-image {
                width: 40%;
            }

            .hero-image img {
                height: 310px;
            }
        }

        @media (max-width: 650px) {
            header {
                padding-top: 12px;
                padding-bottom: 12px;
                background: rgba(7, 11, 22, .94);
            }

            .hero {
                min-height: auto;
                padding-top: 165px;
                padding-bottom: 65px;
            }

            .hero-content {
                width: 100%;
            }

            .hero h1 {
                font-size: clamp(34px, 8.5vw, 46px);
                letter-spacing: -.8px;
            }

            .hero::before {
                width: 390px;
                height: 390px;
                right: -210px;
                top: 300px;
            }

            .hero-image {
                width: 100%;
                margin-top: 35px;
                transform: none;
            }

            .hero-image img {
                height: 270px;
            }

            .floating-card {
                margin: 12px 0 0 10px;
                padding: 12px 15px;
            }

            .stats {
                gap: 8px;
                padding: 22px 4%;
            }

            .stat h2 {
                font-size: 18px;
            }

            .stat p {
                font-size: 8px;
                letter-spacing: .5px;
            }

            .section {
                padding-top: 65px;
                padding-bottom: 65px;
            }

            .card {
                min-height: 0;
            }

            .access-section {
                padding-top: 48px;
                padding-bottom: 60px;
            }

            .access-box {
                padding: 42px 20px;
            }
        }

        @media (prefers-reduced-motion: reduce) {
            *,
            *::before,
            *::after {
                scroll-behavior: auto !important;
                transition-duration: .01ms !important;
            }
        }
    </style>
</head>

<body>

<header>
    <a href="{{ url('/') }}" class="logo">ARENA<span>Z.</span></a>

    <nav>
        <a href="{{ url('/') }}">Home</a>
        <a href="#tentang">Tentang</a>
        <a href="{{ url('/turnamen') }}">Turnamen</a>
        <a href="{{ url('/jadwal') }}">Jadwal</a>
        <a href="{{ url('/bracket') }}">Bracket</a>
    </nav>

    <div class="nav-actions">
        @auth
            @if(auth()->user()->role === 'admin')
                <a href="{{ url('/admin/dashboard') }}" class="dashboard-btn">Dashboard Admin</a>
            @else
                <a href="{{ url('/user/dashboard') }}" class="dashboard-btn">Dashboard Saya</a>
            @endif

            <form action="{{ url('/logout') }}" method="POST">
                @csrf
                <button type="submit" class="logout-btn">Logout</button>
            </form>
        @else
            <a href="{{ url('/pilih-login') }}" class="login-btn">Login</a>
            <a href="{{ url('/user/register') }}" class="register-btn">Daftar</a>
        @endauth
    </div>
</header>

<!-- HERO -->
<section class="hero" id="home">

    <div class="hero-content">
        <div class="tag">★ STUDENT ESPORTS PLATFORM</div>

        <h1>
            YOUR GAME.<br>
            YOUR <span>ARENA.</span>
        </h1>

        <p>
            Tempat berkumpulnya para pelajar yang memiliki semangat
            kompetisi Mobile Legends. Bentuk tim terbaikmu, susun
            strategi, dan buktikan kemampuanmu di ARENA Z.
        </p>

        <div class="hero-actions">
            <a href="{{ url('/turnamen') }}" class="main-button">
                JELAJAHI TURNAMEN →
            </a>

            <a href="#tentang" class="second-button">
                PELAJARI LEBIH LANJUT
            </a>
        </div>
    </div>

    <div class="hero-image">
        <img src="{{ asset('foto1.png') }}" alt="ARENA Z Esports">

        <div class="floating-card">
            <small>GAME COMPETITION</small>
            <h3>MOBILE LEGENDS</h3>
        </div>
    </div>

</section>

<!-- STATISTIK -->
<section class="stats">
    <div class="stat">
        <h2>5 VS 5</h2>
        <p>FORMAT PERTANDINGAN</p>
    </div>

    <div class="stat">
        <h2>MLBB</h2>
        <p>GAME UTAMA</p>
    </div>

    <div class="stat">
        <h2>STUDENT</h2>
        <p>TARGET PESERTA</p>
    </div>
</section>

<!-- TENTANG -->
<section class="section" id="tentang">

    <div class="section-heading">
        <small>ABOUT ARENA Z</small>
        <h2>MORE THAN JUST A GAME.</h2>
        <p>
            ARENA Z merupakan platform turnamen esports
            yang dirancang khusus untuk pelajar.
        </p>
    </div>

    <div class="cards">

        <div class="card">
            <div class="game-icon">01</div>
            <h3>Competitive</h3>
            <p>
                Ikuti turnamen Mobile Legends dan uji
                kemampuan timmu melawan tim lainnya.
            </p>
        </div>

        <div class="card">
            <div class="game-icon">02</div>
            <h3>Teamwork</h3>
            <p>
                Bangun kerja sama, komunikasi, dan strategi
                bersama anggota tim.
            </p>
        </div>

        <div class="card">
            <div class="game-icon">03</div>
            <h3>Achievement</h3>
            <p>
                Dapatkan pengalaman baru dan raih prestasi
                melalui kompetisi esports pelajar.
            </p>
        </div>

    </div>

</section>

<!-- TURNAMEN -->
<section class="section tournament-section" id="turnamen">

    <div class="section-heading">
        <small>MAIN COMPETITION</small>
        <h2>MLBB TOURNAMENT</h2>
        <p>
            Siapkan tim terbaikmu dan bersiaplah untuk
            menghadapi kompetisi Mobile Legends antar pelajar.
        </p>
    </div>

    <div class="tournament-card">

        <div class="tournament-visual">
            <div class="ml-logo">MLBB</div>
        </div>

        <div class="tournament-info">

            <div class="status">● STUDENT ESPORTS</div>

            <h3>STUDENT MLBB CUP</h3>

            <p>
                Kompetisi Mobile Legends dengan format
                pertandingan 5 vs 5. Daftarkan timmu dan
                jadilah bagian dari pertandingan ARENA Z.
            </p>

            <div class="tournament-details">
                <div class="detail">
                    <small>GAME</small>
                    <strong>Mobile Legends</strong>
                </div>

                <div class="detail">
                    <small>FORMAT</small>
                    <strong>5 VS 5</strong>
                </div>

                <div class="detail">
                    <small>PESERTA</small>
                    <strong>Pelajar</strong>
                </div>
            </div>

            <div>
                <a href="{{ url('/turnamen') }}" class="main-button">
                    LIHAT TURNAMEN →
                </a>
            </div>

        </div>

    </div>

</section>

<!-- AKSES LOGIN -->
<section class="access-section">

    <div class="access-box">

        @auth
            <h2>WELCOME BACK!</h2>
            <p>
                Kamu sudah login. Silakan lanjutkan ke dashboard
                untuk mengakses fitur ARENA Z.
            </p>

            @if(auth()->user()->role === 'admin')
                <a href="{{ url('/admin/dashboard') }}" class="main-button">
                    BUKA DASHBOARD ADMIN →
                </a>
            @else
                <a href="{{ url('/user/dashboard') }}" class="main-button">
                    BUKA DASHBOARD SAYA →
                </a>
            @endif

        @else
            <h2>ENTER YOUR ARENA.</h2>

            <p>
                Pilih jenis akun untuk masuk ke platform
                atau buat akun baru untuk bergabung.
            </p>

            <div class="access-buttons">
                <a href="{{ url('/admin/login') }}" class="second-button">
                    LOGIN ADMIN
                </a>

                <a href="{{ url('/user/login') }}" class="main-button">
                    LOGIN USER
                </a>

                <a href="{{ url('/user/register') }}" class="second-button">
                    DAFTAR AKUN
                </a>
            </div>
        @endauth

    </div>

</section>

<!-- FOOTER -->
<footer>
    <div class="footer-logo">ARENA<span>Z.</span></div>

    <p>© 2026 ARENA Z. STUDENT ESPORTS PLATFORM.</p>

    <p>YOUR GAME. YOUR ARENA.</p>
</footer>

</body>
</html>

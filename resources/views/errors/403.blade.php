<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>403 — Forbidden</title>
  <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=DM+Mono:wght@300;400&display=swap" rel="stylesheet"/>
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    :root {
      --bg: #f4f2ee;
      --ink: #0d0d0d;
      --mid: #8a8880;
    }

    html, body {
      height: 100%;
      background: var(--bg);
      color: var(--ink);
      font-family: 'DM Mono', monospace;
      overflow: hidden;
    }

    /* ── SVG canvas ── */
    .geo {
      position: fixed;
      inset: 0;
      width: 100%;
      height: 100%;
      z-index: 0;
    }

    /* ── Content ── */
    .stage {
      position: relative;
      z-index: 1;
      height: 100vh;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      gap: 0;
    }

    .code {
      font-family: 'DM Serif Display', serif;
      font-size: clamp(7rem, 20vw, 14rem);
      line-height: 1;
      letter-spacing: -0.04em;
      color: var(--ink);
      opacity: 0;
      transform: translateY(24px);
      animation: rise 0.9s cubic-bezier(0.16,1,0.3,1) 0.1s forwards;
    }

    .line {
      width: clamp(160px, 28vw, 320px);
      height: 1px;
      background: var(--ink);
      transform: scaleX(0);
      transform-origin: left;
      animation: expand 0.7s cubic-bezier(0.16,1,0.3,1) 0.6s forwards;
    }

    .label {
      margin-top: 20px;
      font-size: 0.7rem;
      letter-spacing: 0.28em;
      text-transform: uppercase;
      color: var(--mid);
      opacity: 0;
      animation: rise 0.6s ease 0.85s forwards;
    }

    .msg {
      margin-top: 8px;
      font-size: 0.78rem;
      color: var(--mid);
      letter-spacing: 0.06em;
      opacity: 0;
      animation: rise 0.6s ease 1s forwards;
    }

    .back {
      margin-top: 40px;
      display: inline-block;
      padding: 10px 28px;
      border: 1px solid var(--ink);
      font-family: 'DM Mono', monospace;
      font-size: 0.7rem;
      letter-spacing: 0.2em;
      text-transform: uppercase;
      color: var(--ink);
      text-decoration: none;
      opacity: 0;
      animation: rise 0.6s ease 1.15s forwards;
      transition: background 0.2s, color 0.2s;
    }
    .back:hover {
      background: var(--ink);
      color: var(--bg);
    }

    @keyframes rise {
      to { opacity: 1; transform: translateY(0); }
    }
    @keyframes expand {
      to { transform: scaleX(1); }
    }

    /* geo animations */
    .geo-shape {
      animation: spin 22s linear infinite;
      transform-origin: center;
      transform-box: fill-box;
    }
    .geo-shape.rev { animation-direction: reverse; animation-duration: 18s; }
    .geo-shape.slow { animation-duration: 35s; }

    @keyframes spin {
      to { transform: rotate(360deg); }
    }
  </style>
</head>
<body>

<!-- Geometric background -->
<svg class="geo" viewBox="0 0 1000 1000" preserveAspectRatio="xMidYMid slice" xmlns="http://www.w3.org/2000/svg">
  <defs>
    <filter id="blur1"><feGaussianBlur stdDeviation="0.5"/></filter>
  </defs>

  <!-- Large rotating square top-right -->
  <rect class="geo-shape slow" x="680" y="-80" width="320" height="320"
        fill="none" stroke="#0d0d0d" stroke-width="1" opacity="0.12"/>
  <rect class="geo-shape rev" x="710" y="-50" width="260" height="260"
        fill="none" stroke="#0d0d0d" stroke-width="0.5" opacity="0.1"/>

  <!-- Circle cluster bottom-left -->
  <circle class="geo-shape" cx="100" cy="860" r="180"
          fill="none" stroke="#0d0d0d" stroke-width="1" opacity="0.1"/>
  <circle class="geo-shape rev" cx="100" cy="860" r="130"
          fill="none" stroke="#0d0d0d" stroke-width="0.5" opacity="0.08"/>
  <circle cx="100" cy="860" r="4" fill="#0d0d0d" opacity="0.15"/>

  <!-- Triangle mid-left -->
  <polygon class="geo-shape slow" points="60,400 160,250 260,400"
           fill="none" stroke="#0d0d0d" stroke-width="0.8" opacity="0.1"/>

  <!-- Dot grid top-left -->
  <g opacity="0.07">
    <circle cx="40" cy="40" r="1.5" fill="#0d0d0d"/>
    <circle cx="70" cy="40" r="1.5" fill="#0d0d0d"/>
    <circle cx="100" cy="40" r="1.5" fill="#0d0d0d"/>
    <circle cx="130" cy="40" r="1.5" fill="#0d0d0d"/>
    <circle cx="40" cy="70" r="1.5" fill="#0d0d0d"/>
    <circle cx="70" cy="70" r="1.5" fill="#0d0d0d"/>
    <circle cx="100" cy="70" r="1.5" fill="#0d0d0d"/>
    <circle cx="130" cy="70" r="1.5" fill="#0d0d0d"/>
    <circle cx="40" cy="100" r="1.5" fill="#0d0d0d"/>
    <circle cx="70" cy="100" r="1.5" fill="#0d0d0d"/>
    <circle cx="100" cy="100" r="1.5" fill="#0d0d0d"/>
    <circle cx="130" cy="100" r="1.5" fill="#0d0d0d"/>
    <circle cx="40" cy="130" r="1.5" fill="#0d0d0d"/>
    <circle cx="70" cy="130" r="1.5" fill="#0d0d0d"/>
    <circle cx="100" cy="130" r="1.5" fill="#0d0d0d"/>
    <circle cx="130" cy="130" r="1.5" fill="#0d0d0d"/>
  </g>

  <!-- Diagonal lines bottom-right -->
  <g opacity="0.07" stroke="#0d0d0d" stroke-width="0.8">
    <line x1="820" y1="880" x2="1000" y2="700"/>
    <line x1="840" y1="920" x2="1000" y2="760"/>
    <line x1="860" y1="960" x2="1000" y2="820"/>
    <line x1="880" y1="1000" x2="1000" y2="880"/>
    <line x1="800" y1="840" x2="1000" y2="640"/>
  </g>

  <!-- Small accent cross center-right -->
  <g opacity="0.18" stroke="#0d0d0d" stroke-width="1" transform="translate(820,480)">
    <line x1="-12" y1="0" x2="12" y2="0"/>
    <line x1="0" y1="-12" x2="0" y2="12"/>
  </g>
  <g opacity="0.1" stroke="#0d0d0d" stroke-width="0.8" transform="translate(200,600)">
    <line x1="-8" y1="0" x2="8" y2="0"/>
    <line x1="0" y1="-8" x2="0" y2="8"/>
  </g>

  <!-- Hexagon mid-right -->
  <polygon class="geo-shape" points="900,300 930,283 960,300 960,334 930,351 900,334"
           fill="none" stroke="#0d0d0d" stroke-width="0.8" opacity="0.1"/>
</svg>

<!-- Main content -->
<div class="stage">
  <div class="code">403</div>
  <div class="line"></div>
  <div class="label">Access Forbidden</div>
  <div class="msg">You don't have permission to view this page.</div>
  <a class="back" href="{{ route('dashboard') }}">← Return Home</a>
</div>

</body>
</html>

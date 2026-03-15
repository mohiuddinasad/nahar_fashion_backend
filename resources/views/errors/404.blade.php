<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>404 - Page Not Found</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .auth-wrap { display:flex; flex-direction:column; width:100%; max-width:820px; border-radius:20px; overflow:hidden; background:#fff; border:0.5px solid #f0e0de; }
        .auth-left { background:#fdf0ee; display:flex; flex-direction:column; align-items:center; justify-content:center; padding:2rem; gap:1rem; }
        .auth-right { flex:1; padding:2rem 1.5rem; display:flex; flex-direction:column; justify-content:center; background:#fff; }
        .auth-btn-primary { padding:10px 22px; background:#D19C97; color:#fff; border-radius:10px; font-size:13px; font-weight:500; text-decoration:none; display:inline-block; touch-action:manipulation; }
        .auth-btn-primary:hover { background:#c48c87; }
        .auth-btn-secondary { padding:10px 22px; background:#fdf0ee; color:#b07a75; border-radius:10px; font-size:13px; font-weight:500; text-decoration:none; display:inline-block; border:1px solid #f0dbd8; touch-action:manipulation; }
        .auth-btn-secondary:hover { background:#fae4e0; }
        @media (min-width: 640px) {
            .auth-wrap { flex-direction:row; }
            .auth-left { flex:0 0 42%; max-width:42%; padding:2.5rem; gap:1.5rem; }
            .auth-right { padding:2.5rem 2rem; }
        }
    </style>
</head>
<body style="margin:0;padding:0;background-color:#fdf6f5;">
    <div style="min-height:100vh; display:flex; align-items:center; justify-content:center; padding:1rem;">
        <div class="auth-wrap">

            <!-- Left Illustration Side -->
            <div class="auth-left">
                <svg viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg" style="width:clamp(80px,20vw,160px); height:clamp(80px,20vw,160px);">
                    <circle cx="100" cy="100" r="90" fill="#fae4e0"/>
                    <circle cx="92" cy="90" r="36" fill="#e8c4be"/>
                    <circle cx="92" cy="90" r="28" fill="#fdf6f5"/>
                    <text x="84" y="98" font-size="26" font-weight="600" fill="#D19C97" font-family="sans-serif">?</text>
                    <line x1="112" y1="112" x2="138" y2="140" stroke="#e8c4be" stroke-width="11" stroke-linecap="round"/>
                    <line x1="112" y1="112" x2="138" y2="140" stroke="#D19C97" stroke-width="6" stroke-linecap="round"/>
                    <circle cx="50" cy="62" r="4" fill="#f5c8c0"/>
                    <circle cx="158" cy="65" r="3.5" fill="#f5c8c0"/>
                    <circle cx="44" cy="148" r="3" fill="#edb8b0"/>
                    <circle cx="160" cy="152" r="4" fill="#e8b8b0"/>
                    <circle cx="100" cy="170" r="3.5" fill="#edb8b0"/>
                </svg>
                <div style="text-align:center;">
                    <h2 style="font-size:17px; font-weight:500; color:#5a3a36; margin:0;">Lost in space</h2>
                    <p style="font-size:12px; color:#a07870; margin-top:5px; line-height:1.6;">The page you're looking for<br/>doesn't exist.</p>
                </div>
            </div>

            <!-- Right Content Side -->
            <div class="auth-right">
                <div style="display:inline-flex; align-items:center; justify-content:center; width:52px; height:52px; border-radius:14px; background:#fdf0ee; margin-bottom:1.25rem;">
                    <svg width="24" height="24" fill="none" stroke="#D19C97" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                        <circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/>
                    </svg>
                </div>
                <p style="font-size:12px; font-weight:500; color:#D19C97; margin:0 0 6px; letter-spacing:0.08em; text-transform:uppercase;">Error 404</p>
                <h1 style="font-size:clamp(22px,5vw,28px); font-weight:500; color:#3a2a28; margin:0 0 10px;">Page not found</h1>
                <p style="font-size:clamp(12px,3vw,13px); color:#a09090; margin:0 0 2rem; line-height:1.7;">Oops! The page you're looking for doesn't exist or may have been moved. Double-check the URL or head back home.</p>
                <div style="display:flex; gap:10px; flex-wrap:wrap;">
                    <a href="{{ url('/') }}" class="auth-btn-primary">Go home</a>
                    <a href="javascript:history.back()" class="auth-btn-secondary">Go back</a>
                </div>
            </div>

        </div>
    </div>
</body>
</html>

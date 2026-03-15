<x-guest-layout>

    <style>
        .auth-wrap { display:flex; flex-direction:column; width:100%; max-width:820px; border-radius:20px; overflow:hidden; background:#fff; border:0.5px solid #f0e0de; }
        .auth-left { background:#fdf0ee; display:flex; flex-direction:column; align-items:center; justify-content:center; padding:2rem; gap:1rem; }
        .auth-right { flex:1; padding:2rem 1.5rem; display:flex; flex-direction:column; justify-content:center; background:#fff; }
        .auth-input { width:100%; padding:11px 13px; border-radius:10px; border:1px solid #f0dbd8; background:#fffafa; font-size:14px; color:#3a2a28; outline:none; -webkit-appearance:none; box-sizing:border-box; }
        .auth-input:focus { border-color:#D19C97; box-shadow:0 0 0 3px rgba(209,156,151,0.15); }
        .auth-btn { width:100%; padding:12px; background:#D19C97; color:#fff; border:none; border-radius:10px; font-size:14px; font-weight:500; cursor:pointer; letter-spacing:0.02em; touch-action:manipulation; }
        .auth-btn:hover { background:#c48c87; }
        .auth-label { display:block; font-size:12px; font-weight:500; color:#7a5a55; margin-bottom:5px; }
        @media (min-width: 640px) {
            .auth-wrap { flex-direction:row; }
            .auth-left { flex:0 0 42%; max-width:42%; padding:2.5rem; gap:1.5rem; }
            .auth-right { padding:2.5rem 2rem; }
        }
    </style>

    <div style="min-height:100vh; display:flex; align-items:center; justify-content:center; padding:1rem; background-color:#fdf6f5;">
        <div class="auth-wrap">

            <!-- Left Illustration Side -->
            <div class="auth-left">
                <svg viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg" style="width:clamp(80px,20vw,160px); height:clamp(80px,20vw,160px);">
                    <circle cx="100" cy="100" r="90" fill="#fae4e0"/>
                    <rect x="42" y="72" width="116" height="80" rx="10" fill="#e8c4be"/>
                    <rect x="47" y="77" width="106" height="70" rx="7" fill="#fdf6f5"/>
                    <path d="M47 84l53 38 53-38" stroke="#e0b8b2" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <rect x="82" y="108" width="36" height="26" rx="6" fill="#D19C97"/>
                    <path d="M90 108v-6a10 10 0 0 1 20 0v6" stroke="#e8c4be" stroke-width="2.2" stroke-linecap="round"/>
                    <circle cx="100" cy="121" r="3.5" fill="#fff"/>
                    <circle cx="50" cy="68" r="4" fill="#f5c8c0"/>
                    <circle cx="160" cy="68" r="3.5" fill="#f5c8c0"/>
                    <circle cx="45" cy="155" r="3" fill="#edb8b0"/>
                    <circle cx="158" cy="158" r="4" fill="#e8b8b0"/>
                </svg>
                <div style="text-align:center;">
                    <h2 style="font-size:17px; font-weight:500; color:#5a3a36; margin:0;">Password reset</h2>
                    <p style="font-size:12px; color:#a07870; margin-top:5px; line-height:1.6;">We'll send a reset link<br/>straight to your inbox.</p>
                </div>
            </div>

            <!-- Right Form Side -->
            <div class="auth-right">
                <h1 style="font-size:clamp(18px,4vw,22px); font-weight:500; color:#3a2a28; margin:0 0 4px;">Forgot password?</h1>
                <p style="font-size:13px; color:#a09090; margin:0 0 1.5rem; line-height:1.6;">{{ __("No problem. Enter your email and we'll send you a reset link.") }}</p>

                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('password.email') }}">
                    @csrf

                    <div style="margin-bottom:1.5rem;">
                        <label for="email" class="auth-label">{{ __('Email address') }}</label>
                        <input id="email" class="auth-input" type="email" name="email" value="{{ old('email') }}" required autofocus placeholder="you@example.com"
                            onfocus="this.style.borderColor='#D19C97';this.style.boxShadow='0 0 0 3px rgba(209,156,151,0.15)';"
                            onblur="this.style.borderColor='#f0dbd8';this.style.boxShadow='none';" />
                        <x-input-error :messages="$errors->get('email')" class="mt-1" />
                    </div>

                    <button type="submit" class="auth-btn">{{ __('Email Password Reset Link') }}</button>

                    <p style="text-align:center; font-size:13px; color:#b0a0a0; margin-top:1.1rem;">
                        {{ __('Remember your password?') }}
                        <a href="{{ route('login') }}" style="font-weight:500; color:#D19C97; text-decoration:none;">{{ __('Sign in') }}</a>
                    </p>
                </form>
            </div>

        </div>
    </div>
</x-guest-layout>

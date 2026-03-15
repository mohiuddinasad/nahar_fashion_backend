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
                    <rect x="45" y="85" width="110" height="68" rx="8" fill="#e8c4be"/>
                    <rect x="50" y="90" width="100" height="55" rx="5" fill="#fdf6f5"/>
                    <rect x="60" y="100" width="50" height="5" rx="2.5" fill="#e0b8b2"/>
                    <rect x="60" y="112" width="35" height="4" rx="2" fill="#edd0cc"/>
                    <rect x="60" y="123" width="42" height="4" rx="2" fill="#edd0cc"/>
                    <rect x="118" y="104" width="22" height="18" rx="4" fill="#D19C97"/>
                    <path d="M124 104v-4a5 5 0 0 1 10 0v4" stroke="#fff" stroke-width="2" stroke-linecap="round"/>
                    <circle cx="129" cy="113" r="2.5" fill="#fff"/>
                    <rect x="35" y="153" width="130" height="7" rx="3.5" fill="#d4a8a2"/>
                    <circle cx="160" cy="70" r="5" fill="#f5c8c0"/>
                    <circle cx="40" cy="130" r="4" fill="#f5c8c0"/>
                    <circle cx="170" cy="130" r="3" fill="#edb8b0"/>
                    <circle cx="55" cy="70" r="3" fill="#e8b8b0"/>
                    <circle cx="155" cy="150" r="3.5" fill="#e8b8b0"/>
                </svg>
                <div style="text-align:center;">
                    <h2 style="font-size:17px; font-weight:500; color:#5a3a36; margin:0;">Secure sign in</h2>
                    <p style="font-size:12px; color:#a07870; margin-top:5px; line-height:1.6;">Your data is safe.<br/>Sign in to get started.</p>
                </div>
            </div>

            <!-- Right Form Side -->
            <div class="auth-right">
                <h1 style="font-size:clamp(18px,4vw,22px); font-weight:500; color:#3a2a28; margin:0 0 4px;">Welcome back</h1>
                <p style="font-size:13px; color:#a09090; margin:0 0 1.5rem;">Enter your details below</p>

                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <!-- Email -->
                    <div style="margin-bottom:1rem;">
                        <label for="email" class="auth-label">{{ __('Email address') }}</label>
                        <input id="email" class="auth-input" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="you@example.com"
                            onfocus="this.style.borderColor='#D19C97';this.style.boxShadow='0 0 0 3px rgba(209,156,151,0.15)';"
                            onblur="this.style.borderColor='#f0dbd8';this.style.boxShadow='none';" />
                        <x-input-error :messages="$errors->get('email')" class="mt-1" />
                    </div>

                    <!-- Password -->
                    <div style="margin-bottom:1rem;">
                        <label for="password" class="auth-label">{{ __('Password') }}</label>
                        <div style="position:relative;">
                            <input id="password" class="auth-input" type="password" name="password" required autocomplete="current-password" placeholder="••••••••"
                                style="padding-right:42px;"
                                onfocus="this.style.borderColor='#D19C97';this.style.boxShadow='0 0 0 3px rgba(209,156,151,0.15)';"
                                onblur="this.style.borderColor='#f0dbd8';this.style.boxShadow='none';" />
                            <button type="button"
                                onclick="var i=document.getElementById('password'),o=document.getElementById('eo'),c=document.getElementById('ec');if(i.type==='password'){i.type='text';o.style.display='none';c.style.display='block';}else{i.type='password';o.style.display='block';c.style.display='none';}"
                                style="position:absolute;right:12px;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;padding:4px;display:flex;align-items:center;touch-action:manipulation;">
                                <svg id="eo" width="18" height="18" fill="none" stroke="#c4a09a" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                <svg id="ec" width="18" height="18" fill="none" stroke="#c4a09a" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" style="display:none;"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/></svg>
                            </button>
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-1" />
                    </div>

                    <!-- Remember + Forgot -->
                    <div style="display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:8px; margin-bottom:1.5rem;">
                        <label style="display:flex; align-items:center; gap:6px; font-size:13px; color:#a09090; cursor:pointer;">
                            <input type="checkbox" name="remember" style="accent-color:#D19C97; width:15px; height:15px;" />
                            {{ __('Remember me') }}
                        </label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" style="font-size:13px; font-weight:500; color:#D19C97; text-decoration:none;">{{ __('Forgot password?') }}</a>
                        @endif
                    </div>

                    <button type="submit" class="auth-btn">{{ __('Log in') }}</button>

                    @if (Route::has('register'))
                        <p style="text-align:center; font-size:13px; color:#b0a0a0; margin-top:1.1rem;">
                            {{ __("Don't have an account?") }}
                            <a href="{{ route('register') }}" style="font-weight:500; color:#D19C97; text-decoration:none;">{{ __('Register') }}</a>
                        </p>
                    @endif
                </form>
            </div>

        </div>
    </div>
</x-guest-layout>

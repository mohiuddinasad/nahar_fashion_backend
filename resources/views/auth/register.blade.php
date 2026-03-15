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
                    <circle cx="100" cy="78" r="22" fill="#e8c4be"/>
                    <path d="M58 158c0-23.2 18.8-42 42-42h0c23.2 0 42 18.8 42 42" fill="#D19C97"/>
                    <circle cx="148" cy="68" r="16" fill="#fdf6f5" stroke="#e8c4be" stroke-width="1.5"/>
                    <path d="M141 68l5 5 9-9" stroke="#D19C97" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/>
                    <circle cx="52" cy="80" r="4" fill="#f5c8c0"/>
                    <circle cx="160" cy="130" r="3.5" fill="#f5c8c0"/>
                    <circle cx="55" cy="140" r="3" fill="#e8b8b0"/>
                    <circle cx="165" cy="75" r="2.5" fill="#e8b8b0"/>
                </svg>
                <div style="text-align:center;">
                    <h2 style="font-size:17px; font-weight:500; color:#5a3a36; margin:0;">Create account</h2>
                    <p style="font-size:12px; color:#a07870; margin-top:5px; line-height:1.6;">Join us today.<br/>It only takes a minute.</p>
                </div>
            </div>

            <!-- Right Form Side -->
            <div class="auth-right">
                <h1 style="font-size:clamp(18px,4vw,22px); font-weight:500; color:#3a2a28; margin:0 0 4px;">Register</h1>
                <p style="font-size:13px; color:#a09090; margin:0 0 1.5rem;">Fill in your details to get started</p>

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <!-- Name -->
                    <div style="margin-bottom:1rem;">
                        <label for="name" class="auth-label">{{ __('Name') }}</label>
                        <input id="name" class="auth-input" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" placeholder="John Doe"
                            onfocus="this.style.borderColor='#D19C97';this.style.boxShadow='0 0 0 3px rgba(209,156,151,0.15)';"
                            onblur="this.style.borderColor='#f0dbd8';this.style.boxShadow='none';" />
                        <x-input-error :messages="$errors->get('name')" class="mt-1" />
                    </div>

                    <!-- Email -->
                    <div style="margin-bottom:1rem;">
                        <label for="email" class="auth-label">{{ __('Email address') }}</label>
                        <input id="email" class="auth-input" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" placeholder="you@example.com"
                            onfocus="this.style.borderColor='#D19C97';this.style.boxShadow='0 0 0 3px rgba(209,156,151,0.15)';"
                            onblur="this.style.borderColor='#f0dbd8';this.style.boxShadow='none';" />
                        <x-input-error :messages="$errors->get('email')" class="mt-1" />
                    </div>

                    <!-- Password -->
                    <div style="margin-bottom:1rem;">
                        <label for="password" class="auth-label">{{ __('Password') }}</label>
                        <div style="position:relative;">
                            <input id="password" class="auth-input" type="password" name="password" required autocomplete="new-password" placeholder="••••••••"
                                style="padding-right:42px;"
                                onfocus="this.style.borderColor='#D19C97';this.style.boxShadow='0 0 0 3px rgba(209,156,151,0.15)';"
                                onblur="this.style.borderColor='#f0dbd8';this.style.boxShadow='none';" />
                            <button type="button"
                                onclick="var i=document.getElementById('password'),o=document.getElementById('pw-eo'),c=document.getElementById('pw-ec');if(i.type==='password'){i.type='text';o.style.display='none';c.style.display='block';}else{i.type='password';o.style.display='block';c.style.display='none';}"
                                style="position:absolute;right:12px;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;padding:4px;display:flex;align-items:center;touch-action:manipulation;">
                                <svg id="pw-eo" width="18" height="18" fill="none" stroke="#c4a09a" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                <svg id="pw-ec" width="18" height="18" fill="none" stroke="#c4a09a" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" style="display:none;"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/></svg>
                            </button>
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-1" />
                    </div>

                    <!-- Confirm Password -->
                    <div style="margin-bottom:1.5rem;">
                        <label for="password_confirmation" class="auth-label">{{ __('Confirm Password') }}</label>
                        <div style="position:relative;">
                            <input id="password_confirmation" class="auth-input" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="••••••••"
                                style="padding-right:42px;"
                                onfocus="this.style.borderColor='#D19C97';this.style.boxShadow='0 0 0 3px rgba(209,156,151,0.15)';"
                                onblur="this.style.borderColor='#f0dbd8';this.style.boxShadow='none';" />
                            <button type="button"
                                onclick="var i=document.getElementById('password_confirmation'),o=document.getElementById('pc-eo'),c=document.getElementById('pc-ec');if(i.type==='password'){i.type='text';o.style.display='none';c.style.display='block';}else{i.type='password';o.style.display='block';c.style.display='none';}"
                                style="position:absolute;right:12px;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;padding:4px;display:flex;align-items:center;touch-action:manipulation;">
                                <svg id="pc-eo" width="18" height="18" fill="none" stroke="#c4a09a" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                <svg id="pc-ec" width="18" height="18" fill="none" stroke="#c4a09a" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" style="display:none;"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/></svg>
                            </button>
                        </div>
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1" />
                    </div>

                    <button type="submit" class="auth-btn">{{ __('Register') }}</button>

                    <p style="text-align:center; font-size:13px; color:#b0a0a0; margin-top:1.1rem;">
                        {{ __('Already registered?') }}
                        <a href="{{ route('login') }}" style="font-weight:500; color:#D19C97; text-decoration:none;">{{ __('Sign in') }}</a>
                    </p>
                </form>
            </div>

        </div>
    </div>
</x-guest-layout>

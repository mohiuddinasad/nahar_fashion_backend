@extends('backend.layout')
@push('backend_css')
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Nunito:wght@400;500;600;700&display=swap');

        .pf * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        .pf {
            font-family: 'Nunito', sans-serif;
            background: #f5f6fa;
            min-height: 100vh;
            padding: 28px 24px 60px;
            color: #2d3142;
        }

        /* ── Breadcrumb ── */
        .pf-breadcrumb {
            font-size: 0.8rem;
            color: #9ca3af;
            margin-bottom: 6px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .pf-breadcrumb a {
            color: #4f7ef8;
            text-decoration: none;
        }

        .pf-page-title {
            font-size: 1.35rem;
            font-weight: 700;
            color: #1e2235;
            margin-bottom: 24px;
        }

        /* ── Layout ── */
        .pf-layout {
            display: grid;
            grid-template-columns: 260px 1fr;
            gap: 20px;
            align-items: start;
        }

        @media (max-width: 840px) {
            .pf-layout {
                grid-template-columns: 1fr;
            }
        }

        /* ── Card ── */
        .pf-card {
            background: #ffffff;
            border: 1px solid #e8eaf2;
            border-radius: 12px;
            overflow: hidden;
        }

        /* ── Sidebar ── */
        .pf-sidebar {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .pf-user-card {
            padding: 28px 20px;
            text-align: center;
        }

        .pf-avatar {
            width: 76px;
            height: 76px;
            border-radius: 50%;
            background: #eef1ff;
            color: #4f7ef8;
            font-size: 1.8rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 14px;
            border: 3px solid #e0e6ff;
            overflow: hidden;
        }

        .pf-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
        }

        .pf-user-name {
            font-size: 1rem;
            font-weight: 700;
            color: #1e2235;
        }

        .pf-user-role {
            display: inline-block;
            margin-top: 6px;
            padding: 3px 12px;
            background: #eef1ff;
            color: #4f7ef8;
            border-radius: 20px;
            font-size: 0.72rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.04em;
        }

        .pf-user-email {
            font-size: 0.8rem;
            color: #9ca3af;
            margin-top: 8px;
        }

        .pf-nav {
            padding: 10px;
        }

        .pf-nav-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 9px 14px;
            border-radius: 8px;
            font-size: 0.875rem;
            font-weight: 600;
            color: #6b7280;
            cursor: pointer;
            transition: all 0.15s;
            border: none;
            background: none;
            width: 100%;
            text-align: left;
        }

        .pf-nav-item:hover {
            background: #f5f6fa;
            color: #2d3142;
        }

        .pf-nav-item.active {
            background: #eef1ff;
            color: #4f7ef8;
        }

        .pf-nav-item svg {
            width: 16px;
            height: 16px;
            flex-shrink: 0;
        }

        .pf-meta {
            padding: 16px 20px;
        }

        .pf-meta-row {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 8px 0;
            border-bottom: 1px solid #f0f1f7;
        }

        .pf-meta-row:last-child {
            border-bottom: none;
        }

        .pf-meta-icon {
            width: 30px;
            height: 30px;
            background: #f5f6fa;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.85rem;
            flex-shrink: 0;
        }

        .pf-meta-key {
            font-size: 0.7rem;
            color: #9ca3af;
            text-transform: uppercase;
            letter-spacing: 0.04em;
        }

        .pf-meta-val {
            font-size: 0.82rem;
            font-weight: 600;
            color: #2d3142;
            margin-top: 1px;
        }

        /* ── Main ── */
        .pf-main {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .pf-section-header {
            padding: 18px 22px 0;
            margin-bottom: 16px;
        }

        .pf-section-header h3 {
            font-size: 0.95rem;
            font-weight: 700;
            color: #1e2235;
        }

        .pf-section-header p {
            font-size: 0.8rem;
            color: #9ca3af;
            margin-top: 2px;
        }

        /* ── Panels ── */
        .pf-panel {
            display: none;
            flex-direction: column;
            gap: 16px;
        }

        .pf-panel.active {
            display: flex;
        }

        /* ── Form ── */
        .pf-form-body {
            padding: 0 22px 22px;
        }

        .pf-form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 14px;
        }

        .pf-form-grid .col-2 {
            grid-column: span 2;
        }

        @media (max-width: 600px) {
            .pf-form-grid {
                grid-template-columns: 1fr;
            }

            .pf-form-grid .col-2 {
                grid-column: span 1;
            }
        }

        .pf-field label {
            display: block;
            font-size: 0.78rem;
            font-weight: 700;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            margin-bottom: 6px;
        }

        .pf-input {
            width: 100%;
            padding: 9px 12px;
            background: #f9fafb;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            font-family: 'Nunito', sans-serif;
            font-size: 0.875rem;
            color: #1e2235;
            outline: none;
            transition: border-color 0.15s, box-shadow 0.15s;
        }

        .pf-input:focus {
            border-color: #4f7ef8;
            background: #fff;
            box-shadow: 0 0 0 3px rgba(79, 126, 248, 0.1);
        }

        .pf-input::placeholder {
            color: #c4c9d9;
        }

        select.pf-input {
            appearance: none;
            cursor: pointer;
        }

        textarea.pf-input {
            resize: vertical;
            min-height: 80px;
            line-height: 1.6;
        }

        /* Avatar upload strip */
        .pf-upload-strip {
            display: flex;
            align-items: center;
            gap: 16px;
            padding: 14px 16px;
            background: #f9fafb;
            border: 1px dashed #d1d5db;
            border-radius: 8px;
            margin-bottom: 18px;
            transition: border-color 0.15s;
        }

        .pf-upload-strip:hover {
            border-color: #4f7ef8;
        }

        .pf-upload-thumb {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            background: #eef1ff;
            color: #4f7ef8;
            font-size: 1.2rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            border: 2px solid #e0e6ff;
            overflow: hidden;
        }

        .pf-upload-thumb img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
        }

        .pf-upload-info p:first-child {
            font-size: 0.85rem;
            font-weight: 600;
            color: #2d3142;
        }

        .pf-upload-info p:last-child {
            font-size: 0.75rem;
            color: #9ca3af;
            margin-top: 2px;
        }

        .pf-upload-btn {
            margin-left: auto;
            padding: 7px 16px;
            border: 1px solid #d1d5db;
            border-radius: 7px;
            background: #fff;
            font-family: 'Nunito', sans-serif;
            font-size: 0.8rem;
            font-weight: 600;
            color: #6b7280;
            cursor: pointer;
            transition: all 0.15s;
            flex-shrink: 0;
        }

        .pf-upload-btn:hover {
            border-color: #4f7ef8;
            color: #4f7ef8;
        }

        /* Buttons */
        .pf-actions {
            display: flex;
            gap: 10px;
            margin-top: 20px;
        }

        .pf-btn {
            padding: 9px 20px;
            border-radius: 8px;
            font-family: 'Nunito', sans-serif;
            font-size: 0.875rem;
            font-weight: 700;
            cursor: pointer;
            border: none;
            transition: all 0.15s;
        }

        .pf-btn-primary {
            background: #4f7ef8;
            color: #fff;
        }

        .pf-btn-primary:hover {
            background: #3a68e0;
        }

        .pf-btn-light {
            background: #f5f6fa;
            color: #6b7280;
            border: 1px solid #e5e7eb;
        }

        .pf-btn-light:hover {
            background: #eaecf4;
            color: #2d3142;
        }

        .pf-btn-danger {
            background: #fff0f1;
            color: #ef4444;
            border: 1px solid #fecaca;
        }

        .pf-btn-danger:hover {
            background: #fee2e2;
        }

        /* ── Security items ── */
        .pf-sec-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 14px 0;
            border-bottom: 1px solid #f0f1f7;
            gap: 12px;
            flex-wrap: wrap;
        }

        .pf-sec-item:last-child {
            border-bottom: none;
        }

        .pf-sec-left {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .pf-sec-icon {
            width: 36px;
            height: 36px;
            border-radius: 8px;
            background: #f5f6fa;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.95rem;
            flex-shrink: 0;
        }

        .pf-sec-label h4 {
            font-size: 0.875rem;
            font-weight: 700;
            color: #1e2235;
        }

        .pf-sec-label p {
            font-size: 0.75rem;
            color: #9ca3af;
            margin-top: 2px;
        }

        /* Toggle */
        .pf-toggle {
            position: relative;
            width: 40px;
            height: 22px;
            flex-shrink: 0;
        }

        .pf-toggle input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .pf-toggle-track {
            position: absolute;
            inset: 0;
            border-radius: 22px;
            background: #e5e7eb;
            cursor: pointer;
            transition: background 0.2s;
        }

        .pf-toggle-track::after {
            content: '';
            position: absolute;
            width: 16px;
            height: 16px;
            border-radius: 50%;
            background: #fff;
            top: 3px;
            left: 3px;
            transition: left 0.2s;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.15);
        }

        .pf-toggle input:checked+.pf-toggle-track {
            background: #4f7ef8;
        }

        .pf-toggle input:checked+.pf-toggle-track::after {
            left: 21px;
        }

        /* ── Activity ── */
        .pf-act {
            display: flex;
            gap: 14px;
            align-items: flex-start;
            padding: 12px 0;
            border-bottom: 1px solid #f0f1f7;
        }

        .pf-act:last-child {
            border-bottom: none;
        }

        .pf-act-dot {
            width: 34px;
            height: 34px;
            border-radius: 8px;
            background: #f5f6fa;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.85rem;
            flex-shrink: 0;
        }

        .pf-act-text h4 {
            font-size: 0.85rem;
            font-weight: 600;
            color: #2d3142;
        }

        .pf-act-text time {
            font-size: 0.75rem;
            color: #9ca3af;
            margin-top: 2px;
            display: block;
        }

        /* Danger zone */
        .pf-danger-card {
            border: 1px solid #fecaca;
            border-radius: 12px;
            background: #fff;
            overflow: hidden;
        }

        .pf-danger-header {
            padding: 12px 22px;
            background: #fff5f5;
            border-bottom: 1px solid #fecaca;
            font-size: 0.78rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: #ef4444;
        }

        .pf-danger-body {
            padding: 16px 22px;
        }

        .pf-danger-body p {
            font-size: 0.82rem;
            color: #6b7280;
            margin-bottom: 14px;
            line-height: 1.6;
        }
    </style>
@endpush
@section('backend_content')
    <div class="pf">

        {{-- Page title --}}
        <div class="pf-breadcrumb">
            <a href="">Dashboard</a>
            <span>›</span>
            <span>Profile</span>
        </div>
        <div class="pf-page-title">My Profile</div>

        <div class="pf-layout">

            {{-- ── Sidebar ── --}}
            <aside class="pf-sidebar">

                {{-- User card --}}
                <div class="pf-card pf-user-card">
                    <div class="pf-avatar" id="sidebarAvatar">
                        @if (Auth::user()->user_image)
                            <img src="{{ asset(Auth::user()->user_image) }}" alt="Profile Image"
                                style="width:100%; height:100%; object-fit:cover; border-radius:inherit;">
                        @else
                            <span>
                                {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 1)) }}
                            </span>
                        @endif
                    </div>
                    <div class="pf-user-name">{{ Auth::user()->name ?? 'Admin User' }}</div>
                    <div class="pf-user-role">{{ $role ?? 'customer' }}</div>
                    <div class="pf-user-email">{{ Auth::user()->email ?? 'admin@example.com' }}</div>
                </div>

                {{-- Nav --}}
                <div class="pf-card">
                    <div class="pf-nav">
                        <button class="pf-nav-item active" onclick="switchTab('profile', this)">
                            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                                <circle cx="12" cy="7" r="4" />
                            </svg>
                            Profile Info
                        </button>
                        <button class="pf-nav-item" onclick="switchTab('security', this)">
                            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" />
                            </svg>
                            Security
                        </button>
                    </div>
                </div>

                {{-- Meta info --}}
                <div class="pf-card">
                    <div class="pf-meta">
                        <div class="pf-meta-row">
                            <div class="pf-meta-icon">📅</div>
                            <div>
                                <div class="pf-meta-key">Member Since</div>
                                <div class="pf-meta-val">{{ Auth::user()->created_at?->format('M d, Y') ?? 'Jan 1, 2024' }}
                                </div>
                            </div>
                        </div>
                        <div class="pf-meta-row">
                            <div class="pf-meta-icon">🕐</div>
                            <div>
                                <div class="pf-meta-key">Last Login</div>
                                <div class="pf-meta-val">
                                    {{ Auth::user()->last_login?->diffForHumans() ?? 'N/A' }}
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </aside>

            {{-- ── Main ── --}}
            <div class="pf-main">

                {{-- ── Profile Panel ── --}}
                <div id="tab-profile" class="pf-panel active">

                    <form action="{{ route('dashboard.profile.update') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="pf-card">
                            <div class="pf-section-header">
                                <h3>Profile Information</h3>
                                <p>Update your personal details below</p>
                            </div>

                            <div class="pf-form-body">

                                {{-- Avatar upload --}}
                                <div class="pf-upload-strip">
                                    <div class="pf-upload-thumb" id="uploadThumb">
                                        @if (Auth::user()->user_image)
                                            <img id="avatarPreview" src="{{ asset(Auth::user()->user_image) }}"
                                                alt="Profile Image"
                                                style="width:100%; height:100%; object-fit:cover; border-radius:inherit;">
                                        @else
                                            <span id="avatarInitial">
                                                {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 1)) }}
                                            </span>
                                        @endif
                                    </div>
                                    <div class="pf-upload-info">
                                        <p>Profile Photo</p>
                                        <p>PNG or JPG, max 2MB</p>
                                    </div>
                                    <label class="pf-upload-btn">
                                        Upload Photo
                                        <input type="file" name="user_image" accept="image/*" style="display:none"
                                            onchange="previewAvatar(event)">
                                    </label>
                                </div>



                                <div class="pf-form-grid">


                                    <div class="pf-field">
                                        <label>Name</label>
                                        <input type="text" name="name" class="pf-input"
                                            value="{{ Auth::user()->name ?? '' }}" placeholder="Full name">

                                        @error('name')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="pf-field">
                                        <label>Position</label>
                                        <input type="text" name="position" class="pf-input"
                                            value="{{ Auth::user()->position ?? '' }}" placeholder="Position">

                                        @error('position')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>


                                    <div class="pf-field col-12">
                                        <label>Email Address</label>
                                        <input type="email" name="email" class="pf-input"
                                            value="{{ Auth::user()->email ?? '' }}" placeholder="your@email.com">

                                        @error('email')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="pf-field">
                                        <label>Phone Number</label>
                                        <input type="tel" name="phone" class="pf-input"
                                            value="{{ Auth::user()->phone ?? '' }}" placeholder="+8801XXXXXXXX">

                                        @error('phone')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="pf-field">
                                        <label>Username</label>
                                        <input type="text" name="username" class="pf-input"
                                            value="{{ Auth::user()->username ?? '' }}" placeholder="username">

                                    </div>



                                </div>

                                <div class="pf-actions">
                                    <button type="submit" class="pf-btn pf-btn-primary">Save Changes</button>
                                    <button type="reset" class="pf-btn pf-btn-light">Reset</button>
                                </div>


                            </div>
                        </div>

                    </form>

                </div>

                {{-- ── Security Panel ── --}}
                <div id="tab-security" class="pf-panel">

                    <div class="pf-card">
                        <div class="pf-section-header">
                            <h3>Change Password</h3>
                            <p>Choose a strong password with at least 6 characters</p>
                        </div>

                        <div class="pf-form-body">
                            <form action="{{ route('dashboard.password.update') }}" method="POST">
                                @csrf
                                <div class="pf-form-grid">
                                    <div class="pf-field col-12">
                                        <label>Current Password</label>
                                        <input type="password" name="current_password" class="pf-input"
                                            placeholder="Enter current password">

                                        @error('current_password')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="pf-field">
                                        <label>New Password</label>
                                        <input type="password" name="new_password" class="pf-input"
                                            placeholder="New password">

                                        @error('new_password')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror

                                    </div>
                                    <div class="pf-field">
                                        <label>Confirm Password</label>
                                        <input type="password" name="new_password_confirmation" class="pf-input"
                                            placeholder="Confirm new password">


                                    </div>
                                </div>
                                <div class="pf-actions">
                                    <button type="submit" class="pf-btn pf-btn-primary">Update Password</button>
                                </div>
                            </form>
                        </div>
                    </div>



                    <div class="pf-danger-card">
                        <div class="pf-danger-header">⚠ Danger Zone</div>
                        <div class="pf-danger-body">
                            <p>Permanently delete your account and all associated data. This action cannot be undone.</p>
                            <a href="{{ route('dashboard.profile.delete') }}" class="pf-btn pf-btn-danger"
                                onclick="return confirm('Are you sure? This cannot be undone.')">
                                Delete My Account
                            </a>
                        </div>
                    </div>

                </div>



            </div>{{-- end pf-main --}}

        </div>{{-- end pf-layout --}}

    </div>{{-- end pf --}}

    @push('backend_js')
        <script>
            function switchTab(name, btn) {
                document.querySelectorAll('.pf-panel').forEach(p => p.classList.remove('active'));
                document.querySelectorAll('.pf-nav-item').forEach(b => b.classList.remove('active'));
                document.getElementById('tab-' + name).classList.add('active');
                btn.classList.add('active');
            }

            function previewAvatar(event) {
                const file = event.target.files[0];
                if (!file) return;

                const reader = new FileReader();

                reader.onload = function(e) {
                    const src = e.target.result;

                    // Update uploadThumb
                    const thumb = document.getElementById('uploadThumb');
                    if (thumb) {
                        thumb.innerHTML = `<img src="${src}"
                                        alt="Avatar"
                                        style="width:100%; height:100%; object-fit:cover; border-radius:inherit;">`;
                    }

                    // Update sidebarAvatar
                    const sidebar = document.getElementById('sidebarAvatar');
                    if (sidebar) {
                        sidebar.innerHTML = `<img src="${src}"
                                          alt="Avatar"
                                          style="width:100%; height:100%; object-fit:cover; border-radius:inherit;">`;
                    }
                };

                reader.readAsDataURL(file);
            }
        </script>
    @endpush
@endsection

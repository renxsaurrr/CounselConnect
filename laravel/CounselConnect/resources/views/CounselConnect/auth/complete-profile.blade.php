{{-- resources/views/CounselConnect/auth/complete-profile.blade.php --}}
{{-- Shown to new students after signing in with Google for the first time --}}

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Complete Your Profile — CounselConnect</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-50 flex items-center justify-center px-4 py-6">

<div class="w-full max-w-4xl bg-white rounded-3xl shadow-2xl shadow-slate-200/80 overflow-hidden flex flex-col lg:flex-row" style="max-height: 95vh;">

    {{-- Left branding panel --}}
    <aside class="hidden lg:flex flex-col justify-between bg-blue-600 px-10 py-10 relative overflow-hidden lg:w-1/2 flex-shrink-0">
        <div class="absolute top-0 right-0 w-64 h-64 bg-blue-500 rounded-full -translate-y-1/2 translate-x-1/2 opacity-50"></div>
        <div class="absolute bottom-0 left-0 w-80 h-80 bg-blue-700 rounded-full translate-y-1/2 -translate-x-1/3 opacity-40"></div>
        <div class="absolute top-1/2 left-1/2 w-40 h-40 bg-blue-400 rounded-full -translate-x-1/2 -translate-y-1/2 opacity-20"></div>

        <div class="relative z-10 space-y-3">
            <h2 class="text-3xl font-bold text-white leading-snug">Almost there!</h2>
            <p class="text-blue-100 text-sm leading-relaxed">We just need a couple more details to set up your student account.</p>
        </div>

        <div class="relative z-10 space-y-4">
            <ul class="space-y-3">
                <li class="flex items-start gap-3">
                    <div class="w-5 h-5 rounded-full bg-white/20 flex items-center justify-center flex-shrink-0 mt-0.5">
                        <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                    </div>
                    <span class="text-blue-100 text-sm">Your Google account is verified</span>
                </li>
                <li class="flex items-start gap-3">
                    <div class="w-5 h-5 rounded-full bg-white/20 flex items-center justify-center flex-shrink-0 mt-0.5">
                        <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                    </div>
                    <span class="text-blue-100 text-sm">Just fill in your student details below</span>
                </li>
                <li class="flex items-start gap-3">
                    <div class="w-5 h-5 rounded-full bg-white/20 flex items-center justify-center flex-shrink-0 mt-0.5">
                        <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                    </div>
                    <span class="text-blue-100 text-sm">You'll only need to do this once</span>
                </li>
            </ul>
            <blockquote class="text-white/90 text-sm font-semibold leading-snug pt-2">
                "Your mental health is just as important as your grades."
            </blockquote>
        </div>

        <dl class="flex items-center gap-5 relative z-10">
            <div>
                <dd class="text-white text-base font-bold">2,400+</dd>
                <dt class="text-blue-200 text-xs">Students supported</dt>
            </div>
            <div class="w-px h-7 bg-white/20"></div>
            <div>
                <dd class="text-white text-base font-bold">15+</dd>
                <dt class="text-blue-200 text-xs">Expert counselors</dt>
            </div>
            <div class="w-px h-7 bg-white/20"></div>
            <div>
                <dd class="text-white text-base font-bold">24/7</dd>
                <dt class="text-blue-200 text-xs">Resource access</dt>
            </div>
        </dl>
    </aside>

    {{-- Right panel: form (scrollable) --}}
    <section class="flex flex-col flex-1 lg:w-1/2 relative overflow-y-auto">

        <div class="px-8 pb-10 pt-10">
            <div class="w-full max-w-sm mx-auto">

                <header class="mb-7 text-center">
                    <div class="w-12 h-12 bg-blue-50 rounded-full flex items-center justify-center mx-auto mb-4">
                        {{-- Google icon --}}
                        <svg class="w-6 h-6" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                            <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                            <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
                            <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
                        </svg>
                    </div>
                    <h2 class="text-2xl font-bold text-slate-900 mb-1">Complete your profile</h2>
                    <p class="text-sm text-slate-500">
                        Signed in as <span class="font-medium text-slate-700">{{ $google_email }}</span>
                    </p>
                </header>

                @if ($errors->any())
                    <div class="mb-6 bg-red-50 border border-red-200 text-red-700 text-sm rounded-xl px-4 py-3 flex items-start gap-2.5" role="alert" aria-live="assertive">
                        <svg class="w-4 h-4 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span>{{ $errors->first() }}</span>
                    </div>
                @endif

                <form method="POST" action="{{ route('google.complete-profile.store') }}" class="space-y-4" novalidate>
                    @csrf

                    {{-- Pre-filled from Google, read-only --}}
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Full name</label>
                        <input type="text" value="{{ $google_name }}" disabled
                            class="w-full px-4 py-2.5 text-sm text-slate-500 bg-slate-50 border border-slate-200 rounded-xl cursor-not-allowed">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Email address</label>
                        <input type="email" value="{{ $google_email }}" disabled
                            class="w-full px-4 py-2.5 text-sm text-slate-500 bg-slate-50 border border-slate-200 rounded-xl cursor-not-allowed">
                    </div>

                    {{-- Student must fill these in --}}
                    <div>
                        <label for="student_id" class="block text-sm font-medium text-slate-700 mb-1.5">
                            Student ID <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="student_id" name="student_id" value="{{ old('student_id') }}"
                            required autocomplete="off" placeholder="e.g. 2023-00123"
                            class="w-full px-4 py-2.5 text-sm text-slate-900 bg-white border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent placeholder:text-slate-400 transition-all duration-200">
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label for="department" class="block text-sm font-medium text-slate-700 mb-1.5">Department</label>
                            <input type="text" id="department" name="department" value="{{ old('department') }}"
                                autocomplete="off" placeholder="e.g. BSIT"
                                class="w-full px-4 py-2.5 text-sm text-slate-900 bg-white border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent placeholder:text-slate-400 transition-all duration-200">
                        </div>
                        <div>
                            <label for="year_level" class="block text-sm font-medium text-slate-700 mb-1.5">Year Level</label>
                            <select id="year_level" name="year_level"
                                class="w-full px-4 py-2.5 text-sm text-slate-900 bg-white border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 appearance-none cursor-pointer">
                                <option value="" disabled selected>Select</option>
                                <option value="1st Year" {{ old('year_level') === '1st Year' ? 'selected' : '' }}>1st Year</option>
                                <option value="2nd Year" {{ old('year_level') === '2nd Year' ? 'selected' : '' }}>2nd Year</option>
                                <option value="3rd Year" {{ old('year_level') === '3rd Year' ? 'selected' : '' }}>3rd Year</option>
                                <option value="4th Year" {{ old('year_level') === '4th Year' ? 'selected' : '' }}>4th Year</option>
                            </select>
                        </div>
                    </div>

                    {{-- Password --}}
                    <div>
                        <label for="password" class="block text-sm font-medium text-slate-700 mb-1.5">
                            Password <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input type="password" id="password" name="password" required autocomplete="new-password" placeholder="••••••••"
                                class="w-full px-4 py-2.5 pr-11 text-sm text-slate-900 bg-white border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent placeholder:text-slate-400 transition-all duration-200">
                            <button type="button" onclick="togglePassword()" aria-label="Toggle password visibility"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 transition-colors duration-200 cursor-pointer">
                                <svg id="cp-eye-show" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                                <svg id="cp-eye-hide" class="w-4 h-4 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.542 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    {{-- Confirm Password --}}
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-slate-700 mb-1.5">
                            Confirm password <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input type="password" id="password_confirmation" name="password_confirmation" required autocomplete="new-password" placeholder="••••••••"
                                class="w-full px-4 py-2.5 pr-11 text-sm text-slate-900 bg-white border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent placeholder:text-slate-400 transition-all duration-200">
                            <button type="button" onclick="toggleConfirmPassword()" aria-label="Toggle confirm password visibility"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 transition-colors duration-200 cursor-pointer">
                                <svg id="cp-confirm-eye-show" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                                <svg id="cp-confirm-eye-hide" class="w-4 h-4 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.542 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <button type="submit"
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2.5 rounded-xl shadow-sm hover:shadow-md transition-all duration-200 text-sm cursor-pointer">
                        Complete Sign Up
                    </button>

                </form>

            </div>
        </div>

    </section>

</div>

<script>
    function togglePassword() {
        const input = document.getElementById('password');
        const show = document.getElementById('cp-eye-show');
        const hide = document.getElementById('cp-eye-hide');
        const isHidden = input.type === 'password';
        input.type = isHidden ? 'text' : 'password';
        show.classList.toggle('hidden', isHidden);
        hide.classList.toggle('hidden', !isHidden);
    }

    function toggleConfirmPassword() {
        const input = document.getElementById('password_confirmation');
        const show = document.getElementById('cp-confirm-eye-show');
        const hide = document.getElementById('cp-confirm-eye-hide');
        const isHidden = input.type === 'password';
        input.type = isHidden ? 'text' : 'password';
        show.classList.toggle('hidden', isHidden);
        hide.classList.toggle('hidden', !isHidden);
    }
</script>

</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CounselConnect</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<!-- Page background -->
<body class="bg-slate-50">


    <!-- SITE HEADER: Sticky, blurred header bar with logo, nav links, and action buttons -->
    <header class="bg-white/80 backdrop-blur-xl sticky top-0 z-50 border-b border-slate-200/50"
            role="banner">

        <!-- Primary navigation wrapper -->
        <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8"
             aria-label="Primary navigation">

            <!-- Inner flex row: logo | nav links | action buttons | hamburger -->
            <div class="flex justify-between items-center h-16 lg:h-20">

                <!-- Site logo linking back to the homepage -->
                <div class="flex-shrink-0">
                    <a href="#" class="flex items-center space-x-2" aria-label="CounselConnect home">
                        <span class="text-xl lg:text-2xl font-bold text-blue-600">
                            CounselConnect
                        </span>
                    </a>
                </div>

                <!-- Desktop navigation links (hidden on mobile) -->
                <ul class="hidden lg:flex items-center space-x-2 xl:space-x-8" role="list">

                    <!-- Home nav link -->
                    <li>
                        <a href="{{ route('home') }}"
                           aria-current="{{ request()->routeIs('home') ? 'page' : false }}"
                           class="px-3 py-2 font-medium rounded-xl hover:bg-blue-50 hover:text-blue-700 transition-all duration-300 group relative
                                  {{ request()->routeIs('home') ? 'text-blue-700' : 'text-slate-700' }}">
                            <span>Home</span>
                            <span class="absolute -bottom-1 left-0 right-0 h-0.5 bg-blue-600 transition-transform duration-300 origin-left
                                         {{ request()->routeIs('home') ? 'scale-x-100' : 'scale-x-0 group-hover:scale-x-100' }}"
                                  aria-hidden="true"></span>
                        </a>
                    </li>

                    <!-- Services nav link -->
                    <li>
                        <a href="{{ route('services') }}"
                           aria-current="{{ request()->routeIs('services') ? 'page' : false }}"
                           class="px-3 py-2 font-medium rounded-xl hover:bg-blue-50 hover:text-blue-700 transition-all duration-300 group relative
                                  {{ request()->routeIs('services') ? 'text-blue-700' : 'text-slate-700' }}">
                            <span>Services</span>
                            <span class="absolute -bottom-1 left-0 right-0 h-0.5 bg-blue-600 transition-transform duration-300 origin-left
                                         {{ request()->routeIs('services') ? 'scale-x-100' : 'scale-x-0 group-hover:scale-x-100' }}"
                                  aria-hidden="true"></span>
                        </a>
                    </li>

                    <!-- Resources nav link -->
                    <li>
                        <a href="{{ route('resources') }}"
                           aria-current="{{ request()->routeIs('resources') ? 'page' : false }}"
                           class="px-3 py-2 font-medium rounded-xl hover:bg-blue-50 hover:text-blue-700 transition-all duration-300 group relative
                                  {{ request()->routeIs('resources') ? 'text-blue-700' : 'text-slate-700' }}">
                            <span>Resources</span>
                            <span class="absolute -bottom-1 left-0 right-0 h-0.5 bg-blue-600 transition-transform duration-300 origin-left
                                         {{ request()->routeIs('resources') ? 'scale-x-100' : 'scale-x-0 group-hover:scale-x-100' }}"
                                  aria-hidden="true"></span>
                        </a>
                    </li>

                    <!-- FAQ nav link -->
                    <li>
                        <a href="{{ route('FAQ') }}"
                           aria-current="{{ request()->routeIs('FAQ') ? 'page' : false }}"
                           class="px-3 py-2 font-medium rounded-xl hover:bg-blue-50 hover:text-blue-700 transition-all duration-300 group relative
                                  {{ request()->routeIs('FAQ') ? 'text-blue-700' : 'text-slate-700' }}">
                            <span>FAQ</span>
                            <span class="absolute -bottom-1 left-0 right-0 h-0.5 bg-blue-600 transition-transform duration-300 origin-left
                                         {{ request()->routeIs('FAQ') ? 'scale-x-100' : 'scale-x-0 group-hover:scale-x-100' }}"
                                  aria-hidden="true"></span>
                        </a>
                    </li>

                </ul>

                <!-- Desktop action buttons (hidden on mobile) -->
                <div class="hidden lg:flex items-center space-x-4">

                    <!-- Log In button: opens the login modal dialog -->
                    <button
                        type="button"
                        onclick="document.getElementById('login-modal').classList.remove('hidden')"
                        aria-haspopup="dialog"
                        aria-controls="login-modal"
                        class="w-32 h-10 flex items-center justify-center text-slate-700 font-semibold border-2 border-slate-200
                         hover:border-blue-300 hover:text-blue-700 hover:bg-blue-50 rounded-3xl transition-all duration-300 hover:shadow-xl
                         transform hover:-translate-y-0.5 cursor-pointer">
                        Log In
                    </button>

                    <!-- Get Started CTA button: opens the register modal dialog -->
                    <button
                        type="button"
                        onclick="document.getElementById('register-modal').classList.remove('hidden')"
                        aria-haspopup="dialog"
                        aria-controls="register-modal"
                        class="bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white px-8 py-2 rounded-3xl font-semibold 
                        hover:shadow-xl transition-all duration-300 transform hover:-translate-y-0.5 cursor-pointer">
                        Get Started
                    </button>

                </div>

                <!-- Mobile hamburger toggle button -->
                <button
                    id="mobile-menu-btn"
                    type="button"
                    aria-controls="mobile-menu"
                    aria-expanded="false"
                    aria-label="Toggle mobile navigation menu"
                    class="lg:hidden p-2 rounded-xl text-slate-700 hover:bg-blue-50 hover:text-blue-700 transition-all duration-300 cursor-pointer">

                    <svg id="hamburger-icon" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>

                    <svg id="close-icon" class="w-6 h-6 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>

                </button>

            </div>

            <!-- Mobile dropdown menu -->
            <div id="mobile-menu"
                 class="hidden lg:hidden pb-4"
                 role="region"
                 aria-label="Mobile navigation">

                <ul class="flex flex-col space-y-1 mb-4" role="list">
                    <li>
                        <a href="{{ route('home') }}"
                           class="block px-4 py-2.5 text-slate-700 font-medium rounded-xl hover:bg-blue-50 hover:text-blue-700 transition-all duration-300">
                            Home
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('services') }}"
                           class="block px-4 py-2.5 text-slate-700 font-medium rounded-xl hover:bg-blue-50 hover:text-blue-700 transition-all duration-300">
                            Services
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('resources') }}"
                           class="block px-4 py-2.5 text-slate-700 font-medium rounded-xl hover:bg-blue-50 hover:text-blue-700 transition-all duration-300">
                            Resources
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('FAQ') }}"
                           class="block px-4 py-2.5 text-slate-700 font-medium rounded-xl hover:bg-blue-50 hover:text-blue-700 transition-all duration-300">
                            FAQ
                        </a>
                    </li>
                </ul>

                <div class="flex flex-col space-y-2 px-2">

                    <button
                        type="button"
                        onclick="document.getElementById('login-modal').classList.remove('hidden')"
                        aria-haspopup="dialog"
                        aria-controls="login-modal"
                        class="w-full text-center py-2.5 text-slate-700 font-semibold border-2 border-slate-200 hover:border-blue-300 hover:text-blue-700 hover:bg-blue-50 rounded-3xl transition-all duration-300 cursor-pointer">
                        Log In
                    </button>

                    <button
                        type="button"
                        onclick="document.getElementById('register-modal').classList.remove('hidden')"
                        aria-haspopup="dialog"
                        aria-controls="register-modal"
                        class="w-full text-center py-2.5 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white rounded-3xl font-semibold shadow-lg transition-all duration-300 cursor-pointer">
                        Get Started
                    </button>

                </div>

            </div>

        </nav>

    </header>
    <!-- END: SITE HEADER -->


    <!-- MAIN PAGE CONTENT -->
    <main id="main-content">


        <!-- HERO SECTION -->
        <section class="relative overflow-hidden bg-white" aria-labelledby="hero-heading">

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-8 pb-16 lg:pt-12 lg:pb-24">
                <div class="grid lg:grid-cols-2 gap-12 lg:gap-16 items-center">

                    <div class="space-y-7">

                        <div class="inline-flex items-center gap-2 bg-blue-50 border border-blue-200 px-4 py-2 rounded-full w-fit" role="note">
                            <span class="w-2 h-2 bg-blue-500 rounded-full animate-pulse" aria-hidden="true"></span>
                            <span class="text-blue-700 text-sm font-semibold tracking-wide">Confidential & Secure Sanctuary</span>
                        </div>

                        <h1 id="hero-heading" class="text-5xl lg:text-6xl xl:text-7xl font-bold leading-tight text-slate-900">
                            Empowering student
                            <span class="text-blue-600"> well-being</span>,
                            one connection at a time.
                        </h1>

                        <p class="text-slate-500 text-lg leading-relaxed max-w-md">
                            CounselConnect is a professional sanctuary designed for students. Access expert care, personalized matching, and a comprehensive library of wellness resources in a safe, private environment.
                        </p>

                        <div class="flex flex-wrap gap-4">

                            <button
                            type="button"
                            onclick="document.getElementById('login-modal').classList.remove('hidden')"
                            aria-haspopup="dialog"
                            aria-controls="login-modal"
                            class="inline-flex items-center gap-2 bg-gradient-to-r from-blue-600 to-blue-700
                             hover:from-blue-700 hover:to-blue-800 text-white px-8 py-3.5 rounded-3xl 
                             font-semibold shadow-lg hover:shadow-xl transition-all duration-300 transform 
                             hover:-translate-y-0.5 cursor-pointer">
                            Book Your First Session
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                            </svg>
                            </button>

                            <a href="{{ route('resources') }}"
                               class="inline-flex items-center gap-2 text-blue-700 font-semibold px-6 py-3.5 
                               rounded-3xl border-2 border-blue-100 hover:border-blue-300 hover:bg-blue-100
                               hover:-translate-y-0.5
                               transition-all duration-300">
                                Explore Resources
                            </a>

                        </div>

                        <div class="flex items-center gap-5 pt-2">

                            <div class="flex -space-x-2" aria-hidden="true">
                                <div class="w-9 h-9 rounded-full bg-blue-200 border-2 border-white flex items-center justify-center text-blue-700 text-xs font-bold">A</div>
                                <div class="w-9 h-9 rounded-full bg-blue-300 border-2 border-white flex items-center justify-center text-blue-800 text-xs font-bold">B</div>
                                <div class="w-9 h-9 rounded-full bg-blue-400 border-2 border-white flex items-center justify-center text-white text-xs font-bold">C</div>
                                <div class="w-9 h-9 rounded-full bg-blue-500 border-2 border-white flex items-center justify-center text-white text-xs font-bold">+</div>
                            </div>

                            <p class="text-sm text-slate-500">
                                <span class="font-semibold text-slate-700">2,400+ students</span> already connected
                            </p>

                        </div>

                    </div>

                    <div class="relative">
                        <div class="relative rounded-3xl overflow-hidden shadow-2xl shadow-blue-100">
                            <img
                                src="{{ asset('images/pic1.jpg') }}"
                                alt="Two students in a warm, supportive counseling session"
                                class="w-full h-[480px] lg:h-[540px] object-cover object-top"
                                loading="eager"
                            />
                        </div>
                    </div>

                </div>
            </div>

        </section>
        <!-- END: HERO SECTION -->


        <!-- STATS SECTION -->
        <section class="relative overflow-hidden bg-gradient-to-r from-slate-50 to-blue-50/50 py-12 lg:py-16"
                 aria-label="Key statistics">

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <dl class="grid grid-cols-1 md:grid-cols-3 gap-8 lg:gap-12">

                    <div class="group text-center">
                        <dd class="inline-flex items-baseline gap-2 mb-2">
                            <span class="text-4xl lg:text-5xl font-black text-blue-600 tracking-tight">2,400+</span>
                        </dd>
                        <dt class="text-sm font-semibold tracking-wider text-slate-500 uppercase group-hover:text-blue-500 transition-colors">
                            Students Supported
                        </dt>
                    </div>

                    <div class="group text-center">
                        <dd class="inline-flex items-baseline gap-2 mb-2">
                            <span class="text-4xl lg:text-5xl font-black text-blue-600 tracking-tight">15+</span>
                        </dd>
                        <dt class="text-sm font-semibold tracking-wider text-slate-500 uppercase group-hover:text-blue-500 transition-colors">
                            Expert Counselors
                        </dt>
                    </div>

                    <div class="group text-center">
                        <dd class="inline-flex items-baseline gap-2 mb-2">
                            <span class="text-4xl lg:text-5xl font-black text-blue-600 tracking-tight">24/7</span>
                        </dd>
                        <dt class="text-sm font-semibold tracking-wider text-slate-500 uppercase group-hover:text-blue-500 transition-colors">
                            Resource Access
                        </dt>
                    </div>

                </dl>
            </div>

        </section>
        <!-- END: STATS SECTION -->


        <!-- FEATURES BENTO SECTION -->
        <section class="bg-white py-16 lg:py-24" aria-labelledby="features-heading">

            <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

                <header class="text-center mb-16">

                    <div class="inline-flex items-center gap-2 bg-blue-500/10 text-blue-600 text-sm font-semibold px-4 py-2 rounded-full border border-blue-200 mb-6" role="note">
                        <div class="w-2 h-2 bg-blue-600 rounded-full" aria-hidden="true"></div>
                        Student-first design
                    </div>

                    <h2 id="features-heading" class="text-3xl lg:text-4xl font-bold text-slate-900 mb-4">
                        Designed for your peace of mind
                    </h2>

                    <p class="text-slate-500 max-w-md mx-auto text-sm leading-relaxed">
                        Professional standards with intuitive student experience
                    </p>

                </header>

                <div class="grid grid-cols-2 lg:grid-cols-5 gap-6 lg:gap-8">

                    <!-- Feature card: Private & Secure -->
                    <article class="col-span-1 lg:col-span-2 bg-slate-50 rounded-3xl p-8 flex flex-col gap-6 border border-slate-200 hover:border-blue-200 hover:shadow-xl transition-all duration-300 hover:-translate-y-1 group"
                             aria-labelledby="feature-secure-heading">

                        <div class="w-12 h-12 min-w-[48px] min-h-[48px] bg-blue-100 rounded-2xl flex items-center justify-center group-hover:bg-blue-200 transition-all" aria-hidden="true">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 2.25c0 0-7.5 3-7.5 8.25v4.5l7.5 6.75 7.5-6.75v-4.5c0-5.25-7.5-8.25-7.5-8.25z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 12l1.5 1.5 3-3"/>
                            </svg>
                        </div>

                        <div class="flex flex-col gap-2 flex-1">
                            <h3 id="feature-secure-heading" class="text-base font-bold text-slate-900">
                                Private & Secure Sanctuary
                            </h3>
                            <p class="text-slate-500 text-sm leading-relaxed">
                                Fully HIPAA compliant platform ensuring your conversations and records remain confidential between you and your counselor.
                            </p>
                        </div>

                        <a href="#" class="inline-flex items-center gap-1 text-blue-600 text-sm font-semibold hover:gap-2 transition-all duration-200">
                            Learn about our security
                            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                            </svg>
                        </a>

                    </article>

                    <!-- Feature card: Easy Scheduling -->
                    <article class="col-span-1 lg:col-span-3 bg-blue-600 rounded-3xl p-8 flex flex-col gap-6 text-white hover:shadow-2xl hover:shadow-blue-500/30 transition-all duration-300 hover:-translate-y-1"
                             aria-labelledby="feature-scheduling-heading">

                        <div class="w-12 h-12 flex-shrink-0 bg-white/20 rounded-2xl flex items-center justify-center" aria-hidden="true">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/>
                            </svg>
                        </div>

                        <div class="flex flex-col gap-2 flex-1">
                            <h3 id="feature-scheduling-heading" class="text-base font-bold">
                                Easy Scheduling
                            </h3>
                            <p class="text-blue-100 text-sm leading-relaxed">
                                Book sessions in seconds. Our real-time calendar allows you to find a slot that fits your busy academic schedule perfectly.
                            </p>
                        </div>

                    </article>

                    <!-- Feature card: Personalized Care -->
                    <article class="col-span-1 lg:col-span-3 bg-slate-50 rounded-3xl p-8 flex flex-col gap-6 border border-slate-200 hover:border-blue-200 hover:shadow-xl transition-all duration-300 hover:-translate-y-1 group"
                             aria-labelledby="feature-care-heading">

                        <div class="w-12 h-12 flex-shrink-0 bg-blue-100 rounded-2xl flex items-center justify-center group-hover:bg-blue-200 transition-all" aria-hidden="true">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/>
                            </svg>
                        </div>

                        <div class="flex flex-col gap-2 flex-1">
                            <h3 id="feature-care-heading" class="text-base font-bold text-slate-900">
                                Personalized Care
                            </h3>
                            <p class="text-slate-500 text-sm leading-relaxed">
                                Get matched with expert counselors who specialize in student-specific challenges like anxiety, burnout, and career stress.
                            </p>
                        </div>

                    </article>

                    <!-- Feature card: Resource Library -->
                    <article class="col-span-1 lg:col-span-2 bg-slate-50 rounded-3xl p-8 flex flex-col gap-6 border border-slate-200 hover:border-blue-200 hover:shadow-xl transition-all duration-300 hover:-translate-y-1 group"
                             aria-labelledby="feature-library-heading">

                        <div class="w-12 h-12 flex-shrink-0 bg-blue-100 rounded-2xl flex items-center justify-center group-hover:bg-blue-200 transition-all" aria-hidden="true">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/>
                            </svg>
                        </div>

                        <div class="flex flex-col gap-2 flex-1">
                            <h3 id="feature-library-heading" class="text-base font-bold text-slate-900">
                                Resource Library
                            </h3>
                            <p class="text-slate-500 text-sm leading-relaxed">
                                24/7 access to guided meditations, wellness workshops, and mental health toolkits curated by clinical professionals.
                            </p>
                        </div>

                        <a href="{{ route('resources') }}"
                           class="inline-flex items-center justify-center w-fit px-5 py-2 bg-white border border-slate-200 rounded-full text-sm font-semibold text-slate-700 hover:border-blue-300 hover:text-blue-600 hover:bg-blue-50 transition-all duration-300">
                            View Library
                        </a>

                    </article>

                </div>

            </div>

        </section>
        <!-- END: FEATURES BENTO SECTION -->


        <!-- FAQ SECTION -->
        <section class="bg-slate-50 py-16 lg:py-24 border-t border-slate-200/70"
                 aria-labelledby="faq-heading">

            <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">

                <header class="text-center mb-12">

                    <div class="inline-flex items-center gap-2 bg-blue-500/10 text-blue-600 text-sm font-semibold px-4 py-2 rounded-full border border-blue-200 mb-6" role="note">
                        <div class="w-2 h-2 bg-blue-600 rounded-full" aria-hidden="true"></div>
                        Got questions?
                    </div>

                    <h2 id="faq-heading" class="text-3xl font-bold text-slate-900">
                        Common Questions
                    </h2>

                </header>

                <div class="space-y-3" role="list">

                    <div class="faq-item bg-white rounded-2xl border border-slate-200 overflow-hidden hover:border-blue-200 transition-colors duration-300" role="listitem">
                        <button class="faq-btn w-full flex justify-between items-center px-6 py-5 text-left"
                                type="button"
                                aria-expanded="false">
                            <span class="font-semibold text-slate-800 text-sm">Is my data really private?</span>
                            <svg class="faq-arrow w-5 h-5 text-slate-400 transition-transform duration-300 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                        <div class="faq-body hidden px-6 pb-5">
                            <p class="text-slate-500 text-sm leading-relaxed">
                                Yes. Our platform is fully HIPAA compliant. All conversations and records remain strictly confidential between you and your counselor, and are never sold or shared with third parties.
                            </p>
                        </div>
                    </div>

                    <div class="faq-item bg-white rounded-2xl border border-slate-200 overflow-hidden hover:border-blue-200 transition-colors duration-300" role="listitem">
                        <button class="faq-btn w-full flex justify-between items-center px-6 py-5 text-left"
                                type="button"
                                aria-expanded="false">
                            <span class="font-semibold text-slate-800 text-sm">How do I find a counselor?</span>
                            <svg class="faq-arrow w-5 h-5 text-slate-400 transition-transform duration-300 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                        <div class="faq-body hidden px-6 pb-5">
                            <p class="text-slate-500 text-sm leading-relaxed">
                                CounselConnect matches you based on your specific needs. Answer a short questionnaire and we'll suggest counselors who specialize in what you're going through — from academic stress to anxiety and burnout.
                            </p>
                        </div>
                    </div>

                    <div class="faq-item bg-white rounded-2xl border border-slate-200 overflow-hidden hover:border-blue-200 transition-colors duration-300" role="listitem">
                        <button class="faq-btn w-full flex justify-between items-center px-6 py-5 text-left"
                                type="button"
                                aria-expanded="false">
                            <span class="font-semibold text-slate-800 text-sm">Can I cancel or reschedule?</span>
                            <svg class="faq-arrow w-5 h-5 text-slate-400 transition-transform duration-300 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                        <div class="faq-body hidden px-6 pb-5">
                            <p class="text-slate-500 text-sm leading-relaxed">
                                Absolutely. You can cancel or reschedule any session up to 24 hours in advance through your dashboard at no charge. We know student schedules change fast.
                            </p>
                        </div>
                    </div>

                    <div class="faq-item bg-white rounded-2xl border border-slate-200 overflow-hidden hover:border-blue-200 transition-colors duration-300" role="listitem">
                        <button class="faq-btn w-full flex justify-between items-center px-6 py-5 text-left"
                                type="button"
                                aria-expanded="false">
                            <span class="font-semibold text-slate-800 text-sm">Is CounselConnect free for students?</span>
                            <svg class="faq-arrow w-5 h-5 text-slate-400 transition-transform duration-300 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                        <div class="faq-body hidden px-6 pb-5">
                            <p class="text-slate-500 text-sm leading-relaxed">
                                Creating an account and browsing the resource library is completely free. Session pricing depends on your institution's partnership plan — many students get subsidized or fully covered sessions through their school.
                            </p>
                        </div>
                    </div>

                </div>

            </div>

        </section>
        <!-- END: FAQ SECTION -->


        <!-- CTA BANNER SECTION -->
        <section class="bg-blue-600 py-16 lg:py-20 relative overflow-hidden" aria-labelledby="cta-heading">

            <div class="absolute inset-0 opacity-10" aria-hidden="true">
                <div class="absolute top-0 left-1/4 w-96 h-96 bg-white rounded-full -translate-y-1/2"></div>
                <div class="absolute bottom-0 right-1/4 w-64 h-64 bg-white rounded-full translate-y-1/2"></div>
            </div>

            <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 text-center space-y-6 relative z-10">

                <h2 id="cta-heading" class="text-3xl lg:text-4xl font-bold text-white leading-tight">
                    Take the first step today.
                </h2>

                <p class="text-blue-100 text-base leading-relaxed max-w-lg mx-auto">
                    We're here for every student no matter how they feel. Your mental health journey is important to us.
                </p>

                <button
                    type="button"
                    onclick="document.getElementById('register-modal').classList.remove('hidden')"
                    aria-haspopup="dialog"
                    aria-controls="register-modal"
                    class="inline-flex items-center gap-2 bg-white text-blue-600 font-bold px-8 py-3.5 rounded-3xl
                     hover:bg-blue-50 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-0.5 cursor-pointer">
                        Create Free Account
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                </button>

            </div>

        </section>
        <!-- END: CTA BANNER SECTION -->


    </main>
    <!-- END: MAIN PAGE CONTENT -->


    <!-- SITE FOOTER -->
    <footer class="bg-white border-t border-slate-200/70 py-12" role="contentinfo">

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-10">

                <div class="md:col-span-2 space-y-4">

                    <span class="text-xl font-bold text-blue-600">CounselConnect</span>

                    <p class="text-slate-500 text-sm leading-relaxed max-w-xs">
                        A safe, professional sanctuary designed to support student mental health and well-being every step of the way.
                    </p>

                    <nav aria-label="Social media links">
                        <ul class="flex items-center gap-4" role="list">

                            <li>
                                <a href="#"
                                   aria-label="Follow CounselConnect on Instagram"
                                   class="text-slate-400 hover:text-blue-600 transition-colors duration-200">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path d="M12 2.163c3.204 0 3.584.012 4.85.07 1.366.062 2.633.334 3.608 1.31.975.975 1.247 2.242 1.31 3.608.058 1.266.07 1.646.07 4.849s-.012 3.584-.07 4.85c-.062 1.366-.334 2.633-1.31 3.608-.975.975-2.242 1.247-3.608 1.31-1.266.058-1.646.07-4.85.07s-3.584-.012-4.85-.07c-1.366-.062-2.633-.334-3.608-1.31-.975-.975-1.247-2.242-1.31-3.608C2.175 15.584 2.163 15.204 2.163 12s.012-3.584.07-4.85c.062-1.366.334-2.633 1.31-3.608.975-.975 2.242-1.247 3.608-1.31C8.416 2.175 8.796 2.163 12 2.163zm0-2.163C8.741 0 8.332.014 7.052.072 5.197.157 3.355.673 2.014 2.014.673 3.355.157 5.197.072 7.052.014 8.332 0 8.741 0 12c0 3.259.014 3.668.072 4.948.085 1.855.601 3.697 1.942 5.038 1.341 1.341 3.183 1.857 5.038 1.942C8.332 23.986 8.741 24 12 24s3.668-.014 4.948-.072c1.855-.085 3.697-.601 5.038-1.942 1.341-1.341 1.857-3.183 1.942-5.038C23.986 15.668 24 15.259 24 12c0-3.259-.014-3.668-.072-4.948-.085-1.855-.601-3.697-1.942-5.038C20.645.673 18.803.157 16.948.072 15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zm0 10.162a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/>
                                    </svg>
                                </a>
                            </li>

                            <li>
                                <a href="#"
                                   aria-label="Follow CounselConnect on X (Twitter)"
                                   class="text-slate-400 hover:text-blue-600 transition-colors duration-200">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-4.714-6.231-5.401 6.231H2.748l7.73-8.835L1.254 2.25H8.08l4.253 5.622L18.244 2.25zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
                                    </svg>
                                </a>
                            </li>

                        </ul>
                    </nav>

                </div>

                <nav aria-label="Company pages">
                    <h2 class="text-xs font-bold tracking-widest text-slate-400 uppercase mb-3">Company</h2>
                    <ul class="space-y-2" role="list">
                        <li><a href="#" class="text-sm text-slate-600 hover:text-blue-600 transition-colors duration-200">About Us</a></li>
                        <li><a href="#" class="text-sm text-slate-600 hover:text-blue-600 transition-colors duration-200">Services</a></li>
                        <li><a href="#" class="text-sm text-slate-600 hover:text-blue-600 transition-colors duration-200">Resources</a></li>
                        <li><a href="#" class="text-sm text-slate-600 hover:text-blue-600 transition-colors duration-200">FAQ</a></li>
                    </ul>
                </nav>

                <nav aria-label="Support and legal pages">
                    <h2 class="text-xs font-bold tracking-widest text-slate-400 uppercase mb-3">Support</h2>
                    <ul class="space-y-2" role="list">
                        <li><a href="#" class="text-sm text-slate-600 hover:text-blue-600 transition-colors duration-200">Privacy Policy</a></li>
                        <li><a href="#" class="text-sm text-slate-600 hover:text-blue-600 transition-colors duration-200">Terms of Service</a></li>
                        <li><a href="#" class="text-sm text-slate-600 hover:text-blue-600 transition-colors duration-200">Contact Us</a></li>
                    </ul>
                </nav>

            </div>

            <div class="mt-10 pt-6 border-t border-slate-100 text-center text-xs text-slate-400">
                <small>© {{ date('Y') }} CounselConnect. All rights reserved.</small>
            </div>

        </div>

    </footer>
    <!-- END: SITE FOOTER -->


    <!-- ============================================================== -->
    <!-- LOGIN MODAL DIALOG                                             -->
    <!-- ============================================================== -->
<!-- LOGIN MODAL -->
<div
    id="login-modal"
    class="hidden fixed inset-0 z-[9999] flex items-center justify-center px-4 py-8 bg-black/50 backdrop-blur-sm"
    role="dialog"
    aria-modal="true"
    aria-labelledby="login-modal-title"
    onclick="if(event.target === this) document.getElementById('login-modal').classList.add('hidden')">

    <div class="w-full max-w-4xl bg-white rounded-3xl shadow-2xl shadow-slate-200/80 overflow-hidden flex flex-col lg:flex-row" style="max-height: 95vh;">

        <!-- Left branding panel -->
        <aside class="hidden lg:flex flex-col justify-between bg-blue-600 px-10 py-10 relative overflow-hidden lg:w-1/2 flex-shrink-0"
            aria-label="CounselConnect highlights">
            <div class="absolute top-0 right-0 w-64 h-64 bg-blue-500 rounded-full -translate-y-1/2 translate-x-1/2 opacity-50" aria-hidden="true"></div>
            <div class="absolute bottom-0 left-0 w-80 h-80 bg-blue-700 rounded-full translate-y-1/2 -translate-x-1/3 opacity-40" aria-hidden="true"></div>
            <div class="absolute top-1/2 left-1/2 w-40 h-40 bg-blue-400 rounded-full -translate-x-1/2 -translate-y-1/2 opacity-20" aria-hidden="true"></div>

            <div class="relative z-10 space-y-3">
                <h2 class="text-3xl font-bold text-white leading-snug">Welcome back to your sanctuary.</h2>
                <p class="text-blue-100 text-sm leading-relaxed">Sign in to continue your journey toward balance and well-being.</p>
            </div>

            <div class="relative z-10 space-y-4">
                <ul class="space-y-3" role="list" aria-label="Platform features">
                    <li class="flex items-start gap-3">
                        <div class="w-5 h-5 rounded-full bg-white/20 flex items-center justify-center flex-shrink-0 mt-0.5" aria-hidden="true">
                            <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                        </div>
                        <span class="text-blue-100 text-sm">Private, confidential counseling sessions</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <div class="w-5 h-5 rounded-full bg-white/20 flex items-center justify-center flex-shrink-0 mt-0.5" aria-hidden="true">
                            <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                        </div>
                        <span class="text-blue-100 text-sm">Access to peer mentoring and group support</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <div class="w-5 h-5 rounded-full bg-white/20 flex items-center justify-center flex-shrink-0 mt-0.5" aria-hidden="true">
                            <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                        </div>
                        <span class="text-blue-100 text-sm">24/7 resource library and self-help tools</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <div class="w-5 h-5 rounded-full bg-white/20 flex items-center justify-center flex-shrink-0 mt-0.5" aria-hidden="true">
                            <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                        </div>
                        <span class="text-blue-100 text-sm">Academic stress management workshops</span>
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
                <div class="w-px h-7 bg-white/20" aria-hidden="true"></div>
                <div>
                    <dd class="text-white text-base font-bold">15+</dd>
                    <dt class="text-blue-200 text-xs">Expert counselors</dt>
                </div>
                <div class="w-px h-7 bg-white/20" aria-hidden="true"></div>
                <div>
                    <dd class="text-white text-base font-bold">24/7</dd>
                    <dt class="text-blue-200 text-xs">Resource access</dt>
                </div>
            </dl>
        </aside>

        <!-- Right panel: scrollable, close button sticky -->
        <section class="flex flex-col flex-1 lg:w-1/2 relative overflow-y-auto" aria-label="Login form">

            <!-- Sticky close button -->
            <button
                type="button"
                onclick="document.getElementById('login-modal').classList.add('hidden')"
                aria-label="Close login dialog"
                class="sticky top-4 ml-auto mr-4 mt-4 w-8 h-8 flex items-center justify-center rounded-full bg-slate-100 hover:bg-slate-200 text-slate-500 hover:text-slate-800 transition-all duration-200 cursor-pointer z-10 flex-shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>

            <div class="px-8 pb-10 -mt-2 flex flex-col justify-center flex-1">
                <div class="w-full max-w-sm mx-auto">

                    <header class="mb-8 text-center">
                        <h2 id="login-modal-title" class="text-2xl font-bold text-slate-900 mb-1">Sign in to CounselConnect</h2>
                        <p class="text-sm text-slate-500">Welcome back to your sanctuary.</p>
                    </header>

                    @if ($errors->any())
                        <div
                            class="mb-6 bg-red-50 border border-red-200 text-red-700 text-sm rounded-xl px-4 py-3 flex items-start gap-2.5"
                            role="alert"
                            aria-live="assertive">
                            <svg class="w-4 h-4 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span>{{ $errors->first() }}</span>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}" class="space-y-5" novalidate>
                        @csrf

                        <div>
                            <label for="email" class="block text-sm font-medium text-slate-700 mb-1.5">Email address</label>
                            <input
                                type="email" id="email" name="email" value="{{ old('email') }}"
                                required autofocus autocomplete="email" placeholder="name@university.edu"
                                class="w-full px-4 py-2.5 text-sm text-slate-900 bg-white border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent placeholder:text-slate-400 transition-all duration-200">
                        </div>

                        <div>
                            <div class="flex items-center justify-between mb-1.5">
                                <label for="password" class="block text-sm font-medium text-slate-700">Password</label>
                                <a href="#" class="text-xs text-blue-600 hover:text-blue-800 font-medium transition-colors duration-200">Forgot password?</a>
                            </div>
                            <div class="relative">
                                <input
                                    type="password" id="password" name="password"
                                    required autocomplete="current-password" placeholder="••••••••"
                                    class="w-full px-4 py-2.5 pr-11 text-sm text-slate-900 bg-white border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent placeholder:text-slate-400 transition-all duration-200">
                                <button type="button" onclick="togglePassword()" aria-label="Toggle password visibility" aria-controls="password"
                                    class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 transition-colors duration-200 cursor-pointer">
                                    <svg id="eye-show" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                    <svg id="eye-hide" class="w-4 h-4 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.542 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <div class="flex items-center gap-2.5">
                            <input type="checkbox" id="remember" name="remember"
                                class="w-4 h-4 text-blue-600 border-slate-300 rounded focus:ring-blue-500 cursor-pointer">
                            <label for="remember" class="text-sm text-slate-600 cursor-pointer">Remember me</label>
                        </div>

                        <button type="submit"
                            class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2.5 rounded-xl shadow-sm hover:shadow-md transition-all duration-200 text-sm cursor-pointer">
                            Log In
                        </button>

                        <div class="relative flex items-center gap-3" role="separator" aria-hidden="true">
    <div class="flex-1 border-t border-slate-200"></div>
    <span class="text-xs text-slate-400">or</span>
    <div class="flex-1 border-t border-slate-200"></div>
</div>

            {{-- Google Sign-In button --}}
            <a href="{{ route('google.redirect') }}"
            class="w-full flex items-center justify-center gap-3 border border-slate-200 hover:border-blue-300 hover:bg-blue-50 text-slate-700 hover:text-blue-700 font-semibold py-2.5 rounded-xl transition-all duration-200 text-sm cursor-pointer">
    <svg class="w-4 h-4 flex-shrink-0" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
        <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
        <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
        <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
    </svg>
    Continue with Google
</a>

<button type="button"
    onclick="document.getElementById('login-modal').classList.add('hidden'); document.getElementById('register-modal').classList.remove('hidden')"
    class="w-full flex items-center justify-center border border-slate-200 hover:border-blue-300 hover:bg-blue-50 text-slate-700 hover:text-blue-700 font-semibold py-2.5 rounded-xl transition-all duration-200 text-sm cursor-pointer">
    Create a new account
</button>
                    </form>

                    <p class="mt-6 text-center text-xs text-slate-400">
                        For administrators, use the
                        <a href="#" class="text-blue-600 hover:text-blue-800 font-medium transition-colors duration-200">admin portal</a>.
                    </p>

                </div>
            </div>
        </section>

    </div>
</div>
    <!-- END: LOGIN MODAL DIALOG -->


    <!-- ============================================================== -->
    <!-- REGISTER MODAL DIALOG                                          -->
    <!-- ============================================================== -->
    <div
        id="register-modal"
        class="hidden fixed inset-0 z-[9999] flex items-center justify-center px-4 py-6 bg-black/50 backdrop-blur-sm"
        role="dialog"
        aria-modal="true"
        aria-labelledby="register-modal-title"
        onclick="if(event.target === this) document.getElementById('register-modal').classList.add('hidden')">

        <div class="w-full max-w-4xl bg-white rounded-3xl shadow-2xl shadow-slate-200/80 overflow-hidden flex flex-col lg:flex-row" style="max-height: 95vh;">

            <!-- Modal left branding panel -->
            <aside
                class="hidden lg:flex flex-col justify-between bg-blue-600 px-10 py-10 relative overflow-hidden lg:w-1/2 flex-shrink-0"
                aria-label="CounselConnect highlights">

                <div class="absolute top-0 right-0 w-64 h-64 bg-blue-500 rounded-full -translate-y-1/2 translate-x-1/2 opacity-50" aria-hidden="true"></div>
                <div class="absolute bottom-0 left-0 w-80 h-80 bg-blue-700 rounded-full translate-y-1/2 -translate-x-1/3 opacity-40" aria-hidden="true"></div>
                <div class="absolute top-1/2 left-1/2 w-40 h-40 bg-blue-400 rounded-full -translate-x-1/2 -translate-y-1/2 opacity-20" aria-hidden="true"></div>

                <div class="relative z-10 space-y-3">
                    <h2 class="text-3xl font-bold text-white leading-snug">Your journey to balance starts here.</h2>
                    <p class="text-blue-100 text-sm leading-relaxed">Join thousands of students who've taken the first step toward better mental health and academic well-being.</p>
                </div>

                <div class="relative z-10 space-y-4">
                    <ul class="space-y-3" role="list" aria-label="Benefits of joining">
                        <li class="flex items-start gap-3">
                            <div class="w-5 h-5 rounded-full bg-white/20 flex items-center justify-center flex-shrink-0 mt-0.5" aria-hidden="true">
                                <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                            </div>
                            <span class="text-blue-100 text-sm">Private, confidential counseling sessions</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <div class="w-5 h-5 rounded-full bg-white/20 flex items-center justify-center flex-shrink-0 mt-0.5" aria-hidden="true">
                                <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                            </div>
                            <span class="text-blue-100 text-sm">Access to peer mentoring and group support</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <div class="w-5 h-5 rounded-full bg-white/20 flex items-center justify-center flex-shrink-0 mt-0.5" aria-hidden="true">
                                <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                            </div>
                            <span class="text-blue-100 text-sm">24/7 resource library and self-help tools</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <div class="w-5 h-5 rounded-full bg-white/20 flex items-center justify-center flex-shrink-0 mt-0.5" aria-hidden="true">
                                <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                            </div>
                            <span class="text-blue-100 text-sm">Academic stress management workshops</span>
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
                    <div class="w-px h-7 bg-white/20" aria-hidden="true"></div>
                    <div>
                        <dd class="text-white text-base font-bold">15+</dd>
                        <dt class="text-blue-200 text-xs">Expert counselors</dt>
                    </div>
                    <div class="w-px h-7 bg-white/20" aria-hidden="true"></div>
                    <div>
                        <dd class="text-white text-base font-bold">24/7</dd>
                        <dt class="text-blue-200 text-xs">Resource access</dt>
                    </div>
                </dl>

            </aside>

            <!-- Modal right panel: registration form -->
            <section
                class="flex flex-col flex-1 lg:w-1/2 relative overflow-y-auto"
                aria-label="Create account form">

                <button
                    type="button"
                    onclick="document.getElementById('register-modal').classList.add('hidden')"
                    aria-label="Close create account dialog"
                    class="sticky top-4 ml-auto mr-4 mt-4 w-8 h-8 flex items-center justify-center rounded-full bg-slate-100 hover:bg-slate-200 text-slate-500 hover:text-slate-800 transition-all duration-200 cursor-pointer z-10 flex-shrink-0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>

                <div class="px-8 pb-10 -mt-2">

                    <div class="w-full max-w-sm mx-auto">

                        <header class="mb-7 text-center">
                            <h2 id="register-modal-title" class="text-2xl font-bold text-slate-900 mb-1">Create your account</h2>
                            <p class="text-sm text-slate-500">Join CounselConnect as a student.</p>
                        </header>

                        {{-- ✅ Validation errors for register modal --}}
                        @if ($errors->any() && session('modal') === 'register')
                            <div
                                class="mb-6 bg-red-50 border border-red-200 text-red-700 text-sm rounded-xl px-4 py-3 flex items-start gap-2.5"
                                role="alert"
                                aria-live="assertive">
                                <svg class="w-4 h-4 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span>{{ $errors->first() }}</span>
                            </div>
                        @endif

                        <!-- Registration form -->
                        <form id="register-form" method="POST" action="{{ route('register') }}" class="space-y-4" novalidate>
                            @csrf

                            <div>
                                <label for="name" class="block text-sm font-medium text-slate-700 mb-1.5">Full name</label>
                                <input type="text" id="name" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" placeholder="Juan Dela Cruz"
                                    class="w-full px-4 py-2.5 text-sm text-slate-900 bg-white border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent placeholder:text-slate-400 transition-all duration-200">
                            </div>

                            <div>
                                <label for="reg-email" class="block text-sm font-medium text-slate-700 mb-1.5">Email address</label>
                                <input type="email" id="reg-email" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="name@university.edu"
                                    class="w-full px-4 py-2.5 text-sm text-slate-900 bg-white border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent placeholder:text-slate-400 transition-all duration-200">
                            </div>

                            <div>
                                <label for="student_id" class="block text-sm font-medium text-slate-700 mb-1.5">Student ID</label>
                                <input type="text" id="student_id" name="student_id" value="{{ old('student_id') }}" required autocomplete="off" placeholder="e.g. 2023-00123"
                                    class="w-full px-4 py-2.5 text-sm text-slate-900 bg-white border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent placeholder:text-slate-400 transition-all duration-200">
                            </div>

                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label for="department" class="block text-sm font-medium text-slate-700 mb-1.5">Department</label>
                                    <input type="text" id="department" name="department" value="{{ old('department') }}" required autocomplete="off" placeholder="e.g. BSIT"
                                        class="w-full px-4 py-2.5 text-sm text-slate-900 bg-white border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent placeholder:text-slate-400 transition-all duration-200">
                                </div>
                                <div>
                                    <label for="year_level" class="block text-sm font-medium text-slate-700 mb-1.5">Year Level</label>
                                    <select id="year_level" name="year_level" required
                                        class="w-full px-4 py-2.5 text-sm text-slate-900 bg-white border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 appearance-none cursor-pointer">
                                        <option value="" disabled {{ old('year_level') ? '' : 'selected' }}>Select</option>
                                        <option value="1st Year" {{ old('year_level') === '1st Year' ? 'selected' : '' }}>1st Year</option>
                                        <option value="2nd Year" {{ old('year_level') === '2nd Year' ? 'selected' : '' }}>2nd Year</option>
                                        <option value="3rd Year" {{ old('year_level') === '3rd Year' ? 'selected' : '' }}>3rd Year</option>
                                        <option value="4th Year" {{ old('year_level') === '4th Year' ? 'selected' : '' }}>4th Year</option>
                                    </select>
                                </div>
                            </div>

                            <div>
                                <label for="reg-password" class="block text-sm font-medium text-slate-700 mb-1.5">Password</label>
                                <div class="relative">
                                    <input type="password" id="reg-password" name="password" required autocomplete="new-password" placeholder="••••••••"
                                        class="w-full px-4 py-2.5 pr-11 text-sm text-slate-900 bg-white border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent placeholder:text-slate-400 transition-all duration-200">
                                    <button type="button" onclick="toggleRegPassword()" aria-label="Toggle password visibility" aria-controls="reg-password"
                                        class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 transition-colors duration-200 cursor-pointer">
                                        <svg id="reg-eye-show" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                        <svg id="reg-eye-hide" class="w-4 h-4 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.542 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            <div>
                                <label for="password_confirmation" class="block text-sm font-medium text-slate-700 mb-1.5">Confirm password</label>
                                <div class="relative">
                                    <input type="password" id="password_confirmation" name="password_confirmation" required autocomplete="new-password" placeholder="••••••••"
                                        class="w-full px-4 py-2.5 pr-11 text-sm text-slate-900 bg-white border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent placeholder:text-slate-400 transition-all duration-200">
                                    <button type="button" onclick="toggleConfirmPassword()" aria-label="Toggle confirm password visibility" aria-controls="password_confirmation"
                                        class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 transition-colors duration-200 cursor-pointer">
                                        <svg id="confirm-eye-show" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                        <svg id="confirm-eye-hide" class="w-4 h-4 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.542 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            <button type="submit"
                                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2.5 rounded-xl shadow-sm hover:shadow-md transition-all duration-200 text-sm cursor-pointer">
                                Create Account
                            </button>

                            <div class="relative flex items-center gap-3" role="separator" aria-hidden="true">
                                <div class="flex-1 border-t border-slate-200"></div>
                                <span class="text-xs text-slate-400">or</span>
                                <div class="flex-1 border-t border-slate-200"></div>
                            </div>

                            <button type="button"
                                onclick="document.getElementById('register-modal').classList.add('hidden'); document.getElementById('login-modal').classList.remove('hidden')"
                                class="w-full flex items-center justify-center border border-slate-200 hover:border-blue-300 hover:bg-blue-50 text-slate-700 hover:text-blue-700 font-semibold py-2.5 rounded-xl transition-all duration-200 text-sm cursor-pointer">
                                Already have an account? Sign in
                            </button>

                        </form>

                    </div>
                </div>

            </section>

        </div>
    </div>
    <!-- END: REGISTER MODAL DIALOG -->


    {{-- ✅ Modal auto-reopen script — must be inside <body>, before </body> --}}
    @if (session('modal') || $errors->any())
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            @if(session('modal') === 'login')
                document.getElementById('login-modal')?.classList.remove('hidden');
            @elseif(session('modal') === 'register')
                document.getElementById('register-modal')?.classList.remove('hidden');
            @endif
        });
    </script>
    @endif

</body>
</html>
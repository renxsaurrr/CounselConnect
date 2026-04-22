<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Services | CounselConnect</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>

<!-- =============================================================== -->
<!-- SITE HEADER: Sticky top navigation bar with logo, links, CTAs  -->
<!-- =============================================================== -->
<header class="bg-white/80 backdrop-blur-xl sticky top-0 z-50 border-b border-slate-200/50">

    <!-- Primary navigation wrapper -->
    <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8" aria-label="Primary navigation">

        <!-- Nav inner row: logo | desktop links | CTA buttons | mobile toggle -->
        <div class="flex justify-between items-center h-16 lg:h-20">

            <!-- Site logo linking to homepage -->
            <div class="flex-shrink-0">
                <a href="#" class="flex items-center space-x-2" aria-label="CounselConnect home">
                    <span class="text-xl lg:text-2xl font-bold text-blue-600">CounselConnect</span>
                </a>
            </div>

            <!-- Desktop navigation links (hidden on mobile) -->
            <ul class="hidden lg:flex items-center space-x-2 xl:space-x-8" role="list">

                <!-- Home nav link -->
                <li>
                    <a href="{{ route('home') }}"
                        class="px-3 py-2 font-medium rounded-xl hover:bg-blue-50 hover:text-blue-700 transition-all duration-300 group relative
                        {{ request()->routeIs('home') ? 'text-blue-700' : 'text-slate-700' }}"
                        {{ request()->routeIs('home') ? 'aria-current=page' : '' }}>
                        <span>Home</span>
                        <!-- Active/hover underline indicator -->
                        <span class="absolute -bottom-1 left-0 right-0 h-0.5 bg-blue-600 transition-transform duration-300 origin-left
                            {{ request()->routeIs('home') ? 'scale-x-100' : 'scale-x-0 group-hover:scale-x-100' }}"
                            aria-hidden="true"></span>
                    </a>
                </li>

                <!-- Services nav link -->
                <li>
                    <a href="{{ route('services') }}"
                        class="px-3 py-2 font-medium rounded-xl hover:bg-blue-50 hover:text-blue-700 transition-all duration-300 group relative
                        {{ request()->routeIs('services') ? 'text-blue-700' : 'text-slate-700' }}"
                        {{ request()->routeIs('services') ? 'aria-current=page' : '' }}>
                        <span>Services</span>
                        <!-- Active/hover underline indicator -->
                        <span class="absolute -bottom-1 left-0 right-0 h-0.5 bg-blue-600 transition-transform duration-300 origin-left
                            {{ request()->routeIs('services') ? 'scale-x-100' : 'scale-x-0 group-hover:scale-x-100' }}"
                            aria-hidden="true"></span>
                    </a>
                </li>

                <!-- Resources nav link -->
                <li>
                    <a href="{{ route('resources') }}"
                        class="px-3 py-2 font-medium rounded-xl hover:bg-blue-50 hover:text-blue-700 transition-all duration-300 group relative
                        {{ request()->routeIs('resources') ? 'text-blue-700' : 'text-slate-700' }}"
                        {{ request()->routeIs('resources') ? 'aria-current=page' : '' }}>
                        <span>Resources</span>
                        <!-- Active/hover underline indicator -->
                        <span class="absolute -bottom-1 left-0 right-0 h-0.5 bg-blue-600 transition-transform duration-300 origin-left
                            {{ request()->routeIs('resources') ? 'scale-x-100' : 'scale-x-0 group-hover:scale-x-100' }}"
                            aria-hidden="true"></span>
                    </a>
                </li>

                <!-- FAQ nav link -->
                <li>
                    <a href="{{ route('FAQ') }}"
                        class="px-3 py-2 font-medium rounded-xl hover:bg-blue-50 hover:text-blue-700 transition-all duration-300 group relative
                        {{ request()->routeIs('FAQ') ? 'text-blue-700' : 'text-slate-700' }}"
                        {{ request()->routeIs('FAQ') ? 'aria-current=page' : '' }}>
                        <span>FAQ</span>
                        <!-- Active/hover underline indicator -->
                        <span class="absolute -bottom-1 left-0 right-0 h-0.5 bg-blue-600 transition-transform duration-300 origin-left
                            {{ request()->routeIs('FAQ') ? 'scale-x-100' : 'scale-x-0 group-hover:scale-x-100' }}"
                            aria-hidden="true"></span>
                    </a>
                </li>

            </ul>
            <!-- End desktop navigation links -->

            <!-- Desktop CTA buttons (hidden on mobile) -->
            <div class="hidden lg:flex items-center space-x-4">

                <!-- Log In button: opens the login modal dialog -->
                <button
                    type="button"
                    onclick="document.getElementById('login-modal').classList.remove('hidden')"
                    aria-haspopup="dialog"
                    aria-controls="login-modal"
                    class="w-32 h-10 flex items-center justify-center text-slate-700 font-semibold border-2 border-slate-200
                     hover:border-blue-300 hover:text-blue-700 hover:bg-blue-50 rounded-3xl transition-all duration-300
                      hover:shadow-xl transform hover:-translate-y-0.5 cursor-pointer">
                    Log In
                </button>

                <!-- Get Started CTA button: links to registration -->
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
            <!-- End desktop CTA buttons -->

            <!-- Mobile hamburger toggle button (hidden on desktop) -->
            <button
                id="mobile-menu-btn"
                type="button"
                class="lg:hidden p-2 rounded-xl text-slate-700 hover:bg-blue-50 hover:text-blue-700 transition-all duration-300 cursor-pointer"
                aria-controls="mobile-menu"
                aria-expanded="false"
                aria-label="Toggle mobile navigation">

                <!-- Hamburger icon: shown when menu is closed -->
                <svg id="hamburger-icon" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>

                <!-- Close (X) icon: shown when menu is open -->
                <svg id="close-icon" class="w-6 h-6 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>

            </button>
            <!-- End mobile hamburger toggle button -->

        </div>
        <!-- End nav inner row -->

        <!-- Mobile dropdown menu (hidden by default, toggled via JS) -->
        <div id="mobile-menu" class="hidden lg:hidden pb-4" role="navigation" aria-label="Mobile navigation">

            <!-- Mobile nav links list -->
            <ul class="flex flex-col space-y-1 mb-4" role="list">
                <li><a href="{{ route('home') }}" class="block px-4 py-2.5 text-slate-700 font-medium rounded-xl hover:bg-blue-50 hover:text-blue-700 transition-all duration-300">Home</a></li>
                <li><a href="{{ route('services') }}" class="block px-4 py-2.5 text-slate-700 font-medium rounded-xl hover:bg-blue-50 hover:text-blue-700 transition-all duration-300">Services</a></li>
                <li><a href="{{ route('resources') }}" class="block px-4 py-2.5 text-slate-700 font-medium rounded-xl hover:bg-blue-50 hover:text-blue-700 transition-all duration-300">Resources</a></li>
                <li><a href="{{ route('FAQ') }}" class="block px-4 py-2.5 text-slate-700 font-medium rounded-xl hover:bg-blue-50 hover:text-blue-700 transition-all duration-300">FAQ</a></li>
            </ul>
            <!-- End mobile nav links list -->

            <!-- Mobile CTA buttons -->
            <div class="flex flex-col space-y-2 px-2">

                <!-- Mobile Log In button: opens the login modal dialog -->
                <button
                    type="button"
                    onclick="document.getElementById('login-modal').classList.remove('hidden')"
                    aria-haspopup="dialog"
                    aria-controls="login-modal"
                    class="w-full text-center py-2.5 text-slate-700 font-semibold border-2 border-slate-200 hover:border-blue-300 hover:text-blue-700 hover:bg-blue-50 rounded-3xl transition-all duration-300 cursor-pointer">
                    Log In
                </button>

                <!-- Mobile Get Started CTA button: links to registration -->
                <button
                        type="button"
                        onclick="document.getElementById('register-modal').classList.remove('hidden')"
                        aria-haspopup="dialog"
                        aria-controls="register-modal"
                        class="w-full text-center py-2.5 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white rounded-3xl font-semibold shadow-lg transition-all duration-300 cursor-pointer">
                        Get Started
                </button>

            </div>
            <!-- End mobile CTA buttons -->

        </div>
        <!-- End mobile dropdown menu -->

    </nav>
    <!-- End primary navigation wrapper -->

</header>
<!-- End site header -->


<!-- =============================================================== -->
<!-- MAIN CONTENT AREA                                               -->
<!-- =============================================================== -->
<main>

    <!-- =========================================================== -->
    <!-- SERVICES SECTION: Bento grid of available service cards     -->
    <!-- =========================================================== -->
    <section class="bg-white pt-6 pb-16 lg:pt-8 lg:pb-24" aria-labelledby="services-heading">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Section header -->
            <header class="mb-12">

                <!-- Section category badge -->
                <div class="inline-flex items-center gap-2 bg-blue-50 border border-blue-200 text-blue-600 text-xs font-bold px-3 py-1.5 rounded-full mb-5 tracking-widest uppercase">
                    Support Systems
                </div>

                <!-- Section heading -->
                <h1 id="services-heading" class="text-4xl lg:text-5xl font-bold text-slate-900 mb-4">Our Services</h1>

                <!-- Section description -->
                <p class="text-slate-500 text-base leading-relaxed max-w-xl">
                    A comprehensive ecosystem of care designed specifically for the unique challenges of student life. We provide the tools, the community, and the professional guidance to help you thrive.
                </p>

            </header>
            <!-- End section header -->

            <!-- Bento grid: service cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">

                <!-- Service card: Individual Counseling (spans 2 columns on large screens) -->
                <article class="lg:col-span-2 bg-slate-50 border border-slate-200 rounded-3xl p-8 flex flex-col gap-6 hover:border-blue-200 hover:shadow-xl transition-all duration-300 hover:-translate-y-1 group">

                    <!-- Card icon: person silhouette -->
                    <div class="w-11 h-11 bg-blue-100 rounded-2xl flex items-center justify-center group-hover:bg-blue-200 transition-colors" aria-hidden="true">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/>
                        </svg>
                    </div>

                    <!-- Card text content -->
                    <div>
                        <h2 class="text-xl font-bold text-slate-900 mb-2">Individual Counseling</h2>
                        <p class="text-slate-500 text-sm leading-relaxed">Private, confidential sessions with licensed professionals tailored to your personal journey, mental health goals, and academic transitions.</p>
                    </div>

                </article>
                <!-- End Individual Counseling card -->

                <!-- Service card: Group Support -->
                <article class="bg-slate-50 border border-slate-200 rounded-3xl p-8 flex flex-col gap-6 hover:border-blue-200 hover:shadow-xl transition-all duration-300 hover:-translate-y-1 group">

                    <!-- Card icon: group of people -->
                    <div class="w-11 h-11 bg-blue-100 rounded-2xl flex items-center justify-center group-hover:bg-blue-200 transition-colors" aria-hidden="true">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z"/>
                        </svg>
                    </div>

                    <!-- Card text content -->
                    <div>
                        <h2 class="text-xl font-bold text-slate-900 mb-2">Group Support</h2>
                        <p class="text-slate-500 text-sm leading-relaxed">Shared experiences in a guided environment focusing on anxiety, grief, and building resilience alongside your peers.</p>
                    </div>

                </article>
                <!-- End Group Support card -->

                <!-- Service card: Academic Stress Management -->
                <article class="bg-slate-50 border border-slate-200 rounded-3xl p-8 flex flex-col gap-6 hover:border-blue-200 hover:shadow-xl transition-all duration-300 hover:-translate-y-1 group">

                    <!-- Card icon: academic cap/graduation -->
                    <div class="w-11 h-11 bg-blue-100 rounded-2xl flex items-center justify-center group-hover:bg-blue-200 transition-colors" aria-hidden="true">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.57 50.57 0 00-2.658-.813A59.905 59.905 0 0112 3.493a59.902 59.902 0 0110.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.697 50.697 0 0112 13.489a50.702 50.702 0 017.74-3.342M6.75 15a.75.75 0 100-1.5.75.75 0 000 1.5zm0 0v-3.675A55.378 55.378 0 0112 8.443m-7.007 11.55A5.981 5.981 0 006.75 15.75v-1.5"/>
                        </svg>
                    </div>

                    <!-- Card text content -->
                    <div>
                        <h2 class="text-xl font-bold text-slate-900 mb-2">Academic Stress Management</h2>
                        <p class="text-slate-500 text-sm leading-relaxed">Workshops and coaching to handle finals, dissertation pressure, and the delicate balance of study-life integration.</p>
                    </div>

                </article>
                <!-- End Academic Stress Management card -->

                <!-- Service card: Peer Mentoring (spans 2 columns, contains an image) -->
                <article class="lg:col-span-2 bg-slate-50 border border-slate-200 rounded-3xl overflow-hidden flex flex-col md:flex-row hover:border-blue-200 hover:shadow-xl transition-all duration-300 hover:-translate-y-1 group">

                    <!-- Card image: students mentoring -->
                    <figure class="md:w-2/5 h-52 md:h-auto flex-shrink-0">
                        <img
                            src="{{ asset('images/peermentoring.jpg') }}"
                            alt="Two students engaged in a peer mentoring session"
                            class="w-full h-full object-cover"
                            loading="lazy"
                        />
                    </figure>

                    <!-- Card text content and CTA link -->
                    <div class="flex flex-col gap-4 p-8 justify-center">

                        <!-- Card icon: chat bubble -->
                        <div class="w-11 h-11 bg-blue-100 rounded-2xl flex items-center justify-center group-hover:bg-blue-200 transition-colors" aria-hidden="true">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 01.865-.501 48.172 48.172 0 003.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018z"/>
                            </svg>
                        </div>

                        <!-- Card title and description -->
                        <div>
                            <h2 class="text-xl font-bold text-slate-900 mb-2">Peer Mentoring</h2>
                            <p class="text-slate-500 text-sm leading-relaxed">Connect with upperclassmen trained in active listening and student advocacy to navigate the social landscape of campus life.</p>
                        </div>

                        <!-- Learn more link: navigates to peer mentoring detail page -->
                        <a href="https://www.mentoring.org/wp-content/uploads/2020/08/Peer-Mentoring-Supplement-to-the-EEP.pdf" target= "_blank" class="inline-flex items-center gap-1.5 text-blue-600 text-sm font-semibold hover:gap-3 transition-all duration-200 w-fit">
                            Learn about mentoring
                            <!-- Arrow icon -->
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                            </svg>
                        </a>

                    </div>
                    <!-- End card text content -->

                </article>
                <!-- End Peer Mentoring card -->

            </div>
            <!-- End bento grid -->

        </div>
    </section>
    <!-- End services section -->


    <!-- =========================================================== -->
    <!-- PATH TO BALANCE SECTION: 3-step process walkthrough         -->
    <!-- =========================================================== -->
    <section class="bg-slate-50 border-t border-slate-200/70 py-16 lg:py-24" aria-labelledby="steps-heading">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">

            <!-- Section heading -->
            <h2 id="steps-heading" class="text-3xl lg:text-4xl font-bold text-slate-900 mb-3">The Path to Balance</h2>

            <!-- Section subheading -->
            <p class="text-slate-500 text-base mb-14">Simple, streamlined, and empathetic from the first click.</p>

            <!-- Ordered steps list: using ol for sequential process steps -->
            <ol class="grid grid-cols-1 md:grid-cols-3 gap-8 lg:gap-12 relative list-none" aria-label="How to get started in 3 steps">

                <!-- Decorative connector line between steps (desktop only) -->
                <div class="hidden md:block absolute top-10 left-1/4 right-1/4 h-px bg-blue-200 z-0" aria-hidden="true"></div>

                <!-- Step 1: Request -->
                <li class="flex flex-col items-center gap-4 relative z-10">

                    <!-- Step icon: edit/pencil -->
                    <div class="w-20 h-20 bg-white border-2 border-blue-100 rounded-3xl flex items-center justify-center shadow-sm" aria-hidden="true">
                        <svg class="w-8 h-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10"/>
                        </svg>
                    </div>

                    <!-- Step text content -->
                    <div>
                        <h3 class="text-base font-bold text-slate-900 mb-1">Request</h3>
                        <p class="text-slate-500 text-sm leading-relaxed">Fill out a short, confidential form about your current needs and preferences.</p>
                    </div>

                </li>
                <!-- End Step 1 -->

                <!-- Step 2: Match -->
                <li class="flex flex-col items-center gap-4 relative z-10">

                    <!-- Step icon: people/matching -->
                    <div class="w-20 h-20 bg-white border-2 border-blue-100 rounded-3xl flex items-center justify-center shadow-sm" aria-hidden="true">
                        <svg class="w-8 h-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"/>
                        </svg>
                    </div>

                    <!-- Step text content -->
                    <div>
                        <h3 class="text-base font-bold text-slate-900 mb-1">Match</h3>
                        <p class="text-slate-500 text-sm leading-relaxed">Our clinical team matches your request to pair you with the best-fit counselor or group.</p>
                    </div>

                </li>
                <!-- End Step 2 -->

                <!-- Step 3: Connect -->
                <li class="flex flex-col items-center gap-4 relative z-10">

                    <!-- Step icon: chat/video platform -->
                    <div class="w-20 h-20 bg-white border-2 border-blue-100 rounded-3xl flex items-center justify-center shadow-sm" aria-hidden="true">
                        <svg class="w-8 h-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 8.511c.884.284 1.5 1.128 1.5 2.097v4.286c0 1.136-.847 2.1-1.98 2.193-.34.027-.68.052-1.02.072v3.091l-3-3c-1.354 0-2.694-.055-4.02-.163a2.115 2.115 0 01-.825-.242m9.345-8.334a2.126 2.126 0 00-.476-.095 48.64 48.64 0 00-8.048 0c-1.131.094-1.976 1.057-1.976 2.192v4.286c0 .837.46 1.58 1.155 1.951m9.345-8.334V6.637c0-1.621-1.152-3.026-2.76-3.235A48.455 48.455 0 0011.25 3c-2.115 0-4.198.137-6.24.402-1.608.209-2.76 1.614-2.76 3.235v6.226c0 1.621 1.152 3.026 2.76 3.235.577.075 1.157.14 1.74.194V21l4.155-4.155"/>
                        </svg>
                    </div>

                    <!-- Step text content -->
                    <div>
                        <h3 class="text-base font-bold text-slate-900 mb-1">Connect</h3>
                        <p class="text-slate-500 text-sm leading-relaxed">Begin your sessions in-person or via our secure, encrypted video platform.</p>
                    </div>

                </li>
                <!-- End Step 3 -->

            </ol>
            <!-- End ordered steps list -->

        </div>
    </section>
    <!-- End path to balance section -->


    <!-- =========================================================== -->
    <!-- EMERGENCY SUPPORT SECTION: Crisis hotline banner            -->
    <!-- =========================================================== -->
    <section class="bg-red-50 border-t border-red-100 py-12 lg:py-16" aria-labelledby="emergency-heading">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Emergency banner card -->
            <div class="bg-red-400 rounded-3xl p-8 lg:p-12 flex flex-col lg:flex-row items-start lg:items-center justify-between gap-8">

                <!-- Banner left side: heading and description text -->
                <div class="space-y-3">

                    <!-- Urgency badge -->
                    <div class="inline-flex items-center gap-2 bg-red-300/40 text-white text-xs font-bold px-3 py-1.5 rounded-full tracking-widest uppercase">
                        <!-- Warning triangle icon -->
                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path fill-rule="evenodd" d="M9.401 3.003c1.155-2 4.043-2 5.197 0l7.355 12.748c1.154 2-.29 4.5-2.599 4.5H4.645c-2.309 0-3.752-2.5-2.598-4.5L9.4 3.003zM12 8.25a.75.75 0 01.75.75v3.75a.75.75 0 01-1.5 0V9a.75.75 0 01.75-.75zm0 8.25a.75.75 0 100-1.5.75.75 0 000 1.5z" clip-rule="evenodd"/>
                        </svg>
                        Immediate Assistance
                    </div>

                    <!-- Emergency section heading -->
                    <h2 id="emergency-heading" class="text-3xl lg:text-4xl font-bold text-white">Emergency Support</h2>

                    <!-- Emergency section description -->
                    <p class="text-red-100 text-sm leading-relaxed max-w-sm">
                        If you are in immediate distress or considering self-harm, please reach out now. Support is available 24/7. You are never alone.
                    </p>

                </div>
                <!-- End banner left side -->

                <!-- Banner right side: crisis contact buttons -->
                <div class="flex flex-col gap-3 w-full lg:w-auto lg:min-w-[260px]">

                    <!-- Crisis Hotline phone link -->
                    <a href="tel:988"
                        class="flex items-center justify-between bg-slate-900 hover:bg-slate-800 text-white px-6 py-4 rounded-2xl transition-all duration-200 group"
                        aria-label="Call the crisis hotline at 988">

                        <!-- Left: icon and label -->
                        <div class="flex items-center gap-3">
                            <!-- Phone icon -->
                            <svg class="w-5 h-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z"/>
                            </svg>
                            <!-- Label text -->
                            <div>
                                <p class="text-xs text-slate-400 font-medium">Crisis Hotline</p>
                                <p class="text-lg font-bold tracking-wide">Dial 988</p>
                            </div>
                        </div>

                        <!-- Right: chevron arrow -->
                        <svg class="w-4 h-4 text-slate-400 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
                        </svg>

                    </a>
                    <!-- End crisis hotline phone link -->

                    <!-- Crisis text line SMS link -->
                    <a href="sms:741741&body=HELP"
                        class="flex items-center justify-between bg-slate-900 hover:bg-slate-800 text-white px-6 py-4 rounded-2xl transition-all duration-200 group"
                        aria-label="Text HELP to 741741 for 24/7 crisis support">

                        <!-- Left: icon and label -->
                        <div class="flex items-center gap-3">
                            <!-- Chat bubble icon -->
                            <svg class="w-5 h-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 01.865-.501 48.172 48.172 0 003.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018z"/>
                            </svg>
                            <!-- Label text -->
                            <div>
                                <p class="text-xs text-slate-400 font-medium">Text Line — 24/7</p>
                                <p class="text-lg font-bold tracking-wide">Text 'HELP' to 741741</p>
                            </div>
                        </div>

                        <!-- Right: chevron arrow -->
                        <svg class="w-4 h-4 text-slate-400 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
                        </svg>

                    </a>
                    <!-- End crisis text line SMS link -->

                </div>
                <!-- End banner right side -->

            </div>
            <!-- End emergency banner card -->

        </div>
    </section>
    <!-- End emergency support section -->

</main>
<!-- End main content area -->


<!-- =============================================================== -->
<!-- SITE FOOTER: Brand info, navigation links, social icons         -->
<!-- =============================================================== -->
<footer class="bg-white border-t border-slate-200/70 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Footer grid: brand column + two nav columns -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-10">

            <!-- Brand column: logo, tagline, and social links -->
            <div class="md:col-span-2 space-y-4">

                <!-- Footer brand name -->
                <span class="text-xl font-bold text-blue-600">CounselConnect</span>

                <!-- Footer tagline -->
                <p class="text-slate-500 text-sm leading-relaxed max-w-xs">
                    A safe, professional sanctuary designed to support student mental health and well-being every step of the way.
                </p>

                <!-- Social media icon links -->
                <nav aria-label="Social media links">
                    <div class="flex items-center gap-4">

                        <!-- Instagram link -->
                        <a href="#" class="text-slate-400 hover:text-blue-600 transition-colors duration-200" aria-label="Follow us on Instagram">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M12 2.163c3.204 0 3.584.012 4.85.07 1.366.062 2.633.334 3.608 1.31.975.975 1.247 2.242 1.31 3.608.058 1.266.07 1.646.07 4.849s-.012 3.584-.07 4.85c-.062 1.366-.334 2.633-1.31 3.608-.975.975-2.242 1.247-3.608 1.31-1.266.058-1.646.07-4.85.07s-3.584-.012-4.85-.07c-1.366-.062-2.633-.334-3.608-1.31-.975-.975-1.247-2.242-1.31-3.608C2.175 15.584 2.163 15.204 2.163 12s.012-3.584.07-4.85c.062-1.366.334-2.633 1.31-3.608.975-.975 2.242-1.247 3.608-1.31C8.416 2.175 8.796 2.163 12 2.163zm0-2.163C8.741 0 8.332.014 7.052.072 5.197.157 3.355.673 2.014 2.014.673 3.355.157 5.197.072 7.052.014 8.332 0 8.741 0 12c0 3.259.014 3.668.072 4.948.085 1.855.601 3.697 1.942 5.038 1.341 1.341 3.183 1.857 5.038 1.942C8.332 23.986 8.741 24 12 24s3.668-.014 4.948-.072c1.855-.085 3.697-.601 5.038-1.942 1.341-1.341 1.857-3.183 1.942-5.038C23.986 15.668 24 15.259 24 12c0-3.259-.014-3.668-.072-4.948-.085-1.855-.601-3.697-1.942-5.038C20.645.673 18.803.157 16.948.072 15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zm0 10.162a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/>
                            </svg>
                        </a>

                        <!-- X (Twitter) link -->
                        <a href="#" class="text-slate-400 hover:text-blue-600 transition-colors duration-200" aria-label="Follow us on X (Twitter)">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-4.714-6.231-5.401 6.231H2.748l7.73-8.835L1.254 2.25H8.08l4.253 5.622L18.244 2.25zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
                            </svg>
                        </a>

                    </div>
                </nav>
                <!-- End social media icon links -->

            </div>
            <!-- End brand column -->

            <!-- Company navigation column -->
            <nav aria-label="Company links">
                <h2 class="text-xs font-bold tracking-widest text-slate-400 uppercase mb-3">Company</h2>
                <ul class="space-y-2" role="list">
                    <li><a href="#" class="text-sm text-slate-600 hover:text-blue-600 transition-colors duration-200">About Us</a></li>
                    <li><a href="#" class="text-sm text-slate-600 hover:text-blue-600 transition-colors duration-200">Services</a></li>
                    <li><a href="#" class="text-sm text-slate-600 hover:text-blue-600 transition-colors duration-200">Resources</a></li>
                    <li><a href="#" class="text-sm text-slate-600 hover:text-blue-600 transition-colors duration-200">FAQ</a></li>
                </ul>
            </nav>
            <!-- End company navigation column -->

            <!-- Support/legal navigation column -->
            <nav aria-label="Support and legal links">
                <h2 class="text-xs font-bold tracking-widest text-slate-400 uppercase mb-3">Support</h2>
                <ul class="space-y-2" role="list">
                    <li><a href="#" class="text-sm text-slate-600 hover:text-blue-600 transition-colors duration-200">Privacy Policy</a></li>
                    <li><a href="#" class="text-sm text-slate-600 hover:text-blue-600 transition-colors duration-200">Terms of Service</a></li>
                    <li><a href="#" class="text-sm text-slate-600 hover:text-blue-600 transition-colors duration-200">Contact Us</a></li>
                </ul>
            </nav>
            <!-- End support/legal navigation column -->

        </div>
        <!-- End footer grid -->

        <!-- Footer copyright bar -->
        <div class="mt-10 pt-6 border-t border-slate-100 text-center text-xs text-slate-400">
            <small>&copy; {{ date('Y') }} CounselConnect. All rights reserved.</small>
        </div>
        <!-- End footer copyright bar -->

    </div>
</footer>
<!-- End site footer -->

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
    <!-- REGISTER MODAL DIALOG: Overlay with branding panel (left) and  -->
    <!-- student registration form (right)                              -->
    <!-- ============================================================== -->
    <!-- REGISTER MODAL DIALOG -->
<div
    id="register-modal"
    class="hidden fixed inset-0 z-[9999] flex items-center justify-center px-4 py-6 bg-black/50 backdrop-blur-sm"
    role="dialog"
    aria-modal="true"
    aria-labelledby="register-modal-title"
    onclick="if(event.target === this) document.getElementById('register-modal').classList.add('hidden')">

    <!-- Modal container card -->
    <div class="w-full max-w-4xl bg-white rounded-3xl shadow-2xl shadow-slate-200/80 overflow-hidden flex flex-col lg:flex-row" style="max-height: 95vh;">

        <!-- Modal left branding panel (desktop only) -->
        <aside
            class="hidden lg:flex flex-col justify-between bg-blue-600 px-10 py-10 relative overflow-hidden lg:w-1/2 flex-shrink-0"
            aria-label="CounselConnect highlights">

            <!-- Decorative blobs -->
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
        <!-- End left branding panel -->


        <!-- Modal right panel: registration form (scrollable) -->
        <section
            class="flex flex-col flex-1 lg:w-1/2 relative overflow-y-auto"
            aria-label="Create account form">

            <!-- Close button — sticky at top right of the scroll panel -->
            <button
                type="button"
                onclick="document.getElementById('register-modal').classList.add('hidden')"
                aria-label="Close create account dialog"
                class="sticky top-4 ml-auto mr-4 mt-4 w-8 h-8 flex items-center justify-center rounded-full bg-slate-100 hover:bg-slate-200 text-slate-500 hover:text-slate-800 transition-all duration-200 cursor-pointer z-10 flex-shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>

            <!-- Form content -->
            <div class="px-8 pb-10 -mt-2">

                <div class="w-full max-w-sm mx-auto">

                    <!-- Header -->
                    <header class="mb-7 text-center">
                        <h2 id="register-modal-title" class="text-2xl font-bold text-slate-900 mb-1">Create your account</h2>
                        <p class="text-sm text-slate-500">Join CounselConnect as a student.</p>
                    </header>

                    <!-- Validation errors -->
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

                    <!-- Registration form -->
                    <form method="POST" action="{{ route('register') }}" class="space-y-4" novalidate>
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
        <!-- End modal right panel -->

    </div>
</div>
<!-- End register modal -->
    

</body>
</html>
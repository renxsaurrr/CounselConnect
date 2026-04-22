<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resource Library — CounselConnect</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white text-slate-900 antialiased">


<!-- SITE HEADER: Sticky top navigation bar with logo, nav links, and action buttons -->
<header class="bg-white/80 backdrop-blur-xl sticky top-0 z-50 border-b border-slate-200/50">

    <!-- MAIN NAV: Constrains content width and aligns all nav items in a row -->
    <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8" aria-label="Main navigation">

        <!-- NAV INNER ROW: Flex row holding logo, desktop links, and action buttons -->
        <div class="flex justify-between items-center h-16 lg:h-20">

            <!-- LOGO: Brand name linking to the homepage -->
            <div class="flex-shrink-0">
                <a href="#" class="flex items-center space-x-2" aria-label="CounselConnect home">
                    <span class="text-xl lg:text-2xl font-bold text-blue-600">CounselConnect</span>
                </a>
            </div>

            <!-- DESKTOP NAV LINKS: Visible on large screens only -->
            <ul class="hidden lg:flex items-center space-x-2 xl:space-x-8" role="list">

                <!-- NAV ITEM: Home link with active state underline indicator -->
                <li>
                    <a href="{{ route('home') }}"
                       class="px-3 py-2 font-medium rounded-xl hover:bg-blue-50 hover:text-blue-700 transition-all duration-300 group relative
                              {{ request()->routeIs('home') ? 'text-blue-700' : 'text-slate-700' }}">
                        <span>Home</span>
                        <!-- ACTIVE UNDERLINE INDICATOR: Visible when on the Home route -->
                        <span class="absolute -bottom-1 left-0 right-0 h-0.5 bg-blue-600 transition-transform duration-300 origin-left
                                     {{ request()->routeIs('home') ? 'scale-x-100' : 'scale-x-0 group-hover:scale-x-100' }}"
                              aria-hidden="true"></span>
                    </a>
                </li>

                <!-- NAV ITEM: Services link with active state underline indicator -->
                <li>
                    <a href="{{ route('services') }}"
                       class="px-3 py-2 font-medium rounded-xl hover:bg-blue-50 hover:text-blue-700 transition-all duration-300 group relative
                              {{ request()->routeIs('services') ? 'text-blue-700' : 'text-slate-700' }}">
                        <span>Services</span>
                        <!-- ACTIVE UNDERLINE INDICATOR: Visible when on the Services route -->
                        <span class="absolute -bottom-1 left-0 right-0 h-0.5 bg-blue-600 transition-transform duration-300 origin-left
                                     {{ request()->routeIs('services') ? 'scale-x-100' : 'scale-x-0 group-hover:scale-x-100' }}"
                              aria-hidden="true"></span>
                    </a>
                </li>

                <!-- NAV ITEM: Resources link with active state underline indicator -->
                <li>
                    <a href="{{ route('resources') }}"
                       class="px-3 py-2 font-medium rounded-xl hover:bg-blue-50 hover:text-blue-700 transition-all duration-300 group relative
                              {{ request()->routeIs('resources') ? 'text-blue-700' : 'text-slate-700' }}"
                       aria-current="{{ request()->routeIs('resources') ? 'page' : false }}">
                        <span>Resources</span>
                        <!-- ACTIVE UNDERLINE INDICATOR: Visible when on the Resources route -->
                        <span class="absolute -bottom-1 left-0 right-0 h-0.5 bg-blue-600 transition-transform duration-300 origin-left
                                     {{ request()->routeIs('resources') ? 'scale-x-100' : 'scale-x-0 group-hover:scale-x-100' }}"
                              aria-hidden="true"></span>
                    </a>
                </li>

                <!-- NAV ITEM: FAQ link with active state underline indicator -->
                <li>
                    <a href="{{ route('FAQ') }}"
                       class="px-3 py-2 font-medium rounded-xl hover:bg-blue-50 hover:text-blue-700 transition-all duration-300 group relative
                              {{ request()->routeIs('FAQ') ? 'text-blue-700' : 'text-slate-700' }}">
                        <span>FAQ</span>
                        <!-- ACTIVE UNDERLINE INDICATOR: Visible when on the FAQ route -->
                        <span class="absolute -bottom-1 left-0 right-0 h-0.5 bg-blue-600 transition-transform duration-300 origin-left
                                     {{ request()->routeIs('FAQ') ? 'scale-x-100' : 'scale-x-0 group-hover:scale-x-100' }}"
                              aria-hidden="true"></span>
                    </a>
                </li>

            </ul>
            <!-- END DESKTOP NAV LINKS -->

            <!-- DESKTOP ACTION BUTTONS: Log In and Get Started CTA, visible on large screens only -->
            <div class="hidden lg:flex items-center space-x-4">

                <!-- LOG IN BUTTON: Opens the login modal dialog -->
                <button
                    type="button"
                    onclick="document.getElementById('login-modal').classList.remove('hidden')"
                    aria-haspopup="dialog"
                    aria-controls="login-modal"
                    class="w-32 h-10 flex items-center justify-center text-slate-700 font-semibold border-2 border-slate-200 hover:border-blue-300 hover:text-blue-700 hover:bg-blue-50 
                    rounded-3xl transition-all duration-300 hover:shadow-xl transform hover:-translate-y-0.5 cursor-pointer">
                    Log In
                </button>

                <!-- GET STARTED CTA BUTTON: Primary call-to-action linking to registration -->
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
            <!-- END DESKTOP ACTION BUTTONS -->

            <!-- MOBILE HAMBURGER BUTTON: Toggles the mobile menu, visible on small screens only -->
            <button
                id="mobile-menu-btn"
                class="lg:hidden p-2 rounded-xl text-slate-700 hover:bg-blue-50 hover:text-blue-700 transition-all duration-300 cursor-pointer"
                aria-label="Toggle mobile menu"
                aria-expanded="false"
                aria-controls="mobile-menu">

                <!-- HAMBURGER ICON: Shown when the mobile menu is closed -->
                <svg id="hamburger-icon" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>

                <!-- CLOSE ICON: Shown when the mobile menu is open -->
                <svg id="close-icon" class="w-6 h-6 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>

            </button>
            <!-- END MOBILE HAMBURGER BUTTON -->

        </div>
        <!-- END NAV INNER ROW -->

        <!-- MOBILE MENU: Vertical nav links and action buttons shown when hamburger is toggled -->
        <div id="mobile-menu" class="hidden lg:hidden pb-4">

            <!-- MOBILE NAV LINKS -->
            <ul class="flex flex-col space-y-1 mb-4" role="list">
                <li><a href="{{ route('home') }}"      class="block px-4 py-2.5 text-slate-700 font-medium rounded-xl hover:bg-blue-50 hover:text-blue-700 transition-all duration-300">Home</a></li>
                <li><a href="{{ route('services') }}"  class="block px-4 py-2.5 text-slate-700 font-medium rounded-xl hover:bg-blue-50 hover:text-blue-700 transition-all duration-300">Services</a></li>
                <li><a href="{{ route('resources') }}" class="block px-4 py-2.5 text-slate-700 font-medium rounded-xl hover:bg-blue-50 hover:text-blue-700 transition-all duration-300">Resources</a></li>
                <li><a href="{{ route('FAQ') }}"       class="block px-4 py-2.5 text-slate-700 font-medium rounded-xl hover:bg-blue-50 hover:text-blue-700 transition-all duration-300">FAQ</a></li>
            </ul>
            <!-- END MOBILE NAV LINKS -->

            <!-- MOBILE ACTION BUTTONS: Log In and Get Started stacked vertically -->
            <div class="flex flex-col space-y-2 px-2">

                <!-- MOBILE LOG IN BUTTON: Opens the login modal dialog -->
                <button
                    type="button"
                    onclick="document.getElementById('login-modal').classList.remove('hidden')"
                    aria-haspopup="dialog"
                    aria-controls="login-modal"
                    class="w-full text-center py-2.5 text-slate-700 font-semibold border-2 border-slate-200 hover:border-blue-300 hover:text-blue-700 hover:bg-blue-50 rounded-3xl transition-all duration-300 cursor-pointer">
                    Log In
                </button>

                <!-- MOBILE GET STARTED CTA BUTTON -->
                <button
                        type="button"
                        onclick="document.getElementById('register-modal').classList.remove('hidden')"
                        aria-haspopup="dialog"
                        aria-controls="register-modal"
                        class="w-full text-center py-2.5 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white rounded-3xl font-semibold shadow-lg transition-all duration-300 cursor-pointer">
                        Get Started
                </button>

            </div>
            <!-- END MOBILE ACTION BUTTONS -->

        </div>
        <!-- END MOBILE MENU -->

    </nav>
    <!-- END MAIN NAV -->

</header>
<!-- END SITE HEADER -->


<!-- MAIN PAGE CONTENT -->
<main>

    <!-- RESOURCE LIBRARY HEADER SECTION: Page title, description, search bar, and category cards -->
    <section class="bg-white pt-6 pb-0" aria-labelledby="library-heading">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- TITLE ROW: Page heading and description on the left, search bar on the right -->
            <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4 mb-8">

                <!-- PAGE HEADING AND DESCRIPTION -->
                <div>
                    <h1 id="library-heading" class="text-4xl lg:text-5xl font-bold text-slate-900 mb-2">Resource Library</h1>
                    <p class="text-slate-500 text-sm leading-relaxed max-w-sm">
                        A curated collection of tools, guides, and sanctuary spaces designed to support your mental well-being and academic journey.
                    </p>
                </div>

                <!-- SEARCH BAR: Triggers a resource search -->
                
                

            </div>
            <!-- END TITLE ROW -->

            <!-- CATEGORY CARDS GRID: Four topic categories displayed in a responsive grid -->
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 pb-8" role="list" aria-label="Resource categories">

                <!-- CATEGORY CARD: Wellness -->
                <article class="flex flex-col gap-3 p-5 rounded-2xl border border-blue-100 bg-blue-50 hover:border-blue-200 hover:bg-blue-100 transition-all"
                         role="listitem">
                    <!-- WELLNESS ICON -->
                    <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"/>
                    </svg>
                    <!-- CATEGORY LABEL AND SUBTITLE -->
                    <div>
                        <p class="text-sm font-bold text-slate-700">Wellness</p>
                        <p class="text-xs text-slate-400 mt-0.5">Mind, body, and spirit</p>
                    </div>
                </article>
                <!-- END CATEGORY CARD: Wellness -->

                <!-- CATEGORY CARD: Academics -->
                <article class="flex flex-col gap-3 p-5 rounded-2xl border border-teal-100 bg-teal-50 hover:border-teal-200 hover:bg-teal-100 transition-all"
                         role="listitem">
                    <!-- ACADEMICS ICON -->
                    <svg class="w-5 h-5 text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.57 50.57 0 00-2.658-.813A59.905 59.905 0 0112 3.493a59.902 59.902 0 0110.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.697 50.697 0 0112 13.489a50.702 50.702 0 017.74-3.342M6.75 15a.75.75 0 100-1.5.75.75 0 000 1.5zm0 0v-3.675A55.378 55.378 0 0112 8.443m-7.007 11.55A5.981 5.981 0 006.75 15.75v-1.5"/>
                    </svg>
                    <!-- CATEGORY LABEL AND SUBTITLE -->
                    <div>
                        <p class="text-sm font-bold text-slate-700">Academics</p>
                        <p class="text-xs text-slate-400 mt-0.5">Learning with focus</p>
                    </div>
                </article>
                <!-- END CATEGORY CARD: Academics -->

                <!-- CATEGORY CARD: Relationships -->
                <article class="flex flex-col gap-3 p-5 rounded-2xl border border-slate-200 bg-slate-100 hover:border-slate-300 hover:bg-slate-200 transition-all"
                         role="listitem">
                    <!-- RELATIONSHIPS ICON -->
                    <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"/>
                    </svg>
                    <!-- CATEGORY LABEL AND SUBTITLE -->
                    <div>
                        <p class="text-sm font-bold text-slate-700">Relationships</p>
                        <p class="text-xs text-slate-400 mt-0.5">Connecting with others</p>
                    </div>
                </article>
                <!-- END CATEGORY CARD: Relationships -->

                <!-- CATEGORY CARD: Self-Care -->
                <article class="flex flex-col gap-3 p-5 rounded-2xl border border-indigo-100 bg-indigo-50 hover:border-indigo-200 hover:bg-indigo-100 transition-all"
                         role="listitem">
                    <!-- SELF-CARE ICON -->
                    <svg class="w-5 h-5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.182 15.182a4.5 4.5 0 01-6.364 0M21 12a9 9 0 11-18 0 9 9 0 0118 0zM9.75 9.75c0 .414-.168.75-.375.75S9 10.164 9 9.75 9.168 9 9.375 9s.375.336.375.75zm-.375 0h.008v.015h-.008V9.75zm5.625 0c0 .414-.168.75-.375.75s-.375-.336-.375-.75.168-.75.375-.75.375.336.375.75zm-.375 0h.008v.015h-.008V9.75z"/>
                    </svg>
                    <!-- CATEGORY LABEL AND SUBTITLE -->
                    <div>
                        <p class="text-sm font-bold text-slate-700">Self-Care</p>
                        <p class="text-xs text-slate-400 mt-0.5">Personal rituals</p>
                    </div>
                </article>
                <!-- END CATEGORY CARD: Self-Care -->

            </div>
            <!-- END CATEGORY CARDS GRID -->

        </div>
    </section>
    <!-- END RESOURCE LIBRARY HEADER SECTION -->


    <!-- FEATURED RESOURCES SECTION: Bento grid of highlighted resource cards -->
    <section class="bg-white pb-16 lg:pb-24" aria-labelledby="featured-heading">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- SECTION TITLE ROW: Heading on the left, "View all" link on the right -->
            <div class="flex items-center justify-between mb-6">
                <h2 id="featured-heading" class="text-xl font-bold text-slate-900">Featured Resources</h2>
                <!-- VIEW ALL LINK: Navigates to the full resource listing -->
                <a href="https://www.thementalhealthcoalition.org/resources/" target="_blank" class="inline-flex items-center gap-1 text-sm font-semibold text-blue-600 hover:gap-2 transition-all duration-200">
                    View all
                    <!-- ARROW ICON -->
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>
            <!-- END SECTION TITLE ROW -->

            <!-- BENTO GRID: Large card on the left, two stacked cards on the right -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">

                <!-- LARGE RESOURCE CARD: Mental Health Guide -->
                <article class="bg-slate-50 border border-slate-200 rounded-3xl overflow-hidden flex flex-col hover:shadow-xl hover:border-blue-200 transition-all duration-300 hover:-translate-y-1 group">

                    <!-- CARD THUMBNAIL IMAGE -->
                    <div class="h-64 lg:h-72 overflow-hidden">
                        <img
                            src="{{ asset('images/mental.jpg') }}"
                            alt="Mental Health Guide"
                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                            loading="lazy"
                        />
                    </div>

                    <!-- CARD BODY: Tags, title, description, and CTA -->
                    <div class="p-7 flex flex-col gap-3 flex-1">

                        <!-- CARD META: Category badge and read time -->
                        <div class="flex items-center gap-3">
                            <span class="bg-blue-100 text-blue-600 text-xs font-bold px-3 py-1 rounded-full tracking-widest uppercase">Guide</span>
                            <span class="text-slate-400 text-xs">12 min read</span>
                        </div>

                        <!-- CARD TITLE -->
                        <h3 class="text-2xl font-bold text-slate-900">Mental Health Guide</h3>

                        <!-- CARD DESCRIPTION -->
                        <p class="text-slate-500 text-sm leading-relaxed">
                            A comprehensive roadmap to understanding emotional health and navigating the resources available to students in high-stress environments.
                        </p>

                        <!-- START READING CTA BUTTON -->
                        <a href="#"
                           class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-5 py-2.5 rounded-full transition-all w-fit mt-auto">
                            Start Reading
                            <!-- ARROW ICON -->
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                            </svg>
                        </a>

                    </div>
                    <!-- END CARD BODY -->

                </article>
                <!-- END LARGE RESOURCE CARD: Mental Health Guide -->

                <!-- RIGHT COLUMN: Two stacked smaller resource cards -->
                <div class="flex flex-col gap-5">

                    <!-- SMALL RESOURCE CARD: Exam Anxiety Toolkit -->
                    <article class="bg-slate-50 border border-slate-200 rounded-3xl overflow-hidden flex flex-col hover:shadow-xl hover:border-blue-200 transition-all duration-300 hover:-translate-y-1 group">

                        <!-- CARD THUMBNAIL IMAGE -->
                        <div class="h-44 overflow-hidden">
                            <img
                                src="{{ asset('images/anxiety.jpg') }}"
                                alt="Exam Anxiety Toolkit"
                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                                loading="lazy"
                            />
                        </div>

                        <!-- CARD BODY: Badge, title, description, and link -->
                        <div class="p-6 flex flex-col gap-2">
                            <!-- CATEGORY BADGE -->
                            <span class="bg-amber-100 text-amber-600 text-xs font-bold px-3 py-1 rounded-full tracking-widest uppercase w-fit">Toolkit</span>
                            <!-- CARD TITLE -->
                            <h3 class="text-base font-bold text-slate-900">Exam Anxiety Toolkit</h3>
                            <!-- CARD DESCRIPTION -->
                            <p class="text-slate-500 text-sm leading-relaxed">Proven strategies to stay calm and focused during finals week.</p>
                            <!-- EXPLORE TOOLKIT LINK -->
                            <a href="#" class="inline-flex items-center gap-1 text-blue-600 text-sm font-semibold hover:gap-2 transition-all w-fit">
                                Explore Toolkit
                                <!-- ARROW ICON -->
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                </svg>
                            </a>
                        </div>
                        <!-- END CARD BODY -->

                    </article>
                    <!-- END SMALL RESOURCE CARD: Exam Anxiety Toolkit -->

                    <!-- SMALL RESOURCE CARD: Guided Meditation -->
                    <article class="bg-slate-50 border border-slate-200 rounded-3xl overflow-hidden flex flex-col hover:shadow-xl hover:border-blue-200 transition-all duration-300 hover:-translate-y-1 group">

                        <!-- CARD THUMBNAIL IMAGE -->
                        <div class="h-44 overflow-hidden">
                            <img
                                src="{{ asset('images/guided.jpg') }}"
                                alt="Guided Meditation"
                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                                loading="lazy"
                            />
                        </div>

                        <!-- CARD BODY: Badge, title, description, and link -->
                        <div class="p-6 flex flex-col gap-2">
                            <!-- CATEGORY BADGE -->
                            <span class="bg-purple-100 text-purple-600 text-xs font-bold px-3 py-1 rounded-full tracking-widest uppercase w-fit">Audio</span>
                            <!-- CARD TITLE -->
                            <h3 class="text-base font-bold text-slate-900">Guided Meditation</h3>
                            <!-- CARD DESCRIPTION -->
                            <p class="text-slate-500 text-sm leading-relaxed">A 10-minute session to reset your nervous system and find clarity.</p>
                            <!-- LISTEN NOW LINK -->
                            <a href="#" class="inline-flex items-center gap-1 text-blue-600 text-sm font-semibold hover:gap-2 transition-all w-fit">
                                Listen Now
                                <!-- ARROW ICON -->
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                </svg>
                            </a>
                        </div>
                        <!-- END CARD BODY -->

                    </article>
                    <!-- END SMALL RESOURCE CARD: Guided Meditation -->

                </div>
                <!-- END RIGHT COLUMN -->

            </div>
            <!-- END BENTO GRID -->

        </div>
    </section>
    <!-- END FEATURED RESOURCES SECTION -->


    <!-- NEWSLETTER SECTION: Weekly wellness tips email subscription -->
    <section class="bg-slate-100 py-10 px-4" aria-labelledby="newsletter-heading">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- NEWSLETTER CARD: Dark panel with icon, heading, form, and disclaimer -->
            <div class="bg-slate-800 rounded-3xl px-8 py-14 flex flex-col items-center text-center gap-5">

                <!-- NEWSLETTER ICON: Envelope decoration -->
                <div class="w-14 h-14 bg-slate-700 rounded-2xl flex items-center justify-center" aria-hidden="true">
                    <svg class="w-7 h-7 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/>
                    </svg>
                </div>

                <!-- NEWSLETTER HEADING AND DESCRIPTION -->
                <div>
                    <h2 id="newsletter-heading" class="text-2xl lg:text-3xl font-bold text-white mb-2">Weekly Wellness Tips</h2>
                    <p class="text-slate-400 text-sm leading-relaxed max-w-sm mx-auto">
                        Join 5,000+ students receiving bite-sized mental health advice and early access to workshops every Monday morning.
                    </p>
                </div>

                <!-- NEWSLETTER SUBSCRIPTION FORM: Email input and subscribe button -->
                <div class="flex flex-col sm:flex-row items-center gap-3 w-full max-w-md">

                    <!-- EMAIL INPUT FIELD -->
                    <label for="newsletter-email" class="sr-only">Email address</label>
                    <input
                        type="email"
                        id="newsletter-email"
                        name="email"
                        placeholder="student@university.edu"
                        class="w-full sm:flex-1 bg-slate-700 border border-slate-600 text-white placeholder-slate-400 text-sm rounded-full px-5 py-3 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-all"
                    />

                    <!-- SUBSCRIBE SUBMIT BUTTON -->
                    <button
                        type="submit"
                        class="w-full sm:w-auto bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-6 py-3 rounded-full transition-all flex-shrink-0">
                        Subscribe
                    </button>

                </div>
                <!-- END NEWSLETTER SUBSCRIPTION FORM -->

                <!-- NO SPAM DISCLAIMER -->
                <p class="text-slate-500 text-xs">No spam, just care. Unsubscribe anytime.</p>

            </div>
            <!-- END NEWSLETTER CARD -->

        </div>
    </section>
    <!-- END NEWSLETTER SECTION -->

</main>
<!-- END MAIN PAGE CONTENT -->


<!-- SITE FOOTER: Brand info, navigation columns, and copyright notice -->
<footer class="bg-white border-t border-slate-200/70 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- FOOTER GRID: Four-column layout (brand spans two, plus two link groups) -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-10">

            <!-- FOOTER BRAND COLUMN: Logo, tagline, and social links -->
            <div class="md:col-span-2 space-y-4">

                <!-- FOOTER LOGO -->
                <a href="#" class="inline-block text-xl font-bold text-blue-600" aria-label="CounselConnect home">
                    CounselConnect
                </a>

                <!-- FOOTER TAGLINE -->
                <p class="text-slate-500 text-sm leading-relaxed max-w-xs">
                    A safe, professional sanctuary designed to support student mental health and well-being every step of the way.
                </p>

                <!-- SOCIAL LINKS: Instagram and X (Twitter) -->
                <div class="flex items-center gap-4">

                    <!-- INSTAGRAM LINK -->
                    <a href="#" class="text-slate-400 hover:text-blue-600 transition-colors duration-200" aria-label="Follow us on Instagram">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M12 2.163c3.204 0 3.584.012 4.85.07 1.366.062 2.633.334 3.608 1.31.975.975 1.247 2.242 1.31 3.608.058 1.266.07 1.646.07 4.849s-.012 3.584-.07 4.85c-.062 1.366-.334 2.633-1.31 3.608-.975.975-2.242 1.247-3.608 1.31-1.266.058-1.646.07-4.85.07s-3.584-.012-4.85-.07c-1.366-.062-2.633-.334-3.608-1.31-.975-.975-1.247-2.242-1.31-3.608C2.175 15.584 2.163 15.204 2.163 12s.012-3.584.07-4.85c.062-1.366.334-2.633 1.31-3.608.975-.975 2.242-1.247 3.608-1.31C8.416 2.175 8.796 2.163 12 2.163zm0-2.163C8.741 0 8.332.014 7.052.072 5.197.157 3.355.673 2.014 2.014.673 3.355.157 5.197.072 7.052.014 8.332 0 8.741 0 12c0 3.259.014 3.668.072 4.948.085 1.855.601 3.697 1.942 5.038 1.341 1.341 3.183 1.857 5.038 1.942C8.332 23.986 8.741 24 12 24s3.668-.014 4.948-.072c1.855-.085 3.697-.601 5.038-1.942 1.341-1.341 1.857-3.183 1.942-5.038C23.986 15.668 24 15.259 24 12c0-3.259-.014-3.668-.072-4.948-.085-1.855-.601-3.697-1.942-5.038C20.645.673 18.803.157 16.948.072 15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zm0 10.162a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/>
                        </svg>
                    </a>

                    <!-- X (TWITTER) LINK -->
                    <a href="#" class="text-slate-400 hover:text-blue-600 transition-colors duration-200" aria-label="Follow us on X">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-4.714-6.231-5.401 6.231H2.748l7.73-8.835L1.254 2.25H8.08l4.253 5.622L18.244 2.25zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
                        </svg>
                    </a>

                </div>
                <!-- END SOCIAL LINKS -->

            </div>
            <!-- END FOOTER BRAND COLUMN -->

            <!-- FOOTER NAV COLUMN: Company links -->
            <nav aria-label="Company links">
                <h2 class="text-xs font-bold tracking-widest text-slate-400 uppercase mb-3">Company</h2>
                <ul class="space-y-2" role="list">
                    <li><a href="#" class="text-sm text-slate-600 hover:text-blue-600 transition-colors duration-200">About Us</a></li>
                    <li><a href="#" class="text-sm text-slate-600 hover:text-blue-600 transition-colors duration-200">Services</a></li>
                    <li><a href="#" class="text-sm text-slate-600 hover:text-blue-600 transition-colors duration-200">Resources</a></li>
                    <li><a href="#" class="text-sm text-slate-600 hover:text-blue-600 transition-colors duration-200">FAQ</a></li>
                </ul>
            </nav>
            <!-- END FOOTER NAV COLUMN: Company links -->

            <!-- FOOTER NAV COLUMN: Support and legal links -->
            <nav aria-label="Support links">
                <h2 class="text-xs font-bold tracking-widest text-slate-400 uppercase mb-3">Support</h2>
                <ul class="space-y-2" role="list">
                    <li><a href="#" class="text-sm text-slate-600 hover:text-blue-600 transition-colors duration-200">Privacy Policy</a></li>
                    <li><a href="#" class="text-sm text-slate-600 hover:text-blue-600 transition-colors duration-200">Terms of Service</a></li>
                    <li><a href="#" class="text-sm text-slate-600 hover:text-blue-600 transition-colors duration-200">Contact Us</a></li>
                </ul>
            </nav>
            <!-- END FOOTER NAV COLUMN: Support links -->

        </div>
        <!-- END FOOTER GRID -->

        <!-- FOOTER COPYRIGHT NOTICE -->
        <p class="mt-10 pt-6 border-t border-slate-100 text-center text-xs text-slate-400">
            &copy; {{ date('Y') }} CounselConnect. All rights reserved.
        </p>
        <!-- END FOOTER COPYRIGHT NOTICE -->

    </div>
</footer>
<!-- END SITE FOOTER -->


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
                class="sticky top-4 ml-auto mr-4 mt-4 w-8 h-8 flex items-center justify-center rounded-full bg-slate-100 hover:bg-slate-200 text-slate-500 hover:text-slate-800 transition-all cursor-pointer z-10 flex-shrink-0">
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
                                    class="w-full px-4 py-2.5 text-sm text-slate-900 bg-white border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all appearance-none cursor-pointer">
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
                                    class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 transition-colors cursor-pointer">
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
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 transition-colors cursor-pointer">
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
                            class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2.5 rounded-xl shadow-sm hover:shadow-md transition-all text-sm cursor-pointer">
                            Create Account
                        </button>

                        <div class="relative flex items-center gap-3" role="separator" aria-hidden="true">
                            <div class="flex-1 border-t border-slate-200"></div>
                            <span class="text-xs text-slate-400">or</span>
                            <div class="flex-1 border-t border-slate-200"></div>
                        </div>

                        <button type="button"
                            onclick="document.getElementById('register-modal').classList.add('hidden'); document.getElementById('login-modal').classList.remove('hidden')"
                            class="w-full flex items-center justify-center border border-slate-200 hover:border-blue-300 hover:bg-blue-50 text-slate-700 hover:text-blue-700 font-semibold py-2.5 rounded-xl transition-all text-sm cursor-pointer">
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
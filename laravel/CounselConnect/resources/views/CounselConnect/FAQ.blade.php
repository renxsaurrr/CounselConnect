<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FAQ — CounselConnect</title>
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
                        <!-- Active underline indicator: visible when on the Home route -->
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
                        <!-- Active underline indicator: visible when on the Services route -->
                        <span class="absolute -bottom-1 left-0 right-0 h-0.5 bg-blue-600 transition-transform duration-300 origin-left
                                     {{ request()->routeIs('services') ? 'scale-x-100' : 'scale-x-0 group-hover:scale-x-100' }}"
                              aria-hidden="true"></span>
                    </a>
                </li>

                <!-- NAV ITEM: Resources link with active state underline indicator -->
                <li>
                    <a href="{{ route('resources') }}"
                       class="px-3 py-2 font-medium rounded-xl hover:bg-blue-50 hover:text-blue-700 transition-all duration-300 group relative
                              {{ request()->routeIs('resources') ? 'text-blue-700' : 'text-slate-700' }}">
                        <span>Resources</span>
                        <!-- Active underline indicator: visible when on the Resources route -->
                        <span class="absolute -bottom-1 left-0 right-0 h-0.5 bg-blue-600 transition-transform duration-300 origin-left
                                     {{ request()->routeIs('resources') ? 'scale-x-100' : 'scale-x-0 group-hover:scale-x-100' }}"
                              aria-hidden="true"></span>
                    </a>
                </li>

                <!-- NAV ITEM: FAQ link with active state underline indicator -->
                <li>
                    <a href="{{ route('FAQ') }}"
                       class="px-3 py-2 font-medium rounded-xl hover:bg-blue-50 hover:text-blue-700 transition-all duration-300 group relative
                              {{ request()->routeIs('FAQ') ? 'text-blue-700' : 'text-slate-700' }}"
                       aria-current="{{ request()->routeIs('FAQ') ? 'page' : false }}">
                        <span>FAQ</span>
                        <!-- Active underline indicator: visible when on the FAQ route -->
                        <span class="absolute -bottom-1 left-0 right-0 h-0.5 bg-blue-600 transition-transform duration-300 origin-left
                                     {{ request()->routeIs('FAQ') ? 'scale-x-100' : 'scale-x-0 group-hover:scale-x-100' }}"
                              aria-hidden="true"></span>
                    </a>
                </li>

            </ul>
            <!-- END DESKTOP NAV LINKS -->

            <!-- DESKTOP ACTION BUTTONS: Log In button and Get Started CTA, visible on large screens only -->
            <div class="hidden lg:flex items-center space-x-4">

                <!-- LOG IN BUTTON: Opens the login modal dialog -->
                <button
                    type="button"
                    onclick="document.getElementById('login-modal').classList.remove('hidden')"
                    aria-haspopup="dialog"
                    aria-controls="login-modal"
                    class="w-32 h-10 flex items-center justify-center text-slate-700 font-semibold border-2 border-slate-200 hover:border-blue-300
                     hover:text-blue-700 hover:bg-blue-50 rounded-3xl transition-all duration-300 hover:shadow-xl transform hover:-translate-y-0.5 cursor-pointer">
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

                <!-- MOBILE LOG IN BUTTON -->
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

    <!-- FAQ SECTION: Accordion list of frequently asked questions with a support CTA card -->
    <section class="bg-white pt-6 pb-16 lg:pt-8 lg:pb-24" aria-labelledby="faq-heading">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- FAQ SECTION HEADER: Label, main heading -->
            <header class="mb-10">
                <span class="inline-block text-xs font-semibold tracking-widest text-blue-500 uppercase mb-3">Support</span>
                <h1 id="faq-heading" class="text-3xl lg:text-4xl font-bold text-slate-900 mb-3 leading-tight">
                    Frequently Asked<br>Questions
                </h1>
            </header>

            <!-- FAQ ACCORDION LIST: Each item toggles open/closed on click -->
            <div class="space-y-2" role="list">

                <!-- FAQ ITEM 1: Data privacy question -->
                <div class="faq-item bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden" role="listitem">
                    <button
                        class="faq-btn w-full flex justify-between items-center px-6 py-5 text-left group"
                        aria-expanded="false">
                        <span class="font-medium text-slate-800 text-sm group-hover:text-blue-600 transition-colors duration-200">
                            Is my data really private?
                        </span>
                        <!-- ACCORDION TOGGLE ICON: Arrow rotates when item is open -->
                        <span class="faq-icon w-7 h-7 rounded-full bg-slate-100 flex items-center justify-center flex-shrink-0 ml-4 transition-all duration-300" aria-hidden="true">
                            <svg class="faq-arrow w-3.5 h-3.5 text-slate-500 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </span>
                    </button>
                    <!-- FAQ ANSWER BODY: Hidden by default, revealed when button is toggled -->
                    <div class="faq-body hidden px-6 pb-5">
                        <div class="border-t border-slate-100 pt-4">
                            <p class="text-slate-500 text-sm leading-relaxed">
                                Yes. Our platform is fully HIPAA compliant. All conversations and records remain strictly confidential between you and your counselor, and are never sold or shared with third parties.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- FAQ ITEM 2: Pricing question -->
                <div class="faq-item bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden" role="listitem">
                    <button
                        class="faq-btn w-full flex justify-between items-center px-6 py-5 text-left group"
                        aria-expanded="false">
                        <span class="font-medium text-slate-800 text-sm group-hover:text-blue-600 transition-colors duration-200">
                            How much does it cost?
                        </span>
                        <!-- ACCORDION TOGGLE ICON -->
                        <span class="faq-icon w-7 h-7 rounded-full bg-slate-100 flex items-center justify-center flex-shrink-0 ml-4 transition-all duration-300" aria-hidden="true">
                            <svg class="faq-arrow w-3.5 h-3.5 text-slate-500 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </span>
                    </button>
                    <!-- FAQ ANSWER BODY -->
                    <div class="faq-body hidden px-6 pb-5">
                        <div class="border-t border-slate-100 pt-4">
                            <p class="text-slate-500 text-sm leading-relaxed">
                                Creating an account and browsing the resource library is completely free. Session pricing depends on your institution's partnership plan — many students get subsidized or fully covered sessions through their school.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- FAQ ITEM 3: Counselor selection question -->
                <div class="faq-item bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden" role="listitem">
                    <button
                        class="faq-btn w-full flex justify-between items-center px-6 py-5 text-left group"
                        aria-expanded="false">
                        <span class="font-medium text-slate-800 text-sm group-hover:text-blue-600 transition-colors duration-200">
                            Can I choose my counselor?
                        </span>
                        <!-- ACCORDION TOGGLE ICON -->
                        <span class="faq-icon w-7 h-7 rounded-full bg-slate-100 flex items-center justify-center flex-shrink-0 ml-4 transition-all duration-300" aria-hidden="true">
                            <svg class="faq-arrow w-3.5 h-3.5 text-slate-500 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </span>
                    </button>
                    <!-- FAQ ANSWER BODY -->
                    <div class="faq-body hidden px-6 pb-5">
                        <div class="border-t border-slate-100 pt-4">
                            <p class="text-slate-500 text-sm leading-relaxed">
                                Absolutely. After your initial assessment, we provide a list of matched professionals. You can review their profiles, specialties, and approach styles before booking. If you ever feel your counselor isn't the right fit, you can request a switch at any time — no questions asked.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- FAQ ITEM 4: First session experience question -->
                <div class="faq-item bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden" role="listitem">
                    <button
                        class="faq-btn w-full flex justify-between items-center px-6 py-5 text-left group"
                        aria-expanded="false">
                        <span class="font-medium text-slate-800 text-sm group-hover:text-blue-600 transition-colors duration-200">
                            What happens in a first session?
                        </span>
                        <!-- ACCORDION TOGGLE ICON -->
                        <span class="faq-icon w-7 h-7 rounded-full bg-slate-100 flex items-center justify-center flex-shrink-0 ml-4 transition-all duration-300" aria-hidden="true">
                            <svg class="faq-arrow w-3.5 h-3.5 text-slate-500 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </span>
                    </button>
                    <!-- FAQ ANSWER BODY -->
                    <div class="faq-body hidden px-6 pb-5">
                        <div class="border-t border-slate-100 pt-4">
                            <p class="text-slate-500 text-sm leading-relaxed">
                                Your first session is a relaxed introduction. Your counselor will take time to understand your background, current challenges, and goals. There's no pressure — it's simply a conversation to help you both determine the best path forward.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- FAQ ITEM 5: Cancellation policy question -->
                <div class="faq-item bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden" role="listitem">
                    <button
                        class="faq-btn w-full flex justify-between items-center px-6 py-5 text-left group"
                        aria-expanded="false">
                        <span class="font-medium text-slate-800 text-sm group-hover:text-blue-600 transition-colors duration-200">
                            How do I cancel an appointment?
                        </span>
                        <!-- ACCORDION TOGGLE ICON -->
                        <span class="faq-icon w-7 h-7 rounded-full bg-slate-100 flex items-center justify-center flex-shrink-0 ml-4 transition-all duration-300" aria-hidden="true">
                            <svg class="faq-arrow w-3.5 h-3.5 text-slate-500 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </span>
                    </button>
                    <!-- FAQ ANSWER BODY -->
                    <div class="faq-body hidden px-6 pb-5">
                        <div class="border-t border-slate-100 pt-4">
                            <p class="text-slate-500 text-sm leading-relaxed">
                                You can cancel or reschedule any session up to 24 hours in advance through your student dashboard at no charge. We know student schedules change fast.
                            </p>
                        </div>
                    </div>
                </div>

            </div>
            <!-- END FAQ ACCORDION LIST -->

            <!-- SUPPORT CTA CARD: Encourages users with unanswered questions to contact support -->
            <aside class="mt-8 bg-white border border-slate-100 shadow-sm rounded-2xl px-10 py-12 flex flex-col items-center text-center gap-4"
                   aria-label="Contact support prompt">

                <!-- CTA ICON: Decorative speech bubble icon -->
                <div class="w-14 h-14 bg-blue-50 rounded-2xl flex items-center justify-center" aria-hidden="true">
                    <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 8.511c.884.284 1.5 1.128 1.5 2.097v4.286c0 1.136-.847 2.1-1.98 2.193-.34.027-.68.052-1.02.072v3.091l-3-3c-1.354 0-2.694-.055-4.02-.163a2.115 2.115 0 01-.825-.242m9.345-8.334a2.126 2.126 0 00-.476-.095 48.64 48.64 0 00-8.048 0c-1.131.094-1.976 1.057-1.976 2.192v4.286c0 .837.46 1.58 1.155 1.951m9.345-8.334V6.637c0-1.621-1.152-3.026-2.76-3.235A48.455 48.455 0 0011.25 3c-2.115 0-4.198.137-6.24.402-1.608.209-2.76 1.614-2.76 3.235v6.226c0 1.621 1.152 3.026 2.76 3.235.577.075 1.157.14 1.74.194V21l4.155-4.155"/>
                    </svg>
                </div>

                <!-- CTA TEXT: Heading and supporting description -->
                <div>
                    <h2 class="text-lg font-bold text-slate-900 mb-2">Still have questions?</h2>
                    <p class="text-slate-400 text-sm leading-relaxed max-w-xs mx-auto">
                        Can't find what you're looking for? Chat with our friendly support team.
                    </p>
                </div>

                <!-- CONTACT SUPPORT BUTTON: Primary CTA linking to the support contact page -->
                <a href="#"
                   class="w-full max-w-sm flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-6 py-3 rounded-full transition-all duration-200 shadow-sm mt-1">
                    Contact Support
                    <!-- ARROW ICON: Decorative directional indicator -->
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                    </svg>
                </a>

            </aside>
            <!-- END SUPPORT CTA CARD -->

        </div>
    </section>
    <!-- END FAQ SECTION -->

</main>
<!-- END MAIN PAGE CONTENT -->


<!-- SITE FOOTER: Brand info, navigation columns, and copyright notice -->
<footer class="bg-white border-t border-slate-200/70 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- FOOTER GRID: Four-column layout (brand + two link groups) -->
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
    <!-- End login modal dialog -->


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
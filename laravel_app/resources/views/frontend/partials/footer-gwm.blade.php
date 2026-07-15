<footer class="gwm-footer gwm-bg-primary text-white pt-4">

    <!-- Top Footer with Hardcoded Columns -->
    <div class="gwm-footer-top py-3">
        <div class="container">
            <div class="row align-items-start">

                <!-- Column 1: About GWM -->
                <div class="col-lg-5 col-md-6 mb-4">
                    <div class="gwm-footer-widget">
                        <a href="{{url('/')}}" class="gwm-footer-logo mb-3 d-inline-block">
                            {!! render_image_markup_by_attachment_id(get_static_option('site_logo'), 'full') !!}
                        </a>
                        <p class="mb-0" style="font-size: 0.9rem; line-height: 1.6; color: #475569;">
                            GWM terus memperluas portofolio bisnis melalui berbagai proyek strategis yang mendukung
                            transformasi industri Indonesia menuju era digital dan energi berkelanjutan.
                        </p>
                    </div>
                </div>

                <!-- Column 2: Hubungi Kami (Shifted to right using offset) -->
                <div class="col-lg-6 offset-lg-1 col-md-6 mb-4">
                    <div class="gwm-footer-widget">
                        <h4 class="gwm-widget-title mb-4"
                            style="font-family: var(--font-heading); font-weight: 700; color: #1C2A4A; font-size: 1.25rem;">
                            Hubungi Kami</h4>
                        <ul class="list-unstyled gwm-footer-contact"
                            style="font-size: 0.9rem; color: #475569; line-height: 1.6;">
                            <li class="d-flex mb-3 align-items-start">
                                <i class="fas fa-map-marker-alt mt-1 mr-3"
                                    style="color: #0056B3; font-size: 1.1rem; width: 20px; text-align: center;"></i>
                                <span>Gedung Jaya, Lantai 9 Jl. M.H. Thamrin, Kebon Sirih, Kec. Menteng, Kota Jakarta
                                    Pusat, DKI Jakarta, 10340</span>
                            </li>
                            <li class="d-flex mb-3 align-items-start">
                                <i class="fas fa-phone-alt mt-1 mr-3"
                                    style="color: #0056B3; font-size: 1.1rem; width: 20px; text-align: center;"></i>
                                <span>089674972000</span>
                            </li>
                            <li class="d-flex mb-3 align-items-start">
                                <i class="fas fa-envelope mt-1 mr-3"
                                    style="color: #0056B3; font-size: 1.1rem; width: 20px; text-align: center;"></i>
                                <span>info@gitawahanamandiri.com</span>
                            </li>
                        </ul>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Copyright Bottom -->
    <div class="gwm-copyright-area py-3 border-top" style="border-color: #b0b0b0 !important;">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 col-md-6 text-center text-md-left">
                    <p class="mb-0" style="font-size: 0.875rem; color: #1C2A4A; font-weight: 500;">
                        {!! render_footer_copyright_text() !!}
                    </p>
                </div>
                <div class="col-lg-6 col-md-6 text-center text-md-right mt-3 mt-md-0">
                    <ul class="list-inline mb-0" style="font-size: 0.875rem;">
                        <li class="list-inline-item"><a
                                href="{{ route('frontend.dynamic.page', ['id' => 1, 'any' => 'terms']) }}"
                                style="color: #1C2A4A; font-weight: 600;">{{ __('Terms of Service') }}</a></li>
                        <li class="list-inline-item ml-3"><a
                                href="{{ route('frontend.dynamic.page', ['id' => 2, 'any' => 'privacy']) }}"
                                style="color: #1C2A4A; font-weight: 600;">{{ __('Privacy Policy') }}</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</footer>

<!-- Back to top button -->
<div class="gwm-back-to-top">
    <i class="fas fa-arrow-up"></i>
</div>

<style>
    /* Override existing widget styles inside footer */
    .gwm-footer {
        background-color: #cfd7e9 !important;
        color: #1C2A4A !important;
        border-top: 1px solid #a0b2e6;
    }

    .gwm-footer .gwm-copyright-area {
        border-top: 1px solid #a0b2e6 !important;
    }

    .gwm-footer p,
    .gwm-footer span,
    .gwm-footer li,
    .gwm-footer-logo img,
    .gwm-footer img {
        color: #1C2A4A !important;
    }

    /* Limit Logo sizing to keep it clean and proportioned */
    .gwm-footer-logo img,
    .gwm-footer img {
        max-width: 180px !important;
        height: auto !important;
    }

    /* Back to Top */
    .gwm-back-to-top {
        position: fixed;
        bottom: 30px;
        right: 30px;
        width: 45px;
        height: 45px;
        line-height: 45px;
        text-align: center;
        background-color: #0056B3;
        color: white;
        border-radius: var(--radius-sm);
        cursor: pointer;
        z-index: 999;
        opacity: 0;
        visibility: hidden;
        transition: all var(--transition-normal);
        box-shadow: var(--shadow-lg);
    }

    .gwm-back-to-top.show {
        opacity: 1;
        visibility: visible;
    }

    .gwm-back-to-top:hover {
        background-color: #1C2A4A;
        transform: translateY(-3px);
    }
</style>

<script>
    // Inline JS for Back to top
    document.addEventListener("DOMContentLoaded", function () {
        var backToTopBtn = document.querySelector('.gwm-back-to-top');
        if (backToTopBtn) {
            window.addEventListener('scroll', function () {
                if (window.scrollY > 300) {
                    backToTopBtn.classList.add('show');
                } else {
                    backToTopBtn.classList.remove('show');
                }
            });

            backToTopBtn.addEventListener('click', function () {
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            });
        }
    });
</script>
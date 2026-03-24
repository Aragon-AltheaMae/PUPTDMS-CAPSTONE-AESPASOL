<style>
    #siteFooter {
        background: var(--crimson);
        color: rgba(255, 255, 255, .8);
        padding: 1.25rem 2rem;
        margin-left: 256px;
    }

    .footer-inner {
        max-width: 1280px;
        margin: 0 auto;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 1.5rem;
        flex-wrap: wrap;
        font-size: .74rem;
    }

    .footer-inner a {
        color: rgba(255, 255, 255, .7);
        text-decoration: none;
        transition: color .15s;
    }

    .footer-inner a:hover {
        color: #fff;
    }

    .footer-dot {
        color: rgba(255, 255, 255, .3);
    }

    @media (max-width: 767px) {
        #siteFooter {
            margin-left: 0 !important;
        }
    }
</style>

<!-- FOOTER -->
<footer id="siteFooter">
    <div class="footer-inner">
        <span style="color:rgba(255,255,255,.5);">© 1998–2026</span>
        <span style="font-weight:700;color:#fff;">Polytechnic University of the Philippines</span>
        <span class="footer-dot">|</span>
        <a href="https://www.pup.edu.ph/terms/">Terms of Use</a>
        <span class="footer-dot">|</span>
        <a href="https://www.pup.edu.ph/privacy/">Privacy Statement</a>
    </div>
</footer>

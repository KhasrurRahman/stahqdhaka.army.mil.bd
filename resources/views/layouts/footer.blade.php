<style>
    .copyright-section {
        height: 80px;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        background-color: #3a8c49;
        color: #fff;
    }

    .important-link {
        text-align: left;
    }

    .contact-info a {
        text-decoration: none;
        color: white;

    }
    .contact-info p {
        padding-left: 15px;

    }
    .contact-info h3, .about h3 {
        padding: 10px;
        margin: 0;

    }
</style>
<footer id="contact-us" class="site-footer">
    <div class="footer-widgets section-padding">
        <div class="container">
            <div class="row widgets">
                <div class="col-lg-4 col-md-4 sigle-widget pb-2">
                    <div class="about text-center">
                        <h3>ABOUT</h3>

                        <p> {{ $header_footer->about }} </p>

                    </div>
                </div>
                <div class="important-link col-lg-4 col-md-4 sigle-widget pb-2">
                    <div class="contact-info">
                        <h3>IMPORTENT LINK</h3>
                        <p><a href="{{ route('footer.about_us') }}">About Us</a></p>
                        <p><a href="{{ route('footer.privacy_policy') }}">Privacy Policy</a></p>
                        <p><a href="{{ route('footer.terms_condition') }}">Terms &amp; Conditions</a></p>
                        <p><a href="{{ route('footer.return_refund') }}">Return &amp; Refund Policy</a></p>
                    </div>

                </div>
                <div class="col-lg-4 col-md-4 sigle-widget pb-2">
                    <div class="contact-info">
                        <h3>CONTACT INFORMATION</h3>
                        <p><span>Duty Clark </span><span>:</span> {{ $header_footer->duty_clark }} </p>
                        <p><span>Sticker Query </span><span>:</span> {{ $header_footer->sticker_query }} </p>
                        <p><span>Army Exch </span><span>:</span> {{ $header_footer->army_exch }} </p>
                        <p><span>FAX </span><span>:</span> {{ $header_footer->fax }} </p>
                        <p><span>Duty Clerk Mil </span><span>:</span> {{ $header_footer->duty_clerk_mil }} </p>

                    </div>

                </div>
                <!-- <div class="col-lg-4 col-md-4 sigle-widget">
                    <div class="copyright">
                        <h3>&nbsp;</h3>
                        <p>{{ $header_footer->copyright }} <br>
                            Unique Visits: {{ $header_footer->unique_visitor }}</p>
                    </div>
                </div> -->
            </div>
        </div>
    </div>
    <div class="copyright-section">
        <div class="copyright ">
            {{ $header_footer->copyright }} <br>
            Unique Visits: {{ $header_footer->unique_visitor }}
        </div>
    </div>
    <div class="powered-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="developer-info text-center" style="font-size:22px;font-weight:bold;">
                        Powered by <a href="https://www.itdte.net/" target="_blank">
                            <span style="font-size:22px;font-weight:bold;color:#fff">IT Dte, GS Br, AHQ</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>

<a class="scrolltotop" href="#page">
    <i class="fa fa-angle-double-up"></i>
</a>
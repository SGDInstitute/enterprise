<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col-md-3 col-sm-4">
                <a href="https://sgdinstitute.org/"><img src="{{ asset('images/sgdinstitute-logo-white.png') }}" alt="Logo White" class="img-responsive"></a>
            </div>
            <div class="col-sm-8 visible-sm">
                <p class="muted credit">&copy {{ date("Y") }} Midwest Institute for Sexuality and Gender Diversity</p>
                <ul class="list-inline copy-links">
                    <li><a href="/legal-privacy">Legal & Privacy</a></li>
                    <li><a href="mailto:webmaster@sgdinstitute.org">Webmaster</a></li>
                    <li><a href="mailto:marketing@sgdinstitute.org">Media</a></li>
                    <li><a href="/stay-engaged">Contact</a></li>
                </ul>
            </div>
            <div class="col-md-9 mt-20-xs">
                @include('components.menu')
            </div>
        </div>
        <div class="hidden-sm" style="font-size: 12px">
            <p class="muted credit"><a href="/backend" class="copyright">&copy;</a> {{ date("Y") }} Midwest Institute for Sexuality and Gender Diversity</p>
            <p class="muted credit">PO Box 1053, East Lansing, MI 48826-1053</p>
            <ul class="list-inline copy-links">
                <li><a href="/legal-privacy">Legal & Privacy</a></li>
                <li><a href="mailto:webmaster@sgdinstitute.org">Webmaster</a></li>
                <li><a href="mailto:marketing@sgdinstitute.org">Media</a></li>
                <li><a href="/stay-engaged">Contact</a></li>
            </ul>
        </div>

    </div>
</footer>

<footer class="footer">
    <div class="container-fluid">
        <div class="d-flex justify-content-between">
            <div class="fst-italic small">
                Version 1.0
            </div>
            <div>
                <script>document.write(new Date().getFullYear())</script> © {{ $option['site-title']->value ?? config('app.name', 'Laravel') }}.
            </div>
        </div>
    </div>
</footer>
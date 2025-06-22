<footer class="footer">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6 p-0 footer-left">
                <p class="mb-0">Copyright © <span id="currentYear"></span> Groupe Scolaire Rihab Al Marjan.</p>
            </div>
            <div class="col-md-6 p-0 footer-right">
                <p class="mb-0">Hand-crafted & made with <i class="fa fa-heart font-danger"></i> by us</p>
            </div>
        </div>
    </div>
</footer>

<script>
    // Get the current year
    const currentYear = new Date().getFullYear();
    // Set the current year in the HTML
    document.getElementById('currentYear').textContent = currentYear;
</script>
<!-- navbar.php -->
<nav class="navbar navbar-expand-sm bg-light">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" href="/">Index</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="/table.php">Pregled unetih polisa</a>
        </li>
    </ul>      
</nav>

<script>
    // Get current page path
    var path = window.location.pathname;

    // Set active class based on current page path
    $("a.nav-link[href='" + path + "']").addClass("active");
</script>

<style>
    .nav-link.active {
        background-color: #007bff;
        color: #fff;
    }
</style>

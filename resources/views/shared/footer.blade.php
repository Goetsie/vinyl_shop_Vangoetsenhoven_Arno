<footer>
    <div class="container">
        <hr>

    {{--        Without double curly braces --}}
    <?php
//    echo "<p class='text-right'>The Vinyl Shop - &copy; " . date('Y') . " </p>";
//    ?>

    <!--Method of double curly braces -->
        <p class="text-right">The Vinyl Shop - &copy; {{date('Y')}}</p>
    </div>
</footer>

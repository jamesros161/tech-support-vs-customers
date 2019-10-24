</div>
    <!-- /container -->
 
<!-- jQuery library -->
<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
 
<!-- Bootstrap JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.0/js/bootstrap.min.js"></script>
 
<?php
    if($page_title == "New Agent Creator") {
        echo '<script src="libs/js/newagent.js"></script>';
    }
    if($page_title == "Active Contact") {
        echo '<script src="libs/js/play.js"></script>';
    }
    if($page_title == "Level Up Agent") {
        echo '<script src="libs/js/levelup.js"></script>';
    }
    ?>
<!-- end HTML page -->
</body>
</html>
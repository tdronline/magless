<?php require_once('inc/functions.php'); ?>
<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link href="https://fonts.googleapis.com/css?family=Oxygen" rel="stylesheet">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/default.css">

    <title>MagLess</title>
</head>
<body>
<nav class="nav">
    <div class="logo">
        <img class="logo-img" src="images/magento-icon.svg" alt="Magento Admin Panel">
        MagLess
    </div>
    <div class="options">
        <ul class="options">
            <li><span class="icon-cog settings" data-toggle="modal" data-target="#infoModal"></span></li>
            <li></li>
        </ul></div>
</nav>
<div class="container-fluid wrapper">
    <div class="row">
        <div class="col-md-2 sidebar">
            <ul class="side-nav">
                <?php
                $less_files = scandir (SITE_ROOT.VAR_FOLDER.'/');
                foreach ($less_files as $file){
                    if(!in_array($file, array('.','..'))) {
                        $file_name = str_replace('_','',$file);
                        $file_name = str_replace('.less','',$file_name);
                        echo "<li id='$file'>$file_name</li>";
                    }
                }
                ?>
            </ul>
        </div>
        <div class="col-md-10 contents">
            <div class="col-md-8" id="content">
                <?php

                ?>
            </div>
            <div class="preview"></div>
        </div>
    </div>
</div>

<!-- Large modal -->
<div class="modal fade" id="infoModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="infotitle"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"></script>
<script src="js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>
<script>
    $(".side-nav li").click(function () {
        var page = $(this).attr('id');
        $(".side-nav li").removeClass('active');
        $(this).addClass('active');
        $("#content").fadeOut('fast', function () {
            $.ajax({
                method: "POST",
                url: "inc/ajax-less-file.php",
                data: { lessfile: page }
            })
            .done(function( data ) {
                    $("#content").html('').append(data).fadeIn('slow');
            });
        });
    });

    $(".nav").on('keypress', 'input', function () {
        var lessVal = $(this).val();
        if ($(this).val().length > 2) {
            console.log(lessVal);
        }
    });

    $(".nav").on('click', ".settings", function(){
        $.ajax({
            method: "POST",
            url: "inc/ajax-settings.php"
            //, data: { lessfile: page }
        })
            .done(function( data ) {
                $("#infotitle").html('Project Settings');
                $(".modal-body").html(data);
            });
    });
    $(".modal").on('click', ".save-setting", function(){
        var dir = $("#project-dir").val();
        var theme = $("#project-name").val();
        $.ajax({
            method: "POST",
            url: "inc/ajax-create.php"
            , data: { prj_path: dir, prj_name: theme }
        })
            .done(function( data ) {
                $("#infotitle").html('Project Settings');
                $(".modal-body").html(data);
            });
    });
</script>
</body>
</html>
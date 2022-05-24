<?php

    require_once __DIR__ . '/vendor/autoload.php';
    require_once "utils.php";
    require_once "db.php";


    require "header.html"
?>

<div class="container">
    <div class="row">
        <div class="col">

            <form action="index.php" method="get" class="shadow-sm p-3 mb-5 bg-body rounded">
                <div class="form-check ">
                    <input class="form-check-input" type="radio" name="list-select" id="l1" value="l1">
                    <label class="form-check-label" for="l1"> List of manufactures </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="list-select" id="l2" value="l2">
                    <label class="form-check-label" for="l2"> Out of stock </label>
                </div>
                <div class="p-2 mt-1">
                    <button type="submit" class="btn btn-success"> Get list </button>
                </div>
            </form>


            <form action="index.php" method="get" class="shadow-sm p-3 mb-5 bg-body rounded">
                <div class=" form-group row">
                    <div class="form-group col">
                        <label for="from" class="col-sm-2 col-form-label"> From </label>
                        <div class="col-sm-10">
                            <input type="number" name="from" class="form-control" id="from">
                        </div>
                    </div>
                    <div class="form-group col">
                        <label for="to" class="col-sm-2 col-form-label"> To </label>
                        <div class="col-sm-10">
                            <input type="number" name="to" class="form-control" id="to">
                        </div>
                    </div>
                </div>
                <div class="p-2 mt-1">
                    <button type="submit" class="btn btn-success" onclick="handleClick()"> Get products</button>
                </div>
            </form>

            <?php handle_request($products)?>


        </div>
    </div>
</div>
<script src="index.js"></script>
<?php require "footer.html"?>

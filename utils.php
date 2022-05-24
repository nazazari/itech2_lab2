<?php


function print_error(int $code = 404, string $data = ""): void{

    require "header.html";
    echo <<< DATA
        <div class='jumbotron p-4 bg-light'>
            <div class='container'>
                <h1 class='display-4'>Error $code</h1>
            </div>
        </div>
        <div class='container p-6 border-top border-bottom'>$data</div>
    DATA;
    require "footer.html";

    http_response_code($code);
}


function get_products($collection): array{

    $filter = array();
    if(isset($_GET['from']) && is_numeric($_GET['from'])){
        $filter['$gt'] = $_GET['from'] - 1;
    }
    if(isset($_GET['to']) && is_numeric($_GET['from'])){
        $filter['$lt'] = $_GET['to'] + 1;
    }

    if(count($filter) == 0){
        return $collection->find()->toArray();
    }
    return $collection->find( ['price' => $filter] )->toArray();
}

function print_products(array $products): void{

    if (count($products) == 0) {
        echo "<p> Products not found </p>";
        return;
    }
    echo '<ul class="list-group">';
    foreach ($products as $product) {
        $style = $product->stored == 0 ? "list-group-item list-group-item-danger" : "list-group-item list-group-item-primary ";

        $extra = "<div>";
        if(isset($product->state)){
            $extra .= "<p> <b>State:</b> $product->state </p>";
        }
        if(isset($product->reviews) && count($product->reviews) != 0 ){
            $reviews_list = '';
            foreach ($product->reviews as $review) {
                $reviews_list .= "<li class='list-group-item list-group-item-secondary'> $review </li>";
            }
            $extra .= "<ul class='list-group'> $reviews_list </ul>";
        }
        $extra .= "</div>";

        echo <<< PRODUCT
            <div class="$style pt-1 m-1">
                <h6>$product->name</h6>
                <table class="table table-bordered border-dark">
                  <thead>
                    <tr><th scope="col">#</th><th scope="col"> Info </th></tr>
                  </thead>
                  <tbody>
                    <tr><th scope="row"> Type         </th><td>$product->type</td></tr>
                    <tr><th scope="row"> Manufacturer </th><td>$product->manufacturer</td></tr>
                    <tr><th scope="row"> Price        </th><td>$product->price</td></tr></tr>
                    <tr><th scope="row"> Stored       </th><td>$product->stored</td></tr>
                  </tbody>
                </table>
                $extra
            </div>
        PRODUCT;

    }
    echo '</ul>';
}

function get_manufacturers(\MongoDB\Collection $collection): array{

    $manufacturers = array();
    foreach ($collection->find()->toArray() as $product){
        if(!in_array($product->manufacturer, $manufacturers)){
            $manufacturers[] = $product->manufacturer;
        }
    }
    return $manufacturers;
}

function get_out_of_stock_products(\MongoDB\Collection $collection): array{
    $names = array();
    foreach ($collection->find( ['stored' => 0 ] )->toArray() as $product){
        $names[] = $product->name;
    }
    return $names;
}

function print_list(array $items): void{

    if (count($items) == 0) {
        echo "<p> empty list </p>";
        return;
    }

    echo '<ul class="list-group">';
    foreach ($items as $item){
        echo "<li class='list-group-item'>$item</li>";
    }
    echo '</ul>';
}


function handle_request(\MongoDB\Collection $products) : void{
    if(array_key_exists("list-select", $_GET)){
        if($_GET["list-select"] == "l1"){
            echo "<h3> Manufacturers </h3>";
            print_list(get_manufacturers($products));
        } else{
            echo "<h3> Out of stock </h3>";
            print_list(get_out_of_stock_products($products));
        }
        return;
    }

    if(array_key_exists("from", $_GET) && array_key_exists("to", $_GET)){
        echo "<h3> List of products </h3>";
        print_products(get_products($products));
    }
}

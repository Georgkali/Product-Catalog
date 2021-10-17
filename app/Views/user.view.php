<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Product Catalog v1.0</title>

    <form method="post" action="/logout">
        <button type="submit">Logout</button>
    </form>



</head>
<body>
<form method="post" action="/addProduct">

    <label for="name">Product name</label>
    <input type="text" name="productName" required>
    <label for="name">Quantity</label>
    <input type="number" name="qty" required>
    <label for="name">Category</label>
    <select name="category" required>
        <option value="a">a</option>
        <option value="b">b</option>
        <option value="c">c</option>
        <option value="d">d</option>
    </select>
    <button type="submit">Add product</button>
<ul>
    <?php
    foreach ($products->getProducts() as $key => $product) {
       echo "<li> {$product->getProductName()} {$product->getQty()} {$product->getCategory()} {$product->getAddDate()} </li>";
    }
    ?>
</ul>

</form>

</body>
</html>
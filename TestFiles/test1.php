<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Stock Details</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="stock-container">
    <h1>Stock Details</h1>
    <form action="add_product_backend.php" method="POST" enctype="multipart/form-data">
      <div class="form-layout">
        <div class="image-upload">
          <label for="product_image">
            <div class="upload-area">
              <img src="upload-icon.png" alt="Upload Icon">
              <p>upload an image</p>
            </div>
          </label>
          <input type="file" id="product_image" name="product_image" accept="image/*">
        </div>
        <div class="details-form">
          <div class="form-group">
            <label for="product_name">Product Name</label>
            <input type="text" id="product_name" name="product_name" required>
          </div>
          <div class="form-group">
            <label for="stock_quantity">Stock Quantity</label>
            <input type="number" id="stock_quantity" name="stock_quantity" required>
          </div>
          <div class="form-group">
            <label for="control_number">ID No. / Control No.</label>
            <input type="text" id="control_number" name="control_number" required>
          </div>
          <div class="form-group">
            <label for="price">Unit Price (₱)</label>
            <input type="number" id="price" name="price" step="0.01" required>
          </div>
        </div>
      </div>
      <button type="submit" class="submit-btn">Submit</button>
    </form>
  </div>
</body>
</html>

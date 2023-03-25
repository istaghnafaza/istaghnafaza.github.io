<!DOCTYPE html>
<html>
  <head>
    <title>Invoice</title>
    <style>
      /* Style untuk invoice */
      body {
        font-family: Arial, sans-serif;
        font-size: 14px;
      }
      
      .invoice {
        border: 1px solid #ccc;
        padding: 20px;
        margin: 20px;
      }
      
      .invoice-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
      }
      
      .invoice-header img {
        height: 60px;
      }
      
      .invoice-header h1 {
        font-size: 24px;
        margin: 0;
      }
      
      .invoice-details {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 20px;
      }
      
      .invoice-details div {
        flex-basis: 50%;
      }
      
      .invoice-table {
        width: 100%;
        border-collapse: collapse;
      }
      
      .invoice-table th, .invoice-table td {
        padding: 8px;
        border: 1px solid #ccc;
      }
      
      .invoice-table th {
        background-color: #f5f5f5;
      }
      
      .invoice-total {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 20px;
      }
      
      .invoice-total h2 {
        margin: 0;
      }
      
      .invoice-total strong {
        font-weight: bold;
      }
    </style>
  </head>
  <body>
    <div class="invoice">
      <!-- Header -->
      <div class="invoice-header">
        <img src="SIMETRI.png" alt="Logo">
        <h1>Invoice</h1>
      </div>
      
      <!-- Details -->
      <div class="invoice-details">
        <div>
          <h3>From:</h3>
          <p>Your Company Name<br>
             Your Company Address<br>
             City, State Zip<br>
             Phone: 123-456-7890<br>
             Email: info@yourcompany.com
          </p>
        </div>
        <div>
          <h3>To:</h3>
          <p>Customer Name<br>
             Customer Address<br>
             City, State Zip<br>
             Phone: 123-456-7890<br>
             Email: customer@example.com
          </p>
        </div>
      </div>
      
      <!-- Table -->
      <table class="invoice-table">
        <thead>
          <tr>
            <th>Description</th>
            <th>Quantity</th>
            <th>Price</th>
            <th>Total</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>Product 1</td>
            <td>2</td>
            <td>$50.00</td>
            <td>$100.00</td>
          </tr>
          <tr>
            <td>Product 2</td>
            <td>3</td>
            <td>$25.00</td>
            <td>$75.00</td>
          </tr>
        </tbody>
      </table>
      
      <!-- Total -->
        <div class="invoice-total">
    <h2>Total:</h2>
    <strong>$175.00</strong>
  </div>
</div>
</body>
</html>

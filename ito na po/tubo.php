<?php
// No PHP backend logic — frontend-driven payment UI
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>TUBO - Monthly Interest Payment</title>
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background-color: #fef8d9;
      margin: 0;
      padding: 20px;
    }
    .container {
      max-width: 960px;
      margin: auto;
      background: white;
      padding: 30px;
      border-radius: 8px;
      box-shadow: 0 0 10px #ccc;
    }
    h1 {
      text-align: center;
      margin-bottom: 30px;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 20px;
    }
    th, td {
      border: 1px solid #ccc;
      padding: 12px;
      text-align: center;
    }
    button {
      padding: 6px 12px;
      background-color: #3d7c2b;
      color: white;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }
    button:hover {
      background-color: #2f5f20;
    }
    .modal, .receipt {
      display: none;
      background: rgba(0,0,0,0.5);
      position: fixed;
      top: 0; left: 0;
      width: 100%; height: 100%;
      justify-content: center;
      align-items: center;
      z-index: 10;
    }
    .modal-content, .receipt-content {
      background: white;
      padding: 30px;
      border-radius: 10px;
      width: 400px;
      max-width: 90%;
      position: relative;
    }
    .receipt-content p {
      margin: 8px 0;
    }
    .close {
      background-color: #aaa;
      color: white;
      position: absolute;
      top: 10px; right: 15px;
      padding: 5px 10px;
      border-radius: 50%;
      cursor: pointer;
    }
    .payment-methods input {
      margin-right: 8px;
    }
    .actions {
      text-align: center;
      margin-top: 20px;
    }
    .receipt-title {
      text-align: center;
      font-weight: bold;
      margin-bottom: 10px;
      font-size: 18px;
      text-transform: uppercase;
    }
    .divider {
      border-top: 1px dashed #ccc;
      margin: 10px 0;
    }
    .print-email-buttons {
      text-align: center;
      margin-top: 15px;
    }
    .print-email-buttons button {
      margin: 5px;
    }
  </style>
</head>
<body>
  <div class="container">
    <h1>Pay Monthly TUBO</h1>
    <table>
      <thead>
        <tr>
          <th>Item Name</th>
          <th>Pawn Ticket No.</th>
          <th>Due Date</th>
          <th>Interest Amount Due</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>18K Gold Ring</td>
          <td>#PT-001</td>
          <td>June 05, 2025</td>
          <td>₱1,200.00</td>
          <td><button onclick="openModal('18K Gold Ring', '#PT-001', '₱1,200.00', 'June 05, 2025')">Pay TUBO</button></td>
        </tr>
        <tr>
          <td>22K Necklace</td>
          <td>#PT-002</td>
          <td>June 10, 2025</td>
          <td>₱1,800.00</td>
          <td><button onclick="openModal('22K Necklace', '#PT-002', '₱1,800.00', 'June 10, 2025')">Pay TUBO</button></td>
        </tr>
      </tbody>
    </table>
  </div>

  <!-- Payment Modal -->
  <div class="modal" id="paymentModal">
    <div class="modal-content">
      <span class="close" onclick="closeModal('paymentModal')">&times;</span>
      <h3>Confirm TUBO Payment</h3>
      <p><strong>Item Name:</strong> <span id="itemName"></span></p>
      <p><strong>Pawn Ticket:</strong> <span id="ticketNo"></span></p>
      <p><strong>Due Date:</strong> <span id="dueDate"></span></p>
      <p><strong>Interest Amount:</strong> <span id="amountDue"></span></p>
      <div class="payment-methods">
        <p><strong>Payment Method:</strong></p>
        <label><input type="radio" name="paymentMethod" value="GCash"> GCash</label><br>
        <label><input type="radio" name="paymentMethod" value="Debit/Credit Card"> Debit/Credit Card</label><br>
        <label><input type="radio" name="paymentMethod" value="Bank Transfer"> Bank Transfer</label>
      </div>
      <div class="actions">
        <button onclick="proceedToPayment()">Confirm Payment</button>
      </div>
    </div>
  </div>

  <!-- Receipt Modal -->
  <div class="receipt" id="receiptScreen">
    <div class="receipt-content" id="receiptContent">
      <span class="close" onclick="closeModal('receiptScreen')">&times;</span>
      <div class="receipt-title">TUBO RECEIPT</div>
      <p><strong>Reference No:</strong> <span id="refNo"></span></p>
      <p><strong>Date & Time:</strong> <span id="dateTime"></span></p>
      <div class="divider"></div>
      <p><strong>Item Name:</strong> <span id="rItemName"></span></p>
      <p><strong>Pawn Ticket:</strong> <span id="rTicketNo"></span></p>
      <p><strong>Amount Paid:</strong> <span id="rAmountPaid"></span></p>
      <p><strong>Payment Method:</strong> <span id="rPaymentMethod"></span></p>
      <div class="divider"></div>
      <p><strong>Redemption Reminder:</strong></p>
      <p>Please make the next TUBO payment <strong>before or on</strong> the next due date to avoid penalty or item forfeiture.</p>
      <p>Always present your valid ID and this receipt during any transaction.</p>

      <div class="print-email-buttons">
        <button onclick="printReceipt()">🖨 Print Receipt</button>
        <button onclick="emailReceipt()">📧 Email Receipt</button>
      </div>
    </div>
  </div>

  <script>
    let currentItem = {};

    function openModal(name, ticket, amount, dueDate) {
      currentItem = { name, ticket, amount, dueDate };
      document.getElementById('itemName').textContent = name;
      document.getElementById('ticketNo').textContent = ticket;
      document.getElementById('amountDue').textContent = amount;
      document.getElementById('dueDate').textContent = dueDate;
      document.getElementById('paymentModal').style.display = 'flex';
    }

    function closeModal(id) {
      document.getElementById(id).style.display = 'none';
    }

    function proceedToPayment() {
      const method = document.querySelector('input[name="paymentMethod"]:checked');
      if (!method) {
        alert('Please select a payment method.');
        return;
      }

      const refNo = 'TXN-' + new Date().getTime();
      const now = new Date().toLocaleString();

      document.getElementById('refNo').textContent = refNo;
      document.getElementById('dateTime').textContent = now;
      document.getElementById('rItemName').textContent = currentItem.name;
      document.getElementById('rTicketNo').textContent = currentItem.ticket;
      document.getElementById('rAmountPaid').textContent = currentItem.amount;
      document.getElementById('rPaymentMethod').textContent = method.value;

      closeModal('paymentModal');
      document.getElementById('receiptScreen').style.display = 'flex';
    }

    function printReceipt() {
      const content = document.getElementById('receiptContent').innerHTML;
      const printWindow = window.open('', '', 'width=800,height=600');
      printWindow.document.write('<html><head><title>TUBO Receipt</title>');
      printWindow.document.write('<style>body{font-family:sans-serif;padding:20px;} .divider{border-top:1px dashed #ccc;margin:10px 0;}</style>');
      printWindow.document.write('</head><body>');
      printWindow.document.write(content);
      printWindow.document.write('</body></html>');
      printWindow.document.close();
      printWindow.print();
    }

    function emailReceipt() {
      const subject = encodeURIComponent("Your TUBO Payment Receipt");
      const body = encodeURIComponent(
        `TUBO Payment Successful!\n\n` +
        `Reference No: ${document.getElementById('refNo').textContent}\n` +
        `Date & Time: ${document.getElementById('dateTime').textContent}\n` +
        `Item Name: ${document.getElementById('rItemName').textContent}\n` +
        `Pawn Ticket: ${document.getElementById('rTicketNo').textContent}\n` +
        `Amount Paid: ${document.getElementById('rAmountPaid').textContent}\n` +
        `Payment Method: ${document.getElementById('rPaymentMethod').textContent}\n\n` +
        `Reminder: Please redeem before the next due date.`
      );
      window.location.href = `mailto:?subject=${subject}&body=${body}`;
    }
  </script>
</body>
</html>

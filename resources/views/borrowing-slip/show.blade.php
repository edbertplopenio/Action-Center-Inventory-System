<!-- resources/views/borrowing-slip/show.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Borrowing Slip Details</title>
</head>
<body>
    <h1>Borrowing Slip Details</h1>

    <p><strong>Name:</strong> {{ $borrowingSlip->name }}</p>
    <p><strong>Department:</strong> {{ $borrowingSlip->department }}</p>
    <p><strong>Email:</strong> {{ $borrowingSlip->email }}</p>
    <p><strong>Responsible Person:</strong> {{ $borrowingSlip->responsible_person }}</p>
    <p><strong>Item Code:</strong> {{ $borrowingSlip->item_code }}</p>
    <p><strong>Quantity:</strong> {{ $borrowingSlip->quantity }}</p>
    <p><strong>Borrow Date:</strong> {{ $borrowingSlip->borrow_date }}</p>
    <p><strong>Due Date:</strong> {{ $borrowingSlip->due_date }}</p>

    <h3>Signature</h3>
    @if ($borrowingSlip->signature)
        <img src="{{ Storage::url($borrowingSlip->signature) }}" alt="Signature" style="max-width: 200px;">
    @else
        <p>No signature uploaded.</p>
    @endif
</body>
</html>

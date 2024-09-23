
    <style>
        thead {
            background-color: #f2f2f2;
        }

        tbody {
            display: block;
            height: 400px; /* Adjust this height as needed */
            overflow-y: auto;
        }
        thead, tbody tr {
            display: table;
            width: 99%;
            table-layout: fixed;
        }


        body {
            font-family: Arial, sans-serif;
           
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        form {
            margin-bottom: 20px;
        }
        input[type="text"], input[type="number"], input[type="date"] {
            margin: 5px 0;
            padding: 8px;
            width: 200px;
        }
        select {
            margin: 5px 0;
            padding: 8px;
            width: 200px;
        }
        input[type="submit"] {
            padding: 8px 16px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }
        .summary {
            margin-top: 20px;
        }
    </style>
</head>
<body>
<div class="margin">
    

    <!-- Add Vehicle Form -->
    <form method="post">
        <input type="hidden" name="action" value="add">
        <label for="vehicleNumber">Vehicle Number :</label>
        <input type="text" id="vehicleNumber" name="vehicleNumber" required>
        <label for="acclocation">Licence Number :</label>
        <input type="text" id="acclocation" name="acclocation" required>
        <label for="date">DOB :</label>
        <input type="date" id="date" name="date" required>
        <input type="submit" value="Insert">
    </form>



    <!-- Vehicle Service Records Table -->
    <table>
        <thead>
            <tr>
                <th>Vehicle Number</th>
                <th>Licence No</th>
                <th>DOB</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($vehicles as $vehicle): ?>
            <tr>
                <form method="post">
                    <td><input type="text" name="newVehicleNumber" value="<?= htmlspecialchars($vehicle['vehicleNumber']) ?>"></td>
                    <td><input type="text" name="newlicenceno" value="<?= htmlspecialchars($vehicle['licenceno']) ?>"></td>
                    <td><input type="date" name="newDate" value="<?= htmlspecialchars($vehicle['date']) ?>"></td>
                    <td>
                        <input type="hidden" name="oldVehicleNumber" value="<?= htmlspecialchars($vehicle['vehicleNumber']) ?>">
                        <input type="hidden" name="action" value="update">
                        <button type="submit">Update</button>
                        <button type="button" onclick="deleteRecord('<?= htmlspecialchars($vehicle['vehicleNumber']) ?>')">Delete</button>
                    </td>
                </form>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Summary -->
    <div class="summary">
<!-- Summary -->
<div class="summary">
    <h2>Summary</h2>
    <p>Total Number of Drivers: <?= $linkedList1->countAllVehicles() ?></p>
</div>


    </div>


            </div>

    <script>
        function deleteRecord(vehicleNumber) {
            if (confirm('Are you sure you want to delete this record?')) {
                var form = document.createElement('form');
                form.method = 'post';
                form.action = '';

                var actionInput = document.createElement('input');
                actionInput.type = 'hidden';
                actionInput.name = 'action';
                actionInput.value = 'delete';
                form.appendChild(actionInput);

                var vehicleNumberInput = document.createElement('input');
                vehicleNumberInput.type = 'hidden';
                vehicleNumberInput.name = 'deleteVehicleNumber';
                vehicleNumberInput.value = vehicleNumber;
                form.appendChild(vehicleNumberInput);

                document.body.appendChild(form);
                form.submit();
            }
        }
    </script>

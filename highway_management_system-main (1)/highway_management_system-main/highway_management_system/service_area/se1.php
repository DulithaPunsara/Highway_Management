
<style>
        thead {
            background-color: #f2f2f2;
        }

        tbody {
            display: block;
            height: 250px; /* Adjust this height as needed */
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
<div class="margin">
     <!--  <h1>HIGHWAY VEHICLE MANAGEMENT SYSTEM - SERVICE MANAGEMENT</h1>

   -->
   
    <form method="post">
        <input type="hidden" name="action" value="add">
        <label for="vehicleNumber">Vehicle Number:</label>
        <input type="text" id="vehicleNumber" name="vehicleNumber" required>
        <label for="fuelType">Fuel Type:</label>
        <select id="fuelType" name="fuelType" required>
            <option value="petrol">Petrol</option>
            <option value="diesel">Diesel</option>
        </select>
        <label for="fuelConsumption">Fuel Consumption (liters):</label>
        <input type="number" id="fuelConsumption" name="fuelConsumption" step="0.01" required>
        <label for="date">Date:</label>
        <input type="date" id="date" name="date" required>
        <input type="submit" value="Add Vehicle">
    </form>

    
    <form method="post">
        <label for="startDate">Start Date:</label>
        <input type="date" id="startDate" name="startDate" value="<?= htmlspecialchars($startDate) ?>">
        <label for="endDate">End Date:</label>
        <input type="date" id="endDate" name="endDate" value="<?= htmlspecialchars($endDate) ?>">
        <input type="submit" value="Filter">
    </form>
  
   <form method="post">
 
        <input type="hidden" name="action" value="sort">
  
        <input type="submit" value="<?= $_SESSION['sortOrder'] === 'asc' ? 'Sort High to Low' : 'Sort Low to High' ?>">
    </form>




    <table>
        <thead>
            <tr>
                <th>Vehicle Number</th>
                <th>Fuel Type</th>
                <th>Fuel Consumption</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($vehicles as $vehicle): ?>
            <tr>
                <form method="post">
                    <td><input type="text" name="newVehicleNumber" value="<?= htmlspecialchars($vehicle['vehicleNumber']) ?>"></td>
                    <td><input type="text" name="newFuelType" value="<?= htmlspecialchars($vehicle['fuelType']) ?>"></td>
                    <td><input type="number" name="newFuelConsumption" value="<?= htmlspecialchars($vehicle['fuelConsumption']) ?>" step="0.01"></td>
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

   
    <div class="summary">
    <h2>Summary</h2>
    <ul style="list-style-type: disc; display: flex; flex-wrap: wrap; padding-left: 0; margin: 0;">
        <li style="margin-right: 20px;"> Total vehicles using petrol:  <?= $petrolCount ?></li>
        <li style="margin-right: 20px;"> Total vehicles using diesel:  <?= $dieselCount ?></li>
        <li style="margin-right: 20px;"> Total petrol consumption:  <?= number_format($totalPetrolConsumption, 2) ?> liters</li>
        <li style="margin-right: 20px;"> Total diesel consumption: <?= number_format($totalDieselConsumption, 2) ?> liters</li>
    </ul>
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

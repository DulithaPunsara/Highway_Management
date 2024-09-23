<div class="margin">
   <!--  <h1>Add Entrance Vehicle</h1>

    Add Vehicle  -->
    <form method="post" class="Add_vehicale">
        <input type="hidden" name="action" value="add">
        <label for="vehicleNumber">Vehicle Number:</label>
        <input type="text" id="vehicleNumber" name="vehicleNumber" required>
        <label for="vehicleType">Vehicle Type:</label>
        <select id="vehicleType" name="vehicleType" required>
            <option value="Heavy vehicle">Heavy vehicle</option>
            <option value="Lite vehicle">Lite vehicle</option>
        </select>
       <!--  <label for="date">Date:</label>
        <input type="date" id="date" name="date" required>
        <label for="time">Time:</label>
        <input type="time" id="time" name="time" required> -->
        <input type="submit" value="Add Vehicle">
    </form>



    <!-- Filter Form -->
    <form method="post" class="search_vehicale">
        <label for="startDate">Start Date:</label>
        <input type="date" id="startDate" name="startDate" value="<?= htmlspecialchars($startDate) ?>">
        <label for="endDate">End Date:</label>
        <input type="date" id="endDate" name="endDate" value="<?= htmlspecialchars($endDate) ?>">
        <input type="submit" value="Filter">
    </form>






    <!-- V Table -->
    <table>
        <thead>
            <tr>
                <th style="width:19.8%">Vehicle Number</th>
                <th style="width:19.8%">Vehicle Type</th>
                <th>Date and Time</th>
                <th style="width:11%">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($vehicles as $vehicle): ?>
            <tr>
                <form method="post">
                    <td style="width:20%"><input type="text" name="newVehicleNumber" value="<?= htmlspecialchars($vehicle['vehicleNumber']) ?>"></td>
                    <td style="width:20%">
                        <select name="newVehicleType">
                            <option value="Heavy vehicle" <?= $vehicle['vehicleType'] == 'Heavy vehicle' ? 'selected' : '' ?>>Heavy vehicle</option>
                            <option value="Lite vehicle" <?= $vehicle['vehicleType'] == 'Lite vehicle' ? 'selected' : '' ?>>Lite vehicle</option>
                        </select>
                    </td>
                    <td>
                        <input type="date" name="newDate" value="<?= htmlspecialchars(explode(' ', $vehicle['dateTime'])[0]) ?>" readonly>
                        <input type="time" name="newTime" value="<?= htmlspecialchars(explode(' ', $vehicle['dateTime'])[1]) ?>" readonly>
                    </td>
                    <td style="width:10%">
                        <input type="hidden" name="oldVehicleNumber" value="<?= htmlspecialchars($vehicle['vehicleNumber']) ?>">
                        <input type="hidden" name="action" value="update">
                        <button type="submit" class="upadte">Update</button>
                        <button type="button" class="dlete" onclick="deleteRecord('<?= htmlspecialchars($vehicle['vehicleNumber']) ?>')">Delete</button>
                    </td>
                </form>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>




    <!-- Summary  -->
    <div class="summary">
        <span>Number of Heavy vehicle: <?= htmlspecialchars($carCount) ?></span>
        <span class="sum_2">Number of Lite vehicle: <?= htmlspecialchars($truckCount) ?></span>
    </div>


            </div>


    <script>
        function deleteRecord(vehicleNumber) {
            if (confirm('Are you sure you want to delete vehicle ' + vehicleNumber + '?')) {
                const form = document.createElement('form');
                form.method = 'post';
                const vehicleInput = document.createElement('input');
                vehicleInput.type = 'hidden';
                vehicleInput.name = 'deleteVehicleNumber';
                vehicleInput.value = vehicleNumber;
                form.appendChild(vehicleInput);

                const actionInput = document.createElement('input');
                actionInput.type = 'hidden';
                actionInput.name = 'action';
                actionInput.value = 'delete';
                form.appendChild(actionInput);

                document.body.appendChild(form);
                form.submit();
            }
        }
    </script>




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
            text-align: center;
        }
        th {
            background-color: #f2f2f2;
        }
        form {
            margin-bottom: 20px;
        }
        input[type="text"], input[type="date"], input[type="time"] {
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
            margin-left:550px;
            font-size:20px;
        }
        .sum_2{
            padding-left:50px;
        }
        .Add_vehicale{
            margin-left:400px;
        }
        .search_vehicale{
            margin-left:800px;
        }
        .upadte{
            background-color:#0cc0df;
            padding-top:5px;
            border: none;
        }
        .dlete{
            background-color:#fb5453;
            padding-top:5px;
            border: none;
        }

    </style>


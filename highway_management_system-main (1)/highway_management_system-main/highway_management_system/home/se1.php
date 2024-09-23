
<br><br><br><br><br><br>
<style>
    .box-container {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-around;
    }

    .box {
        width: 400px;
        height: 200px;
        background-color: #f0f0f0;
        border: 1px solid #ccc;
        margin: 10px;
        display: flex;
        align-items: center;
        font-family: Arial, sans-serif;
    }

    .box img {
        width: 150px;
        height: 100%;
        object-fit: cover;
    }

    .box .content {
        padding: 10px;
        flex: 1;
        text-align:center;
    }

    .box .content h3 {
        margin: 0 0 10px 0;
        font-size: 18px;
    }

    .box .content p {
        margin: 0;
        font-size: 14px;
        color: #666;
    }
</style>
</head>
<body>

<div class="box-container">
    <div class="box">
        <img src="img/1.png" alt="Image 1">
        <div class="content">
            <h3>Number Of Entry Vehicles</h3>
            <h1><?= htmlspecialchars($carCount + $truckCount) ?></h1>
        </div>
    </div>

    <div class="box">
        <img src="img/2.png" alt="Image 2">
        <div class="content">
          <h3>Vehicles In Highway</h3>
          <h1><?= htmlspecialchars($carCount + $truckCount -$carCount1 - $truckCount1  ) ?></h1>
        </div>
    </div>

    <div class="box">
        <img src="img/3.png" alt="Image 3">
        <div class="content">
          <h3>Number Of Accidents</h3>
          <h1><?= $linkedList2->countAllVehicles() ?></h1>
        </div>
    </div>

    <div class="box">
        <img src="img/4.png" alt="Image 4">
        <div class="content">
            <h3>Petrol Consumption</h3>
            <h1><?= number_format($totalPetrolConsumption, 2) ?> L</h1>
        </div>
    </div>

    <div class="box">
        <img src="img/5.png" alt="Image 5">
        <div class="content">
                <h3>Diesel Consumption</h3>
                <h1> <?= number_format($totalDieselConsumption, 2) ?> L</h1>
        </div>
    </div>

    <div class="box">
        <img src="img/7.png" alt="Image 5">
        <div class="content">
            <h3>Number Of Drivers</h3>
            <h1><?= $linkedList1->countAllVehicles() ?></h1>
        </div>
    </div>
</div>
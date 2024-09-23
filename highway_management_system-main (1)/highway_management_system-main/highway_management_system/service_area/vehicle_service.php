<?php

class Node {
    public $vehicleNumber;
    public $fuelType;
    public $fuelConsumption;
    public $date;
    public $next;

    public function __construct($vehicleNumber, $fuelType, $fuelConsumption, $date) {
        $this->vehicleNumber = $vehicleNumber;
        $this->fuelType = $fuelType;
        $this->fuelConsumption = $fuelConsumption;
        $this->date = $date;
        $this->next = null;
    }
}


class LinkedList {
    private $head;

    public function __construct() {
        $this->head = null;
    }

    public function addVehicle($vehicleNumber, $fuelType, $fuelConsumption, $date) {
        $newNode = new Node($vehicleNumber, $fuelType, $fuelConsumption, $date);
        if ($this->head === null) {
            $this->head = $newNode;
        } else {
            $current = $this->head;
            while ($current->next !== null) {
                $current = $current->next;
            }
            $current->next = $newNode;
        }
        
    }
    

    public function updateVehicle($oldVehicleNumber, $newVehicleNumber, $newFuelType, $newFuelConsumption, $newDate) {
        $current = $this->head;
        while ($current !== null) {
            if ($current->vehicleNumber === $oldVehicleNumber) {
                $current->vehicleNumber = $newVehicleNumber;
                $current->fuelType = $newFuelType;
                $current->fuelConsumption = $newFuelConsumption;
                $current->date = $newDate;
                return true;
            }
            $current = $current->next;
        }
        return false; 
    }

    public function deleteVehicle($vehicleNumber) {
        if ($this->head === null) {
            return false; 
        }

        if ($this->head->vehicleNumber === $vehicleNumber) {
            $this->head = $this->head->next;
            return true;
        }

        $current = $this->head;
        while ($current->next !== null && $current->next->vehicleNumber !== $vehicleNumber) {
            $current = $current->next;
        }

        if ($current->next !== null) {
            $current->next = $current->next->next;
            return true;
        }

        return false;  
    }

    public function getVehicles($startDate = null, $endDate = null) {
        $vehicles = [];
        $current = $this->head;
        while ($current !== null) {
            if (($startDate === null || $current->date >= $startDate) &&
                ($endDate === null || $current->date <= $endDate)) {
                $vehicles[] = [
                    'vehicleNumber' => $current->vehicleNumber,
                    'fuelType' => $current->fuelType,
                    'fuelConsumption' => $current->fuelConsumption,
                    'date' => $current->date
                ];
            }
            $current = $current->next;
        }
        return $vehicles;
    }

    public function countVehiclesByFuelType($fuelType, $startDate = null, $endDate = null) {
        $count = 0;
        $current = $this->head;
        while ($current !== null) {
            if ($current->fuelType === $fuelType &&
                ($startDate === null || $current->date >= $startDate) &&
                ($endDate === null || $current->date <= $endDate)) {
                $count++;
            }
            $current = $current->next;
        }
        return $count;
    }

    public function calculateTotalFuelConsumption($fuelType, $startDate = null, $endDate = null) {
        $total = 0;
        $current = $this->head;
        while ($current !== null) {
            if ($current->fuelType === $fuelType &&
                ($startDate === null || $current->date >= $startDate) &&
                ($endDate === null || $current->date <= $endDate)) {
                $total += $current->fuelConsumption;
            }
            $current = $current->next;
        }
        return $total;
    }
    public function bubbleSortByFuelConsumption($ascending = true) {
        if ($this->head === null) {
            return;
        }
    
        $swapped = true;
        while ($swapped) {
            $swapped = false;
            $current = $this->head;
            while ($current->next !== null) {
                if (($ascending && $current->fuelConsumption > $current->next->fuelConsumption) ||
                    (!$ascending && $current->fuelConsumption < $current->next->fuelConsumption)) {
                    
                    $temp = $current->fuelConsumption;
                    $current->fuelConsumption = $current->next->fuelConsumption;
                    $current->next->fuelConsumption = $temp;
    
                    
                    $temp = $current->vehicleNumber;
                    $current->vehicleNumber = $current->next->vehicleNumber;
                    $current->next->vehicleNumber = $temp;
    
                    $temp = $current->fuelType;
                    $current->fuelType = $current->next->fuelType;
                    $current->next->fuelType = $temp;
    
                    $temp = $current->date;
                    $current->date = $current->next->date;
                    $current->next->date = $temp;
    
                    $swapped = true;
                }
                $current = $current->next;
            }
        }
    }
    
    
}

session_start();

if (!isset($_SESSION['linkedList'])) {
    $_SESSION['linkedList'] = serialize(new LinkedList());
}

$linkedList = unserialize($_SESSION['linkedList']);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'add':
                if (isset($_POST['vehicleNumber']) && isset($_POST['fuelType']) && isset($_POST['fuelConsumption']) && isset($_POST['date'])) {
                    $vehicleNumber = htmlspecialchars($_POST['vehicleNumber']);
                    $fuelType = htmlspecialchars($_POST['fuelType']);
                    $fuelConsumption = (float)$_POST['fuelConsumption'];
                    $date = htmlspecialchars($_POST['date']);
                    $linkedList->addVehicle($vehicleNumber, $fuelType, $fuelConsumption, $date);
                    $_SESSION['linkedList'] = serialize($linkedList);
                }
                break;

            case 'update':
                if (isset($_POST['oldVehicleNumber']) && isset($_POST['newVehicleNumber']) && isset($_POST['newFuelType']) && isset($_POST['newFuelConsumption']) && isset($_POST['newDate'])) {
                    $oldVehicleNumber = htmlspecialchars($_POST['oldVehicleNumber']);
                    $newVehicleNumber = htmlspecialchars($_POST['newVehicleNumber']);
                    $newFuelType = htmlspecialchars($_POST['newFuelType']);
                    $newFuelConsumption = (float)$_POST['newFuelConsumption'];
                    $newDate = htmlspecialchars($_POST['newDate']);
                    $linkedList->updateVehicle($oldVehicleNumber, $newVehicleNumber, $newFuelType, $newFuelConsumption, $newDate);
                    $_SESSION['linkedList'] = serialize($linkedList);
                }
                break;

            case 'delete':
                if (isset($_POST['deleteVehicleNumber'])) {
                    $deleteVehicleNumber = htmlspecialchars($_POST['deleteVehicleNumber']);
                    $linkedList->deleteVehicle($deleteVehicleNumber);
                    $_SESSION['linkedList'] = serialize($linkedList);
                }
                break;
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] === 'sort') {
    
    $_SESSION['sortOrder'] = ($_SESSION['sortOrder'] === 'asc') ? 'desc' : 'asc';
    $ascending = ($_SESSION['sortOrder'] === 'asc');
    $linkedList->bubbleSortByFuelConsumption($ascending);
    $_SESSION['linkedList'] = serialize($linkedList);
}



$startDate = isset($_POST['startDate']) ? htmlspecialchars($_POST['startDate']) : null;
$endDate = isset($_POST['endDate']) ? htmlspecialchars($_POST['endDate']) : null;



$vehicles = $linkedList->getVehicles($startDate, $endDate);
$petrolCount = $linkedList->countVehiclesByFuelType('petrol', $startDate, $endDate);
$dieselCount = $linkedList->countVehiclesByFuelType('diesel', $startDate, $endDate);
$totalPetrolConsumption = $linkedList->calculateTotalFuelConsumption('petrol', $startDate, $endDate);
$totalDieselConsumption = $linkedList->calculateTotalFuelConsumption('diesel', $startDate, $endDate);
?>



<?php

class ExitNode {
    public $vehicleNumber;
    public $vehicleType;
    public $dateTime;
    public $next;

    public function __construct($vehicleNumber, $vehicleType, $dateTime) {
        $this->vehicleNumber = $vehicleNumber;
        $this->vehicleType = $vehicleType;
        $this->dateTime = $dateTime;
        $this->next = null;
    }
}

class ExitLinkedList {
    private $head;

    public function __construct() {
        $this->head = null;
    }

    public function addVehicle($vehicleNumber, $vehicleType, $dateTime) {
        $newNode = new ExitNode($vehicleNumber, $vehicleType, $dateTime);
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

    public function updateVehicle($oldVehicleNumber, $newVehicleNumber, $newVehicleType, $newDateTime) {
        $current = $this->head;
        while ($current !== null) {
            if ($current->vehicleNumber === $oldVehicleNumber) {
                $current->vehicleNumber = $newVehicleNumber;
                $current->vehicleType = $newVehicleType;
                $current->dateTime = $newDateTime;
                return true;
            }
            $current = $current->next;
        }
        return false; // Vehicle not found
    }

    public function deleteVehicle($vehicleNumber) {
        if ($this->head === null) {
            return false; // List is empty
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

        return false; // Vehicle not found
    }

    public function getVehicles($startDate = null, $endDate = null) {
        $vehicles = [];
        $current = $this->head;
        while ($current !== null) {
            $currentDate = explode(' ', $current->dateTime)[0];
            if (($startDate === null || $currentDate >= $startDate) &&
                ($endDate === null || $currentDate <= $endDate)) {
                $vehicles[] = [
                    'vehicleNumber' => $current->vehicleNumber,
                    'vehicleType' => $current->vehicleType,
                    'dateTime' => $current->dateTime
                ];
            }
            $current = $current->next;
        }
        return $this->bubbleSortByDateTime($vehicles);
    }

    private function bubbleSortByDateTime($vehicles) {
        $n = count($vehicles);
        for ($i = 0; $i < $n - 1; $i++) {
            for ($j = 0; $j < $n - $i - 1; $j++) {
                // Sort in descending order by date and time
                if ($vehicles[$j]['dateTime'] < $vehicles[$j + 1]['dateTime']) {
                    $temp = $vehicles[$j];
                    $vehicles[$j] = $vehicles[$j + 1];
                    $vehicles[$j + 1] = $temp;
                }
            }
        }
        return $vehicles;
    }

    public function countVehiclesByType($vehicleType, $startDate = null, $endDate = null) {
        $count = 0;
        $current = $this->head;
        while ($current !== null) {
            $currentDate = explode(' ', $current->dateTime)[0];
            if ($current->vehicleType === $vehicleType &&
                ($startDate === null || $currentDate >= $startDate) &&
                ($endDate === null || $currentDate <= $endDate)) {
                $count++;
            }
            $current = $current->next;
        }
        return $count;
    }
}

session_start();

if (!isset($_SESSION['ExitLinkedList'])) {
    $_SESSION['ExitLinkedList'] = serialize(new ExitLinkedList());
}

$ExitLinkedList = unserialize($_SESSION['ExitLinkedList']);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'add':
                if (isset($_POST['vehicleNumber']) && isset($_POST['vehicleType'])) {
                    $vehicleNumber = htmlspecialchars($_POST['vehicleNumber']);
                    $vehicleType = htmlspecialchars($_POST['vehicleType']);
                    $date = date('Y-m-d');
                    $time = date('H:i:s');
                    $dateTime = $date . ' ' . $time;
                    $ExitLinkedList->addVehicle($vehicleNumber, $vehicleType, $dateTime);
                    $_SESSION['ExitLinkedList'] = serialize($ExitLinkedList);
                    header("location:exit.php");
                }
                break;

            case 'update':
                if (isset($_POST['oldVehicleNumber']) && isset($_POST['newVehicleNumber']) && isset($_POST['newVehicleType']) && isset($_POST['newDate']) && isset($_POST['newTime'])) {
                    $oldVehicleNumber = htmlspecialchars($_POST['oldVehicleNumber']);
                    $newVehicleNumber = htmlspecialchars($_POST['newVehicleNumber']);
                    $newVehicleType = htmlspecialchars($_POST['newVehicleType']);
                    $newDate = htmlspecialchars($_POST['newDate']);
                    $newTime = htmlspecialchars($_POST['newTime']);
                    $newDateTime = $newDate . ' ' . $newTime;
                    $ExitLinkedList->updateVehicle($oldVehicleNumber, $newVehicleNumber, $newVehicleType, $newDateTime);
                    $_SESSION['ExitLinkedList'] = serialize($ExitLinkedList);
                }
                break;

            case 'delete':
                if (isset($_POST['deleteVehicleNumber'])) {
                    $deleteVehicleNumber = htmlspecialchars($_POST['deleteVehicleNumber']);
                    $ExitLinkedList->deleteVehicle($deleteVehicleNumber);
                    $_SESSION['ExitLinkedList'] = serialize($ExitLinkedList);
                }
                break;
        }
    }
}

// Filter
$startDate = isset($_POST['startDate']) ? htmlspecialchars($_POST['startDate']) : null;
$endDate = isset($_POST['endDate']) ? htmlspecialchars($_POST['endDate']) : null;

$vehicles = $ExitLinkedList->getVehicles($startDate, $endDate);
$carCount1 = $ExitLinkedList->countVehiclesByType('Heavy vehicle', $startDate, $endDate);
$truckCount1 = $ExitLinkedList->countVehiclesByType('Lite vehicle', $startDate, $endDate);

?>

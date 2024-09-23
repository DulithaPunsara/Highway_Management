<?php
// Define the Node class for the linked list with fuel consumption and date
class Node1 {
    public $vehicleNumber;
    public $licenceno;
    public $date;
    public $next;

    public function __construct($vehicleNumber, $licenceno, $date) {
        $this->vehicleNumber = $vehicleNumber;
        $this->licenceno = $licenceno;
        $this->date = $date;
        $this->next = null;
    }
}

// Define the LinkedList class
class LinkedList1 {
    private $head;

    public function __construct() {
        $this->head = null;
    }

    public function addVehicle($vehicleNumber, $licenceno, $date) {
        $newNode1 = new Node1($vehicleNumber, $licenceno, $date);
        if ($this->head === null) {
            $this->head = $newNode1;
        } else {
            $current = $this->head;
            while ($current->next !== null) {
                $current = $current->next;
            }
            $current->next = $newNode1;
        }
    }

    public function updateVehicle($oldVehicleNumber, $newVehicleNumber, $newlicenceno, $newDate) {
        $current = $this->head;
        while ($current !== null) {
            if ($current->vehicleNumber === $oldVehicleNumber) {
                $current->vehicleNumber = $newVehicleNumber;
                $current->licenceno = $newlicenceno;
                $current->date = $newDate;
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
            if (($startDate === null || $current->date >= $startDate) &&
                ($endDate === null || $current->date <= $endDate)) {
                $vehicles[] = [
                    'vehicleNumber' => $current->vehicleNumber,
                    'licenceno' => $current->licenceno,
                    'date' => $current->date
                ];
            }
            $current = $current->next;
        }
        return $vehicles;
    }

    public function countVehiclesByFuelType($licenceno, $startDate = null, $endDate = null) {
        $count = 0;
        $current = $this->head;
        while ($current !== null) {
            if ($current->licenceno === $licenceno &&
                ($startDate === null || $current->date >= $startDate) &&
                ($endDate === null || $current->date <= $endDate)) {
                $count++;
            }
            $current = $current->next;
        }
        return $count;
    }



    public function countAllVehicles() {
        $count = 0;
        $current = $this->head;
        while ($current !== null) {
            $count++;
            $current = $current->next;
        }
        return $count;
    }


    

}

session_start();

if (!isset($_SESSION['linkedList1'])) {
    $_SESSION['linkedList1'] = serialize(new LinkedList1());
}

$linkedList1 = unserialize($_SESSION['linkedList1']);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'add':
                if (isset($_POST['vehicleNumber']) && isset($_POST['acclocation']) && isset($_POST['date'])) {
                    $vehicleNumber = htmlspecialchars($_POST['vehicleNumber']);
                    $acclocation = htmlspecialchars($_POST['acclocation']);
                    $date = htmlspecialchars($_POST['date']);
                    $linkedList1->addVehicle($vehicleNumber, $acclocation,  $date);
                    $_SESSION['linkedList1'] = serialize($linkedList1);
                }
                break;

            case 'update':
                if (isset($_POST['oldVehicleNumber']) && isset($_POST['newVehicleNumber']) && isset($_POST['newacclocation']) && isset($_POST['newDate'])) {
                    $oldVehicleNumber = htmlspecialchars($_POST['oldVehicleNumber']);
                    $newVehicleNumber = htmlspecialchars($_POST['newVehicleNumber']);
                    $newacclocation = htmlspecialchars($_POST['newacclocation']);
                    $newDate = htmlspecialchars($_POST['newDate']);
                    $linkedList1->updateVehicle($oldVehicleNumber, $newVehicleNumber, $newacclocation, $newDate);
                    $_SESSION['linkedList'] = serialize($linkedList1);
                }
                break;

            case 'delete':
                if (isset($_POST['deleteVehicleNumber'])) {
                    $deleteVehicleNumber = htmlspecialchars($_POST['deleteVehicleNumber']);
                    $linkedList1->deleteVehicle($deleteVehicleNumber);
                    $_SESSION['linkedList1'] = serialize($linkedList1);
                }
                break;
        }
    }
}

// Retrieve filter dates if provided
$startDate = isset($_POST['startDate']) ? htmlspecialchars($_POST['startDate']) : null;
$endDate = isset($_POST['endDate']) ? htmlspecialchars($_POST['endDate']) : null;

// Get filtered vehicles and summary
$vehicles = $linkedList1->getVehicles($startDate, $endDate);
$petrolCount = $linkedList1->countVehiclesByFuelType('petrol', $startDate, $endDate);
$dieselCount = $linkedList1->countVehiclesByFuelType('diesel', $startDate, $endDate);

?>



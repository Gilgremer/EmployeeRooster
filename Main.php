<?php

class Main {

    private EmployeeRoster $roster;
    private $size;
    private $repeat;

    public function start() {
        $this->clear();
        $this->repeat = true;

        $this->size = (int)readline("Enter the size of the roster: ");

        if ($this->size < 1) {
            echo "Invalid input. Please try again.\n";
            readline("Press \"Enter\" key to continue...");
            $this->start();
        } else {
            $this->roster = new EmployeeRoster($this->size);
            $this->entrance();
        }
    }

    public function entrance() {
        while ($this->repeat) {
            $this->clear();
            $this->menu();
            $choice = (int)readline("Select an option: ");

            switch ($choice) {
                case 1:
                    $this->addMenu();
                    break;
                case 2:
                    $this->deleteMenu();
                    break;
                case 3:
                    $this->otherMenu();
                    break;
                case 0:
                    $this->repeat = false;
                    break;
                default:
                    echo "Invalid input. Please try again.\n";
                    readline("Press \"Enter\" key to continue...");
                    break;
            }
        }
        echo "Process terminated.\n";
    }

    public function menu() {
        echo "*** EMPLOYEE ROSTER MENU ***\n";
        echo "[1] Add Employee\n";
        echo "[2] Delete Employee\n";
        echo "[3] Other Menu\n";
        echo "[0] Exit\n";
    }

    public function addMenu() {
        $name = readline("Enter name: ");
        $address = readline("Enter address: ");
        $age = (int)readline("Enter age: ");
        $companyName = readline("Enter company name: ");
        $this->empType($name, $address, $age, $companyName);
    }

    public function empType($name, $address, $age, $cName) {
        $this->clear();
        echo "---Employee Details---\n";
        echo "Enter name: $name\n";
        echo "Enter address: $address\n";
        echo "Enter company name: $cName\n";
        echo "Enter age: $age\n";
        echo "[1] Commission Employee\n";
        echo "[2] Hourly Employee\n";
        echo "[3] Piece Worker\n";
        $type = (int)readline("Type of Employee: ");

        switch ($type) {
            case 1:
                $this->addOnsCE($name, $address, $age, $cName);
                break;
            case 2:
                $this->addOnsHE($name, $address, $age, $cName);
                break;
            case 3:
                $this->addOnsPE($name, $address, $age, $cName);
                break;
            default:
                echo "Invalid input. Please try again.\n";
                readline("Press \"Enter\" key to continue...");
                $this->empType($name, $address, $age, $cName);
                break;
        }
    }

    public function addOnsCE($name, $address, $age, $cName) {
        $regularSalary = (float)readline("Enter regular salary: ");
        $itemSold = (int)readline("Enter items sold: ");
        $commissionRate = (float)readline("Enter commission rate: ");
        $employee = new CommissionEmployee($name, $address, $age, $cName, $regularSalary, $itemSold, $commissionRate);
        $this->addEmployeeToRoster($employee);
    }

    public function addOnsHE($name, $address, $age, $cName) {
        $hoursWorked = (int)readline("Enter hours worked: ");
        $rate = (float)readline("Enter rate: ");
        $employee = new HourlyEmployee($name, $address, $age, $cName, $hoursWorked, $rate);
        $this->addEmployeeToRoster($employee);
    }

    public function addOnsPE($name, $address, $age, $cName) {
        $numberItems = (int)readline("Enter number of items: ");
        $wagePerItem = (float)readline("Enter wage per item: ");
        $employee = new PieceWorker($name, $address, $age, $cName, $numberItems, $wagePerItem);
        $this->addEmployeeToRoster($employee);
    }

    private function addEmployeeToRoster($employee) {
        if ($this->roster->add($employee)) {
            echo "Employee added successfully.\n";
        } else {
            echo "Roster is full. Cannot add more employees.\n";
        }
        $this->repeat();
    }

    public function deleteMenu() {
        $this->clear();
        echo "***List of Employees on the current Roster***\n";
        $this->roster->display();
        $employeeNumber = (int)readline("Enter employee number to delete: ");
        if ($this->roster->remove($employeeNumber)) {
            echo "Employee deleted successfully.\n";
        } else {
            echo "Employee not found.\n";
        }
        readline("Press \"Enter\" key to continue...");
    }

    public function otherMenu() {
        $this->clear();
        echo "[1] Display\n";
        echo "[2] Count\n";
        echo "[3] Payroll\n";
        echo "[0] Return\n";
        $choice = (int)readline("Select Menu: ");

        switch ($choice) {
            case 1:
                $this->displayMenu();
                break;
            case 2:
                $this->countMenu();
                break;
            case 3:
                $this->roster->payroll();
                readline("Press \"Enter\" key to continue...");
                break;
            case 0:
                break;
            default:
                echo "Invalid input. Please try again.\n";
                readline("Press \"Enter\" key to continue...");
                break;
        }
    }

    public function displayMenu() {
        $this->clear();
        echo "[1] Display All Employee\n";
        echo "[2] Display Commission Employee\n";
        echo "[3] Display Hourly Employee\n";
        echo "[4] Display Piece Worker\n";
        echo "[0] Return\n";
        $choice = (int)readline("Select Menu: ");

        switch ($choice) {
            case 0:
                break;
            case 1:
                $this->roster->display();
                break;
            case 2:
                $this->roster->displayCE();
                break;
            case 3:
                $this->roster->displayHE();
                break;
            case 4:
                $this->roster->displayPE();
                break;
            default:
                echo "Invalid Input!\n";
                break;
        }

        readline("\nPress \"Enter\" key to continue...");
    }

    public function countMenu() {
        $this->clear();
        echo "[1] Count All Employee\n";
        echo "[2] Count Commission Employee\n";
        echo "[3] Count Hourly Employee\n";
        echo "[4] Count Piece Worker\n";
        echo "[0] Return\n";
        $choice = (int)readline("Select Menu: ");

        switch ($choice) {
            case 0:
                break;
            case 1:
                echo "Total Employees: " . $this->roster->count() . "\n";
                break;
            case 2:
                echo "Total Commission Employees: " . $this->roster->countCE() . "\n";
                break;
            case 3:
                echo "Total Hourly Employees: " . $this->roster->countHE() . "\n";
                break;
            case 4:
                echo "Total Piece Workers: " . $this->roster->countPE() . "\n";
                break;
            default:
                echo "Invalid Input!\n";
                break;
        }

        readline("\nPress \"Enter\" key to continue...");
    }

    public function clear() {
        system('cls'); 
    }

    public function repeat() {
        echo "Employee Added!\n";
        if ($this->roster->count() < $this->size) {
            $c = readline("Add more? (y to continue): ");
            if (strtolower($c) == 'y') {
                $this->addMenu();
            } else {
                $this->entrance();
            }
        } else {
            echo "Roster is Full\n";
            readline("Press \"Enter\" key to continue...");
            $this->entrance();
        }
    }
}
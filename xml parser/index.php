<?php
session_start();
$fileName = "employees.xml";
$fileContent = file_get_contents($fileName);
$doc = new DOMDocument();
$doc->preserveWhiteSpace = false;
$doc->loadXML($fileContent);

if (!isset($_SESSION["myIndex"])) {
    $_SESSION["myIndex"] = 0;
}

$searchName = isset($_POST['searchName']) ? $_POST['searchName'] : '';
$searchError = '';

$elementsLength = $doc->getElementsByTagName("employee")->length;


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($_POST["action"] === "insert") {
        // Create a new element
        $new_element = $doc->createElement('employee');

        //id
        $id_element = $doc->createElement('id');
        $id_element_text = $doc->createTextNode(uniqid());
        $id_element->appendChild($id_element_text);

        //name
        $name_element = $doc->createElement('name');
        $name_element_text = $doc->createTextNode($_POST['name']);
        $name_element->appendChild($name_element_text);

        //email
        $email_element = $doc->createElement('email');
        $email_element_text = $doc->createTextNode($_POST['email']);
        $email_element->appendChild($email_element_text);

        //phone
        $phone_element = $doc->createElement('phone');
        $phone_element_text = $doc->createTextNode($_POST['phone']);
        $phone_element->appendChild($phone_element_text);

        //address
        $address_element = $doc->createElement('address');
        $address_element_text = $doc->createTextNode($_POST['address']);
        $address_element->appendChild($address_element_text);

        $new_element->append($id_element, $name_element, $email_element, $phone_element, $address_element);

        // Insert the new element into the document
        $root = $doc->documentElement;
        $root->appendChild($new_element);

        // Save
        $doc->save($fileName);
    }

    $index = $_SESSION["myIndex"] ?? 0;
    if ($_POST["action"] === "next" && $index < $elementsLength - 1) {
        $_SESSION["myIndex"] += 1;
    }

    if ($_POST["action"] === "prev" && $index > 0) {
        $_SESSION["myIndex"] -= 1;
    }

    if ($_POST["action"] === "delete") {
        $root = $doc->documentElement;
        $childNodes = $root->childNodes;
        if ($childNodes->length > 0) {
            $deleted_element = $childNodes->item($_SESSION["myIndex"]);
            if ($deleted_element !== null) {
                $root->removeChild($deleted_element);
                $doc->save($fileName);
                $elementsLength = $doc->getElementsByTagName("employee")->length;
                if ($_SESSION["myIndex"] >= $elementsLength) {
                    $_SESSION["myIndex"] = $elementsLength - 1;
                } elseif ($_SESSION["myIndex"] > 0) {
                    $_SESSION["myIndex"] -= 1;
                }
            }
        }
    }

    if ($_POST["action"] === "update") {
        $root = $doc->documentElement;
        $updated_element = $root->childNodes[$_SESSION["myIndex"]];
        $updated_element->childNodes[1]->nodeValue = $_POST['name'];
        $updated_element->childNodes[2]->nodeValue = $_POST['email'];
        $updated_element->childNodes[3]->nodeValue = $_POST['phone'];
        $updated_element->childNodes[4]->nodeValue = $_POST['address'];
        $doc->save($fileName);
    }
}

// Check if there are any employees left
$elementsLength = $doc->getElementsByTagName("employee")->length;
if ($elementsLength > 0) {
    if ($searchName !== '') {
        // Search for employee by name
        $xpath = new DOMXPath($doc);
        $query = "/employees/employee[contains(name, '$searchName')]";
        $entries = $xpath->query($query);
        if ($entries->length > 0) {
            $employee = $entries->item(0);
            $employeeIndex = -1;
            foreach ($doc->documentElement->childNodes as $key => $node) {
                if ($node->isSameNode($employee)) {
                    $employeeIndex = $key;
                    break;
                }
            }
            $_SESSION["myIndex"] = $employeeIndex;
            $name = $employee->childNodes[1]->nodeValue;
            $email = $employee->childNodes[2]->nodeValue;
            $phone = $employee->childNodes[3]->nodeValue;
            $address = $employee->childNodes[4]->nodeValue;
            $searchError = ''; // Reset search error if a match is found
        } else {
            // No employee found with the given name
            $name = $email = $phone = $address = "";
            $searchError = "No employee found with the name '$searchName'.";
            unset($_SESSION["myIndex"]);
        }
    } else {
        $index = $_SESSION["myIndex"];
        $employees = $doc->documentElement;
        $employee = $employees->childNodes[$index];
        if ($employee !== null) {
            $name = $employee->childNodes[1]->nodeValue;
            $email = $employee->childNodes[2]->nodeValue;
            $phone = $employee->childNodes[3]->nodeValue;
            $address = $employee->childNodes[4]->nodeValue;
            $searchError = ''; // Reset search error if no search is performed
        } else {
            $name = $email = $phone = $address = "";
        }
    }
} else {
    // Handle the case when there are no employees left
    $name = $email = $phone = $address = "";
    $searchError = ''; // Reset search error if there are no employees
    unset($_SESSION["myIndex"]);
}

require_once("views/view.php");
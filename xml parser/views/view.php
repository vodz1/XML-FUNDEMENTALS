<?php
$searchName = isset($searchName) ? $searchName : '';
$name = isset($name) ? $name : '';
$email = isset($email) ? $email : '';
$phone = isset($phone) ? $phone : '';
$address = isset($address) ? $address : '';
$action = isset($_POST['action']) ? $_POST['action'] : '';
$searchError = isset($searchError) ? $searchError : '';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>XML</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">
    <div class="container mx-auto py-8">
        <form method="post" action="index.php" class="max-w-md mx-auto bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2" for="searchName">
                    Search Name
                </label>
                <div class="flex">
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="searchName" name="searchName" type="text" value="<?php echo $searchName ?>">
                    <button class="ml-2 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit" name="action" value="search">Search</button>
                </div>
                <?php if (!empty($searchError)) : ?>
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mt-4" role="alert">
                        <p class="font-bold">Error</p>
                        <p class="text-sm"><?php echo $searchError ?></p>
                    </div>
                <?php endif; ?>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2" for="name">
                    Name
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="name" name="name" type="text" value="<?php echo $name ?>">
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2" for="email">
                    Email
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="email" name="email" type="email" value="<?php echo $email ?>">
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2" for="phone">
                    Phone
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="phone" name="phone" type="text" value="<?php echo $phone ?>">
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2" for="address">
                    Address
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="address" name="address" type="text" value="<?php echo $address ?>">
            </div>

            <input type="hidden" name="action" value="<?php echo $action ?>">

            <div class="flex items-center justify-center mt-6">
                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline mr-2" type="submit" name="action" value="prev">Prev</button>
                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline mr-2" type="submit" name="action" value="next">Next</button>
                <button class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline mr-2" type="submit" name="action" value="insert">Insert</button>
                <button class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline mr-2" type="submit" name="action" value="update">Update</button>
                <button class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit" name="action" value="delete">Delete</button>
            </div>
        </form>
    </div>
</body>

</html>
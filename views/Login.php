<?php
session_start();
$errors = $_SESSION['errors'] ?? [];
unset($_SESSION['errors']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <title>Login</title>
</head>

<body>

    <div class="w-screen h-screen flex bg-white relative">

        <div class="absolute left-16 top-1/2 -translate-y-1/2 w-[28%] z-10">
            <form
                action="../handlers/AuthHandler.php"
                method="POST"
                class="flex flex-col gap-6 bg-white p-10 rounded-3xl shadow-xl">
                <div class="flex flex-col gap-3">
                    <input
                        type="email"
                        name="email"
                        placeholder="Email"
                        value="<?= htmlspecialchars($_SESSION['last']['email'] ?? '') ?>"
                        class=" w-full border rounded-full py-5 px-8 text-lg outline-none focus:ring-2 focus:ring-black">

                    <?php if (isset($errors['errors_email'])): ?>
                        <span class="text-md text-red-500 whitespace-nowrap">
                            <?php echo $errors['errors_email']; ?>
                        </span>
                    <?php endif; ?>
                </div>

                <div class="flex flex-col gap-3">
                    <input
                        type="password"
                        name="password"
                        placeholder="Password"
                        class=" w-full border rounded-full py-5 px-8 text-lg outline-none focus:ring-2 focus:ring-black">
                    <?php if (isset($errors['errors_password'])): ?>
                        <span class="text-md text-red-500 whitespace-nowrap">
                            <?php echo $errors['errors_password']; ?>
                        </span>
                    <?php endif; ?>
                </div>
                <?php if (isset($errors['general'])): ?>
                    <span class="text-red-500"><?= $errors['general'] ?></span>
                <?php endif; ?>

                <button
                    type="submit"
                    class="bg-black text-white py-4 rounded-full text-lg cursor-pointer">
                    Login
                </button>
            </form>
        </div>
        <div class="ml-auto w-[70%] h-full">
            <img
                src="../assets/images/login_image.png"
                alt="login"
                class="w-full h-full object-cover rounded-l-[3rem]">
        </div>

    </div>

</body>

</html>
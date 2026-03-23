<!-- Login Page Content -->
<main class="login h-screen" ng-controller="ng-login">
    <section class="flex flex-col items-center justify-center">
        <div class="login-card">
            <div class="header-logo">
                <img src="<?php echo base_url('assets/img/brgy-logo.png'); ?>" alt="Logo" class="logo">
                <h1 class="m-0 text-xl"><b>Barangay Incident & Blotter</b> <br> <span class="text-lg text-5-mid">Management System</span></h1>
            </div>
            <div class="login-form">
                <div class="flex flex-col gap-2">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" class="py-2 px-3 textbox" placeholder="Enter your username" ng-model="credentials.username">
                </div>
                <div class="flex flex-col gap-2">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" class="py-2 px-3 textbox" placeholder="Enter your password" ng-model="credentials.password">
                </div>
                <div class="flex flex-col items-center justify-between gap-4">
                    <div class="flex flex-row items-center justify-end w-full order-2">
                        <a href="#" class="text-blue-6" ng-click="forgotPassword()"><span class="text-blue-6">Forgot Password?</span></a>
                    </div>
                    <div class="flex flex-row items-center justify-end w-full mt-4 order-1">
                        <button type="button" class="btn btn-primary" ng-click="login()">Login</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>


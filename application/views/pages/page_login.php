<!-- Login Page Content -->
<main class="login h-screen" ng-controller="ng-login">
    <section class="full-bleed">
        <div class="flex flex-col items-center justify-center login-card">
            <div class="login-card-header">
                <h4>Log In</h4>
            </div>
            <div class="login-card-body">
                <form>
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" id="username" name="username" class="py-2 px-3 textbox" placeholder="Enter your username" ng-model="credentials.username">
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" class="py-2 px-3 textbox" placeholder="Enter your password" ng-model="credentials.password">
                    </div>
                    <div class="form-group mt-4 mb-6">
                        <button type="button" class="btn btn-tertiary" ng-click="login()">Login</button>
                        <button type="button" class="btn btn-tertiary" ng-click="forgotPassword()">Forgot Password</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
</main>


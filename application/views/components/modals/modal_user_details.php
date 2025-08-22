<div id="modalUserDetails" class="modal hidden">
    <!-- Modal Dialog Box -->
    <div class="modal-dialog-box">
        <!-- Header -->
        <div class="modal-header">
            <h5 class="m-0 font-bold text-sm">Brgy Case File Management System</h5>
            <button id="closeModal" ng-click="closeModal()" class="btn-close">
                <b>x</b>
            </button>
        </div>
            
        <!-- Body-->
        <div class="modal-body">
            <div class="flex flex-col gap-2">
                <div class="form-container">
                    <div class="form-header">
                        <h6 class="m-0 font-bold text-sm">User Details</h6>
                    </div>
                    <div class="form-body">
                        <div class="flex flex-row gap-4 w-full">
                            <div class="flex flex-col gap-2 img-container">
                                <img src="assets/img/no-image.png" alt="User Image" class="w-full h-full object-cover border">
                                <button type="button" class="text-xs modal-btn-default" onclick="document.getElementById('btnFileUpload').click();" ng-hide="status == 'View'">
                                    <i class="fa fa-file"></i> Upload
                                </button>
                                <input id="btnFileUpload" type='file' file-model="currentRecord[recordIndex].complainant_image" accept="image/*" onchange="angular.element(this).scope().previewImage(this, 'complainant')" hidden>
                            </div>
                            <div class="flex flex-col gap-2 w-full">
                                <div class="grid grid-cols-3 gap-2">
                                    <div>
                                        <label class="block text-xs font-bold mb-1">First Name</label>
                                        <input type="text" ng-model="currentRecord[recordIndex].user_firstname" class="text-xs form-item" ng-disabled="status == 'View'">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold mb-1">Middle Name</label>
                                        <input type="text" ng-model="currentRecord[recordIndex].user_middlename" class="text-xs form-item" ng-disabled="status == 'View'">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold mb-1">Last Name</label>
                                        <input type="text" ng-model="currentRecord[recordIndex].user_lastname" class="text-xs form-item" ng-disabled="status == 'View'">
                                    </div>
                                </div>
                                <div class="grid grid-cols-3 gap-2">
                                    <div>
                                        <label class="block text-xs font-bold mb-1">Birthday</label>
                                        <input type="date" ng-model="currentRecord[recordIndex].user_birthdate" class="text-xs form-item" ng-disabled="status == 'View'">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold mb-1">Age</label>
                                        <input type="text" ng-model="currentRecord[recordIndex].user_age" class="text-xs form-item" placeholder="Age" min="0" max="150" ng-disabled="status == 'View'">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold mb-1">Gender</label>
                                        <select ng-model="currentRecord[recordIndex].user_gender" class="text-xs form-item" ng-disabled="status == 'View'">
                                            <option value="" selected>Select Gender</option>
                                            <option value="Male">Male</option>
                                            <option value="Female">Female</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="grid grid-cols-1 gap-2">
                                    <div>
                                        <label class="block text-xs font-bold mb-1">Address</label>
                                        <input type="text" ng-model="currentRecord[recordIndex].user_address" class="text-xs form-item" ng-disabled="status == 'View'">
                                    </div>
                                </div>
                                <div class="grid grid-cols-2 gap-2">
                                    <div>
                                        <label class="block text-xs font-bold mb-1">Contact Number</label>
                                        <input type="text" ng-model="currentRecord[recordIndex].user_contact_number" class="text-xs form-item" ng-disabled="status == 'View'">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold mb-1">Email Address</label>
                                        <input type="text" ng-model="currentRecord[recordIndex].user_email" class="text-xs form-item" ng-disabled="status == 'View'">
                                    </div>
                                </div>
                                <div class="grid grid-cols-3 gap-2">
                                    <div>
                                        <label class="block text-xs font-bold mb-1">Barangay Position</label>
                                        <select ng-model="currentRecord[recordIndex].user_type" class="text-xs form-item" ng-disabled="status == 'View'">
                                            <option value="">Select Position</option>
                                            <option ng-repeat="position in orgchart" value="{{ position.org_code }}">{{ position.org_position }}</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold mb-1">Username</label>
                                        <input type="text" ng-model="currentRecord[recordIndex].user_account" class="text-xs form-item" ng-disabled="status == 'View'">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold mb-1">Password</label>
                                        <input type="password" ng-model="currentRecord[recordIndex].user_password" class="text-xs form-item" ng-disabled="status == 'View'">
                                    </div>
                                </div>
                                <div class="grid grid-cols-2 gap-2">
                                    <div>
                                        <label class="block text-xs font-bold mb-1">Secret Question</label>
                                        <select ng-model="currentRecord[recordIndex].user_gender" class="text-xs form-item" ng-disabled="status == 'View'">
                                            <option value="" selected>Select Secret Question</option>
                                            <option value="What is your mother's maiden name?">What is your mother's maiden name?</option>
                                            <option value="What is the name of your childhood hometown?">What is the name of your childhood hometown?</option>
                                            <option value="What is the name of your first school?">What is the name of your first school?</option>
                                            <option value="What is the name of your first car?">What is the name of your first car?</option>
                                            <option value="What is the name of your first pet?">What is the name of your first pet?</option>
                                            <option value="What is your favorite color?">What is your favorite color?</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold mb-1">Secret Answer</label>
                                        <input type="text" ng-model="currentRecord[recordIndex].user_secret_answer" class="text-xs form-item" ng-disabled="status == 'View'">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="flex gap-2 justify-end items-end">
                            <button class="text-xs modal-btn-default" ng-click="closeModal()">Cancel</button>
                            <button class="text-xs modal-btn-default" ng-click="validateAndSave()">Save</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
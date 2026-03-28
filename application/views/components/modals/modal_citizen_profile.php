<?php 
    /*
        Citizen Profile Modal
        This modal is used to display the citizen profile
    */
?>
<div id="modalCitizenProfile" class="modal hidden">
    <!-- Modal Dialog Box -->
    <div class="modal-dialog-box">
        <!-- Header -->
        <div class="modal-header">
            <h5 class="m-0 font-bold text-sm">Citizen Profile Form</h5>
            <button id="closeModal" ng-click="closeModal()" class="btn-close">
                <b>x</b>
            </button>
        </div>
            
        <!-- Body-->
        <div class="modal-body">
            <div class="flex flex-col gap-2">
                <div class="form-container">
                    <div class="form-header" ng-hide="currentProcess == 'Add'">
                        <button class="text-sm modal-btn-default" ng-click="generateBarangayCertificate()">Generate Barangay Certificate</button>
                    </div>
                    <div class="form-body">
                        <div class="flex flex-row gap-4 w-full">
                            <div class="flex flex-col gap-2">
                                <div class="img-container">
                                    <img src="{{ citizen_image_preview }}" alt="Citizen Image" loading="lazy">
                                </div>
                                <button type="button" class="text-sm modal-btn-default" onclick="document.getElementById('btnFileUpload').click();" ng-hide="currentProcess == 'View'">
                                    <i class="fa fa-file"></i> Upload
                                </button>
                                <input id="btnFileUpload" type='file' accept="image/*" onchange="angular.element(this).scope().previewImage(this)" hidden>
                                <button type="button" class="text-sm modal-btn-default" ng-click="openCamera()" ng-hide="currentProcess == 'View'"> 
                                    <i class="fa fa-camera"></i>
                                    Take Photo
                                </button>
                            </div>
                            <div class="flex flex-col gap-2 w-full">
                                <div class="grid grid-cols-3 gap-2">
                                    <div>
                                        <label class="block text-sm font-bold mb-1">First Name</label>
                                        <input type="text" ng-model="currentCitizenProfile.first_name" class="text-sm form-item" ng-disabled="currentProcess == 'View'" ng-required="true">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-bold mb-1">Middle Name</label>
                                        <input type="text" ng-model="currentCitizenProfile.middle_name" class="text-sm form-item" ng-disabled="currentProcess == 'View'" ng-required="true">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-bold mb-1">Last Name</label>
                                        <input type="text" ng-model="currentCitizenProfile.last_name" class="text-sm form-item" ng-disabled="currentProcess == 'View'" ng-required="true">
                                    </div>
                                </div>
                                <div class="grid grid-cols-3 gap-2">
                                    <div>
                                        <label class="block text-sm font-bold mb-1">Birthday</label>
                                        <input type="date" ng-model="currentCitizenProfile.birthdate" class="text-sm form-item" ng-disabled="currentProcess == 'View'" ng-required="true">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-bold mb-1">Age</label>
                                        <input type="text" ng-model="currentCitizenProfile.age" class="text-sm form-item" placeholder="Age" min="0" max="150" ng-disabled="currentProcess == 'View'" ng-required="true">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-bold mb-1">Gender</label>
                                        <select ng-model="currentCitizenProfile.gender" class="text-sm form-item" ng-disabled="currentProcess == 'View'" ng-required="true">
                                            <option value="" selected>Select Gender</option>
                                            <option value="Male">Male</option>
                                            <option value="Female">Female</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="grid grid-cols-2 gap-2">
                                    <div>
                                        <label class="block text-sm font-bold mb-1">Nationality</label>
                                        <input type="text" ng-model="currentCitizenProfile.nationality" class="text-sm form-item" ng-disabled="currentProcess == 'View'" ng-required="true">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-bold mb-1">Civil Status</label>
                                        <select ng-model="currentCitizenProfile.civil_status" class="text-sm form-item" ng-disabled="currentProcess == 'View'" ng-required="true">
                                            <option value="" selected>Select Civil Status</option>
                                            <option value="Single">Single</option>
                                            <option value="Married">Married</option>
                                            <option value="Divorced">Divorced</option>
                                            <option value="Widowed">Widowed</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="grid grid-cols-1 gap-2">
                                    <div>
                                        <label class="block text-sm font-bold mb-1">Address</label>
                                        <input type="text" ng-model="currentCitizenProfile.address" class="text-sm form-item" ng-disabled="currentProcess == 'View'" ng-required="true">
                                    </div>
                                </div>
                                <div class="grid grid-cols-2 gap-2">
                                    <div>
                                        <label class="block text-sm font-bold mb-1">Contact Number</label>
                                        <input type="text" ng-model="currentCitizenProfile.contact_number" class="text-sm form-item" ng-disabled="currentProcess == 'View'" ng-required="true">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-bold mb-1">Email Address</label>
                                        <input type="text" ng-model="currentCitizenProfile.email_address" class="text-sm form-item" ng-disabled="currentProcess == 'View'" ng-required="true">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="flex gap-2 justify-end items-end" ng-if="currentProcess == 'Add' || currentProcess == 'Edit'">
                            <button class="text-sm modal-btn-default" ng-click="closeModal()">Cancel</button>
                            <button class="text-sm modal-btn-default" ng-click="saveCitizenProfile()" ng-disabled="currentCitizenProfile.$invalid">Save</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
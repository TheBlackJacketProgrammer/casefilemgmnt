<?php 
    /*
        Barangay Profile Modal
        This modal is used to display the barangay profile
    */
?>
<div id="modalBrgyProfile" class="modal hidden">
    <!-- Modal Dialog Box -->
    <div class="modal-dialog-box">
        <!-- Header -->
        <div class="modal-header">
            <h5 class="m-0 font-bold text-sm">Barangay Profile Form</h5>
            <button id="closeModal" ng-click="closeModal()" class="btn-close">
                <b>x</b>
            </button>
        </div>
            
        <!-- Body-->
        <div class="modal-body">
            <div class="flex flex-col gap-2">
                <div class="form-container">
                    <div class="form-body">
                        <div class="flex flex-row gap-4 w-full">
                            <div class="flex flex-col gap-2 w-full">
                                <div>
                                    <label class="block text-sm font-bold mb-1">Barangay Name</label>
                                    <input type="text" ng-model="currentBrgyProfile.brgy_name" class="text-sm form-item" ng-disabled="currentProcess == 'View'" ng-required="true">
                                </div>
                                <div>
                                    <label class="block text-sm font-bold mb-1">City/Municipality</label>
                                    <input type="text" ng-model="currentBrgyProfile.brgy_city" class="text-sm form-item" ng-disabled="currentProcess == 'View'" ng-required="true">
                                </div>
                                <div>
                                    <label class="block text-sm font-bold mb-1">Region</label>
                                    <input type="text" ng-model="currentBrgyProfile.brgy_region" class="text-sm form-item" ng-disabled="currentProcess == 'View'" ng-required="true">
                                </div>
                                <div>
                                    <label class="block text-sm font-bold mb-1">Status</label>
                                    <select ng-model="currentBrgyProfile.brgy_status" class="text-sm form-item" ng-disabled="currentProcess == 'View'" ng-required="true">
                                        <option value="" selected>Select Status</option>
                                        <option value="1">Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="flex gap-2 justify-end items-end mt-4" ng-if="currentProcess == 'Add' || currentProcess == 'Edit'">
                            <button class="text-sm modal-btn-default" ng-click="closeModal()">Cancel</button>
                            <button class="text-sm modal-btn-default" ng-click="saveBrgyProfile()" ng-disabled="currentBrgyProfile.$invalid">Save</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
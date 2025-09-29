<div id="modalRecords" class="modal-records hidden">
    <div class="modal-dialog-box">
        <!-- Header -->
        <div class="modal-records-header">
            <h5 class="m-0 font-bold text-sm">Blotter Report Details</h5>
            <button id="closeModal" ng-click="closeModal()" class="text-white hover:text-gray-200">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
            
        <!-- Navigation -->
        <div class="modal-records-navigation">
            <div class="flex">
                <button class="modal-btn-save flex items-center gap-2" ng-click="validateAndSave()" ng-hide="status == 'View'" >
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path>
                    </svg>
                    <span class="text-sm font-medium">Save Record</span>
                </button>
                <!-- Save as PDF -->
                <button class="modal-btn-save flex items-center gap-2" ng-click="viewReportForm()" ng-hide="status == 'Add' || status == 'Edit'" >
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path>
                    </svg>
                    <span class="text-sm font-medium">Generate Report Form PDF</span>
                </button>
            </div>
            
            <!-- Record Navigation -->
            <div class="flex justify-between items-center gap-2">
                <div class="text-xs font-medium">Record <b>{{ recordCount }}</b> of <b>{{ recordTotal }}</b></div>
                <div class="flex gap-1">
                    <button class="btn-record-nav p-1 hover:bg-gray-200 rounded" ng-click="previousRecord()">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                    </button>
                    <button class="btn-record-nav p-1 hover:bg-gray-200 rounded" ng-click="nextRecord()">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
            
        <!-- Scrollable Body Content -->
        <div class="modal-records-body">
            <!-- Complainant & Complainee Details -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-3">

                <!-- Complainant Details -->
                <div class="form-container">
                    <div class="form-header">
                        <h5 class="m-0 text-sm font-bold">Complainant Details</h5> 
                    </div>
                    <div class="form-body">
                        <div class="w-1/3 flex flex-col gap-2 img-container">
                            <img src="{{ complainant_image_preview ? complainant_image_preview : baseUrl + 'assets/img/no-image.png' }}" alt="Complainant Image" class="w-full h-full object-cover border">
                            <button type="button" class="text-xs modal-btn-upload" onclick="document.getElementById('btnFileUpload').click();" ng-hide="status == 'View'">
                                <i class="fa fa-file"></i> Upload
                            </button>
                            <input id="btnFileUpload" type='file' file-model="currentRecord[recordIndex].complainant_image" accept="image/*" onchange="angular.element(this).scope().previewImage(this, 'complainant')" hidden>
                        </div>
                        <div class="w-2/3 flex flex-col gap-2">
                            <div>
                                <label class="block text-xs font-bold mb-1">Full Name</label>
                                <input type="text" ng-model="currentRecord[recordIndex].complainant_name" class="text-xs form-item" placeholder="Enter full name" ng-disabled="status == 'View'">
                            </div>
                            <div class="grid grid-cols-3 gap-2">
                                <div>
                                    <label class="block text-xs font-bold mb-1">Age</label>
                                    <input type="text" ng-model="currentRecord[recordIndex].complainant_age" class="text-xs form-item" placeholder="Age" min="0" max="150" ng-disabled="status == 'View'">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold mb-1">Birthday</label>
                                    <input type="date" ng-model="currentRecord[recordIndex].complainant_birthday" class="text-xs form-item" ng-disabled="status == 'View'">

                                </div>
                                <div>
                                    <label class="block text-xs font-bold mb-1">Gender</label>
                                    <select ng-model="currentRecord[recordIndex].complainant_gender" class="text-xs form-item" ng-disabled="status == 'View'">
                                        <option value="" selected>Select Gender</option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                    </select>
                                </div>
                            </div>
                            <div>
                                <label class="block text-xs font-bold mb-1">Address</label>
                                <textarea ng-model="currentRecord[recordIndex].complainant_address" rows="2" class="text-xs form-item" placeholder="Enter complete address" ng-disabled="status == 'View'"></textarea>
                            </div>
                            <div>
                                <label class="block text-xs font-bold mb-1">Contact Number</label>
                                <input type="text" ng-model="currentRecord[recordIndex].complainant_contactNum" class="text-xs form-item" placeholder="Enter contact number" ng-disabled="status == 'View'">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Complainee Details -->
                <div class="form-container">
                    <div class="form-header">
                        <h5 class="m-0 text-sm font-bold">Complainee Details</h5> 
                    </div>
                    <div class="form-body">
                        <div class="w-1/3 flex flex-col gap-2 img-container">
                            <img src="{{ complainee_image_preview ? complainee_image_preview   : baseUrl + 'assets/img/no-image.png' }}" alt="Complainee Image" class="w-full h-full object-cover border">
                            <button type="button" class="text-xs modal-btn-upload" onclick="document.getElementById('btnFileUpload2').click();" ng-hide="status == 'View'">
                                <i class="fa fa-file"></i> Upload
                            </button>
                            <input id="btnFileUpload2" type='file' accept="image/*" file-model="currentRecord[recordIndex].complainee_image" onchange="angular.element(this).scope().previewImage(this, 'complainee')" hidden>
                        </div>
                        <div class="w-2/3 flex flex-col gap-2">
                            <div>
                                <label class="block text-xs font-bold mb-1">Full Name</label>
                                <input type="text" ng-model="currentRecord[recordIndex].complainee_name" class="text-xs form-item" placeholder="Enter full name" ng-disabled="status == 'View'">
                            </div>
                            <div class="grid grid-cols-3 gap-2">
                                <div>
                                    <label class="block text-xs font-bold mb-1">Age</label>
                                    <input type="text" ng-model="currentRecord[recordIndex].complainee_age" class="text-xs form-item" placeholder="Age" min="0" max="150" ng-disabled="status == 'View'">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold mb-1">Birthday</label>
                                    <input type="date" ng-model="currentRecord[recordIndex].complainee_birthday" class="text-xs form-item" ng-disabled="status == 'View'">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold mb-1">Gender</label>
                                    <select ng-model="currentRecord[recordIndex].complainee_gender" class="text-xs form-item" ng-disabled="status == 'View'">
                                        <option value="" selected>Select Gender</option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                    </select>
                                </div>
                            </div>
                            <div>
                                <label class="block text-xs font-bold mb-1">Address</label>
                                <textarea ng-model="currentRecord[recordIndex].complainee_address" rows="2" class="text-xs form-item" placeholder="Enter complete address" ng-disabled="status == 'View'"></textarea>
                            </div>
                            <div>
                                <label class="block text-xs font-bold mb-1">Contact Number</label>
                                <input type="text" ng-model="currentRecord[recordIndex].complainee_contactNum" class="text-xs form-item" placeholder="Enter contact number" ng-disabled="status == 'View'">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Crime Information & Details -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-3">
                <!-- Crime Information -->
                <div class="form-container">
                    <div class="form-header">
                        <h5 class="m-0 text-sm font-bold">Crime Information</h5> 
                    </div>
                    <div class="form-body flex-col">
                  
                        <!-- Row 1: Crime Date -->
                        <div class="grid grid-cols-2 gap-2">
                            <div>
                                <label class="block text-xs font-bold mb-1">Crime Date</label>
                                <input type="datetime-local" ng-model="currentRecord[recordIndex].case_crimeDate" class="text-xs form-item" ng-disabled="status == 'View'">
                            </div>
                            <div>
                                <label class="block text-xs font-bold mb-1">Place of Crime</label>
                                <input type="text" ng-model="currentRecord[recordIndex].case_crimeScene" class="text-xs form-item" placeholder="Enter place of crime" ng-disabled="status == 'View'">
                            </div>
                        </div>
                            
                        <!-- Row 2: Place of Crime & Witness -->
                        <div class="grid grid-cols-2 gap-2">
                            <div>
                                <label class="block text-xs font-bold mb-1">Witness</label>
                                <input type="text" ng-model="currentRecord[recordIndex].case_crimeWitness" class="text-xs form-item" placeholder="Enter witness name" ng-disabled="status == 'View'">
                            </div>
                            <div>
                                <label class="block text-xs font-bold mb-1">Crime Type</label>
                                <select ng-model="currentRecord[recordIndex].case_crimeType" class="text-xs form-item" ng-disabled="status == 'View'">
                                    <option value="">-Crime Type-</option>
                                    <option ng-repeat="crimeType in crimeTypes" value="{{ crimeType.crimeType_crime }}">{{ crimeType.crimeType_crime }}</option>
                                </select>
                            </div>
                        </div>

                        <!-- Row 3: Status -->
                        <div class="grid grid-cols-4 gap-2" ng-if="status == 'Edit' || status == 'View'">
                            <div>
                                <label class="block text-xs font-bold mb-1">Status</label>
                                <select ng-model="currentRecord[recordIndex].case_status" class="text-xs form-item" ng-disabled="status == 'View'">
                                    <option value="">-Status-</option>
                                    <option value="Pending">Pending</option>
                                    <option value="Ongoing">Ongoing</option>
                                    <option value="Completed">Completed</option>
                                    <option value="Closed">Closed</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-bold mb-1">Date Created</label>
                                <input type="date" ng-model="currentRecord[recordIndex].case_dateFiled" class="text-xs form-item" disabled>
                            </div>
                            <div>
                                <label class="block text-xs font-bold mb-1">Last Date Updated</label>
                                <input type="text" class="text-xs form-item" value="N/A" ng-if="currentRecord[recordIndex].case_dateUpdated == null" disabled>
                                <input type="date" ng-model="currentRecord[recordIndex].case_dateUpdated" class="text-xs form-item" ng-if="currentRecord[recordIndex].case_dateUpdated != null" disabled>
                            </div>
                            <div>
                                <label class="block text-xs font-bold mb-1">Last Updated By</label>
                                <input type="text" ng-model="currentRecord[recordIndex].user_fullname" class="text-xs form-item" disabled>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Details Of Event -->
                <div class="form-container">
                    <div class="form-header">
                        <h5 class="m-0 text-sm font-bold">Details Of Event</h5> 
                    </div>
                    <div class="form-body flex-col">
                        <label class="block text-xs font-bold mb-1">Details Of Event</label>
                        <textarea ng-model="currentRecord[recordIndex].case_crimeDetails" rows="8" class="text-xs form-item" placeholder="Enter detailed description of the event" ng-disabled="status == 'View'"></textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
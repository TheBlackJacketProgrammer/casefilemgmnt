<div id="modalRecords" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-2 hidden">
    <div class="bg-white shadow-xl w-11/12 max-w-5xl max-h-screen flex flex-col modal-records">
        <!-- Header -->
        <div class="flex items-center justify-between p-3 border-b border-gray-200 bg-blue-600 text-white ">
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
                <button class="modal-btn flex items-center gap-2" ng-click="saveRecord()">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path>
                    </svg>
                    <span class="text-sm font-medium">Save Record</span>
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
            
        <!-- Scrollable Content -->
        <div class="flex-1 overflow-y-auto p-3" style="max-height: calc(100vh - 100px);">
            <!-- Complainant & Complainee Details -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-3 mb-3">
                <!-- Complainant Details -->
                <div class="border border-gray-300 rounded-lg">
                    <div class="bg-blue-600 text-white px-3 py-2">
                        <h5 class="m-0 text-sm font-bold">Complainant Details</h5> 
                    </div>
                    <div class="p-3">
                        <div class="flex gap-3">
                            <div class="w-1/3 h-full">
                                <img src="<?php echo base_url('assets/img/no-image.png'); ?>" alt="Complainant Image" class="w-full h-full object-cover border">
                                <button type="button" class="w-full mt-1 px-2 py-1 text-xs modal-btn" onclick="document.getElementById('btnFileUpload').click();">
                                    <i class="fa fa-file"></i> Upload
                                </button>
                                <input id="btnFileUpload" type='file' ng-file='uploadfiles' hidden>
                            </div>
                            <div class="w-2/3 space-y-2">
                                <div>
                                    <label class="block text-xs font-bold mb-1">Full Name</label>
                                    <input type="text" ng-model="currentRecord[recordIndex].complainant_name" class="w-full px-2 py-1 text-xs border border-gray-300 rounded focus:outline-none focus:ring-1 focus:ring-blue-500" placeholder="Enter full name">
                                </div>
                                <div class="grid grid-cols-2 gap-2">
                                    <div>
                                        <label class="block text-xs font-bold mb-1">Age</label>
                                        <input type="text" ng-model="currentRecord[recordIndex].complainant_age" class="w-full px-2 py-1 text-xs border border-gray-300 rounded focus:outline-none focus:ring-1 focus:ring-blue-500" placeholder="Age" min="0" max="150">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold mb-1">Birthday</label>
                                        <input type="date" ng-model="currentRecord[recordIndex].complainant_birthday" class="w-full px-2 py-1 text-xs border border-gray-300 rounded focus:outline-none focus:ring-1 focus:ring-blue-500">
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-xs font-bold mb-1">Address</label>
                                    <textarea ng-model="currentRecord[recordIndex].complainant_address" rows="2" class="w-full px-2 py-1 text-xs border border-gray-300 rounded focus:outline-none focus:ring-1 focus:ring-blue-500" placeholder="Enter complete address"></textarea>
                                </div>
                                <div>
                                    <label class="block text-xs font-bold mb-1">Contact Number</label>
                                    <input type="text" ng-model="currentRecord[recordIndex].complainant_contactNum" class="w-full px-2 py-1 text-xs border border-gray-300 rounded focus:outline-none focus:ring-1 focus:ring-blue-500" placeholder="Enter contact number">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Complainee Details -->
                <div class="border border-gray-300 rounded-lg">
                    <div class="bg-blue-600 text-white px-3 py-2">
                        <h5 class="m-0 text-sm font-bold">Complainee Details</h5> 
                    </div>
                    <div class="p-3">
                        <div class="flex gap-3">
                            <div class="w-1/3 h-full">
                                <img src="<?php echo base_url('assets/img/no-image.png'); ?>" alt="Complainee Image" class="w-full h-full object-cover border">
                                <button type="button" class="w-full mt-1 px-2 py-1 text-xs modal-btn" onclick="document.getElementById('btnFileUpload2').click();">
                                    <i class="fa fa-file"></i> Upload
                                </button>
                                <input id="btnFileUpload2" type='file' ng-file='uploadfiles' hidden>
                            </div>
                            <div class="w-2/3 space-y-2">
                                <div>
                                    <label class="block text-xs font-bold mb-1">Full Name</label>
                                    <input type="text" ng-model="currentRecord[recordIndex].complainee_name" class="w-full px-2 py-1 text-xs border border-gray-300 rounded focus:outline-none focus:ring-1 focus:ring-blue-500" placeholder="Enter full name">
                                </div>
                                <div class="grid grid-cols-2 gap-2">
                                    <div>
                                        <label class="block text-xs font-bold mb-1">Age</label>
                                        <input type="text" ng-model="currentRecord[recordIndex].complainee_age" class="w-full px-2 py-1 text-xs border border-gray-300 rounded focus:outline-none focus:ring-1 focus:ring-blue-500" placeholder="Age" min="0" max="150">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold mb-1">Birthday</label>
                                        <input type="date" ng-model="currentRecord[recordIndex].complainee_birthday" class="w-full px-2 py-1 text-xs border border-gray-300 rounded focus:outline-none focus:ring-1 focus:ring-blue-500">
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-xs font-bold mb-1">Address</label>
                                    <textarea ng-model="currentRecord[recordIndex].complainee_address" rows="2" class="w-full px-2 py-1 text-xs border border-gray-300 rounded focus:outline-none focus:ring-1 focus:ring-blue-500" placeholder="Enter complete address"></textarea>
                                </div>
                                <div>
                                    <label class="block text-xs font-bold mb-1">Contact Number</label>
                                    <input type="text" ng-model="currentRecord[recordIndex].complainee_contactNum" class="w-full px-2 py-1 text-xs border border-gray-300 rounded focus:outline-none focus:ring-1 focus:ring-blue-500" placeholder="Enter contact number">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Crime Information & Details -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-3">
                <!-- Crime Information -->
                <div class="border border-gray-300 rounded-lg">
                    <div class="bg-blue-600 text-white px-3 py-2">
                        <h5 class="m-0 text-sm font-bold">Crime Information</h5> 
                    </div>
                    <div class="p-3 space-y-2">
                        <!-- Row 1: Date Recorded & Crime Type -->
                        <div class="grid grid-cols-2 gap-2">
                            <div>
                                <label class="block text-xs font-bold mb-1">Date Recorded</label>
                                <input type="text" ng-model="currentRecord[recordIndex].case_dateFiled" class="w-full px-2 py-1 text-xs border border-gray-300 rounded bg-gray-100" readonly>
                            </div>
                            <div>
                                <label class="block text-xs font-bold mb-1">Crime Type</label>
                                <select ng-model="currentRecord[recordIndex].case_crimeType" class="w-full px-2 py-1 text-xs border border-gray-300 rounded focus:outline-none focus:ring-1 focus:ring-blue-500">
                                    <option value="">-Crime Type-</option>
                                    <option ng-repeat="crimeType in crimeTypes" value="{{ crimeType.crimeType_id }}">{{ crimeType.crimeType_crime }}</option>
                                </select>
                            </div>
                        </div>
                            
                        <!-- Row 2: Place of Crime & Witness -->
                        <div class="grid grid-cols-2 gap-2">
                            <div>
                                <label class="block text-xs font-bold mb-1">Place of Crime</label>
                                <input type="text" ng-model="currentRecord[recordIndex].case_crimeScene" class="w-full px-2 py-1 text-xs border border-gray-300 rounded focus:outline-none focus:ring-1 focus:ring-blue-500" placeholder="Enter place of crime">
                            </div>
                            <div>
                                <label class="block text-xs font-bold mb-1">Witness</label>
                                <input type="text" ng-model="currentRecord[recordIndex].case_crimeWitness" class="w-full px-2 py-1 text-xs border border-gray-300 rounded focus:outline-none focus:ring-1 focus:ring-blue-500" placeholder="Enter witness name">
                            </div>
                        </div>
                            
                        <!-- Row 3: Crime Date -->
                        <div>
                            <label class="block text-xs font-bold mb-1">Crime Date</label>
                            <input type="date" ng-model="currentRecord[recordIndex].case_crimeDate" class="w-full px-2 py-1 text-xs border border-gray-300 rounded focus:outline-none focus:ring-1 focus:ring-blue-500">
                        </div>
                    </div>
                </div>

                <!-- Details Of Event -->
                <div class="border border-gray-300 rounded-lg">
                    <div class="bg-blue-600 text-white px-3 py-2">
                        <h5 class="m-0 text-sm font-bold">Details Of Event</h5> 
                    </div>
                    <div class="p-3">
                        <div>
                            <label class="block text-xs font-bold mb-1">Details Of Event</label>
                            <textarea ng-model="currentRecord[recordIndex].case_crimeDetails" rows="8" class="w-full px-2 py-1 text-xs border border-gray-300 rounded focus:outline-none focus:ring-1 focus:ring-blue-500" placeholder="Enter detailed description of the event"></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
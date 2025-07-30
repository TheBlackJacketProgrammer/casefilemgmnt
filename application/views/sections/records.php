<div class="flex flex-col items-center justify-center bg-white records-section my-10 overflow-auto" ng-controller="RecordsController">
    <div class="flex flex-row items-center justify-start records-header">
        <h5>Records Management</h5>
    </div>
    <!-- Main Menu -->
    <div class="flex flex-row items-start justify-start records-main-menu p-4 gap-4">
        <div class="flex flex-row items-start justify-start gap-4 w-2/3">
            <button class="btn-menu-item flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Add Record
            </button>
            <button class="btn-menu-item flex items-center gap-2" ng-click="editSelectedRecords()" ng-disabled="getSelectedRecords().length === 0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                </svg>
                View Records {{ getSelectedRecords().length > 0 ? '(' + getSelectedRecords().length + ')' : '' }}
            </button>
            <button class="btn-menu-item flex items-center gap-2" ng-click="editSelectedRecords()" ng-disabled="getSelectedRecords().length === 0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                Edit Records {{ getSelectedRecords().length > 0 ? '(' + getSelectedRecords().length + ')' : '' }}
            </button>
            <button class="btn-menu-item flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                </svg>
                Open Crime Options
            </button>
        </div>
        <!-- <div class="flex flex-row items-end justify-end gap-4 w-1/3">
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 ml-3 flex items-center pointer-events-none">
                    <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
                <input type="text" 
                    placeholder="Search records..." 
                    class="block w-40 pl-10 pr-3 py-2 border border-gray-300 rounded-lg text-sm placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
            </div>
        </div> -->
    </div>
    <!-- End Main Menu -->
    <!-- Records Table - Datatable -->
    <div class="flex flex-col items-center justify-start p-4 gap-4 w-full">
        <table id="tbl_records" class="min-w-full divide-y divide-gray-200" datatable="ng" dt-options="dtOptions" dt-instance="dtInstance">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                        <input type="checkbox" id="selectAll" ng-click="handleHeaderCheckbox()" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Case #</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Crime Type</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Complainant</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Complainee</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Crime Date</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Crime Date Filed</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                </tr>
            </thead>
            <tbody>
                <tr ng-repeat="record in records">
                    <td class="px-6 py-4">
                        <input type="checkbox" id="record" ng-model="record.selected" ng-change="updateSelectAll()" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                    </td>
                    <td class="px-6 py-4">{{ record.case_id }}</td>
                    <td class="px-6 py-4">{{ record.case_crimeType }}</td>
                    <td class="px-6 py-4">{{ record.complainant_name }}</td>
                    <td class="px-6 py-4">{{ record.complainee_name }}</td>
                    <td class="px-6 py-4">{{ record.case_crimeDate }}</td>
                    <td class="px-6 py-4">{{ record.case_dateFiled }}</td>
                    <td class="px-6 py-4">{{ record.case_notify }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Modal -->
    <div id="modalRecords" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-2 hidden">
        <div class="bg-white rounded-lg shadow-xl w-11/12 max-w-5xl max-h-screen flex flex-col">
            <!-- Header -->
            <div class="flex items-center justify-between p-3 border-b border-gray-200 bg-blue-600 text-white rounded-t-lg">
                <h5 class="m-0 font-bold text-sm">Blotter Report Details</h5>
                <button id="closeModal" ng-click="closeModal()" class="text-white hover:text-gray-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            
            <!-- Navigation -->
            <div class="flex items-center justify-between bg-gray-100 px-3 py-2 border-b border-gray-200">
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
            
            <!-- Scrollable Content -->
            <div class="flex-1 overflow-y-auto p-3" style="max-height: calc(100vh - 200px);">
                <!-- Complainant & Complainee Details -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-3 mb-3">
                    <!-- Complainant Details -->
                    <div class="border border-gray-300 rounded-lg">
                        <div class="bg-blue-600 text-white px-3 py-2 rounded-t-lg">
                            <h5 class="m-0 text-sm font-bold">Complainant Details</h5> 
                        </div>
                        <div class="p-3">
                            <div class="flex gap-3">
                                <div class="w-1/3">
                                    <img src="<?php echo base_url('assets/img/no-image.png'); ?>" alt="Complainant Image" class="w-full h-20 object-cover rounded border">
                                    <button type="button" class="w-full mt-1 px-2 py-1 text-xs bg-blue-600 text-white rounded hover:bg-blue-700" onclick="document.getElementById('btnFileUpload').click();">
                                        <i class="fa fa-file"></i> Upload
                                    </button>
                                    <input id="btnFileUpload" type='file' ng-file='uploadfiles' hidden>
                                </div>
                                <div class="w-2/3 space-y-2">
                                    <div>
                                        <label class="block text-xs font-bold mb-1">Full Name</label>
                                        <input type="text" ng-model="currentRecord.complainant_name" class="w-full px-2 py-1 text-xs border border-gray-300 rounded focus:outline-none focus:ring-1 focus:ring-blue-500" placeholder="Enter full name">
                                    </div>
                                    <div class="grid grid-cols-2 gap-2">
                                        <div>
                                            <label class="block text-xs font-bold mb-1">Age</label>
                                            <input type="number" ng-model="currentRecord.complainant_age" class="w-full px-2 py-1 text-xs border border-gray-300 rounded focus:outline-none focus:ring-1 focus:ring-blue-500" placeholder="Age" min="0" max="150">
                                        </div>
                                        <div>
                                            <label class="block text-xs font-bold mb-1">Birthday</label>
                                            <input type="date" ng-model="currentRecord.complainant_birthday" class="w-full px-2 py-1 text-xs border border-gray-300 rounded focus:outline-none focus:ring-1 focus:ring-blue-500">
                                        </div>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold mb-1">Address</label>
                                        <textarea ng-model="currentRecord.complainant_address" rows="2" class="w-full px-2 py-1 text-xs border border-gray-300 rounded focus:outline-none focus:ring-1 focus:ring-blue-500" placeholder="Enter complete address"></textarea>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold mb-1">Contact Number</label>
                                        <input type="tel" ng-model="currentRecord.complainant_contact" class="w-full px-2 py-1 text-xs border border-gray-300 rounded focus:outline-none focus:ring-1 focus:ring-blue-500" placeholder="Enter contact number">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Complainee Details -->
                    <div class="border border-gray-300 rounded-lg">
                        <div class="bg-blue-600 text-white px-3 py-2 rounded-t-lg">
                            <h5 class="m-0 text-sm font-bold">Complainee Details</h5> 
                        </div>
                        <div class="p-3">
                            <div class="flex gap-3">
                                <div class="w-1/3">
                                    <img src="<?php echo base_url('assets/img/no-image.png'); ?>" alt="Complainee Image" class="w-full h-20 object-cover rounded border">
                                    <button type="button" class="w-full mt-1 px-2 py-1 text-xs bg-blue-600 text-white rounded hover:bg-blue-700" onclick="document.getElementById('btnFileUpload2').click();">
                                        <i class="fa fa-file"></i> Upload
                                    </button>
                                    <input id="btnFileUpload2" type='file' ng-file='uploadfiles' hidden>
                                </div>
                                <div class="w-2/3 space-y-2">
                                    <div>
                                        <label class="block text-xs font-bold mb-1">Full Name</label>
                                        <input type="text" ng-model="currentRecord.complainee_name" class="w-full px-2 py-1 text-xs border border-gray-300 rounded focus:outline-none focus:ring-1 focus:ring-blue-500" placeholder="Enter full name">
                                    </div>
                                    <div class="grid grid-cols-2 gap-2">
                                        <div>
                                            <label class="block text-xs font-bold mb-1">Age</label>
                                            <input type="number" ng-model="currentRecord.complainee_age" class="w-full px-2 py-1 text-xs border border-gray-300 rounded focus:outline-none focus:ring-1 focus:ring-blue-500" placeholder="Age" min="0" max="150">
                                        </div>
                                        <div>
                                            <label class="block text-xs font-bold mb-1">Birthday</label>
                                            <input type="date" ng-model="currentRecord.complainee_birthday" class="w-full px-2 py-1 text-xs border border-gray-300 rounded focus:outline-none focus:ring-1 focus:ring-blue-500">
                                        </div>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold mb-1">Address</label>
                                        <textarea ng-model="currentRecord.complainee_address" rows="2" class="w-full px-2 py-1 text-xs border border-gray-300 rounded focus:outline-none focus:ring-1 focus:ring-blue-500" placeholder="Enter complete address"></textarea>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold mb-1">Contact Number</label>
                                        <input type="tel" ng-model="currentRecord.complainee_contact" class="w-full px-2 py-1 text-xs border border-gray-300 rounded focus:outline-none focus:ring-1 focus:ring-blue-500" placeholder="Enter contact number">
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
                        <div class="bg-blue-600 text-white px-3 py-2 rounded-t-lg">
                            <h5 class="m-0 text-sm font-bold">Crime Information</h5> 
                        </div>
                        <div class="p-3 space-y-2">
                            <!-- Row 1: Date Recorded & Crime Type -->
                            <div class="grid grid-cols-2 gap-2">
                                <div>
                                    <label class="block text-xs font-bold mb-1">Date Recorded</label>
                                    <div class="w-full px-2 py-1 text-xs border border-gray-300 rounded bg-gray-100">
                                        {{ currentRecord.case_dateFiled || 'Wed - Jul-30-2025 - 22:24:18 pm' }}
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-xs font-bold mb-1">Crime Type</label>
                                    <select ng-model="currentRecord.case_crimeType" class="w-full px-2 py-1 text-xs border border-gray-300 rounded focus:outline-none focus:ring-1 focus:ring-blue-500">
                                        <option value="">-Crime Type-</option>
                                        <option value="Theft">Theft</option>
                                        <option value="Assault">Assault</option>
                                        <option value="Fraud">Fraud</option>
                                        <option value="Vandalism">Vandalism</option>
                                        <option value="Trespassing">Trespassing</option>
                                        <option value="Harassment">Harassment</option>
                                        <option value="Drug Possession">Drug Possession</option>
                                        <option value="Traffic Violation">Traffic Violation</option>
                                        <option value="Other">Other</option>
                                    </select>
                                </div>
                            </div>
                            
                            <!-- Row 2: Place of Crime & Witness -->
                            <div class="grid grid-cols-2 gap-2">
                                <div>
                                    <label class="block text-xs font-bold mb-1">Place of Crime</label>
                                    <input type="text" ng-model="currentRecord.case_crimePlace" class="w-full px-2 py-1 text-xs border border-gray-300 rounded focus:outline-none focus:ring-1 focus:ring-blue-500" placeholder="Enter place of crime">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold mb-1">Witness</label>
                                    <input type="text" ng-model="currentRecord.case_witness" class="w-full px-2 py-1 text-xs border border-gray-300 rounded focus:outline-none focus:ring-1 focus:ring-blue-500" placeholder="Enter witness name">
                                </div>
                            </div>
                            
                            <!-- Row 3: Crime Date -->
                            <div>
                                <label class="block text-xs font-bold mb-1">Crime Date</label>
                                <input type="date" ng-model="currentRecord.case_crimeDate" class="w-full px-2 py-1 text-xs border border-gray-300 rounded focus:outline-none focus:ring-1 focus:ring-blue-500">
                            </div>
                        </div>
                    </div>

                    <!-- Details Of Event -->
                    <div class="border border-gray-300 rounded-lg">
                        <div class="bg-blue-600 text-white px-3 py-2 rounded-t-lg">
                            <h5 class="m-0 text-sm font-bold">Details Of Event</h5> 
                        </div>
                        <div class="p-3">
                            <div>
                                <label class="block text-xs font-bold mb-1">Details Of Event</label>
                                <textarea ng-model="currentRecord.case_details" rows="8" class="w-full px-2 py-1 text-xs border border-gray-300 rounded focus:outline-none focus:ring-1 focus:ring-blue-500" placeholder="Enter detailed description of the event"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
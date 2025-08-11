<div class="flex flex-col items-center justify-center bg-white records-section my-10 overflow-auto" ng-controller="RecordsController">
    <div class="flex flex-row items-center justify-start records-header">
        <h5>Records Management</h5>
    </div>
    <!-- Main Menu -->
    <div class="flex flex-row items-start justify-start records-main-menu p-4 gap-4">
        <div class="flex flex-row items-start justify-start gap-4 w-2/3">
            <button class="btn-menu-item flex items-center gap-2" ng-click="addRecord()">
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
    <?php $this->load->view('components/modals/modal_records'); ?>
</div>
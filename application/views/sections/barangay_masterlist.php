<?php 
    /*
        Barangay Masterlist Section
        This section is used to display the barangay masterlist
    */
?>

<section class="barangay-masterlist-section" ng-controller="BarangayMasterlistController" ng-init="init()">
    <div class="header">
        <h5>Barangay Masterlist</h5>
    </div>
    <!-- Main Menu -->
    <div class="main-menu">
        <button class="btn-menu-item flex items-center gap-2 text-sm" ng-click="addBarangayInformation()">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            Add Barangay Masterlist
        </button>
    </div>
    <!-- End Main Menu -->
    <!-- Records Table - Datatable -->
    <div class="flex flex-col items-center justify-start p-4 gap-4 w-full">
        <table id="tbl_barangay_masterlist" class="min-w-full divide-y divide-gray-200" datatable="ng" dt-options="dtOpt_barangayMasterlist" dt-instance="dtInstance">
            <thead class="bg-shade-6">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase" hidden>Brgy Id</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase">Barangay Name</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase">City/Municipality</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase">Region</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase">Action</th>
                </tr>
            </thead>
            <tbody>
                <tr ng-repeat="brgy in barangayMasterlist">
                    <td class="px-6 py-4" hidden>{{ brgy.brgy_id }}</td>
                    <td class="px-6 py-4">{{ brgy.brgy_name }}</td>
                    <td class="px-6 py-4">{{ brgy.brgy_city }}</td>
                    <td class="px-6 py-4">{{ brgy.brgy_region }}</td>
                    <td class="px-6 py-4">{{ brgy.brgy_status == 1 ? 'Active' : 'Inactive' }}</td>
                    <td class="px-6 py-4">
                        <div class="flex flex-row gap-2">
                            <button class="btn-edit" ng-click="editBarangayInformation(brgy)">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                                <span class="ml-2">Edit</span>
                            </button>
                            <button class="btn-edit" ng-click="viewBarangayInformation(brgy)">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                <span class="ml-2">View</span>
                            </button>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Citizen Profile Modal -->
    <?php $this->load->view('components/modals/modal_brgy_profile'); ?>
</section>
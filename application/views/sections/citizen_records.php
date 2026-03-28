<?php 
    /*
        Citizen Records Section
        This section is used to display the citizen records
    */
?>

<section class="citizen-records-section" ng-controller="CitizenRecordsController" ng-init="init()">
    <div class="header">
        <h5>Citizen Records</h5>
    </div>
    <!-- Main Menu -->
    <div class="main-menu">
        <button class="btn-menu-item flex items-center gap-2 text-sm" ng-click="addCitizenProfile()">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            Add Citizen Profile
        </button>
    </div>
    <!-- End Main Menu -->
    <!-- Records Table - Datatable -->
    <div class="flex flex-col items-center justify-start p-4 gap-4 w-full">
        <table id="tbl_citizen_records" class="min-w-full divide-y divide-gray-200" datatable="ng" dt-options="dtOpt_citizenRecords" dt-instance="dtInstance">
            <thead class="bg-shade-6">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase" hidden>Citizen Id</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase">Lastname</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase">Firstname</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase">Middlename</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase">Birthdate</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase">Age</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase">Gender</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase">Action</th>
                </tr>
            </thead>
            <tbody>
                <tr ng-repeat="citizen in citizenRecords">
                    <td class="px-6 py-4" hidden>{{ citizen.citizen_id }}</td>
                    <td class="px-6 py-4">{{ citizen.last_name }}</td>
                    <td class="px-6 py-4">{{ citizen.first_name }}</td>
                    <td class="px-6 py-4">{{ citizen.middle_name }}</td>
                    <td class="px-6 py-4">{{ convertMySQLDate(citizen.birthdate)}}</td>
                    <td class="px-6 py-4">{{ citizen.age }}</td>
                    <td class="px-6 py-4">{{ citizen.gender }}</td>
                    <td class="px-6 py-4">
                        <div class="flex flex-row gap-2">
                            <button class="btn-edit" ng-click="editCitizenProfile(citizen)">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                                <span class="ml-2">Edit</span>
                            </button>
                            <button class="btn-edit" ng-click="viewCitizenProfile(citizen)">
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
    <?php $this->load->view('components/modals/modal_citizen_profile'); ?>
    <!-- Camera Modal -->
    <?php $this->load->view('components/modals/modal_camera'); ?>
</section>
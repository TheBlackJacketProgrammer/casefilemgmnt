<div class="flex flex-col items-center justify-center bg-white user-portal-section my-10 overflow-auto" ng-controller="UserPortalController">
    <div class="flex flex-row items-center justify-start user-portal-header">
        <h5>User Portal</h5>
    </div>
    <div class="flex flex-col items-start justify-center user-portal-body p-4">
        <!-- Main Menu -->
        <div class="flex flex-row items-end justify-end gap-4 px-4 w-full">
            <button class="btn-menu-item flex items-center gap-2 text-sm" ng-click="addUser()">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Add User
            </button>
        </div>
        <!-- End Main Menu -->
        <!-- User List -->
        <div class="flex flex-col items-center justify-start p-4 gap-4 w-full">
            <table id="tbl_users" class="min-w-full divide-y divide-gray-200" datatable="ng" dt-options="dtOpt_citizenRecords" dt-instance="dtInstance">
                <thead class="bg-shade-6">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase">Position</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase">Fullname</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase">Gender</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase">Birthdate</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase">Contact Number</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr ng-repeat="user in users">
                        <td class="px-6 py-4 text-sm">{{ getPosition(user.user_type) }}</td>
                        <td class="px-6 py-4 text-sm">{{ user.user_fullname }}</td>
                        <td class="px-6 py-4 text-sm">{{ user.user_gender }}</td>
                        <td class="px-6 py-4 text-sm">{{ convertMySQLDate(user.user_birthdate) }}</td>
                        <td class="px-6 py-4 text-sm">{{ user.user_contact_number ? user.user_contact_number : 'N/A' }}</td>
                        <td class="px-6 py-4 text-sm">{{ user.user_status == 1 ? 'Active' : 'Deactivated' }}</td>
                        <td class="flex flex-col items-center justify-start gap-2">
                            <button class="btn-edit flex items-center gap-2 text-sm w-full" ng-click="editUser($index)">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                                Edit
                            </button>
                            <button class="btn-deactivate flex items-center gap-2 text-sm w-full" ng-click="updateUserStatus(user.user_id, user.user_status)" ng-show="user.user_status == 1">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                                Deactivate
                            </button>
                            <button class="btn-activate flex items-center gap-2 text-sm w-full" ng-click="updateUserStatus(user.user_id, user.user_status)" ng-show="user.user_status == 0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                                Activate
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal -->
    <?php $this->load->view('components/modals/modal_user_details'); ?>
</div>
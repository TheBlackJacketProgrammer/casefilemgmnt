<!-- Event Logs -->
<div class="flex flex-col items-center justify-center bg-white event-logs-section my-10 overflow-auto" ng-controller="EventLogsController">
    <div class="flex flex-row items-center justify-start event-logs-header">
        <h5>Event Logs</h5>
    </div>
    <div class="flex flex-col items-start justify-center event-logs-body p-4">

        <!-- Event Logs List -->
        <div class="flex flex-col items-center justify-start p-4 gap-4 w-full">
            <table id="tbl_logs" class="min-w-full divide-y divide-gray-200" datatable="ng" dt-options="dtOptions_logs" dt-instance="dtInstance">
                <thead class="bg-shade-6">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase">Date Created</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase">User</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr ng-repeat="log in eventlogs">
                        <td class="px-6 py-4 text-sm">{{ log.date_created }}</td>
                        <td class="px-6 py-4 text-sm">{{ log.fullame }}</td>
                        <td class="px-6 py-4 text-sm">{{ log.log_action }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

</div>
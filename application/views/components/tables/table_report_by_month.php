<table id="tbl_report_by_month" class="min-w-full divide-y divide-gray-200" datatable="ng" dt-options="dtOpt_CountsByMonths" dt-instance="dtInstance">
    <thead class="bg-shade-6">
        <tr>
            <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase">Month</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase">Total Reports</th>
        </tr>
    </thead>
    <tbody>
        <tr ng-repeat="report in reportsByMonth">
            <td class="px-6 py-4 text-sm">{{ report.month }}</td>
            <td class="px-6 py-4 text-sm">{{ report.total }}</td>
        </tr>
    </tbody>
</table>
<table id="tbl_report_by_crime_type" class="min-w-full divide-y divide-gray-200">
    <thead class="bg-shade-6">
        <tr>
            <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase">Crime Type</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase">Total Reports</th>
        </tr>
    </thead>
    <tbody>
        <tr ng-repeat="report in reportsByCrimeType">
            <td class="px-6 py-4 text-sm">{{ report.type }}</td>
            <td class="px-6 py-4 text-sm">{{ report.total }}</td>
        </tr>
    </tbody>
</table>
<!-- Data Statistics Section -->
<div class="flex flex-col items-center justify-center bg-white data-statistics-section my-10 overflow-auto" ng-controller="DataStatisticsController">
    <div class="flex flex-row items-center justify-start data-statistics-header">
        <h5>Data Statistics</h5>
    </div>
    <div class="flex flex-col items-start justify-center data-statistics-body p-4 gap-4">
        <!-- Filters Here -->
        <!-- General Counts Here -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-6 w-full general-counts">
            <div class="counts-item bg-primary">
                <h3 class="m-0 text-medium uppercase text-white">Total Records: </h3>
                <p class="m-0 text-medium font-bold text-white">{{ recordTotals[0].GrandTotal }}</p>
            </div>
            <div class="counts-item bg-white">
                <h3 class="m-0 text-medium uppercase">Total this month: </h3>
                <p class="m-0 text-medium font-bold ">{{ recordTotals[0].CurrentMonthTotal }}</p>
            </div>
            <div class="counts-item bg-white">
                <h3 class="m-0 text-medium uppercase">Total this week: </h3>
                <p class="m-0 text-medium font-bold ">{{ recordTotals[0].CurrentWeekTotal }}</p>
            </div>
            <div class="counts-item bg-white">
                <h3 class="m-0 text-medium uppercase">Total today: </h3>
                <p class="m-0 text-medium font-bold ">{{ recordTotals[0].CurrentDayTotal }}</p>
            </div>
        </div>
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-6 w-full general-counts">
            <div class="counts-item bg-white">
                <h3 class="m-0 text-medium uppercase">Ongoing Records: </h3>
                <p class="m-0 text-medium font-bold">{{ recordStatusTotals[0].Ongoing }}</p>
            </div>
            <div class="counts-item bg-white">
                <h3 class="m-0 text-medium uppercase">Pending Records: </h3>
                <p class="m-0 text-medium font-bold ">{{ recordStatusTotals[0].Pending }}</p>
            </div>
            <div class="counts-item bg-white">
                <h3 class="m-0 text-medium uppercase">Completed Records: </h3>
                <p class="m-0 text-medium font-bold ">{{ recordStatusTotals[0].Completed }}</p>
            </div>
            <div class="counts-item bg-white">
                <h3 class="m-0 text-medium uppercase">Closed Records: </h3>
                <p class="m-0 text-medium font-bold ">{{ recordStatusTotals[0].Closed }}</p>
            </div>
        </div>
        <!-- Report Tables -->
        <div class="grid grid-cols-3 gap-4 p-4 w-full justify-start items-start">
            <div class="flex flex-col items-center justify-start gap-3">
                <h3 class="m-0 text-medium font-bold uppercase">Reports by Month</h3>
                <?php $this->load->view('components/tables/table_report_by_month'); ?>
            </div>
            <div class="flex flex-col items-center justify-center gap-3">
                <h3 class="m-0 text-medium font-bold uppercase">Reports by Crime Type</h3>
                <?php $this->load->view('components/tables/table_report_by_crime_type'); ?>
            </div>
            <div class="flex flex-col items-center justify-center gap-3">
                <h3 class="m-0 text-medium font-bold uppercase">Reports by Status</h3>
                <?php $this->load->view('components/tables/table_report_by_status'); ?>
            </div>
        </div>
    </div>
</div>
<!-- Data Statistics Section -->
<div class="flex flex-col items-center justify-center bg-white data-statistics-section my-10 overflow-auto" ng-controller="DataStatisticsController">
    <div class="flex flex-row items-center justify-start data-statistics-header">
        <h5>Data Statistics</h5>
    </div>
    <div class="flex flex-col items-start justify-center data-statistics-body p-4">
        <!-- Filters Here -->
        <!-- General Counts Here -->
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
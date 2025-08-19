<div id="modalCrimeOptions" class="modal-crime-options hidden" ng-controller="CrimeOptionsController">
    <!-- Modal Dialog Box -->
    <div class="modal-dialog-box">
        <!-- Header -->
        <div class="modal-crime-options-header">
            <h5 class="m-0 font-bold text-sm">Crime Masterlist</h5>
            <button id="closeModal" ng-click="closeModal()" class="btn-close">
                <b>x</b>
            </button>
        </div>
            
        <!-- Body-->
        <div class="modal-crime-options-body">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-2">
                <!-- Masterlist -->
                <div>
                    <table id="tbl_crime_options" class="min-w-full" datatable="ng" dt-options="dtOptions_crime" dt-instance="dtInstance">
                        <thead class="bg-shade-6">
                            <tr>
                                <th class="px-6 py-3 text-center font-medium text-white uppercase">Crime Type</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr ng-repeat="crime in crimeOptions">
                                <td class="px-6 py-4" ng-class="{'selected-row': selectedRow === $index}" ng-click="selectCrime($index)">{{ crime.crimeType_crime }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div>
                    <div class="flex flex-col gap-3 justify-center">
                        <div class="form-container">
                            <div class="form-header">
                                <h4 class="m-0 text-sm font-bold uppercase">Information</h4>
                            </div>
                            <div class="form-body">
                                <div>
                                    <label class="block font-bold mb-1 text-sm uppercase">Crime Type</label>
                                    <input type="text" ng-model="selectedCrime.crimeType_crime" class="text-xs form-item" placeholder="Enter crime type">
                                </div>
                                <div>
                                    <label class="block font-bold mb-1 text-sm uppercase">Description</label>
                                    <textarea ng-model="selectedCrime.crimeType_description" rows="8" class="text-xs form-item" placeholder="Enter crime description here. . ."></textarea>
                                </div>
                                <div class="flex flex-row gap-2 justify-center items-center">
                                    <button class="modal-btn-default" ng-click="save()">Save</button>
                                    <button class="modal-btn-default" ng-click="cancel()">Cancel</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
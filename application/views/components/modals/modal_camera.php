<?php 
    /*
        Camera Modal
        This modal is used to display the camera
    */
?>
<div id="modalCamera" class="modal hidden">
    <!-- Modal Dialog Box -->
    <div class="modal-camera">
        <!-- Header -->
        <div class="modal-header">
            <h5 class="m-0 font-bold text-sm">Camera</h5>
            <button id="closeModalCamera" ng-click="closeCamera()" class="btn-close">
                <b>x</b>
            </button>
        </div>
            
        <!-- Body-->
        <div class="modal-body">
            <div class="flex flex-col gap-2 p-4">
                <div class="camera-container">
                    <video id="video" width="300" height="250"  autoplay></video>
                    <canvas id="canvas" width="300" height="250"  style="display:none;"></canvas>
                </div>
                <div class="w-full mt-4">
                    <button class="text-sm modal-btn-default w-full" ng-click="takePhoto()">Take Photo</button>
                </div>
            </div>
        </div>
    </div>
</div>
<form id="regForm">
    <h1>Register:</h1>
    <div class="tab">
        <h3>Name:</h3>
        <p><input oninput="this.className = ''" name="name"></p>
        <h3>Surname:</h3>
        <p><input oninput="this.className = ''" name="surname"></p>
        <h3>Number</h3>
        <p><input oninput="this.className = ''" name="phone"></p>
    </div>
    <div class="tab">
        <h3>Address:</h3>
        <p><input placeholder="street, house's number, city" oninput="this.className = ''" name="address"></p>
    </div>
    <div class="tab">
        <h3>Comment:</h3>
        <p><input oninput="this.className = ''" name="comment"></p>
    </div>
    <div class="tab">
        <h3 id="outputFeedbackDataId"></h3>
    </div>
    <div style="overflow:auto;">
        <div style="float:right;">
            <button type="button" id="prevBtn" onclick="nextPrev(-1)">Previous</button>
            <button type="button" id="nextBtn" onclick="nextPrev(1)">Next</button>
        </div>
    </div>
    <div style="text-align:center;margin-top:40px;">
        <span class="step"></span>
        <span class="step"></span>
        <span class="step"></span>
        <span class="step"></span>
    </div>
</form>

<?php $this->registerJsFile('@web/js/main.js', ['depends' => 'yii\web\YiiAsset']); ?>
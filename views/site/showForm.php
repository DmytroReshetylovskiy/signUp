<form id="regForm" action="/action_page.php">
    <h1>Register:</h1>
    <!-- One "tab" for each step in the form: -->
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
    <div style="overflow:auto;">
        <div style="float:right;">
            <button type="button" id="prevBtn" onclick="nextPrev(-1)">Previous</button>
            <button type="button" id="nextBtn" onclick="nextPrev(1)">Next</button>
        </div>
    </div>
    <!-- Circles which indicates the steps of the form: -->
    <div style="text-align:center;margin-top:40px;">
        <span class="step"></span>
        <span class="step"></span>
        <span class="step"></span>
        <span class="step"></span>
    </div>
</form>

<?php $this->registerJsFile('@web/js/main.js', ['depends' => 'yii\web\YiiAsset']); ?>
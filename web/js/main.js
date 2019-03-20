/* jshint node: true */
$(document).ready(function () {
    "use strict";

    var currentTab = 0;
    var feedbackDataId = '';

    $.get("/info", function (data) {
        if (data) {
            $.each(data.values, function (key, value) {
                document.getElementById("regForm")[key].value = value;
            });
            if (data.step) {
                currentTab = data.step;
            }
        }
        showTab(currentTab);
    });

    function sendRequest(postData) {
        $.post("/register/"+currentTab, postData, function() {});
    }

    function submitForm(postData) {
        $.post("/create-client", postData, function( data ) {
            console.log(data);
            if (data.feedbackDataId) {
                feedbackDataId = data.feedbackDataId;
                document.getElementById('outputFeedbackDataId').innerHTML = 'feedbackDataId: ' + feedbackDataId;
                showFinalTab(currentTab)
            } else {
                document.getElementById('outputFeedbackDataId').innerHTML = 'Error: ' + data.error;
                showFinalErrorTab(currentTab)
            }
        });
    }

    function showFinalErrorTab(n) {
        var x = document.getElementsByClassName("tab");
        x[n].style.display = "block";

        document.getElementById("prevBtn").style.display = "none";
        document.getElementById("nextBtn").style.display = "none";
        document.getElementsByClassName("step")[3].className += " error";
        currentTab = 0;
        sendRequest(getElementsById());
    }

    function showFinalTab(n) {
        var x = document.getElementsByClassName("tab");
        x[n].style.display = "block";

        document.getElementById("prevBtn").style.display = "none";
        document.getElementById("nextBtn").style.display = "none";
        document.getElementsByClassName("step")[3].className += " finish"
    }

    function showTab(n) {
        var x = document.getElementsByClassName("tab");
        x[n].style.display = "block";

        if (n == 0) {
            document.getElementById("prevBtn").style.display = "none";
        } else {
            document.getElementById("prevBtn").style.display = "inline";
        }

        if (n == (x.length - 1)) {
            document.getElementById("nextBtn").innerHTML = "Submit";
        } else {
            document.getElementById("nextBtn").innerHTML = "Next";
        }
        fixStepIndicator(n)
    }

    function getElementsById() {
        return {
            name: document.getElementById("regForm").name.value,
            surname: document.getElementById("regForm").surname.value,
            phone: document.getElementById("regForm").phone.value,
            address: document.getElementById("regForm").address.value,
            comment: document.getElementById("regForm").comment.value
        };
    }

    window.nextPrev = function(n) {
        var x = document.getElementsByClassName("tab");

        if (n == 1 && !validateForm()) {
            return false;
        }
        x[currentTab].style.display = "none";
        currentTab = currentTab + n;

        var data = getElementsById();

        if (currentTab >= x.length - 1) {
            submitForm(data);
            return false;
        }

        sendRequest(data);
        showTab(currentTab);
    };

    function validateForm() {
        var x, y, i, valid = true;
        x = document.getElementsByClassName("tab");
        y = x[currentTab].getElementsByTagName("input");
        for (i = 0; i < y.length; i++) {
            if (y[i].value.trim() == "") {
                y[i].value = "";
                y[i].className += " invalid";
                valid = false;
            }
        }
        if (valid) {
            document.getElementsByClassName("step")[currentTab].className += " finish";
        }
        return valid;
    }

    function fixStepIndicator(n) {
        var i, x = document.getElementsByClassName("step");
        if (n > 0) {
            for (i = n - 1; i >= 0; i--) {
                x[i].className = x[i].className += " finish";
            }
        }
        for (i = 0; i < x.length; i++) {
            x[i].className = x[i].className.replace(" active", "");
        }
        x[n].className += " active";
    }
});

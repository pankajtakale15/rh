var slider = document.getElementById("priceSlider");
var currentRecordQty = document.getElementById("currentRecordQty");
var boxCurrentRecordQty = document.getElementById("boxCurrentRecordQty");
var boxMonthQty = document.getElementById("boxMonthQty")
var boxPrice = document.getElementById("boxPrice");
var boxAmount = document.getElementById("boxAmount");
var boxAnnual = document.getElementById("boxAnnual");

boxMonthQty.innerHTML = "01";
boxPrice.innerHTML = "07";

slider.oninput = function() {
  var sliderValue = slider.value;
  
  if sliderValue < 10
  {
	  currentRecordQty.innerHTML = "0" + sliderValue;
	  boxCurrentRecordQty.innerHTML = "0" + sliderValue;
  }
  else
  {
	  currentRecordQty.innerHTML = sliderValue;
	  boxCurrentRecordQty.innerHTML = sliderValue;
  }
  
  boxAmount.innerHTML = sliderValue * 7;
  boxAnnual.innerHTML = sliderValue * 7 * 12;
  
}

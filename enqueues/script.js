
// JavaScript code to show/hide li elements
const expandBtn = document.getElementById("expandBtn");
const hideBtn = document.getElementById("hideBtn");
const listItems = document.querySelectorAll("#orphanList li");

for (let i = 0; i < listItems.length; i++) {
  listItems[i].style.display = "none";
}

for (let i = 0; i < 5; i++) {
  listItems[i].style.display = "block";
}

expandBtn.addEventListener("click", function() {
  for (let i = 5; i < listItems.length; i++) {
    listItems[i].style.display = "block";
  }
  expandBtn.style.display = "none";
  hideBtn.style.display = "block";
});

hideBtn.addEventListener("click", function() {
  for (let i = 5; i < listItems.length; i++) {
    listItems[i].style.display = "none";
  }
  expandBtn.style.display = "block";
  hideBtn.style.display = "none";
});

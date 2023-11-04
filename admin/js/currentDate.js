const currentDate = new Date();

function addLeadingZero(number) {
  return number < 10 ? `0${number}` : number;
}
const formattedDate = `${addLeadingZero(currentDate.getDate())}.${addLeadingZero(currentDate.getMonth() + 1)}.${currentDate.getFullYear()}`;

document.getElementById("date").textContent = formattedDate;

const zupanije = [
  {
    ime: "Odaberite županiju",
    gradovi: ["Upišite grad"]
  },
  {
    ime: "Hercegovačko-neretvanska županija",
    gradovi: ["Upišite grad", "Mostar", "Čapljina", "Neum", "Čitluk", "Jablanica", "Konjic", "Stolac", "Prozor-Rama", "Ravno"]
  },
  {
    ime: "Sarajevska županija",
    gradovi: ["Upišite grad", "Sarajevo", "Ilidža", "Vogošća", "Centar", "Hadžići", "Ilijaš", "Novi Grad", "Novo Sarajevo", "Stari Grad", "Trnovo"]
  },
  {
    ime: "Zeničko-dobojska županija",
    gradovi: ["Upišite grad", "Zenica", "Doboj", "Maglaj", "Breza", "Doboj Jug", "Kakanj", "Olovo", "Tešanj", "Vareš", "Visoko", "Zavidovići", "Žepče", "Usora"]
  },
  {
    ime: "Tuzlanska županija",
    gradovi: ["Upišite grad", "Tuzla", "Lukavac", "Gradačac", "Banovići", "Čelić", "Doboj Istok", "Gračanica", "Kladanj", "Sapna", "Srebrenik", "Teočak", "Živinice"]
  },
  {
    ime: "Bosansko-podrinjska županija",
    gradovi: ["Upišite grad", "Goražde", "Višegrad", "Foča", "Foča-Ustikolina", "Pale-Prača"]
  },
  {
    ime: "Posavska županija",
    gradovi: ["Upišite grad", "Brčko", "Orašje", "Domaljevac-Šamac", "Odžak"]
  },
  {
    ime: "Unsko-sanska županija",
    gradovi: ["Upišite grad", "Bihać", "Sanski Most", "Cazin", "Bosanska Krupa", "Bosanski Petrovac", "Bužim", "Ključ", "Velika Kladuša"]
  },
  {
    ime: "Zapadnohercegovačka županija",
    gradovi: ["Upišite grad", "Široki Brijeg", "Grude", "Ljubuški", "Posušje"]
  },
  {
    ime: "Hercegbosanska županija",
    gradovi: ["Upišite grad", "Livno", "Tomislavgrad", "Kupres", "Drvar", "Bosansko Grahovo", "Glamoč"]
  },
  {
    ime: "Županija Središnja Bosna",
    gradovi: ["Upišite grad", "Travnik", "Novi Travnik", "Vitez", "Bugojno", "Busovača", "Dobretići", "Donji Vakuf", "Fojnica", "Jajce", "Kiseljak", "Kreševo", "Uskoplje"]
  }
];


const zupanijaSelect = document.getElementById('zupanija');
const gradSelect = document.getElementById('grad');
const gradInput = document.getElementById('gradInput');

function popuniGradove() {
  const odabranaZupanija = zupanijaSelect.value;
  const zupanija = zupanije.find(z => z.ime === odabranaZupanija);
  gradSelect.innerHTML = '';

  zupanija.gradovi.forEach(grad => {
    const option = document.createElement('option');
    option.value = grad;
    option.textContent = grad;
    gradSelect.appendChild(option);
  });
  updateGradInputDisabled();
}

zupanije.forEach(zupanija => {
  const option = document.createElement('option');
  option.value = zupanija.ime;
  option.textContent = zupanija.ime;
  zupanijaSelect.appendChild(option);
});


// Disable / enable grad-input
function updateGradInputDisabled() {
  if (gradSelect.value !== "Upišite grad" || zupanijaSelect.value === "Odaberite županiju") {
    gradInput.disabled = true;
    gradInput.value = "";
  } else {
    gradInput.disabled = false;
  }
}

document.addEventListener("DOMContentLoaded", function () {
  gradSelect.addEventListener("change", updateGradInputDisabled);
  zupanijaSelect.value = "Zapadnohercegovačka županija";
  popuniGradove();
  gradSelect.value = "Ljubuški";
  updateGradInputDisabled();
});
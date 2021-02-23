function imgSlider(anything){
    document.querySelector('.sucosnaturais').src = anything;
   
  }
  function trocarCorCicle(color,texto){
    const ciclo = document.querySelector('.ciclo')
    ciclo.style.background = color

    const trocaCor = document.querySelector('.trocaCor')
    trocaCor.style.background = color

    const text = document.getElementById("paragrafo")
    .innerHTML = texto 
  }


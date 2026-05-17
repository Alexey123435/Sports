document.querySelector('#phone').onkeydown = function(e){
    inputphone(e,document.querySelector('#phone'))
    }
    document.querySelector('#phone2').onkeydown = function(e){
    inputphone(e,document.querySelector('#phone2'))
    }
    //-- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --
    
    
    //Функция маски формат +7 (
    function inputphone(e, phone){
    function stop(evt) {
        evt.preventDefault();
    }
    let key = e.key, v = phone.value; not = key.replace(/([0-9])/, 1)
    
    if(not == 1 || 'Backspace' === not){
    if('Backspace' != not){ 
        if(v.length < 3 || v ===''){phone.value= '+7('}
        if(v.length === 6){phone.value= v +')'}
        if(v.length === 10){phone.value= v +'-'}
         if(v.length === 13){phone.value= v +'-'}
        }
    }else{stop(e)}  }
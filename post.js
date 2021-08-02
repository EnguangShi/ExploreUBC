const fake_icons = document.querySelectorAll(".fake_icon");
const real_btns = document.getElementsByClassName("real_btn")

fake_icons.forEach(icon => {
    icon.addEventListener('click', () => {
        for(let r of real_btns){
            if(r.id.indexOf(icon.id) > -1){
                r.click();
            }
        }
    })
})
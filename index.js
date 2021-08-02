const panels = document.querySelectorAll('.panel')
console.log(panels);
const activePanel = document.querySelectorAll('.active')

panels.forEach(panel => {
    panel.addEventListener('click', () => {
        if(panel.classList.contains('active')){
            window.location.href = "post.php?psid="+panel.id;
        }
        removeActiveClasses()
        panel.classList.add('active')
    })
})

function removeActiveClasses() {
    panels.forEach(panel => {
        panel.classList.remove('active')
    })
}
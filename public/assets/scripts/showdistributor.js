let role

document.addEventListener('DOMContentLoaded',()=>{
    let roleSelect = document.querySelector('.role-input select')
    role = roleSelect.value
    isSalesman(role)
    roleSelect.onchange = (e)=>{
        isSalesman(e.target.value)
    }
})

function isSalesman(role){
    if (role === "ROLE_SALESMAN" || role === "ROLE_DISTRIBUTOR"){
        document.querySelector('.distributor-input select').removeAttribute('disabled')
        document.querySelector('.distributor-input select').setAttribute('required','true')
    }
    else {
        document.querySelector('.distributor-input select').setAttribute('disabled','')
        document.querySelector('.distributor-input select').removeAttribute('required')
        document.querySelector('.distributor-input select').selectedIndex = -1
        document.querySelector('.distributor-input select').dispatchEvent(new Event('change'))
    }
}
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
    if (role === "ROLE_SALESMAN"){
        document.querySelector('.distributor-input select').removeAttribute('disabled')
    }
    else {
        document.querySelector('.distributor-input select').setAttribute('disabled','')

    }
}
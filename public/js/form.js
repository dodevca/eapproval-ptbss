document.addEventListener("DOMContentLoaded", function(){
    function makeid(length) {
        var result           = '';
        var characters       = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        var charactersLength = characters.length;
        for ( var i = 0; i < length; i++ ) {
            result += characters.charAt(Math.floor(Math.random() * charactersLength));
        }
        return result;
    }
    
    const descriptionWrapper = document.getElementById('itemWrapper')
    
    // get projects
    const inputProject = document.getElementById('projectCode')
    inputProject.addEventListener('blur', (e) => {
        e.preventDefault()
        
        let xhr     = new XMLHttpRequest()
        let project = inputProject.value
        
        xhr.open('GET', 'https://devisigeneralservicebss.com/projects?p=P' + project)
        xhr.setRequestHeader('Content-Type', 'application/json');
        xhr.onload = function() {
            if(xhr.readyState == 4 && xhr.status == 200) {
                let data = JSON.parse(this.responseText)
                let contractNumber  = document.getElementById('contractNumber')
                let customerName    = document.getElementById('customerName')
                
                contractNumber.value = data.contractNumber
                contractNumber.classList.add('is-valid')
                
                customerName.value   = data.customer
                customerName.classList.add('is-valid')
            }
        }
        xhr.send(null)
    })

    // category select other
    const category          = document.querySelectorAll('[name="category"]')
    const otherCategoryWrap = document.getElementById('otherCategoryWrapper')
    const otherCategory     = document.querySelectorAll('[name="otherCategory"]')

    category[0].addEventListener("change", (e) =>{
        e.preventDefault()
        if(category[0].options[category[0].selectedIndex].value == 'other') {
            otherCategoryWrap.style.display = 'block'
            otherCategory[0].setAttribute('required', '')
            otherCategory[0].focus()
        } else {
            otherCategoryWrap.style.display = 'none'
            otherCategory[0].removeAttribute('required')
        }
    })

    // add more description
    const addDescription = document.getElementById('addMore')
    
    addDescription.addEventListener("click", (e) => {
        e.preventDefault()
        
        NodeList.prototype.forEach = Array.prototype.forEach
        
        let el = document.getElementById("descriptionBackups").childNodes
        
        const descriptionId = makeid(8)
        const codeId        = makeid(8)
        
        let descriptionEl = [
            '<li class="d-flex align-items-center justify-content-between border-bottom pt-3">',
            '    <div class="row w-100">',
            '        <div class="col-12 col-lg-7 mb-3">',
            '           <label for="description" class="form-label">Keperluan</label> <input type="text" class="form-control description" list="' + descriptionId + '" id="description" name="description[]" placeholder="Keperluan"  onChange="getRefcode(this)" autocomplete="off" required /><datalist class="descriptionList" id="' + descriptionId + '"></datalist>',
            '        </div>',
            '        <div class="col-12 col-lg-5 mb-3">',
            '            <label for="unitRef" class="form-label">Kode Ref.</label><input type="text" class="form-control unitRef" list="' + codeId + '" id="unitRef" name="unitRef[]" placeholder="Kode referensi" autocomplete="off" /><datalist class="codeList" id="' + codeId + '"></datalist>',
            '        </div>',
            '        <div class="col-4 col-lg-2 mb-3">',
            '             <label for="amount" class="form-label">Jumlah</label><input type="number" class="form-control" id="amount" name="amount[]" onBlur="getTotal(this.parentElement.parentElement)" step="any" placeholder="Jumlah" required />',
            '        </div>',
            '        <div class="col-8 col-lg-4 mb-3">',
            '            <label for="unit" class="form-label">Satuan</label><input type="text" class="form-control" id="unit" name="unit[]" placeholder="Satuan" required />',
            '        </div>',
            '        <div class="col-12 col-lg-6 mb-3">',
            '            <label for="unitPrice" class="form-label">Harga satuan</label><div class="input-group"><span class="input-group-text" id="unitPriceText">Rp.</span><input type="text" class="form-control" id="unitPrice" name="unitPrice[]" placeholder="Harga satuan" onBlur="getTotal(this.parentElement.parentElement.parentElement)" required /></div>',
            '        </div>',
            '        <div class="col-12 mb-3">',
            '            <label for="totalPrice" class="form-label">Harga Total</label><div class="input-group"><span class="input-group-text" id="unitPriceText">Rp</span><input type="text" class="form-control totalPrice" id="totalPrice" value="0" name="totalPrice[]" required /></div>',
            '        </div>',
            '        <div class="col-12 mb-3">',
            '            <label for="moreDescription" class="form-label">Keterangan</label><input type="text" class="form-control" id="moreDescription" name="moreDescription[]" placeholder="Keterangan" />',
            '        </div>',
            '        <div class="col-12 col-lg-6 mb-3">',
            '            <label for="beginningPeriod" class="form-label">Periode Awal</label><input type="date" class="form-control" id="beginningPeriod" name="beginningPeriod[]" placeholder="mm/dd/yy" aria-validate="false" required />',
            '        </div>',
            '        <div class="col-12 col-lg-6 mb-3">',
            '            <label for="endPeriod" class="form-label">Periode Akhir</label><input type="date" class="form-control" id="endPeriod" name="endPeriod[]" placeholder="mm/dd/yy" aria-validate="false" required />',
            '        </div>',
            '    </div>',
            '    <button type="button" class="btn-close mb-3 ms-3" aria-label="Close" onClick="removeItem(this.parentElement)" ></button>',
            '</li>'
        ].join('')

        descriptionWrapper.insertAdjacentHTML('beforeend', descriptionEl)
        
        el.forEach(function(i) {
            let clone = i.cloneNode(true);
            document.getElementById(descriptionId).appendChild(clone);
        })
    })

    // validation allert
    const validate = (el, val) => {
        
            if(val === true) {
                if(el.value !== null && el.value !== undefined && el.value !== '') {
                    el.classList.remove('is-invalid')
                    el.classList.add('is-valid')
                } else {
                    el.classList.remove('is-invalid')
                    el.classList.remove('is-valid')
                }
            } else {
                if(el.value !== null && el.value !== undefined && el.value !== '') {
                    el.classList.remove('is-valid')
                    el.classList.add('is-invalid')
                } else {
                    el.classList.remove('is-invalid')
                    el.classList.remove('is-valid')
                }
            }
    }

    // validation function
    //// name
    function isNameValid(string) {
        return /\d/.test(string)
    }

    // need validation
    //// name
    const name = document.querySelectorAll('input[type="name"]')
    for(let i = 0;i < name.length;i++) {
        name[i].addEventListener('blur', (e) => {
            e.preventDefault()
            validate(name[i], !isNameValid(name[i].value))
        })
    }
    /// other category
    otherCategory[0].addEventListener('blur', (e) => {
        e.preventDefault()
        if(otherCategory[0].value == null || otherCategory[0].value == undefined || otherCategory[0].value == '') {
            otherCategory[0].classList.remove('is-valid')
            otherCategory[0].classList.add('is-invalid')
        } else {
            validate(otherCategory[0], true)
        }
    })

    // no need validation
    const noValidate = document.querySelectorAll('[aria-validate="false"]')
    for(let i = 0;i < noValidate.length;i++) {
        noValidate[i].addEventListener('blur', (e) => {
            e.preventDefault()
            validate(noValidate[i], true)
        })
    }
})

// alert message
const alertWrapper = document.getElementById('alertWrapper')
const alert = (message, type) => {
    let html = [
        `<div class="alert alert-${type} alert-dismissible" role="alert">`,
        `   <div>${message}</div>`,
        '   <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>',
        '</div>'
    ].join('')

    alertWrapper.insertAdjacentHTML('beforeend', html)
    alertWrapper.style.display      = 'block'
    alertWrapper.style.visibility   = 'visible'
    
    const alert = document.getElementsByClassName('alert')
    setTimeout(() => {
        for(let i = 0; i < alert.length;i ++) {
            alert[i].remove()
        }
    }, "3000")
}

// get refcode
function getRefcode(e) {
    let xhr     = new XMLHttpRequest()
    let query   = e.value
    
    if(query !== null || query !== undefined) {
        xhr.open('GET', 'https://devisigeneralservicebss.com/refcode?d=' + query)
        xhr.setRequestHeader('Content-Type', 'application/json');
        xhr.onload = function() {
            if(xhr.readyState == 4 && xhr.status == 200) {
                let data        = JSON.parse(this.responseText)
                let input       = e.parentElement.nextElementSibling.children[1]
                let list        = e.parentElement.nextElementSibling.children[2]
                
                input.value     = ''
                list.innerHTML  = ''
                
                for(let i = 0; i < data.code.length; i++) {
                    let el = '<option value="' + data.code[i] + '" />'
                    list.insertAdjacentHTML('beforeend', el)
                }
            }
        }
        xhr.send(null)
    }
}

// remove excess description
function removeItem(e){
    let totalEl         = document.getElementById('total')
    let allTotalPriceEl = document.getElementsByClassName('totalPrice')
    let total           = 0;
    
    if(e.parentElement.children.length <= 1) {
        alert('Berikan minimal 1 rincian dalam formulir', 'danger')
    } else {
        e.remove()
        
        for(let i = 0;i < allTotalPriceEl.length; i++) {
            total += parseInt(allTotalPriceEl[i].value.replace(/\./g,''))
        }
        
        totalEl.value = total.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        
        alert('Rincian berhasil di hapus', 'warning')
    }
}

function getTotal(grandParent) {
    let unitPriceEl = grandParent.children[4].lastElementChild.lastElementChild
    let unitPrice   = unitPriceEl.value.replace(/[^\d.-]/g, '').replace(/\./g, '')
    let total       = 0
    
    if(unitPrice != null && unitPrice != undefined && unitPrice != '') {
        let price           = unitPrice.replace(/\B(?=(\d{3})+(?!\d))/g, ".")
        let totalEl         = document.getElementById('total')
        let allTotalPriceEl = document.getElementsByClassName('totalPrice')
        let amount          = grandParent.children[2].lastElementChild.value
        let totalPriceEl    = grandParent.children[5].lastElementChild.lastElementChild
        unitPriceEl.value   = price
        
        if(amount && price) {
            let totalPrice      = parseInt(price.replace(/\./g, '')) * amount
            totalPriceEl.value  = totalPrice.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            
            for(let i = 0;i < allTotalPriceEl.length; i++) {
                total += parseInt(allTotalPriceEl[i].value.replace(/\./g,''))
            }
            
            totalEl.value = total.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }
    }
}
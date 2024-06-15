document.addEventListener('DOMContentLoaded', function () {
    
    const resizeCanvas = () => {
        canvas.width    = 240
        canvas.height   = 240
        
        signaturePad.clear()
    }
    
    const canvas = document.getElementById('signaturePad')
    
    const signaturePad = new SignaturePad(canvas, {
        backgroundColor: 'rgb(255, 255, 255)'
    })
    
    // resizeCanvas()
    
    document.getElementById('reset').addEventListener('click', function () {
        signaturePad.clear()
    })

    document.getElementById('undo').addEventListener('click', function () {
        var data = signaturePad.toData()
        if (data) {
            data.pop()
            signaturePad.fromData(data)
        }
    })
    
    document.getElementById('submit').addEventListener("click", function(e){
        e.preventDefault()
        
        let alert   = document.getElementById('alert')
        let success = document.getElementById('success')
        if (signaturePad.isEmpty()) {
            alert.classList.remove('d-none')
            alert.classList.add('show')
        } else {
            let xhr     = new XMLHttpRequest()
            let sign    = signaturePad.toDataURL()
            
            xhr.open('POST', 'https://devisigeneralservicebss.com/setting/setesign')
            xhr.setRequestHeader('Content-Type', 'application/json');
            xhr.onload = function() {
                if(xhr.readyState == 4 && xhr.status == 200) {
                    console.log(sign)
                    success.classList.remove('d-none')
                    success.classList.add('show')
                    
                    window.location.reload(true)
                }
            }
            xhr.send(JSON.stringify({sign: sign}))
        }
    })
})
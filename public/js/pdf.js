document.addEventListener('DOMContentLoaded', function(){
    const opt = {
        margin      : 0,
        filename    : 'E-Approval - ' + document.getElementById('docName').innerHTML + '.pdf',
        image       : { type: 'png', quality: 1 },
        html2canvas : { scale: 2 },
        jsPDF       : { unit: 'in', format: 'B3', orientation: 'portrait' }
    }
    
    const downloadPdf = () => {
        const element = document.getElementById('softcopy')
    
        html2pdf().set(opt).from(element).save()
    }
    
    document.getElementById('downloadPdf').addEventListener('click', () => {
        document.body.scrollTop = 0
        document.documentElement.scrollTop = 0
        
        setTimeout(() => {
            downloadPdf()
        }, "800")
    })
})